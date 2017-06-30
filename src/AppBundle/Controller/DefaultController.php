<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pin;
use AppBundle\Entity\User;
use Carbon\Carbon;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT ed.pin_id,
       t.id,
       t.character_name,
       c.planet_id,
       c.solar_system_id,
       c.num_pins,
       c.planet_type,
       p.last_cycle_start,
       p.install_time,
       p.expiry_time,
       ed.cycle_time,
       ed.product_type_id,
       ed.qty_per_cycle,
       timediff(p.expiry_time, :seedtime) time_till_end,
       unix_timestamp(p.expiry_time)-unix_timestamp(:seedtime) AS unix_diff
FROM pin_extractor_detail ed
INNER JOIN pin p ON (ed.pin_id = p.id)
INNER JOIN colony c ON (c.id = p.colony_id)
INNER JOIN toon t ON (t.id = c.toon_id)
ORDER BY t.character_name;");
        $statement->bindValue('seedtime', (new \DateTime('now', new \DateTimeZone('UTC')))->format('Y-m-d H:i:s'));
        $statement->execute();
        $results = $statement->fetchAll();

        $now = new Carbon('now', new \DateTimeZone('UTC'));
        foreach ($results as $i => $result) {
            $results[$i]['diff_hours'] = $now->diffInHours(new Carbon($result['expiry_time']));
            $results[$i]['diff_days'] = $now->diffInDays(new Carbon($result['expiry_time']));
        }

//        VarDumper::dump($results);
//        exit;

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
            'toon_count' => $user->getToons()->count(),
            'colony_view' => $results
        ];
    }

    /**
     * @param $pin_id
     * @return JsonResponse
     *
     * @Route("/api/extractor/{pin_id}/chartdata", name="api_extractor_pinid_chartdata")
     */
    public function extractorChart($pin_id)
    {
        $pin = $this->get('doctrine')->getRepository('AppBundle:Pin')->findOneBy([
            'id' => $pin_id
        ]);
        /** @var $pin Pin */

        $payload = $this->calcPIProgramChart($pin->getInstallTime(), $pin->getExpiryTime(), $pin->getPinExtractorDetail()->getCycleTime(), $pin->getPinExtractorDetail()->getQtyPerCycle());

        foreach ($payload['values'] as $key => $value) {
            if ($value >= $payload['perc95th']) {
                $color = 'red';
            } elseif ($value >= $payload['perc66th']) {
                $color = 'orange';
            } elseif ($value >= $payload['perc33th']) {
                $color = 'green';
            } else {
                $color = 'grey';
            }

            $payload['values'][$key] = [
                'y' => $value,
                'color' => $color
            ];
        }

        return new JsonResponse($payload);
    }

    protected function get_percentile($percentile, $array) {
        sort($array);
        $index = ($percentile/100) * count($array);
        if (floor($index) == $index) {
            $result = ($array[$index-1] + $array[$index])/2;
        }
        else {
            $result = $array[floor($index)];
        }
        return $result;
    }

    protected function calcPIProgramChart(\DateTime $vInstallTime, \DateTime $vExpiryTime, $vCycleTime, $vQuantityPerCycle)
    {
        $sec = 1;
        $values = array();
        $installTime = $vInstallTime->getTimestamp();
        $expiryTime = $vExpiryTime->getTimestamp();
        $numIterations = ($expiryTime - $installTime) / $vCycleTime;

        $decayFactor = (float)0.012;
        $noiseFactor = (float)0.8;

        $barWidth = (float)($vCycleTime / 1 / (float)900);

        $f1 = (float)1 / 12;
        $f2 = (float)1 / 5;
        $f3 = (float)1 / 2;

        $tmpMaxYield = null;
        $tmpMinYield = null;

        for ($i = 0; $i < $numIterations; $i++) {
            $timeDiff = ($i + 1) * $vCycleTime;

            $cycleNum = max(($timeDiff + $sec) / $vCycleTime, 0);

            $t = ($cycleNum + (float)0.5) * $barWidth;

            $decayValue = $vQuantityPerCycle / (1 + $t * $decayFactor);

            $phaseShift = pow($vQuantityPerCycle, (float)0.7);

            $sinA = (double)cos($phaseShift + $t * $f1);
            $sinB = (double)cos($phaseShift / 2 + $t * $f2);
            $sinC = (double)cos($t * $f3);

            $sinStuff = ($sinA + $sinB + $sinC) / 3;
            $sinStuff = max($sinStuff, 0);

            $barHeight = $decayValue * (1 + $noiseFactor * $sinStuff);

            $value = (int)($barWidth * $barHeight);
            $values[] = $value;

            // Update statistical info:
            if (null === $tmpMaxYield || $tmpMaxYield < $value) {
                $tmpMaxYield = $value;
            }

            if (null === $tmpMinYield || $tmpMinYield > $value) {
                $tmpMinYield = $value;
            }
        }

        // median:
        $tmpValues = array_values($values);
        sort($tmpValues);
        $tmpMedian = $tmpValues[(count($tmpValues) + 1) / 2];

        $carbonInstallTime = Carbon::instance($vInstallTime);

//        VarDumper::dump($carbonInstallTime);
//        VarDumper::dump($carbonInstallTime->diffInSeconds(new Carbon('now')));
//        VarDumper::dump($carbonInstallTime->diffInSeconds(new Carbon('now', new \DateTimeZone('Europe/Berlin'))));

        $now = new \DateTime('now');
        if (($vInstallTime <= $now) && ($now <= $vExpiryTime)) {
            $plotLineNOW = floor($carbonInstallTime->diffInMinutes(Carbon::instance($now)) / (15 * $barWidth));
        }

        return [
            'barWidth' => $barWidth,
            'maxValue' => $tmpMaxYield,
            'minValue' => $tmpMinYield,
            'average' => array_sum($values) / count($values),
            'median' => $tmpMedian,
            'perc95th' => $this->get_percentile(95, $values),
            'perc66th' => $this->get_percentile(66, $values),
            'perc33th' => $this->get_percentile(33, $values),
            'plotLineNOW' => (isset($plotLineNOW) ? $plotLineNOW : null),
            'values' => $values
        ];
    }

}
