<?php 
include("conn.php");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
$method = $_SERVER['REQUEST_METHOD'];


switch ($method){
    case "GET":

        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $expense_type = mysqli_query($db_conn , "SELECT expense_type FROM add_expense WHERE id = '$id'");
            $exp = [];
            if(mysqli_num_rows($expense_type) > 0){
                while($row = mysqli_fetch_assoc($expense_type)){
                    $exp[] = $row; 
                }
                echo json_encode(['success'=>true,'data'=>$exp]);
            }else{
                echo json_encode(['success'=>false,'message'=>'No data found']);
            }
        }else{
            $expense_type = mysqli_query($db_conn , "SELECT exp_type FROM expense_type WHERE status = '1'");
        $expense_array = [];
        if(mysqli_num_rows($expense_type) > 0 ){
            while( $row =mysqli_fetch_assoc($expense_type)){
                $expense_array[] = $row;
            }
            echo json_encode(['data'=>$expense_array]);
        }
        else{
            echo json_encode(['success'=>false,'message'=>'Please check for data']);
        }   
        }
     
        break;
    case "POST":

        $expData = json_decode(file_get_contents("php://input"));

        $expense_type = $expData->expense_type;
        $userId = $expData->userId;
        $amount = $expData->amount;
        $description = $expData->description;
        $date = $expData->date;

        $query = "INSERT INTO add_expense(user_id , amount , description ,date  , expense_type ) VALUES('$userId' , '$amount' , '$description'  ,'$date','$expense_type')";

        $result = mysqli_query($db_conn , $query);

        if($result){
            echo json_encode(['success'=>true, 'message'=>'Expense Added Successfully']);
            exit;
        }else{
            echo json_encode(['success'=>false , 'message'=>'Failed to add Expense']);
            exit;
        }
        break;
}


?>