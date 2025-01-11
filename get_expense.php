<?php 
include("conn.php");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

$userId = $_GET['id'];

$sql = "SELECT * FROM add_expense WHERE user_id = '$userId'";

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

}else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);
}
?>