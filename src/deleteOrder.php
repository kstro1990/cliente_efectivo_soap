<?php

class DeleteOrden
{
    public function delete($orderid)
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
            // elimina la orden
            $params = new stdClass();
            $params->auth = $auth;
            $params->id = $orderid;
            $response = $ws->deleteOrder($params);
            return $response->deleteOrderResult;
        } catch (Exception $e) {
            echo $e->getMessage() . '<pre>';
        }
    }
}
?>
