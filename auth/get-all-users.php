<?php
//add headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

//import file
include_once "../middleware/check-auth.php";
include_once("../database/database.php");
include_once("../vendor/autoload.php");

//initialize database
$obj = new Database();


//check method request
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $payload = checkAuth(getallheaders(), "admin");
    if ($payload) {
        $sql = $obj->select("users", "*", "", "", "", "", "");
        if ($sql) {
            $result = $obj->getResult();
            http_response_code(200);
            echo json_encode([
                "status" => "success",
                "data" => $result,
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Server is errored!"
            ]);
        }
    }
} else {
    http_response_code(405);
    echo json_encode(array(
        "status" => "error",
        "message" => "Access denied!",
    ));
}
