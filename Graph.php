<?php 

ini_set("display_error",1);
include("conn.php");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");



$method = $_SERVER['REQUEST_METHOD'];


switch($method){
    case "GET":
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $date = date("Y-m-d");

           $sql=  "SELECT COALESCE(SUM(amount),0) AS Expense FROM
                add_expense WHERE user_id = '$id' AND date = '$date'";

            $result = mysqli_query($db_conn,$sql);

            if($result){
                $row = mysqli_fetch_assoc($result);
                $expense = $row['Expense'];
            }
            
           $sql2=  "SELECT COALESCE(SUM(amount),0) AS Income FROM
           income WHERE user_id = '$id' AND date = '$date'";

            $result2 = mysqli_query($db_conn,$sql2);

            if($result2){
                $row = mysqli_fetch_assoc($result2);
                $income = $row['Income'];
            }
            echo json_encode(['success'=>true,'data'=>['income'=>$income , 'expense'=>$expense]]);
        }
        else{
            echo json_encode(['success'=>true,'message'=>'Please check input']);
        }
    break;
    case "POST":
    if(isset($_GET['user_id'])){
            $id = $_GET['user_id'];

            $sql=  "SELECT COALESCE(SUM(amount), 0)  as Expense
                            FROM add_expense WHERE date
                     BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE()) and user_id = '$id'";

        $result = mysqli_query($db_conn,$sql);

        if($result){
            $row = mysqli_fetch_assoc($result);
            $expense = $row['Expense'];
        }

        $sql2=  "SELECT income as Income FROM user where id = '$id'";


         $result2 = mysqli_query($db_conn,$sql2);

         if($result2){
             $row = mysqli_fetch_assoc($result2);
             $income = $row['Income'];
         }
         echo json_encode(['success'=>true,'data'=>['income'=>$income , 'expense'=>$expense]]);
        }else{
            echo json_encode(['success'=>true,'message'=>'Please check input']);
        }
    break;
}

?>