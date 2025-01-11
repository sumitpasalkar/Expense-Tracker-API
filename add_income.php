<?php  

ini_set("display_error",1);
include("conn.php");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


$method = $_SERVER['REQUEST_METHOD'];


if($method == "POST"){

    $input = json_decode(file_get_contents("php://input"));

    $userId = $input->user_id;
    $amount = $input->amount;
    $date = $input->date;

    $query = "INSERT INTO income(user_id , amount , date)VALUES('$userId','$amount','$date')";

    $result = mysqli_query($db_conn , $query);

    if($result){
        echo json_encode(['success'=>true,'message'=>'Income added successfully']);
    }else{
        echo json_encode(['success'=>false,'message'=>'Failed to add income']);
    }
}else{
    echo json_encode(['success'=>false , 'message'=>'Check Input']);
}


?>