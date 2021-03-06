<!DOCTYPE html>

<html>
<head>
  <title>Video.js | HTML5 Video Player</title>
  <style>
        canvas{border: 0px solid #bbb;}
        .subdiv{width: 320px;}
        .text{margin: auto; width: 320px;}
  </style>

  <!-- Chang URLs to wherever Video.js files will be hosted -->
  <link href="video-js.css" rel="stylesheet" type="text/css">
  <!-- video.js must be in the <head> for older IEs to work. -->
 
  <script src="video.js"></script>
  <script src="comment.js"></script>


</head>
<body onload="loadOverlay()">  
<div id="overlay">
   <canvas id="MyCanvas1" width="635" height="225"> //dimensions of the canvas
      This browser or document mode doesn't support canvas object</canvas>



   


</div>
 <video id="example_video_1" class="video-js vjs-default-skin" controls preload="none" width="640" height="264" 		
      poster="2.png"
      data-setup="{}">
          <source src="2.mp4" type='video/mp4' />
		  
    <track kind="captions" src="demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
    <track kind="subtitles" src="demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
    
	<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
  
  </video>
  <input type="checkbox" name="c1" onclick="showMe('overlay')">Off Captions	
					
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" onSubmit="setVideoTime()">
Comment: <br><textarea type="text" name="comment" placeholder="Maximum 200 words..." rows="3" cols="40" wrap=PHYSICAL onKeyDown="gbcount(this.form.comment,this.form.total,this.form.used,this.form.remain);" onKeyUp="gbcount(this.form.comment,this.form.total,this.form.used,this.form.remain);"></textarea>
<input type="hidden" value="" name="videoTime" id="VT">
<input type="submit" value="Submit">

<p>Max words:
<input disabled maxLength="4" name="total" size="3" value="200" >
Written:
<input disabled maxLength="4" name="used" size="3" value="0" >
Left:
<input disabled maxLength="4" name="remain" size="3" value="200" >
</p>
</form>



</body>
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


$mysqli->real_query('SELECT video_time, content, sending_date, sending_time, like_num, dislike_num, size, color, isAnno, position FROM '.$ID_video .' ORDER BY video_time ASC')
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
//$type;
$position;

function tabulate_resultset($resultSet) {
  echo '<table border=1><tr>';
  // Get fields' name and print table header row
  echo "<th>Time</th>";
  echo "<th width=60% >Comment</th>";
  echo "<th>Insert date</th>";
  echo "<th>Like</th>";
  echo "<th>Dislike</th>";
  echo '</tr>';
  
global $temp;
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
        printf('<td><a href="javascript:void(0)" onclick="seekedVideo(%02d);">%02d:%02d:%02d</a></td>',$playTime,$time,$minute,$second);
        
        $comment = $row['content'];
		$temp[$counter][1] = $comment;
		$anno = $row['isAnno'];
		$temp[$counter][2] = $anno;
		$color = $row['color'];
		$temp[$counter][5] = $color;
		$size = $row['size'];
		$temp[$counter][6] = $size;
		//$type = $row['type'];
		//$temp[$counter][7] = $type;
 		//echo ("<script>console.log(\"$temp[$counter][1]\");</script>");
		$position = $row['position'];
		$temp[$counter][7] = $position;
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
     var currVideoTime; //global var
	 var height = 0;
     var count = 0;
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

   if(currVideoTime > arr[count][0] && currVideoTime < arr[count][0]+0.5){ // check current playing time with DB comment playTime. showing == true(run this only once)
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
 
   var comment = new Comment(arr[count][1],arr[count][0],arr[count][2],640,count*20+50,fontType,fontSize,arr[count][5]); //[0]= time  [1]= comment  [2]= anno  [5]= color
   Comments[count] = comment;
   arr[count][3] = 640;			//position counter for this comment
   if(arr[count][7] == 'top') { //comments marked 'top' will flow top down
		height = tHeightCounter*20+50;
		if(height < 215) { //if height has not reached the end of the canvas
			arr[count][4] = tHeightCounter*20+50; //height counter for this comment
			comment.setHeight(tHeightCounter*20+50);
		} else {
			tHeightCounter = 0;
			arr[count][4] = tHeightCounter*20+50; //once the position of the comment have reached the bottom of the canvas, position it at the top again
			comment.setHeight(tHeightCounter*20+50);
		}
		tHeightCounter++;
	} else { // comments marked 'bottom' will flow bottom up
		height = 255 - (bHeightCounter*20+50);
		if(height > 50) {
			arr[count][4] = 255 - (bHeightCounter*20+50);
			comment.setHeight(255 - (bHeightCounter*20+50));
		} else { //once the position of the comment have reached the top of the canvas, position it at the bottom again
			bHeightCounter = 0;
			arr[count][4] = 255 - (bHeightCounter*20+50);
			comment.setHeight(255 - (bHeightCounter*20+50));
		}
		bHeightCounter++;
	}
	noOfComment++;				//unused for now
	endCommentIndex++;			//add one more comment to display in the displayComment()
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
startCommentIndex = count;
endCommentIndex = count;
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
			if(Comments[i].isAnno() == 1){
				ctx.beginPath();
				ctx.rect(Comments[i].getLength(),Comments[i].getHeight()-Comments[i].getPixelHeight()/2,Comments[i].getPixelLength(),Comments[i].getPixelHeight());
				ctx.strokeStyle="#FF0000";
				ctx.stroke();
			}
            ctx.fillStyle = Comments[i].getColor();
            ctx.font = Comments[i].getFont(); //font of different comments				
            writeStatic(Comments[i].getComment(),Comments[i].getLength(),Comments[i].getHeight());				//print comment on current position          
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
  	//alert(getCursorPosition(e));  //Check which comment is clicked.
  	for (var i = startCommentIndex; i < endCommentIndex && i >= startCommentIndex; i ++){
  	//console.log(i);
	if(Comments[i].checkClicked(getCursorPosition(e))==0){
		//alert("Clicked "+ Comments[i].getComment());
		myPlayer.pause();
		var url = 'http://www.google.com/search?q='+Comments[i].getComment();// url
		var win = window.open(url, '_blank'); // change to get url when db done
		win.focus();
	}				
}
  }
  
  function getCursorPosition(e) {
  	var x;
    var y;
    if (e.pageX != undefined && e.pageY != undefined) {
	x = e.pageX;
	y = e.pageY;
    }
    else {
	x = e.clientX + document.body.scrollLeft +
            document.documentElement.scrollLeft;
	y = e.clientY + document.body.scrollTop +
            document.documentElement.scrollTop;
    }
    x -= can.offsetLeft;
    y -= can.offsetTop;
    
    return [x,y];
  }
  </script>
</html>


