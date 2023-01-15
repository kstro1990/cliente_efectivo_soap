<?php

class GetOrder
{
    public function buscarOrder($orderid)
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

            // obtiene el PDF de la orden
            $params = new stdClass();
            $params->auth = $auth;
            $params->id = $orderid;
            $response = $ws->getOrder($params);
            var_dump($response);
            return response;
        } catch (Exception $e) {
            echo $e->getMessage() . '<pre>';
        }
    }
}
?>
