<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Toon;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Swagger\Client\Api\AllianceApi;
use Swagger\Client\Api\PlanetaryInteractionApi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
//        $api_instance = new AllianceApi();
//        $api_planets = new PlanetaryInteractionApi();
//
        /** @var User $user */
        $user = $this->getUser();
//
//        try {
//            foreach ($user->getToons() as $toon) {
//                /** @var Toon $toon */
//                $result = $api_planets->getCharactersCharacterIdPlanets($toon->getId(), null, $toon->getEsiAccessToken());
//                VarDumper::dump($result);
//            }
//        } catch (\Exception $e) {
//            echo 'Exception when calling AllianceApi->getAlliances: ', $e->getMessage(), PHP_EOL;
//            VarDumper::dump($e);
//        }
//
//        exit;
//
//
//        VarDumper::dump($api_instance);
//        exit;
//
        return [
            'toon_count' => $user->getToons()->count()
        ];
    }
}
