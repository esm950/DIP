<?php
//connect to database
$link = mysqli_connect("localhost", "wampuser", "xxxx", "danmaku");
ob_start();
$student_ID = $_POST['mystudent_ID']; // take in the student_ID keyed-in from the login page
$password=$_POST['mypassword']; // take in the password keyed-in from the login page


// To protect mysql injection (more detail about mysql injection)
$student_ID = stripslashes($student_ID);
$password = stripslashes($password);
$student_ID = mysqli_real_escape_string($link, $student_ID);
$password = mysqli_real_escape_string($link, $password);
$sql="SELECT * FROM userinfo WHERE student_ID='$student_ID' and password='$password'";
$result=mysqli_query($link, $sql);

$result2 = mysqli_query($link,"SELECT ID_num from userinfo where student_ID='$student_ID' and password='$password'");
while($row = mysqli_fetch_array($result2)) {        //to print the ID_num out
	//echo $row['ID_num'];
	$ID_num = $row['ID_num'];   //define $ID_num
}

// mysqli_num_row is counting table row
$count=mysqli_num_rows($result);

// If result matched 'mystudent_ID' and 'mypassword', table row must be 1 row
if($count==1){

// Register $mystudent_ID, $mypassword
session_start();
//$_SESSION [$_POST['mystudent_ID']] = $student_ID;
//$_SESSION [$_POST['mypassword']] = $password;
//$_SESSION[$row['ID_num']] = $ID_num;

$_SESSION ['student_ID'] = $student_ID;
$_SESSION ['password'] = $password;
$_SESSION['ID_num'] = $ID_num;

}
else {
header("location:wronglogin.php");
}
ob_end_flush();
?>

<html>
<head>
<title>Blackboard Learn</title>
<link rel="stylesheet" href="css/styles.css" type="text/css" />
</head>
<body>
<?php

echo $_SESSION ['student_ID'];
echo "<br>";
echo $ID_num;  //for debugging purpose

// Check if session is not registered, redirect back to main page. 
 //Put this code in first line of web page. 

//if(isset($_SESSION["mystudent_ID"]) != $student_ID){
//header("location:login3.php");
//}

?>
<h1>NTULearn</h1>
<hr />
	<form action="login.php">
    <input type="submit" name="Logout" class="logout" value="Logout">
	</form>

<div id="menucase">
  <div id="stylefour">
    <ul>
      <li><a href="#url">Home</a></li>
      <li><a href="testing.php">Courses</a></li>
      <li><a href="#url">My Filling Cabinet</a></li>
      <li><a href="#url">Community</a></li>
      <li><a href="#url">Services</a></li>
	  <li><a href="#url">Tools</a></li>
    </ul>
  </div>
</div>
<br><br><br>
	<div id="Courses">
	 <span class="Italic">Courses where you are: Student</span><br><br>
     <a href="try.html"><span class="bold">IM3080 Design & Innovation Project</span></a><br> 
	 Instructor: Prof Chua
	 
	 </div>
</body>
</html>
