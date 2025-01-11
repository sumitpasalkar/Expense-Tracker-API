<?php

$db_conn = mysqli_connect("localhost","root","","expense");


if(!$db_conn){
    die("Error to connect".mysqli_connect_error());
}
else{
    // echo "connection success";
}

?>