 
<?php
session_start();
//connect to database
$link = mysqli_connect("localhost", "wampuser", "xxxx", "danmaku");
ob_start();

$ID_video = 'im3080';
$TB_responses = $ID_video.'_responses';
$ID_num = $_SESSION ['ID_num'];  

$sqlStr = "CREATE TABLE IF NOT EXISTS ".$TB_responses." (
           ID_num INT UNSIGNED        NOT NULL,
	       satisfied INT       NOT NULL,
	       neutral INT         NOT NULL,
	       unsatisfied INT       NOT NULL )";
$result=mysqli_query($link, $sqlStr);

//Check whether this student has responded
$sqlStrCheck = "SELECT * FROM im3080_responses WHERE ID_num = '$ID_num'";
$resultCheck=mysqli_query($link, $sqlStrCheck);
$count=mysqli_num_rows($resultCheck);
// If resultCheck doesn't have any result/rows, means the person has not responded
if($count==0){
	$sqlStr2 = "INSERT INTO im3080_responses (ID_num) VALUES ('$ID_num')";
	$result2=mysqli_query($link, $sqlStr2);
	
	$sqlStr3 = "UPDATE im3080_responses SET unsatisfied = unsatisfied + 1 WHERE ID_num = '$ID_num'";
	$result3=mysqli_query($link, $sqlStr3);
}
//If person has responded but want to change his response from "neutral"/"satisfied" to "unsatisfied"
//Also caters to if person accidentally click "unsatisfied" twice
else if ($count == 1){
	$sqlStr4 = "UPDATE im3080_responses SET satisfied = 0 WHERE ID_num = '$ID_num'";
	$result4=mysqli_query($link, $sqlStr4);
	$sqlStr5 = "UPDATE im3080_responses SET neutral = 0 WHERE ID_num = '$ID_num'";
	$result5=mysqli_query($link, $sqlStr5);
	$sqlStr6 = "UPDATE im3080_responses SET unsatisfied = 0 WHERE ID_num = '$ID_num'";
	$result6=mysqli_query($link, $sqlStr6);
	$sqlStr7 = "UPDATE im3080_responses SET unsatisfied = unsatisfied + 1 WHERE ID_num = '$ID_num'";
	$result7=mysqli_query($link, $sqlStr7);
}

?>



	