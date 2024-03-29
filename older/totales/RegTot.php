<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/Totales.php';

// instantiate database and product object
    $database = new Database();
    $db = $database->getConnection();

// initialize object
    $consulta = new TotalesR($db);
// read products will be here
// read products

// query products
    $stmt = $consulta->CountTot();
    $num = $stmt->rowCount();

// check if more than 0 record found
    if($num>0)
    {
        $Rtotal_arr=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
            //print_r($row);
            $Rtotal_item=array(
                "totalEmple" => $totalEmple,
                "totalPa" => $totalPa,
                "totalCon" => $totalCon
            );
    
            array_push($Rtotal_arr, $Rtotal_item);
        }
    
        // set response code - 200 OK
        http_response_code(200);
    
        // show products data in json format
        echo json_encode($Rtotal_arr);
    }
else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No employee found.")
    );
}