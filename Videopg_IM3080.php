<?php 
session_start();

// Check if session is not registered, redirect back to main page.
//Put this code in first line of web page.
if(!isset($_SESSION['student_ID'])){
	header("location:login.php");
}

$link = mysqli_connect("localhost", "wampuser", "xxxx", "danmaku");
ob_start();

?>

<!DOCTYPE html>
<html>
	<head>
		<title>NTULearn | Home</title>
		<link rel="SHORTCUT ICON" type="image/x-icon" href="img/bb.ico">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href = "css/bootstrap.min.css" rel = "stylesheet">
		<link href = "css/teststyles.css" rel = "stylesheet">
	</head>
	<body>

		<div class = "navbar navbar-inverse navbar-static-top">
			<div class = "container">
				<a href = "loginSuccess_Student.php" class = "navbar-brand">My NTULearn &nbsp;</a>
				
				
				<button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">
					<span class = "icon-bar"></span>
					<span class = "icon-bar"></span>
					<span class = "icon-bar"></span>
				</button>
				
				<div class = "collapse navbar-collapse navHeaderCollapse">
				
					<ul class = "nav navbar-nav navbar-right">
					
						<li class = "active"><a href = "loginSuccess_Student.php">Home</a></li>
						
						<li><a href = "#">Courses</a></li>
						<li><a href = "#">My Filling Cabinet</a></li>
						
					
						<li><a href = "#">Community</a></li>
						<li><a href = "#">Services</a></li>
						<li><a href = "#">Tools</a></li>
						
							<li class = "dropdown">
						
							
							<a href = "#" class = "dropdown-toggle" data-toggle = "dropdown">Personal Info <b class = "caret"></b></a>
							
							<ul class = "dropdown-menu">
								<?php 
								for ($num = 1; $num <= $_SESSION['course_num']; $num++){
									echo "<li><a href =";
									echo "personalInfo_", $_SESSION["course_ID" . $num], "_responses.php>";
									echo $_SESSION["course_ID" . $num];
								 	echo "</a></li>";
								}		
								?>
							</ul>
					  		</li>
						
							<li class = "dropdown">
		
							<a href = "#" class = "dropdown-toggle" data-toggle = "dropdown"><?php echo $_SESSION ['student_ID']?><b class = "caret"></b></a>
							
							<ul class = "dropdown-menu">
							
								<li><a href = "#">Account Setting</a></li>
								<li><a href = "logout.php">Log Off</a></li>
		
							</ul>
						
						</li>
						<li><a href = "#"><img class="avatar" src="img/profile photo.jpg"  width= 25; height= 25; alt="avatar"/></a></li>
						
					</ul>
				
				</div>
				
			</div>
		</div>
		
		 <div class = "container">           
           	<div class = "row"> 
              	<div class = "col-md-3">
              		<div class = "tools-container">
                    	<h3>&nbsp;&nbsp;Tools</h3>       
						<ul class="nav nav-pills nav-stacked">
    						<li><a href="#">Announcements</a></li>
    						<li><a href="#">Calendar</a></li>
    						<li><a href="#">Tasks</a></li>
    						<li><a href="#">My Grades</a></li>
    						<li><a href="#">Send Email</a></li>
    						<li><a href="#">User Directory</a></li>
    						<li><a href="#">Address Book</a></li>
    						<li><a href="#">Personal Information</a></li>
    						<li><a href="#">Browse NBC Learn</a></li>
    						<li><a href="#">NBC Learn Playlist</a></li>
    						<li><a href="#">Course Materials</a></li>
    						
    					 </ul>
					 </div>                               
                </div>
               
                <div class = "col-md-9">
                	<div class="content-container">
                			 <span class="Italic"><h3>Courses where you are: Student</h3></span><hr>
                			 
                			 <?php
	$sqlCourses = "SELECT * FROM video_ID WHERE Course_ID = 'IM3080'" ;  //.$_SESSION["course_ID" . $num]."'";
	$resultCourses=mysqli_query($link, $sqlCourses);
	while ($row = mysqli_fetch_array($resultCourses)) {
	echo "<a href='try.php'>", $row['Course_ID'] , "</a>";
	echo "<br>";
	echo "Location:" , $row['Venue'] ;
	echo "<br>";
	echo "Author:" , $row['Author'] ;
	echo "<br>" ;
	echo "Recorded on " ,$row['Video_DateTime'];}
 ?> 
                	</div>
            	</div>
         	</div>  
         </div>

		<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src = "js/bootstrap.js"></script>
		
	</body>
</html>