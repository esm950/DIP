<?php
session_start();
//get parameters
$comment_ID=$_GET['comment_ID'];
$TB_comment=$_GET['TB_comment'];
$TB_like=$_GET['TB_like'];
$ID_num = $_SESSION['ID_num'];

//connect to database danmaku
$con = mysqli_connect("localhost","wampuser","xxxx","danmaku");
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"danmaku");

//check if the certain user(ID_num) has liked the certain comment(comment_ID) or not
//if not, then add to table TB_like with click_like=1
//and also update the like_num of that comment in table TB_comment
$sql_like= 'SELECT * FROM '.$TB_like.' WHERE comment_ID='.$comment_ID.' AND ID_num='.$ID_num;
$result_like=mysqli_query($con,$sql_like);

if($result_like->num_rows<1){    
    $sql= "INSERT INTO ".$TB_like." (ID_num, comment_ID, click_like) VALUES (".$ID_num.", ".$comment_ID.", 1)";
    mysqli_query($con,$sql);
    
    $sql= 'UPDATE '.$TB_comment.' SET like_num = like_num + 1 WHERE comment_ID='.$comment_ID;
    mysqli_query($con,$sql);
    
    echo"LIKED (";
}else{
    foreach ($result_like as $row) {  // Loop thru all rows in resultset
        if($row['click_like']==1){
             $sql= 'DELETE FROM '.$TB_like.' WHERE comment_ID='.$comment_ID.' AND ID_num='.$ID_num;
             mysqli_query($con,$sql);
             $sql= 'UPDATE '.$TB_comment.' SET like_num = like_num-1 WHERE comment_ID='.$comment_ID;
             mysqli_query($con,$sql);
        }
        echo"LIKE (";
    }
}

//retrieve and show the total number of likes of a certain comment(comment_ID)
$sql='SELECT like_num FROM '.$TB_comment.' WHERE comment_ID='.$comment_ID;
$result = mysqli_query($con,$sql);

$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
printf ("%d",$row["like_num"]);
echo")";

mysqli_close($con);

?>