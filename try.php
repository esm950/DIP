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
		<!-- Chang URLs to wherever Video.js files will be hosted -->
		<link href="video-js.css" rel="stylesheet" type="text/css">
		<!-- video.js must be in the <head> for older IEs to work. -->
		<link rel='stylesheet' href='errBox.css' type='text/css'>
		<link rel="stylesheet" href="jquery-ui-1.11.1.custom/jquery-ui.min.css">
	</head>
	
	<body onload="loadOverlay()">

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
&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
		<button type="button" onclick="loadXMLDoc1()"><img src="css/satisfied.png" border="0"width="30" height="30" class="satisfied" value="satisfied" /> : Satisfied</button>  &nbsp		 
			<script>
function loadXMLDoc1()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET", "responsesSatisfied.php",true);
xmlhttp.send();
}
</script>

<button type="button" onclick="loadXMLDoc2()"><img src="css/neutral.png" border="0"width="30" height="30" class="neutral" value="neutral"/> : Neutral</button> &nbsp
<script>
function loadXMLDoc2()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET", "responsesNeutral.php",true);
xmlhttp.send();
}
</script>

<button type="button" onclick="loadXMLDoc3()"><img src="css/not-satisfied.png" border="0"width="30" height="30" class="unsatisfied" value="unsatisfied" /> :Unsatisfied</button>
<script>
function loadXMLDoc3()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET", "responsesUnsatisfied.php",true);
xmlhttp.send();
}
</script>
	<br><br>	
		 <div class = "container">           
           	<div class = "row"> 
              	<div class = "col-md-6" >
  <video id="example_video_1" class="video-js vjs-default-skin" controls preload="metadata" width="640" height="264"
       poster="http://video-js.zencoder.com/oceans-clip.png"
      data-setup="{}">
      
         <!--  
          a long video of 5min for testing
      <source src="http://brightcove.vo.llnwd.net/v1/uds/pd/3813322349001/201410/1023/3813322349001_3816110587001_0001-QQ----------------0001.mp4" type='video/mp4' />
       -->
   
       
    <source src="http://video-js.zencoder.com/oceans-clip.mp4" type='video/mp4' />
    <source src="http://video-js.zencoder.com/oceans-clip.webm" type='video/webm' />
    <source src="http://video-js.zencoder.com/oceans-clip.ogv" type='video/ogg' />
    
    <track kind="captions" src="demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
    <track kind="subtitles" src="demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
  </video>
   <div id="overlay">
   <marquee></marquee></div>
</div>

						<div class = "col-md-6">
                	<div class="content-container" >
<!-- tabs to switch between commentBox and noteBox -->
<div id="tabs" style = 'width:650px'>
  <ul>
    <li><a href="#commentBox">Comments</a></li>
    <li><a href="#noteBox">Notes</a></li>
  </ul>
    
<!-- commentBox:   tableTitle + commentBoxFrame + buttonArea + submitComment Area -->    
<div id="commentBox">
<table id="tableTitle" border=1 width=600><tr style=cursor:default>
<th width=10%><span id="video_time" class = "sort">Time</span></th>
<th width=70% >Comment</th>
<th width=20%><span id="sending_time" class = "sort">Published on</span></th></tr>
</table>
<div id="commentBoxFrame"></div>
<br>
<!-- previous button, next page, go page, to change page -->
<div id = "btnArea">
<input id="previous" type="button" value="Previous"/>

<input id="inputTime" rows="1" cols="4">
<input type="submit" id="go" value="Go">
<input id="next" type="button" value="Next"/>
<div id="error_message"></div>
<div id="checkTime"></div>  
</div> 

<!--text area of comments, with max capacity of 200 words-->
<form action="" target="commentBoxIframe" method="post" name="submitComment" id="submitComment">
<textarea id="comment" type="text" name="comment" placeholder="Maximum 200 words..." rows="3" cols="40" wrap=PHYSICAL></textarea>
<input type="checkbox" id="chooseAnnotation" name="chooseAnnotation" value="annotationChecked">Annotation<br>
<div id="annotationBox" style="display:none">
<textarea id="url" type="text" name="url" placeholder="Input the URL..." rows="3" cols="40" wrap=PHYSICAL></textarea>
</div>
<input type="submit" id="submit" value="Submit">
<span id="wordLeft">0</span><span>/200</span>
<br/>
<!-- select font size from large, middle and small, default: middle -->
<div style="display:table">
    <select name="fontSize" id="fontSize">
        <option value="0">Select font size:</option>
        <option value="1">large</option>
        <option value="2">middle</option>
        <option value="3">small</option>
    </select>
    
<!-- select display position from top, middle and bottom, default: top -->
    <select name="position" id="position">
        <option value="0">Select a position:</option>
        <option value="1">top</option>
        <option value="2">middle</option>
        <option value="3">bottom</option>
    </select>
    
<span>Choose color:</span><input class='simple_color' value='#000000' name="color" id="color"/>
</form>

</div></div>

<!-- commentBox:   tableTitle + commentBoxFrame + buttonArea -->    
<div id="noteBox"><div id="noteBoxFrame"></div></div>
</div>


<!-- javascript part -->
 <script src="video.js"></script>
  <script type='text/javascript' charset='utf-8' src='jquery-1.11.1.js'></script>
  <script src="jquery-ui-1.11.1.custom/jquery-ui.min.js"></script>
    <script type="text/javascript" src="colorPicker/src/jquery.simple-color.js"></script>
    <script type="text/javascript" src="Timer.js"></script>
  
  <script>
var arr = <?php echo json_encode($temp); ?>;
var whereYouAt; //global var
var count = 0;
function loadOverlay() {

	var myPlayer = videojs('example_video_1');
	var showing = false;
	
	var playing = function() {
	var myPlayer = this;
	whereYouAt = myPlayer.currentTime();

	      if (whereYouAt > arr[count][0] && showing == false) { // check current playing time with DB comment playTime. showing == true(run this only once)
		         document.getElementById("overlay").innerHTML = "<marquee>" + arr[count][1] + "</marquee>";
		         count++;
	      }
	      showing = false;

    }
	myPlayer.on("timeupdate", playing); // as long as time is updating, will run function "playing"

}
	//var overlay= document.getElementById('overlay');
	//var video= document.getElementById('v');

	videojs.options.flash.swf = "video-js.swf";

function setVideoTime() {
	document.getElementById("VT").value = Math.floor(whereYouAt);
		//alert(document.getElementById("VT").value);

}

</script>
                	</div>
            	</div>
         	</div>  
         </div>
		 <script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src = "js/bootstrap.js"></script>
</body>
</html>