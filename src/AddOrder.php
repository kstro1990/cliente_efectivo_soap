<?php

class AddOrder
{
    function getIpAddress()
    {
        // real ipAddress
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = null;
        }
        return $ip;
    }
    public function addOrder()
    {
        try {
            $ws = new SoapClient(WS_URI, [
                'exceptions' => true,
                'soap_version' => SOAP_1_1,
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
            $cashorder->ipAddress = '192.168.101.1';
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
            //print 'addorder: #orden en Place to Pay ' . $response->addOrderResult . PHP_EOL;
            //echo '<br>';
            $orderid = $response->addOrderResult;
            return $orderid;
            //header('Location: /efectivo');
        } catch (Exception $e) {
            echo $e->getMessage() . '<pre>';
        }
    }
}
?>
