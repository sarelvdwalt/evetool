<?php

namespace AppBundle\Command;

use Afrihost\BaseCommandBundle\Command\BaseCommand;
use AppBundle\Entity\Colony;
use AppBundle\Entity\Pin;
use AppBundle\Entity\PinExtractorDetail;
use AppBundle\Entity\PinLink;
use AppBundle\Entity\PinRoute;
use AppBundle\Entity\Toon;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use GuzzleHttp\Client;
use Pusher;
use sarelvdwalt\EVESDEBundle\Entity\invUniqueName;
use Swagger\Client\Api\PlanetaryInteractionApi;
use Swagger\Client\ApiException;
use Swagger\Client\Configuration;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\VarDumper\VarDumper;

class EveEsiTestCommand extends BaseCommand
{
    /** @var Client */
    protected $guzzleClient;

    protected $eve_client_id;
    protected $eve_secret_key;

    protected function configure()
    {
        $this
            ->setName('eve:esi:test')
            ->setDescription('Test / Playground while development is under way')
//            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
//            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        $this->guzzleClient = new Client();

        $this->eve_client_id = $this->getContainer()->getParameter('eve_client_id');
        $this->eve_secret_key = $this->getContainer()->getParameter('eve_secret_key');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $stopwatch = new Stopwatch();
            $stopwatch->start('main-execute');

            $this->getLogger()->info('Starting...');

            // Get and loop through all users, and their respective toons:
            $em = $this->getContainer()->get('doctrine')->getManager();

            foreach ($em->getRepository('AppBundle:User')->findAll() as $user) {
                /** @var User $user */

                $this->getLogger()->info('User: #' . $user->getId() . ' "' . $user->getUsername() . '"');

                foreach ($user->getToons() as $toon) {
                    /** @var Toon $toon */

                    $dbSideStack = array();

                    $tmp = $em->getRepository('AppBundle:Colony')->findBy([
                        'toon' => $toon
                    ]);

                    $dbSideStack['colonies'] = array();
                    $dbSideStack['pins'] = array();
                    $dbSideStack['links'] = array();
                    $dbSideStack['routes'] = array();

                    foreach ($tmp as $tmpOldColony) {
                        /** @var Colony $tmpOldColony */
                        $dbSideStack['colonies'][$tmpOldColony->getPlanetId()] = $tmpOldColony;
                    }

                    $this->getLogger()->info('Toon: #' . $toon->getId() . ' "' . $toon->getCharacterName() . '"');

                    $this->refreshToken($toon, $em);

                    Configuration::getDefaultConfiguration()->setAccessToken($toon->getEsiAccessToken());

                    $api_planetary_interaction = new PlanetaryInteractionApi();

                    $stopwatch->start('getCharactersCharacterIdPlanets');
                    $result = $api_planetary_interaction->getCharactersCharacterIdPlanets($toon->getId());
                    $stopwatch->stop('getCharactersCharacterIdPlanets');

                    $this->getLogger()->info('Getting Colonies...');

                    foreach ($result as $one_colony) {
                        $colony = null;

                        if (array_key_exists($one_colony->getPlanetId(), $dbSideStack['colonies'])) {
                            $colony = $dbSideStack['colonies'][$one_colony->getPlanetId()];
                        }

                        if (is_null($colony)) {
                            $colony = new Colony();
                            $colony->setToon($toon);
                        }
                        $colony->setLastUpdate($one_colony->getLastUpdate());
                        $colony->setNumPins($one_colony->getNumPins());
                        $colony->setPlanetId($one_colony->getPlanetId());
                        $invUniqueName = $em->getRepository('EVESDEBundle:invUniqueName')->find($one_colony->getPlanetId());
                        $colony->setInvUniqueName($invUniqueName);
                        $colony->setPlanetType($one_colony->getPlanetType());

                        $colony->setSolarSystemId($one_colony->getSolarSystemId());
                        $systemUniqueName = $em->getRepository('EVESDEBundle:invUniqueName')->find($one_colony->getSolarSystemId());
                        $colony->setSystemUniqueName($systemUniqueName);
                        $colony->setUpgradeLevel($one_colony->getUpgradeLevel());

                        $this->getLogger()->info('Processing Colony ' . $toon->getId() . '-' . $colony->getPlanetId() . '-' . $colony->getPlanetType());

                        $stopwatch->start('getCharactersCharacterIdPlanetsPlanetId');
                        $planet_result = $api_planetary_interaction->getCharactersCharacterIdPlanetsPlanetId($toon->getId(), $colony->getPlanetId());
                        $stopwatch->stop('getCharactersCharacterIdPlanetsPlanetId');

                        // Get all existing pins from DB:
                        $tmpOldPins = $em->getRepository('AppBundle:Pin')->findBy([
                            'colony' => $colony
                        ]);
                        foreach ($tmpOldPins as $tmpOldPin) {
                            /** @var $tmpOldPin Pin */
                            $dbSideStack['pins'][$tmpOldPin->getId() ] = $tmpOldPin;
                        }

                        foreach ($planet_result->getPins() as $one_pin) {
                            $pin = $em->getRepository('AppBundle:Pin')->find($one_pin->getPinId());

//                            $this->getLogger()->info('Pin: #' . $one_pin->getPinId());

                            if (is_null($pin)) {
                                $pin = new Pin();
                                $pin->setId($one_pin->getPinId());
                                $pin->setLongitude($one_pin->getLongitude());
                                $pin->setLatitude($one_pin->getLatitude());
                            }

                            $pin->setSchematicId($one_pin->getSchematicId());
                            $pin->setTypeId($one_pin->getTypeId());

                            $pin->setColony($colony);

                            if (null !== $one_pin->getExpiryTime()) {
                                $pin->setExpiryTime($one_pin->getExpiryTime());
                            }

                            if (null !== $one_pin->getInstallTime()) {
                                $pin->setInstallTime($one_pin->getInstallTime());
                            }

                            if (null !== $one_pin->getLastCycleStart()) {
                                $pin->setLastCycleStart($one_pin->getLastCycleStart());
                            }

//                            VarDumper::dump($pin);

//                            if (null !== $pin->getExpiryTime()) {
//                                exit;
//                            }

//                            exit;

                            // Pin Extractor Detail (if it's an extractor type pin):
                            if (null !== $one_pin->getExtractorDetails()) {
                                $pinExtractorDetail = $em->getRepository('AppBundle:PinExtractorDetail')->findOneBy([
                                    'pin' => $pin
                                ]);

                                if (is_null($pinExtractorDetail)) {
                                    $pinExtractorDetail = new PinExtractorDetail();
                                    $pinExtractorDetail->setPin($pin);
                                }

                                $pinExtractorDetail->setCycleTime($one_pin->getExtractorDetails()->getCycleTime());
                                $pinExtractorDetail->setHeadRadius($one_pin->getExtractorDetails()->getHeadRadius());
                                $pinExtractorDetail->setProductTypeId($one_pin->getExtractorDetails()->getProductTypeId());
                                $pinExtractorDetail->setQtyPerCycle($one_pin->getExtractorDetails()->getQtyPerCycle());

                                $em->persist($pinExtractorDetail);
                            }

                            $em->persist($pin);

                            // Remove pin that's already been synced:
                            unset($dbSideStack['pins'][$one_pin->getPinId()]);
                        }

                        // Links:
                        foreach ($planet_result->getLinks() as $link) {
                            $pinLink = $em->getRepository('AppBundle:PinLink')->findOneBy([
                                'destinationPinId' => $link->getDestinationPinId(),
                                'sourcePinId' => $link->getSourcePinId()
                            ]);

                            if (!is_object($pinLink)) {
                                $pinLink = new PinLink();
                                $pinLink->setDestinationPinId($link->getDestinationPinId());
                                $pinLink->setSourcePinId($link->getSourcePinId());
                            }

                            $pinLink->setLinkLevel($link->getLinkLevel());

                            $em->persist($pinLink);
                        }

                        // Routes:
                        foreach ($planet_result->getRoutes() as $route) {
                            $pinRoute = $em->getRepository('AppBundle:PinRoute')->findOneBy([
                                'routeId' => $route->getRouteId()
                            ]);

                            if (!is_object($pinRoute)) {
                                $pinRoute = new PinRoute();
                                $pinRoute->setRouteId($route->getRouteId());
                            }

                            $pinRoute->setContentTypeId($route->getContentTypeId());
                            $pinRoute->setDestinationPinId($route->getDestinationPinId());
                            $pinRoute->setQuantity($route->getQuantity());
                            $pinRoute->setSourcePinId($route->getSourcePinId());

                            $em->persist($pinRoute);

                            //TODO: Deal with waypoints (just VarDump the route and you'll see it)
                        }

                        $em->persist($colony);
                        $em->flush();

                        // Ensure that we are not left with this "found" colony in the list at the end
                        unset($dbSideStack['colonies'][$one_colony->getPlanetId()]);

                    }

                    // Delete all remaining colonies:
                    VarDumper::dump($dbSideStack);
                    
                    // For now we're retrieving things before deleting them, but later on we should no longer have to retrieve anymore:
                    foreach ($dbSideStack['pins'] as $pin_id => $pin) {
                        $em->remove($pin);
                    }

                    $em->flush();
                }
            }

            $this->getLogger()->info('... done.');

            $event = $stopwatch->stop('main-execute');

            foreach (['getCharactersCharacterIdPlanets', 'getCharactersCharacterIdPlanetsPlanetId', 'main-execute'] as $item) {
//                VarDumper::dump($stopwatch->getEvent('getCharactersCharacterIdPlanets'));
//                VarDumper::dump($stopwatch->getEvent('getCharactersCharacterIdPlanets')->getDuration());

                $this->getLogger()->alert('Call "' . $item . '" took ' . ($stopwatch->getEvent($item)->getDuration() / 1000) . ' seconds to run ' . count($stopwatch->getEvent($item)->getPeriods()) . ' times.');
            }

            if ($event->getDuration() / 1000 >= 20) {
                // Send push notification (testing for now):
                $options = array(
                    'cluster' => 'eu',
                    'encrypted' => true
                );
                $pusher = new Pusher(
                    'bf7ea183e4c3ef2f62cc',
                    'ef06a7642a23f3e14ef5',
                    '364587',
                    $options
                );

                $data['message'] = 'Update ran, took ' . ($event->getDuration() / 1000) . ' seconds.';
                $pusher->trigger('my-channel', 'my-event', $data);
            }

        } catch (ApiException $e) {
            VarDumper::dump([
                'body' => $e->getResponseBody(),
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }

    }

    /**
     * Refreshes the access token using the refresh-token if it's within 2 minutes from expiry
     *
     * @param Toon $toon
     * @param ObjectManager $em
     */
    protected function refreshToken(Toon $toon, ObjectManager $em)
    {
        $secondsToExpiry = ($toon->getExpiresOn()->getTimestamp() - (new \DateTime())->getTimestamp());

        if ($secondsToExpiry < 120) { // 2 minutes before it expires we want a new one

            $this->getLogger()->info('Refreshing token for ' . $toon->getCharacterName());

            $response = $this->guzzleClient->request('POST', 'https://login.eveonline.com/oauth/token', [
                'auth' => [
                    $this->eve_client_id,
                    $this->eve_secret_key
                ],
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $toon->getEsiRefreshToken()
                ]
            ]);

            $responseJSON = \GuzzleHttp\json_decode($response->getBody()->getContents());

            $toon->setEsiAccessToken($responseJSON->access_token);
            $toon->setExpiresOn(new \DateTime('+ ' . $responseJSON->expires_in . ' seconds'));
            $toon->setEsiRefreshToken($responseJSON->refresh_token);
            $toon->setEsiTokenType($responseJSON->token_type);

            $em->persist($toon);
            $em->flush();
        }
    }

}
