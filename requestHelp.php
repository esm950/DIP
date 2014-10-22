<?php

session_start();

if(!empty($_GET['comment_ID'])&&!empty( $_GET['ID_video'])&&!empty($_GET['ID_num'])){
    $comment_ID=$_GET['comment_ID']; 
    $ID_video = $_GET['ID_video'];
    $ID_num=$_GET['ID_num']; 
    
    // Define database related constants
    define('DB_HOSTNAME', 'localhost');
    define('DB_USERNAME', 'wampuser');
    define('DB_PASSWORD', 'xxxx');
    define('DB_DATABASE', 'danmaku');
    define('DB_PORT',     3306);


    // Connect to the MySQL server and set the default database
    $con = mysqli_connect("localhost","wampuser","xxxx","danmaku");
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    mysqli_select_db($con,"danmaku");
    //TODO:USE SESSION TO RETRIEVE VIDEO-ID
    $TB_request = $ID_video.'_request';
    
    date_default_timezone_set('Asia/Singapore');
    $request_date = date('Ymd');
    $request_time = date('H:i:s');
    
    $sql='SELECT * FROM '.$TB_request.' WHERE comment_ID='.$comment_ID.' AND ID_num='.$ID_num;
    $result = mysqli_query($con,$sql);
    
    if($result->num_rows<1){
    	$sqlStr = "INSERT INTO ".$TB_request." (comment_ID, ID_num, request_date, request_time) VALUES (".$comment_ID.", ".$ID_num.", '".$request_date."', '".$request_time."')";
    	
    	
    } else {
    	$sqlStr = "UPDATE ".$TB_request." SET request_date='".$request_date."', request_time='".$request_time."', isProcessed=0 WHERE comment_ID=".$comment_ID." AND ID_num=".$ID_num;

    }
	
    mysqli_query($con,$sqlStr);
     
    mysqli_close($con);

}	

?>