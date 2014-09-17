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


</head>
<body onload="loadOverlay()">  
<div id="overlay">
   <canvas id="MyCanvas1" width="635" height="225">
      This browser or document mode doesn't support canvas object</canvas>

</div>

 <video id="example_video_1" class="video-js vjs-default-skin" controls preload="none" width="640" height="264" 		
      poster="http://video-js.zencoder.com/oceans-clip.png"
      data-setup="{}">
          <source src="http://video-js.zencoder.com/oceans-clip.mp4" type='video/mp4' />
    <source src="http://video-js.zencoder.com/oceans-clip.webm" type='video/webm' />
    <source src="http://video-js.zencoder.com/oceans-clip.ogv" type='video/ogg' />
    <track kind="captions" src="demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
    <track kind="subtitles" src="demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
    
	<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
  
  </video>
					
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
echo 'INFO: Connected to MySQL at ' . DB_HOSTNAME . ':' . DB_PORT . '/' . DB_DATABASE . ' (' . DB_USERNAME . ')<br />'; //connected to database

$ID_video = 'im3080'; //database name


$mysqli->real_query('SELECT video_time, content, sending_date, sending_time, like_num, dislike_num FROM '.$ID_video .' ORDER BY video_time ASC')
      or die("Error: SELECT failed: ({$mysqli->errno}) {$mysqli->error}");

$resultSet = $mysqli->store_result()
      or die("Error: Store resultset failed: ({$mysqli->errno}) {$mysqli->error}");
tabulate_resultset($resultSet);
$resultSet->close();  // Close the result set


$currentArray = 0;	//counter for current displayed array on video
$comment;
$playTime;

function tabulate_resultset($resultSet) {
  echo '<table border=1><tr>';
  // Get fields' name and print table header row
  echo "<th>Time</th>";
  echo "<th width=70% >Comment</th>";
  echo "<th>Published on</th>";
  //echo "<th>Like</th>";
  //echo "<th>Dislike</th>";
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
        printf('<td>%02d:%02d:%02d</td>',$time,$minute,$second);
        
        
        $comment = $row['content'];
		$temp[$counter][1] = $comment;
		//echo ("<script>console.log(\"$temp[$counter][1]\");</script>");
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

	var arr = <?php echo json_encode($temp); ?>;
     var whereYouAt; //global var
     var count = 0;
	 var can, ctx, step, steps = 0, delay = 20;
	 var noOfComment = 0;
	 
    function loadOverlay (){
      
     
  //html canvas init() start
  can = document.getElementById("MyCanvas1");
            ctx = can.getContext("2d");
            ctx.textAlign = "start";
            ctx.textBaseline = "middle";
            step = 640;						//width of canvas
            steps = 0;
            //displayComment(can.height/2, "20pt Verdana","white",1);
	//html canvas init() end
	
   var myPlayer = videojs('example_video_1');
   myPlayer.play();
   myPlayer.pause();
   
   var playing = function(){
   var myPlayer= this;
   whereYouAt = myPlayer.currentTime();

   if(whereYouAt > arr[count][0] && whereYouAt < arr[count][0]+0.5){ // check current playing time with DB comment playTime. showing == true(run this only once)
   arr[count][3] = 640;		//position counter for this comment
   arr[count][4] = count*20+50; //height counter for this comment
   arr[count][5] = 2; // speed
   noOfComment++;
   if(count == 0){
   console.log("RUN ONCE");
   displayComment(arr[count][1],arr[count][4], "20pt Verdana","white",1,count);
   }
   //displayComment(arr[count][1],can.height/2, "20pt Verdana","red",1,count);

      console.log("COMMENTS = "+noOfComment);
	  count ++;
	  }
	 

   }
  myPlayer.on("timeupdate",playing); // as long as time is updating, will run function "playing"
  myPlayer.on("seeked",refreshTime);
  myPlayer.on("pause",stopComment);
  myPlayer.on("play",startComment);

   }
    videojs.options.flash.swf = "video-js.swf";
            
function setVideoTime (){
document.getElementById("VT").value = Math.floor(whereYouAt);
}

function stopComment(){
	//document.getElementById('marquee1').stop();
}
function startComment(){
	//document.getElementById('marquee1').start();
}
function refreshTime(){
	count = 0;
		 while(whereYouAt > arr[count][0] && whereYouAt < arr[count][0]+0.5){
	  count ++;
	
}

}

function displayComment(comment,height,font,fontColor, speed,arrayCount) {	//	generic function to display comment
            //step--;
            //console.log("arrayCount =  "+arrayCount+" value = "+arr[arrayCount][3]);
            //console.log("step =  "+step);
            //step = step - speed;
            //arr[arrayCount][3] = arr[arrayCount][3] - speed;
            //ctx.fillStyle = fontColor;
            //ctx.font = font;
            
            ctx.fillStyle = "red";
            ctx.font = "20pt Verdana";
            ctx.clearRect(0, 0, can.width, can.height);
            ctx.save();								//save style and font and clear canvas
            //ctx.translate(step, height);
            //ctx.translate(arr[arrayCount][3], height);
            for (var i = 0; i <= noOfComment; i ++){
              if (arr[i][3] == steps){
                arr[i][3] = 640;                
                }					//set default position to right if end of frame
            writeStatic(arr[i][1],arr[i][3],arr[i][4]);				//print comment on current position
            //ctx.translate(arr[i][3], arr[i][4]);	//change default position to current location           
            arr[i][3] = arr[i][3] - arr[i][5];	
            console.log(arr[i][4]);						// minus the current position to the left
            }
            ctx.restore();            				//load the style back to text
           // if (arr[arrayCount][3] > steps)
                //var t = setTimeout('displayComment(can.height/2, "10pt Verdana","white",1)', delay);
                 var t = setTimeout('displayComment("'+comment+'",'+height+',"'+font+'","'+fontColor+'",'+speed+','+arrayCount+')', delay);
        }
function writeStatic(comment,width,height){
	ctx.fillText(comment, width, height);
	
}
  </script>
</html>


