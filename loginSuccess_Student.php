<?php 
session_start();
// Check if session is not registered, redirect back to main page.
//Put this code in first line of web page.
if(!isset($_SESSION['student_ID'])){
	header("location:login.php");
}
?>

<html>
<head>
<title>NTULearn</title>
<link rel="stylesheet" href="css/styles.css" type="text/css" />
</head>
<body>

<?php
echo $_SESSION ['student_ID'];
echo "<br>";
echo $_SESSION ['ID_num']; //for debugging purpose
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
      <li><a href="#url">Courses</a></li>
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
     <a href="try.php"><span class="bold">IM3080 Design & Innovation Project</span></a><br> 
	 Instructor: Prof Chua
	 </div>

</body>
</html>
