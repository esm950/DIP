<!DOCTYPE html>
<html>
<head>
  <title>Video.js | HTML5 Video Player</title>

  <!-- Chang URLs to wherever Video.js files will be hosted -->
  <link href="video-js.css" rel="stylesheet" type="text/css">
  <!-- video.js must be in the <head> for older IEs to work. -->
 
  <script src="video.js"></script>

  <!-- Unless using the CDN hosted version, update the URL to the Flash SWF -->

  <script>
     
    function loadOverlay (){

   var myPlayer = videojs('example_video_1');
   var showing = false;
   var playing = function(){
   var myPlayer= this;
   var whereYouAt = myPlayer.currentTime();
      if(whereYouAt >3 && whereYouAt < 10 && showing == false){
   document.getElementById("overlay").innerHTML="<marquee>This will play from 3s to 10s</marquee>";
   showing = true;
   }
 if(whereYouAt > 10 && showing == true){
   document.getElementById("overlay").innerHTML="<marquee></marquee>";
   showing = false;
   }
   }
   
   myPlayer.on("timeupdate",playing);
      
   }
  var overlay= document.getElementById('overlay');
  var video= document.getElementById('v');
 
    videojs.options.flash.swf = "video-js.swf";
            
  </script>




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

<form id="send-message-area" method="POST" action="sendchat.php">
            <input type="text" name="when" id="when" value="" hidden />
    <textarea name="msg" id="txtBox"><?php echo "default value" ?></textarea>
                <input type="submit" />
</form>


</body>
</html>
