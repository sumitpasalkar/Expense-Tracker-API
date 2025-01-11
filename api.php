<?php

ini_set("display_error",1);
include("conn.php");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");



$method = $_SERVER['REQUEST_METHOD'];


switch($method){
    case  "POST" : 
        $input = file_get_contents("php://input");
        
        $userData = json_decode($input); 
        // print_r($userData);
        if (!$userData) {
            echo json_encode(['success' => false, 'message' => 'Invalid or missing JSON payload']);
            exit;
        }

        $name = $userData->name;
        $income = $userData->income;
        $email = $userData->email;
        $address = $userData->address;
        $password = $userData->password;
        $date = $userData->date;

        $checkEmailQuery = "SELECT * FROM user WHERE email = '$email'";
        $emailResult = mysqli_query($db_conn, $checkEmailQuery);

            if(mysqli_num_rows($emailResult) > 0 ){
                echo json_encode(['success'=>false,'message'=>'Email already exist']);
            }else{
                  $insert = mysqli_query($db_conn , "INSERT INTO user (email , address , password , date , name  , income ) VALUES ('$email' , '$address' , '$password','$date','$name','$income')");

            if($insert){
                echo json_encode(['success'=>true , 'message'=>'Register successfully']);
            }else{
                echo json_encode(['success'=>false, 'message'=>'Error Occured'.mysqli_error($db_conn)]);
            }
         }
          
            
    break;
}

?>