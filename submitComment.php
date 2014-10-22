<?php

session_start();

if(!empty($_GET['comment'])){
    $comment=$_GET['comment']; 
    $video_time = $_GET['video_time'];
    $size = $_GET['size'];
    $position = $_GET['position'];
    $color = $_GET['color'];


    // Define database related constants
    define('DB_HOSTNAME', 'localhost');
    define('DB_USERNAME', 'wampuser');
    define('DB_PASSWORD', 'xxxx');
    define('DB_DATABASE', 'danmaku');
    define('DB_PORT',     3306);


    // Connect to the MySQL server and set the default database
    $mysqli = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
    !$mysqli->connect_errno
        or die("Error: Failed to CONNECT: ({$mysqli->connect_errno}) {$mysqli->connect_error}");
    echo 'INFO: Connected to MySQL at ' . DB_HOSTNAME . ':' . DB_PORT . '/' . DB_DATABASE . ' (' . DB_USERNAME . ')<br />';

    //TODO:USE SESSION TO RETRIEVE VIDEO-ID
    $ID_video = 'im3080';
    $TB_comment = $ID_video.'_comment';
    $TB_like = $ID_video.'_like';
    $ID_num = $_SESSION ['ID_num'];
    
    if(!empty($_GET['url'])){
        $pStmt = $mysqli->prepare("INSERT INTO ".$TB_comment." (ID_num, content, video_time, sending_date, sending_time, like_num, dislike_num, color, size, position, isAnno, link) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")
    	      or die("Error: create prepared failed: ({$mysqli->errno}) {$mysqli->error}");
    	$content = $comment;
    	date_default_timezone_set('Asia/Singapore');
	$sending_date = date('Ymd');
	$sending_time = date('H:i:s');
	$like_num = 0;
	$dislike_num = 0;
        $isAnno = 1;
        $link = $_GET['url'];
	$pStmt->bind_param('isissiisssis', $ID_num, $content, $video_time, $sending_date, $sending_time, $like_num, $dislike_num, $color, $size, $position, $isAnno, $link)
	        and $pStmt->execute()
	      or die("Error: run prepared failed: ({$pStmt->errno}) {$pStmt->error}");
	echo "INFO: {$pStmt->affected_rows} row(s) inserted<br/>";
        
    }else{

        $pStmt = $mysqli->prepare("INSERT INTO ".$TB_comment." (ID_num, content, video_time, sending_date, sending_time, like_num, dislike_num, color, size, position) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")
    	      or die("Error: create prepared failed: ({$mysqli->errno}) {$mysqli->error}");
    	$content = $comment;
    	date_default_timezone_set('Asia/Singapore');
	$sending_date = date('Ymd');
	$sending_time = date('H:i:s');
	$like_num = 0;
	$dislike_num = 0;
	$pStmt->bind_param('isissiisss', $ID_num, $content, $video_time, $sending_date, $sending_time, $like_num, $dislike_num, $color, $size, $position)
	        and $pStmt->execute()
	      or die("Error: run prepared failed: ({$pStmt->errno}) {$pStmt->error}");
	echo "INFO: {$pStmt->affected_rows} row(s) inserted<br/>";
    }
	
}	
?>