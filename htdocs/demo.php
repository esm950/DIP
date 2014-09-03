<!DOCTYPE html>
<html>
<head>
  <title>Video.js | HTML5 Video Player</title>

  <!-- Chang URLs to wherever Video.js files will be hosted -->
  <link href="video-js.css" rel="stylesheet" type="text/css">
  <!-- video.js must be in the <head> for older IEs to work. -->
 
  <script src="video.js"></script>


</head>
<body onload="loadOverlay()">  
                        
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
   <div id="overlay">
   <marquee></marquee>

</div>
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

// Define database related constants
define('DB_HOSTNAME', '127.0.0.1');
define('DB_USERNAME', 'wampuser');
define('DB_PASSWORD', 'xxxx');
define('DB_DATABASE', 'danmaku');
define('DB_PORT',     8889);


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

function tabulate_resultset($resultSet) {
  echo '<table border=1><tr>';
  // Get fields' name and print table header row
  echo "<th>Time</th>";
  echo "<th width=70% >Comment</th>";
  echo "<th>Published on</th>";
  //echo "<th>Like</th>";
  //echo "<th>Dislike</th>";
  echo '</tr>';

  // Fetch each row and print table detail row
  foreach ($resultSet as $row) {  // Loop thru all rows in resultset
    echo '<tr>';
      global $comment;
        global $playTime;
        $time = $row['video_time'];
        $playTime = $time;
        $second = $time%60;
        $time = (int)($time/60);
        $minute = $time%60;
        $time = (int)($time/60);
        printf('<td>%02d:%02d:%02d</td>',$time,$minute,$second);
        
        $comment = $row['content'];
    
        echo"<td>",$comment,"</td>";

        $date = intval($row['sending_date']);
        $day = $date%100;
        $date = (int)($date/100);
        $month = $date%100;
        $date = (int)($date/100);
        printf('<td>%02d/%02d/%4d  ',$day,$month,$date);
        echo $row['sending_time'],"</td>";
      // echo"<td>",$row['like_num'],"</td>";
      //  echo"<td>",$row['dislike_num'],"</td>";
        echo '</tr>';
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


?>


  <script>

     var whereYouAt; //global var
    function loadOverlay (){
    //alert('<?php echo($playTime); ?>');
    //console.log('<?php echo($playTime); ?>');
    //console.log('<?php echo($comment); ?>');
    
   var myPlayer = videojs('example_video_1');
   var showing = false;
   var playing = function(){
   var myPlayer= this;
   whereYouAt = myPlayer.currentTime();
   console.log(showing);
   if(whereYouAt > <?php echo($playTime); ?> && showing == false){ // check current playing time with DB comment playTime. showing == true(run this only once)
    //alert('<?php echo($playTime); ?>');
    document.getElementById("overlay").innerHTML="<marquee><?php echo($comment); ?></marquee>";   
    showing = true;
   }
   
   }
   
   myPlayer.on("timeupdate",playing); // as long as time is updating, will run function "playing" 
      
   }
  //var overlay= document.getElementById('overlay');
  //var video= document.getElementById('v');
 
    videojs.options.flash.swf = "video-js.swf";
            
            function setVideoTime (){
document.getElementById("VT").value = Math.floor(whereYouAt);
//alert(document.getElementById("VT").value);

}
  </script>
</html>


