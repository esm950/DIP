 <html>
 <body> 
   <link href="css/personalStyle.css" rel="stylesheet" type="text/css">
<?php
session_start();
//connect to database
$link = mysqli_connect("localhost", "wampuser", "xxxx", "danmaku");
ob_start();

$ID_num = $_SESSION ['ID_num'];  


  echo $_SESSION['student_ID'];
  ?>
  <br> <br> <br>
    <table border = 0 width = 75% align="center"> 
	<tr>
	<th>Response:
<?php
//Check whether this student has responded
$sqlStrCheck = "SELECT * FROM im3080_responses WHERE ID_num = '$ID_num'";
$resultCheck=mysqli_query($link, $sqlStrCheck);
while ($row = mysqli_fetch_array($resultCheck)) {
 if ($row['satisfied'] == 1) {
 echo 'Satisfied';}
 if ($row['neutral'] == 1) {
 echo 'Neutral';}
 if ($row['unsatisfied']==1) {
 echo 'Unsatisfied';}
}
 ?>
 </th>
</tr>
</table>

  <table border = 1 width = 75% align="center"> <tr>
 <th>Comments posted: </th>
 <th>Video Time </th>
  <th>Sending Date </th>
  <th>Sending Time </th>
  </tr>
  
  <?php
$sqlStrComment = "SELECT * FROM im3080_comment WHERE ID_num = '$ID_num'";
$resultComment=mysqli_query($link, $sqlStrComment);
 while ($row = mysqli_fetch_array($resultComment)) {
	echo "<tr>" , "<td align=center>", $row['content'] ,"</td>";
	echo "<td align=center>" , $row['video_time'], "</td>";
	echo "<td align=center>" , $row['sending_date'], "</td>";
	echo "<td align=center>" , $row['sending_time'], "</td>"; 
	echo "</tr>";
	echo "<br>";}
 ?>
 <br>
  <table border = 1 width = 75% align="center"> <tr>
   <th>Comments liked: </th>
  <th>Video Time </th>
  <th>Sending Date </th>
  <th>Sending Time </th>
  </tr>

   <?php
$sqlStrCommentID = "SELECT * FROM im3080_like WHERE ID_num = '$ID_num' AND click_like = 1";
$resultCommentID=mysqli_query($link, $sqlStrCommentID);
while($row = mysqli_fetch_array($resultCommentID)){
   //echo $row['comment_ID'];
 $comment_ID = $row['comment_ID'];

$sqlStrLike = "SELECT * FROM im3080_comment WHERE comment_ID = '$comment_ID'";
$resultLike=mysqli_query($link, $sqlStrLike);
 while ($row = mysqli_fetch_array($resultLike)) {
	echo "<tr>", "<td align=center>", $row['content'], "</td>";
	echo "<td align=center>" , $row['video_time'], "</td>";
	echo "<td align=center>" , $row['sending_date'], "</td>";
	echo "<td align=center>" , $row['sending_time'], "</td>"; 
	echo "</tr>";
	echo "<br>";}
  echo "<br>";
	}
 ?>

 </table>
 </body>
 </html>

 