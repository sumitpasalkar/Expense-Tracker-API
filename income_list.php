<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include("conn.php");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$method = $_SERVER['REQUEST_METHOD'];

if($method == "GET"){

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    $sql = "SELECT * FROM income where user_id = '$id' ";
    $result = mysqli_query($db_conn , $sql);
    $income = [];
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $income[] = $row;
        }
        echo json_encode(['success'=>true,'data'=>$income,'message'=>'Fetched Income Data']);
    }else{
        echo json_encode(['success'=>false,'message'=>'No Income Data']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing required parameter: id']);
}
}else{
    echo json_encode(['success'=>false , 'message'=>'check input']);
}

?>