<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include("conn.php");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$method = $_SERVER['REQUEST_METHOD'];

if ($method == "DELETE") {
    $input = json_decode(file_get_contents("php://input"), true);

    if (!$input || !isset($input['id'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid input data']);
        exit;
    }

    $id = mysqli_real_escape_string($db_conn, $input['id']);

    $sql = "DELETE FROM add_expense WHERE id = '$id'";
    $result = mysqli_query($db_conn, $sql);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Expense Deleted Successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete the expense']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Request Method']);
    exit;
}

?>
