<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate product object
include_once '../objects/examenes.php';

$database = new Database();
$db = $database->getConnection();

$examen = new Examen($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if  (
    !empty($data->tipo_Examen) &&
    !empty($data->fecha_Examen) &&
    !empty($data->estado_examen) &&
    !empty($data->fecha_Limite) &&
    !empty($data->idpaciente) &&
    !empty($data->num_Expediente)
    )
{

    // set product property values
    $examen->tipo_Examen = $data->tipo_Examen;
    $examen->fecha_Examen = $data->fecha_Examen;
    $examen->estado_examen = $data->estado_examen;
    $examen->fecha_Limite = $data->fecha_Limite;
    $examen->idpaciente = $data->idpaciente;
    $examen->num_Expediente = $data->num_Expediente;

    // create the product
    if($examen->create())
    {
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array("message" => "exam was created."));
    }
    // if unable to create the product, tell the user
    else
    {
        // set response code - 503 service unavailable
        http_response_code(503);
        // tell the user
        echo json_encode(array("message" => "Unable to create exam."));
    }
}

// tell the user data is incomplete
    else
    {
    // set response code - 400 bad request
    http_response_code(400);
    // tell the user
    echo json_encode(array("message" => "Unable to create exam. Data is incomplete."));
    }
?>