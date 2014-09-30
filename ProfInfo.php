 <html>
 <style>
 <body background="http://www.thoinayweb.com/wp-content/uploads/2013/12/powerpoint-background.jpg"> 
   <link href="css/ProfStyle.css" rel="stylesheet" type="text/css">
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
	<th>Number of Satisfied:
<?php
//Check whether this student has responded
$sqlStrCheck = "SELECT SUM(satisfied) FROM im3080_responses;";
$resultCheck=mysqli_query($link, $sqlStrCheck);
while ($row = mysqli_fetch_array($resultCheck)) {
 echo $row['SUM(satisfied)'];}
 ?> </th>
 <th>Number of Neutral:
 <?php
$sqlStrCheck = "SELECT SUM(neutral) FROM im3080_responses;";
$resultCheck=mysqli_query($link, $sqlStrCheck);
while ($row = mysqli_fetch_array($resultCheck)) {
 echo $row['SUM(neutral)'];}
 ?></th>
 <th>Number of Unsatisfied:
 <?php
$sqlStrCheck = "SELECT SUM(unsatisfied) FROM im3080_responses;";
$resultCheck=mysqli_query($link, $sqlStrCheck);
while ($row = mysqli_fetch_array($resultCheck)) {
 echo $row['SUM(unsatisfied)'];}
 ?></th>

</tr>
</table>

  <table border = 1 width = 75% align="center"> <tr>
 <th>Hot Comments: </th>
 <th>Video Time </th>
  <th>Sending Date </th>
  <th>Sending Time </th>
  </tr>
  
  <?php
$sqlStrCommentID = "SELECT MAX(like_num) FROM im3080_comment;";
$resultCommentID=mysqli_query($link, $sqlStrCommentID);
while($row = mysqli_fetch_array($resultCommentID)){
     $most_liked = $row['MAX(like_num)'];
	 // echo $most_liked; 
	 
$sqlStrLike = "SELECT * FROM im3080_comment WHERE  like_num = '$most_liked'"; 
$resultLike=mysqli_query($link, $sqlStrLike);
 while ($row = mysqli_fetch_array($resultLike)) {
	echo "<tr>", "<td align=center>", $row['content'], "</td>";
	echo "<td align=center>" , $row['video_time'], "</td>";
	echo "<td align=center>" , $row['sending_date'], "</td>";
	echo "<td align=center>" , $row['sending_time'], "</td>"; 
	echo "</tr>";
	echo "<br>";}
	}
 ?>

 </table>
 </body>
 </html>

 