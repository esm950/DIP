<?php 
session_start();

// Check if session is not registered, redirect back to main page.
//Put this code in first line of web page.
if(!isset($_SESSION['ID_num'])){	
	header("location:login.php");
}

$link = mysqli_connect("localhost", "wampuser", "xxxx", "danmaku");
ob_start();

?>

<!DOCTYPE html>
<html>
	<head>
		<title>NTULearn | Video</title>
		<link rel="SHORTCUT ICON" type="image/x-icon" href="img/bb.ico">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href = "css/bootstrap.min.css" rel = "stylesheet">
		<link href = "css/teststyles.css" rel = "stylesheet">
		<!-- Chang URLs to wherever Video.js files will be hosted -->
		<link href="video-js.css" rel="stylesheet" type="text/css">
		<!-- video.js must be in the <head> for older IEs to work. -->
		<link rel='stylesheet' href='errBox.css' type='text/css'>
		<link rel="stylesheet" href="jquery-ui-1.11.1.custom/jquery-ui.min.css">
		
		<style>
        canvas{border: 0px solid #bbb;}
        .subdiv{width: 320px;}
        .text{margin: auto; width: 320px;}
		</style>
		
		<script src="video.js"></script>
 		<script src="comment.js"></script>
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
		
		<div class = "container">           
           	<div class = "row" style="width:1370px;"> 
              	<div class = "col-md-6" style="width:670px;">
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
	
		 			<div id="overlay">
					<canvas id="MyCanvas1" width="640" height="375"> //dimensions of the canvas
					This browser or document mode doesn't support canvas object</canvas>
	
					</div>
  					<video id="example_video_1" class="video-js vjs-default-skin" controls preload="metadata" width="640" height="420"
       				poster="2.png"
     				data-setup="{}">   
       
       				<source src="2.mp4" type='video/mp4' />
				    
				    <track kind="captions" src="demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
				    <track kind="subtitles" src="demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
				    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
				  	</video>
					<input type="checkbox" name="c1" onclick="showMe('overlay')">Off Captions

					
					<?php
//include '/Applications/MAMP/htdocs/ChromePhp.php';
//ChromePhp::log('Hello console!');
//ChromePhp::log($_SERVER);
//ChromePhp::warn('something went wrong!');


// Define database related constants
define('DB_HOSTNAME', '127.0.0.1');
define('DB_USERNAME', 'wampuser');
define('DB_PASSWORD', 'xxxx');
define('DB_DATABASE', 'danmaku');
define('DB_PORT',     3306);


// Connect to the MySQL server and set the default database
$mysqli = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
!$mysqli->connect_errno
      or die("Error: Failed to CONNECT: ({$mysqli->connect_errno}) {$mysqli->connect_error}");
//echo 'INFO: Connected to MySQL at ' . DB_HOSTNAME . ':' . DB_PORT . '/' . DB_DATABASE . ' (' . DB_USERNAME . ')<br />'; //connected to database

$ID_video = 'im3080_comment'; //database name


$mysqli->real_query('SELECT video_time, content, sending_date, sending_time, like_num, dislike_num, size, color, isAnno, position,link,ID_num FROM '.$ID_video .' ORDER BY video_time ASC')
      or die("Error: SELECT failed: ({$mysqli->errno}) {$mysqli->error}");

$resultSet = $mysqli->store_result()
      or die("Error: Store resultset failed: ({$mysqli->errno}) {$mysqli->error}");
tabulate_resultset($resultSet);
$resultSet->close();  // Close the result set


$currentArray = 0;	//counter for current displayed array on video
$comment;
$playTime;
$anno;
$color;
$size;
$link;
//$type;
$position;
$block;
$id;

function tabulate_resultset($resultSet) {
  echo '<table hidden border=1><tr>';
// Get fields' name and print table header row
echo "<th>Time</th>";
echo "<th width=60% >Comment</th>";
echo "<th>Insert date</th>";
echo "<th>Like</th>";
echo "<th>Dislike</th>";
echo '</tr>';
  
global $temp;
global $blockArray;
$blockArray = array();
$temp = array();
$counter = 0;
  // Fetch each row and print table detail row
  foreach ($resultSet as $row) {  // Loop thru all rows in resultset
    echo '<tr>';
  
        $time = $row['video_time'];
        $temp[$counter][0] = $time;
        //echo ("<script>console.log(\"$temp[$counter][0]\");</script>");
        //echo $temp[counter][0]," --VT";
        $playTime = $time;
        $second = $time%60;
        $time = (int)($time/60);
        $minute = $time%60;
        $time = (int)($time/60);
        //printf('<td>%02d:%02d:%02d</td>',$time,$minute,$second);
       // printf('<td><a href="javascript:void(0)" onclick="seekedVideo(%02d);">%02d:%02d:%02d</a></td>',$playTime,$time,$minute,$second);
        
        $comment = $row['content'];
		$temp[$counter][1] = $comment;
		$anno = $row['isAnno'];
		$temp[$counter][2] = $anno;
		$color = $row['color'];
		$temp[$counter][5] = $color;
		$size = $row['size'];
		$temp[$counter][6] = $size;
		$position = $row['position'];
		$temp[$counter][7] = $position;
		$link = $row['link'];
		$temp[$counter][8] = $link;
		$id = $row['ID_num'];
		$temp[$counter][9] = $id;
        echo"<td>",$comment,"</td>";		
        $date = intval($row['sending_date']);
        $day = $date%100;
        $date = (int)($date/100);
        $month = $date%100;
        $date = (int)($date/100);
        printf('<td>%02d/%02d/%4d  ',$day,$month,$date);
        echo $row['sending_time'],"</td>";
      echo"<td>",$row['like_num'],"</td>";
      echo"<td>",$row['dislike_num'],"</td>";
        echo '</tr>';
        $counter ++;
    }
    echo '</table>';
}


//BLOCK USER

      //printf('SELECT ID_num FROM '. 'user' .$_SESSION['ID_num']. '_block');
      
$mysqli->real_query('SELECT ID_num FROM '. 'user' .$_SESSION['ID_num']. '_block')
      or die("Error: SELECT failed: ({$mysqli->errno}) {$mysqli->error}");

$resultSet = $mysqli->store_result()
      or die("Error: Store resultset failed: ({$mysqli->errno}) {$mysqli->error}");
     



$counter = 0;

foreach ($resultSet as $row) {
$block= $row['ID_num'];
$blockArray[$counter] = $block;
$counter ++;
}

$resultSet->close();  // Close the result set









if (!empty($_POST["comment"])){
  $pStmt = $mysqli->prepare("INSERT INTO ".$ID_video ." (ID_num, content, video_time, sending_date, sending_time, like_num, dislike_num) VALUES (?, ?, ?, ?, ?, ?, ?)")
        or die("Error: create prepared failed: ({$mysqli->errno}) {$mysqli->error}");
  $ID_num = 1200;
  $content = $_POST["comment"];
  $video_time = $_POST['videoTime'];
  date_default_timezone_set('Asia/Singapore');
  $sending_date = date('Ymd');
  $sending_time = date('H:i:s');
  $like_num = 0;
  $dislike_num = 0;
  $pStmt->bind_param('isissii', $ID_num, $content, $video_time, $sending_date, $sending_time, $like_num, $dislike_num)
          and $pStmt->execute()
          or die("Error: run prepared failed: ({$pStmt->errno}) {$pStmt->error}");
  echo "INFO: {$pStmt->affected_rows} row(s) inserted<br />";
}

			$playTime = $temp[$currentArray][0];
			$comment = $temp[$currentArray][1];
			?>

<script type="text/javascript">
									
									function showMe(box) {
        
									var chboxs = document.getElementsByName("c1");
									var vis = "block";
									for(var i=0;i<chboxs.length;i++) { 
										if(chboxs[i].checked){
										vis = "none";
										break;
									}
        
									}
									document.getElementById(box).style.display = vis;
    
									}
									
									//init starting variable
									var arr = <?php echo json_encode($temp); ?>;
									var block = <?php echo json_encode($blockArray); ?>;
									var currVideoTime; //global var
									var height = 0;
									var count = 0;
									var cCount=0;
									var prevComm = 0;
									var tHeightCounter = 0;
									var bHeightCounter = 0;
									var fontSize = 20 // default font size variable
									var fontType = "Arial" //font type variable
									var can, ctx, step, delay = 20;
									var steps = 0;
									var speed = 2;
									var noOfComment = 0;
									var startCommentIndex = 0;
									var endCommentIndex= 0;
									var isPaused = 0;
									var Comments = [];
									var anno , annoStyle;
									var myPlayer;
									var canvasx = 55;
									var canvasy = 55;
	 


									function loadOverlay (){
      
     
										//html canvas init() start
										can = document.getElementById("MyCanvas1");
										ctx = can.getContext("2d");
										ctx.textAlign = "start";
										ctx.textBaseline = "middle";
										steps = -300;	//replace steps with 0- limit of string pixel

										can.addEventListener("click", onCanvasClick, false);


										//html canvas init() end
	
										myPlayer = videojs('example_video_1');
										myPlayer.play();	//init displayComment loop
										myPlayer.pause();
   
										var playing = function(){
										var myPlayer= this;
										currVideoTime = myPlayer.currentTime();

										while(currVideoTime > arr[count][0] && currVideoTime < arr[count][0]+0.5){ // check current playing time with DB comment playTime. showing == true(run this only once)
										switch(arr[count][6]) {  //[6] = font size (value in char 'small', 'medium', 'large'
										case 'small':
											fontSize = 10 // font size small
											break;
										case 'large':
											fontSize = 40 // font size large
											break;
										default:
											fontSize = 20 // font size medium (default)
										}
										
										if(count > 0) {
										prevComm = count - 1;
										}
										if(arr[count][0] == arr[prevComm][0]) {
										noOfComment++;
										} else {
										noOfComment = 0;
										}
										
										if(noOfComment < 11) {
										var comment = new Comment(arr[count][1],arr[count][0],arr[count][2],640,count*20+50,fontType,fontSize,arr[count][5],arr[count][8],arr[count][9]); //[0]= time  [1]= comment  [2]= anno  [5]= color
										
   
   Comments[cCount] = comment;
   
   arr[count][3] = 640;			//position counter for this comment
   if(arr[count][7] == 'top') { //comments marked 'top' will flow top down
		height = tHeightCounter*20+50;
		if(height < 370) { //if height has not reached the end of the canvas
			arr[count][4] = tHeightCounter*20+50; //height counter for this comment
			comment.setHeight(tHeightCounter*20+50);
		} else {
			tHeightCounter = 0;
			arr[count][4] = tHeightCounter*20+50; //once the position of the comment have reached the bottom of the canvas, position it at the top again
			comment.setHeight(tHeightCounter*20+50);
		}
		tHeightCounter++;
	} else { // comments marked 'bottom' will flow bottom up
		height = 370 - (bHeightCounter*20+50);
		if(height > 50) {
			arr[count][4] = 370 - (bHeightCounter*20+50);
			comment.setHeight(370 - (bHeightCounter*20+50));
		} else { //once the position of the comment have reached the top of the canvas, position it at the bottom again
			bHeightCounter = 0;
			arr[count][4] = 370 - (bHeightCounter*20+50);
			comment.setHeight(370 - (bHeightCounter*20+50));
		}
		bHeightCounter++;
	}
	//noOfComment++;				//unused for now
	endCommentIndex++;			//add one more comment to display in the displayComment()
	cCount++;
	}
	count++;	

	}
	 

   }
   //status of player
  myPlayer.on("timeupdate",playing); // as long as time is updating, will run function "playing"
  myPlayer.on("seeked",refreshTime);
  myPlayer.on("pause",stopComment);
  myPlayer.on("play",startComment);

   }
    videojs.options.flash.swf = "video-js.swf";
            
            
            // Different function for events
function setVideoTime (){
document.getElementById("VT").value = Math.floor(currVideoTime);
}

function seekedVideo(seconds) {
myPlayer.currentTime(seconds);
}

function stopComment(){
	if(isPaused == 0)
	isPaused = 1;
}
function startComment(){
	if(isPaused == 1){
	isPaused = 0;
	displayComment();
	}
}
function refreshTime(){
	count = 0;
	ctx.clearRect(0, 0, can.width, can.height);
			 while(currVideoTime > arr[count][0]){
		 
	  count ++;
	
}
startCommentIndex = cCount;
endCommentIndex = cCount;
}

//Core function of comment
function displayComment() {	//	generic function to display comment
            if(isPaused == 0){
            
            ctx.clearRect(0, 0, can.width, can.height);
            //ctx.width = ctx.width;
            ctx.save();								//save style and font and clear canvas
            for (var i = startCommentIndex; i < endCommentIndex && i >= startCommentIndex; i ++){
              if (Comments[i].getLength() < steps){					//if comment at end of video frame, stop displaying the comment      
                startCommentIndex++;
                //arr[i][3] = 640;             		  //set default position to right if end of frame 
                }
			//console.log("Number i = "+i+"color is : "+Comments[i].getColor()+"Font is :"+Comments[i].getFont());
			//if(Comment[i].getReply != 1){} //Meaning comment is not a reply to another reply, display it
			if(checkBlocked(Comments[i].getID())== 0){	
			if(Comments[i].isAnno() == 1){
				ctx.beginPath();
				//console.log("x = "+Comments[i].getLength()+"y= "+Comments[i].getHeight()-Comments[i].getPixelHeight()/2);
				ctx.rect(Comments[i].getLength(),Comments[i].getHeight()-Comments[i].getPixelHeight()/2,Comments[i].getPixelLength(),Comments[i].getPixelHeight());
				ctx.strokeStyle="#FF0000";
				ctx.stroke();
			}
            ctx.fillStyle = Comments[i].getColor();
            ctx.font = Comments[i].getFont(); //font of different comments	
            		
            writeStatic(Comments[i].getComment(),Comments[i].getLength(),Comments[i].getHeight());				//print comment on current position  
            }        
            Comments[i].move(speed);				// minus the current position to the left
            }
            ctx.restore();           				//load the style back to text
            var t = setTimeout('displayComment()', delay);
        }
        
        //Print static text on xy plane
function writeStatic(comment,width,height){
	ctx.fillText(comment, width, height);
	
}}

function onCanvasClick(e) {
  	//console.log(getCursorPosition(e));  //Check which comment is clicked.
  
    for (var i = startCommentIndex; i < endCommentIndex && i >= startCommentIndex; i ++){
	if(Comments[i].checkClicked(getCursorPosition(e))==0){
		//alert("Clicked "+ Comments[i].getComment());
		if(checkBlocked(Comments[i].getID())== 0){
		myPlayer.pause();
		if(Comments[i].getLink() == ''){
			alert("There is no link");
		}else{
		var url = 'http://'+Comments[i].getLink();// url
		var win = window.open(url, '_blank'); // change to get url when db done
		win.focus();
		}}
	}				
}
  }
  
 
function checkBlocked(id) {
var value = 0;
//console.log("array length = "+block.length);
for(var i =0; i <= block.length;i++){
//console.log("i="+i);
//console.log("block id = "+block[i]+"this comment id = "+id);
if(block[i] == id){

	value = 1;
}
}
return value;
}

function getCursorPosition(e) {
	var rect = can.getBoundingClientRect();
    var x = e.clientX - rect.left;
    var y = e.clientY - rect.top;  
    
	return [x,y];
    }
</script>
  
  			</div>
  	
						<div class = "col-md-6" style="width:700px;">
                			<div class="content-container">
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
									<!-- <script src="video.js"></script>
									<script src="comment.js"></script> -->
									<script type='text/javascript' charset='utf-8' src='jquery-1.11.1.js'></script>
									<script src="jquery-ui-1.11.1.custom/jquery-ui.min.js"></script>
									<script type="text/javascript" src="colorPicker/src/jquery.simple-color.js"></script>
									<script type="text/javascript" src="Timer.js"></script>
									<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
									<script src = "js/bootstrap.js"></script>
  
									
                	</div>
            	</div>
         	</div>  
         </div>
		 <script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src = "js/bootstrap.js"></script>
</body>
</html>