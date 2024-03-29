<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/database.php';
include_once '../objects/item_cita.php';


$database = new Database();
$db = $database->getConnection();


$itemc = new ItemC($db);


$data = json_decode(file_get_contents("php://input"));


$itemc->idItemC = $data->idItemC;


$itemc->Estado = $data->Estado;
$itemc->IdHorario = $data->IdHorario;




if($itemc->update()){


    http_response_code(200);


    echo json_encode(array("message" => "event was updated."));
}

else{


    http_response_code(503);


    echo json_encode(array("message" => "Unable to update event."));
}
?>