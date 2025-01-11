<?php 
ini_set("display_error",1);
include("conn.php");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    case  "GET":
        if(isset($_GET['id'])){
            $id = $_GET['id'];
             $sql = "SELECT * FROM user WHERE id = '$id'";

        $result = mysqli_query($db_conn , $sql);
        $profile = [];
        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
                $profile = $row;
            }
            echo json_encode(['success'=>true,'message'=>'Profile data fetched','data'=>$profile]);
        }else{
            echo json_encode(['success'=>false,'message'=>'Failed to fetch']);
        }
        }
       
        break;
    
    case "POST":

        $input = json_decode(file_get_contents("php://input"));
        $id = $input->id;
        $name = $input->name;
        $email = $input->email;
        $password = $input->password;
        $income = $input->income;
        $contact = $input->contact;

        $sql = "UPDATE user SET name = '$name',email='$email',contact = '$contact', password='$password',income='$income' WHERE id = '$id'";

        $result = mysqli_query($db_conn , $sql);

        if($result){
            echo json_encode(['success'=>true,'message'=>'Profile Updated']);
        }else{
            echo json_encode(['success'=>false,'message'=>'Failed to update']);
        }
        break;
}




?>
