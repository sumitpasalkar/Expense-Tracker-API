<?php
include("conn.php");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


$method = $_SERVER['REQUEST_METHOD'];


switch($method){
    case "GET":
        if(isset($_GET['id'])){
            $id = $_GET['id'];

            $query = "SELECT * FROM income WHERE id = '$id'";

            $result = mysqli_query($db_conn,$query);
            $income = [];
            if($result){
                    while($row = mysqli_fetch_assoc($result)){
                        $income = $row;
                    }
                    echo json_encode(['success'=>true,'data'=>$income]);
            }else{
                echo json_encode(['success'=>false,'message'=>'No data present']);
            }
        }else{
            echo json_encode(['success'=>false,'message'=>'Please check input']);   
        }
    break;
    case "POST":
        $input = json_decode(file_get_contents("php://input"));

        $id = $input->id;
        $amount = $input->amount;
        $date = $input->date;

        if($id){
            $query = "UPDATE income SET amount = '$amount' , date = '$date' WHERE id = '$id'";
            $result = mysqli_query($db_conn,$query);
            if($result){
                echo json_encode(['success'=>true,'message'=>'Income Edited']);
            }else{
                echo json_encode(['success'=>false,'message'=>'Failed to edit income']);
            }
        }else{
            echo json_encode(['success'=>true,'message'=>'Please check for Id']);
        }
    break;
    case "DELETE":
        $input = json_decode(file_get_contents("php://input"));
        
        if(isset($input->id)){
            $id = $input->id;
    
            $query = "DELETE FROM income WHERE id = '$id'";
            $result = mysqli_query($db_conn, $query);
            if($result){
                echo json_encode(['success'=>true,'message'=>'Income DELETED']);
            } else {
                echo json_encode(['success'=>false,'message'=>'Failed to DELETE income']);
            }
        } else {
            echo json_encode(['success'=>false,'message'=>'Please check for Id']);
        }
        break;
    


}

?>