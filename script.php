<?php

namespace PlacetoPay\Tests;

use \SoapClient;
use \Exception;
use \stdClass;
use \SoapFault;

define('WS_URI', 'https://test.placetopay.com/soap/cashorder/?wsdl');
define('P2P_LOGIN', '');
define('P2P_TRANKEY', '');

/**
 * Obtiene la dirección IP del cliente
 * @return string
 */
function getIpAddress()
{
    // real ipAddress
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
        //	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } else {
        $ip = null;
    }

    return $ip;
}

try {
    $ws = new SoapClient(WS_URI, [
        'exceptions' => true,
        'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
        'trace' => true,
    ]);

    // crea el objeto Authentication
    $auth = new stdClass();
    $auth->login = P2P_LOGIN;
    $auth->seed = date('c');
    $auth->tranKey = sha1($auth->seed . P2P_TRANKEY);

    // crea el objeto Person
    $buyer = new stdClass();
    $buyer->documentType = 'CC';
    $buyer->document = '123456789';
    $buyer->firstName = 'Jonathan';
    $buyer->lastName = 'Bedoya Restrepo';
    $buyer->company = 'EGM';
    $buyer->emailAddress = 'pruebasp2p@yopmail.com';
    $buyer->address =
        'Barrancabermeja (corregimiento el cemtro Vda progreso) Al lado de la de la bomba Gasolina la gran';
    $buyer->city = 'Medellín';
    $buyer->province = 'Antioquia';
    $buyer->country = 'CO';
    $buyer->phone = '4442310';
    $buyer->mobile = '3174310510';

    // crea un objeto Attribute para propositos de prueba
    $attribute1 = new stdClass();
    $attribute1->name = 'numeroOrden';
    $attribute1->value = (string) time();

    // crea el objeto CashOrder
    $cashorder = new stdClass();
    $cashorder->reference = 'test_extrao_2017';
    $cashorder->description =
        'Order 20584 - Products: Caminadora Aqua CMN0017I';
    $cashorder->language = 'ES';
    $cashorder->currency = 'COP';
    $cashorder->totalAmount = 15000;
    $cashorder->taxAmount = 1379;
    $cashorder->subtotalAmount = 8621;
    $cashorder->expiration = date('c', time() + 8 * 3600); // en 8 horas a partir del momento
    $cashorder->buyer = $buyer;
    $cashorder->ipAddress = getIpAddress();
    $cashorder->userAgent = !empty($_SERVER['HTTP_USER_AGENT'])
        ? $_SERVER['HTTP_USER_AGENT']
        : null;
    $cashorder->additionalData = [$attribute1];
    $cashorder->notificationURL = '';

    // invoca el servicio para obtener el identificador de la orden
    $params = new stdClass();
    $params->auth = $auth;
    $params->order = $cashorder;
    $response = $ws->addorder($params);
    var_dump($response);
    print 'addorder: #orden en Place to Pay ' .
        $response->addOrderResult .
        PHP_EOL;
} catch (SoapFault $e) {
    print $ws->__getLastRequestHeaders() . PHP_EOL;
    print $ws->__getLastRequest() . PHP_EOL;
    print 'SoapFault: ' . $e->getMessage() . PHP_EOL;
} catch (Exception $e) {
    print 'Exception: ' . $e->getMessage() . PHP_EOL;
}
