<?php

include __DIR__ . '/AddOrder.php';
include __DIR__ . '/getOrder.php';
include __DIR__ . '/deleteOrder.php';
session_start();

define('WS_URI', 'https://test.placetopay.com/soap/cashorder/?wsdl');
//define('P2P_LOGIN', '');
//define('P2P_TRANKEY', '');

define('P2P_LOGIN', $_SESSION['login']);
define('P2P_TRANKEY', $_SESSION['secretKey']);

$idForm = '';
$orderID = '';

if ($_POST['idForm']) {
    $idForm = $_POST['idForm'];
}
if ($_POST['orderid']) {
    $orderID = $_POST['orderid'];
}
//var_dump($idorden);

switch ($idForm) {
    case 'addOrden':
        echo 'estoy por aqui:';
        $AddOrder = new AddOrder();
        $idOrden = $AddOrder->addOrder();
        echo $idOrden;
        $_SESSION['idorden'] = $idOrden;
        header('Location: /efectivo');
        break;
    case 'getPDF':
        echo 'generando pdf : ';
        break;
    case 'get':
        $oPDF = new getOrder();
        $oPDF->buscarOrder($idOrden);
        break;
    case 'delete':
        echo 'eliminado : ';
        $deleteOrder = new DeleteOrden();
        $respuesta = $deleteOrder->delete($orderID);
        echo $respuesta . " id: $orderID";
        break;
    case 'credeciales':
        header('Location: /efectivo');
        break;
    default:
        $sort = 'rd';
        break;
}

?>
