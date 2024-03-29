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
include_once '../objects/usuario.php';

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
$idempleado = isset($_GET['idempleado']) ? $_GET['idempleado'] : die();

// make sure data is not empty
if  (
    !empty($data->user_Name) &&
    !empty($data->user_Password) &&
    !empty($data->email) &&
    !empty($data->user_type) &&
    !empty($data->valor)
    )
{

    // set product property values
    $usuario->user_Name = $data->user_Name;
    $usuario->user_Password = $data->user_Password;
    $usuario->email = $data->email;
    $usuario->user_type = $data->user_type;
    $usuario->valor = $data->valor;

    // create the product
    if($usuario->create($idempleado))
    {
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array("message" => "User was created."));
    }
    // if unable to create the product, tell the user
    else
    {
        // set response code - 503 service unavailable
        http_response_code(503);
        // tell the user
        echo json_encode(array("message" => "Unable to create user."));
    }
}else
    {
    // set response code - 400 bad request
    http_response_code(400);
    // tell the user
    echo json_encode(array("message" => "Unable to create quote. Data is incomplete."));
    }
?>