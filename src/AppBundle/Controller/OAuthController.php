<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Toon;
use GuzzleHttp\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

class OAuthController extends Controller
{
    /**
     * @Route("/callback", name="oauth_callback")
     */
    public function indexAction(Request $request)
    {
        $code = $request->get('code');

        if (is_null($code)) {
            throw new \Exception('code variable not set');
        }

        $client = new Client();

        $response = $client->request('POST', 'https://login.eveonline.com/oauth/token', [
            'auth' => [
                'fb16f4526c3b453c86786f8c7ea8d0b9',
                'yJB7iHMzaEkwMebrE7Fd6zmQInJnobgbZg6khz0H'
            ],
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code
            ]
        ]);

        $json = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
//        VarDumper::dump($json);

        $access_token = $json['access_token'];
        $token_type = $json['token_type'];
        $refresh_token = $json['refresh_token'];

        $response = $client->request('GET', 'https://login.eveonline.com/oauth/verify', [
            'headers' => [
                'Authorization' => [
                    'Bearer ' . $access_token
                ]
            ]
        ]);
        $json = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        $characterID = $json['CharacterID'];
//        VarDumper::dump($json);

        $toon = $this->get('doctrine')->getRepository('AppBundle:Toon')->find($characterID);
        if (is_null($toon)) {
            $toon = new Toon();
            $toon->setId($characterID);
        }

        $toon->setCharacterName($json['CharacterName']);
        $toon->setExpiresOn(new \DateTime($json['ExpiresOn']));
        $toon->setScopes($json['Scopes']);
        $toon->setTokenType($json['TokenType']);
        $toon->setCharacterOwnerHash($json['CharacterOwnerHash']);
        $toon->setIntellectualProperty($json['IntellectualProperty']);

        $toon->setEsiAccessToken($access_token);
        $toon->setEsiTokenType($token_type);
        $toon->setEsiRefreshToken($refresh_token);

        $em = $this->get('doctrine')->getManager();
        $em->persist($toon);
        $em->flush();

//        $response = $client->request('GET', 'https://esi.tech.ccp.is/latest/characters/' . $characterID . '/planets/', [
//            'headers' => [
//                'Authorization' => [
//                    'Bearer ' . $access_token
//                ]
//            ]
//        ]);
//
//        VarDumper::dump(\GuzzleHttp\json_decode($response->getBody()->getContents(), true));
//        exit;

        return $this->redirect($this->generateUrl('homepage'));
    }
}