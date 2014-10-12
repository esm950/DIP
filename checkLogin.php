<?php
//connect to database
$link = mysqli_connect("localhost", "wampuser", "xxxx", "danmaku");
ob_start();
$user_ID = $_POST['user_ID']; // take in the student_ID keyed-in from the login page
$usertype = $_POST['usertype']; //take in the radio button value (either 'student'(default) or 'prof')
$password=$_POST['password']; // take in the password keyed-in from the login page
$usertype = $_POST['usertype']; //take in the radio button value (either 'prof' or 'student') 

//For student trying to log in
if ($usertype == 'student'){
	$student_ID = $user_ID;
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

	// If result matched 'student_ID' and 'password', table row must be 1 row
	if($count==1){

	// Register $student_ID, $password and $ID_num
	session_start();

	$_SESSION ['student_ID'] = $student_ID;
	$_SESSION ['password'] = $password;
	$_SESSION['ID_num'] = $ID_num;
	header("location:loginSuccess_Student.php");

	}
	else {
	header("location:wrongLogin.php");
	}
	ob_end_flush();
}

//For professors trying to log in 
else if($usertype == 'prof'){
	$prof_ID = $user_ID;
	// To protect mysql injection (more detail about mysql injection)
	$prof_ID = stripslashes($prof_ID);
	$password = stripslashes($password);
	$prof_ID = mysqli_real_escape_string($link, $prof_ID);
	$password = mysqli_real_escape_string($link, $password);
	$sql="SELECT * FROM userinfo_prof WHERE prof_ID='$prof_ID' and password='$password'";
	$result=mysqli_query($link, $sql);
	
	$result2 = mysqli_query($link,"SELECT ID_num from userinfo_prof where prof_ID='$prof_ID' and password='$password'");
	while($row = mysqli_fetch_array($result2)) {        //to print the ID_num out
		//echo $row['ID_num'];
		$ID_num = $row['ID_num'];   //define $ID_num
	}
	
	// mysqli_num_row is counting table row
	$count=mysqli_num_rows($result);
	
	// If result matched 'prof_ID' and 'password', table row must be 1 row
	if($count==1){
	
		// Register $prof_ID, $password and $ID_num
		session_start();
		
		$_SESSION ['prof_ID'] = $prof_ID;
		$_SESSION ['password'] = $password;
		$_SESSION['ID_num'] = $ID_num;
		header("location:loginSuccess_Prof.php");
	}
	else {
		header("location:wrongLogin.php");
	}
	ob_end_flush();
}
?>