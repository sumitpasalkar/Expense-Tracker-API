<?php

ini_set("display_error",1);

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$db_conn = mysqli_connect("localhost","root","","expense");


if(!$db_conn){
    die("Error to connect".mysqli_connect_error());
}
else{
    // echo "connection success";
}

$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    case "POST":

        $input = file_get_contents("php://input");

        $userData = json_decode($input);


        $email = $userData->email;
        $password = $userData->password;


        $query = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($db_conn, $query);


        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            echo json_encode([
                "success" => true,
                "message" => "Login successful.",
                "userId" => $user['id']
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Invalid email or password."]);
        }
        break;
}


?>