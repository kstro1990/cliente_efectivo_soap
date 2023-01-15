<?php

class GetOrderPDF
{
    public function getOrderPDF($orderid)
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
            $response = $ws->getOrderPDF($params);
            chdir('../pdf');
            $filename = getcwd() . '/cashorder_' . $orderid . '.pdf';
            print 'getOrderPDF: detalle del PDF ' .
                PHP_EOL .
                $response->getOrderPDFResult .
                PHP_EOL;
            echo '<br>';
            $fh = @fopen($filename, 'wb');
            if ($fh) {
                fwrite($fh, base64_decode($response->getOrderPDFResult));
                fclose($fh);
            }
            print 'getOrderPDF: archivo generado en ' . $filename . PHP_EOL;
        } catch (Exception $e) {
            echo $e->getMessage() . '<pre>';
        }
    }
}
?>
