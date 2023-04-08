<?php
//add headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

//import file
include_once "../database/database.php";

//initialize database
$obj = new Database();

//check method request
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $conditionString = "";
    if (isset($_GET['bill_id'])) {
        $conditionString  = $conditionString . "bill_id = " . $_GET['bill_id'] . " and ";
    }
    $conditionString =  rtrim($conditionString, " and ");
    $sql = $obj->select("bill_details", "*", "", "", $conditionString, "", "");
    $result = $obj->getResult();
    if ($sql) {
        http_response_code(200);
        echo json_encode(array(
            "status" => "success",
            "data" => $result,
        ));
    } else {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => $result,
        ]);
    }
} else {
    echo json_encode(array(
        "status" => "error",
        "message" => "Access denied!"
    ));
}
