<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../objects/pending_quotes.php';

$database = new Database();
$db = $database->getConnection();


$pending = new pending_quotes($db);


// set ID property of record to read
$pending->idpaciente = isset($_GET['idpaciente']) ? $_GET['idpaciente'] : die();

// read the details of product to be edited
$stmt = $pending->customRead();
$num = $stmt->rowCount();
$pending_arr=array();
if($num>0){

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $pending_item=array(
            "fecha" => $fecha,
            "hora" => $hora,
            "tipo" => $tipo
        );

        array_push($pending_arr, $pending_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show products data in json format
    echo json_encode($pending_arr);
}
else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No invoices found.")
    );
}
?>