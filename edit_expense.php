<?php 
include("conn.php");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

$userId = $_GET['id'];

$sql = "SELECT * FROM add_expense WHERE id = '$userId'";

$result = mysqli_query($db_conn , $sql);
$expense = array();
if($result){
    while($row = mysqli_fetch_assoc($result)){
       $expense[] = $row;
    }
    echo json_encode(['success'=>true,'data'=>$expense]);
}else{
    echo json_encode([
        "success" => false,
        "message" => "No expenses found for the user."
    ]);
}

}elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $input = json_decode(file_get_contents("php://input"));

    $id= $input->id;
    $description = $input->description;
    $date = $input->date;
    $amount = $input->amount;
    $expense_type = $input->expense_type;

    $sql = "UPDATE add_expense SET description = '$description' , date = '$date' , amount = '$amount' , expense_type = '$expense_type' WHERE id = '$id' ";

    $result = mysqli_query($db_conn,$sql);

    if($result){
        echo json_encode(['success'=>true , 'message'=>'Expense Updated']);
    }else{
        echo json_encode(['success'=>false, 'message'=>'Failed to Update']);
    }
}
?>