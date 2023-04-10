<?php
//add headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

//import file
include_once("../database/database.php");
include_once("../vendor/autoload.php");

//initialize database
$obj = new Database();


//check method request
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $conditionString = "";
    if (isset($_GET['status']) && $_GET['status'] !== "all") {
        $conditionString  = $conditionString . "status LIKE '%{$_GET['status']}%' " . " and ";
    }
    if (isset($_GET['user_id'])) {
        $conditionString  = $conditionString . "user_id = " . $_GET['user_id']  . " and ";
    }
    $conditionString =  rtrim($conditionString, " and ");

    $sql = $obj->select("bills", "*", "", "", $conditionString, "", "");
    $result = $obj->getResult();
    if ($sql) {
        $data = $obj->getResult();
        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "data" => $result,
        ]);
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
        "message" => "Access denied!",
    ));
}