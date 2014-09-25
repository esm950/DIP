<?php
session_start();
?>

<!DOCTYPE html>

<html>
<head>
  <title>Video.js | HTML5 Video Player</title>

  <!-- Chang URLs to wherever Video.js files will be hosted -->
  <link href="video-js.css" rel="stylesheet" type="text/css">
  <!-- video.js must be in the <head> for older IEs to work. -->

  <script src="video.js"></script>
  
  <script type='text/javascript' charset='utf-8' src='jquery-1.11.1.js'></script>
  <script type="text/javascript" src="Timer.js"></script>
    	<script type="text/javascript">
		$(function(){
			SetTimer({
			});
		});
	</script>

<SCRIPT language="javascript">

function checktext(text){
	allValid = true;
	for (i = 0; i < text.length; i++){
		if (text.charAt(i) != " "){
			allValid = false;
			break;
		}
	}
	return allValid;
}

function gbcount(message,total,used,remain){
	var max;
	max = total.value;
	if (message.value.length > max) {
		message.value = message.value.substring(0,max);
		used.value = max;
		remain.value = 0;
		//alert("Can not be more than 200 words!");
	}
	else {
	used.value = message.value.length;
	remain.value = max - used.value;
	}
}

//video time is multiples of 5
function send_time(videoTime){
	var xmlhttp;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
	  if (xmlhttp.readyState==4 && xmlhttp.status==200){
	    document.getElementById("iframe").innerHTML=xmlhttp.responseText;
	  }
	}
      
        var url = "RefreshTable.php?videoTime="+ videoTime;
        document.getElementById( "iframe" ).src = url;
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
}


</script>

</head>
<body onload="loadOverlay()">
<?php
echo $_SESSION['student_ID'];?><br><br>
&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 

		 
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
</script>
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

</script>
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


			<button type="button" onclick="loadXMLDoc1()"><img src="css/satisfied.png" border="0"width="30" height="30" class="satisfied" /> : Satisfied</button>  &nbsp 
			<button type="button" onclick="loadXMLDoc2()"><img src="css/neutral.png" border="0"width="30" height="30" class="neutral" /> : Neutral</button> &nbsp
			<button type="button" onclick="loadXMLDoc3()"><img src="css/not-satisfied.png" border="0"width="30" height="30" class="unsatisfied" /> :Unsatisfied</button>
           
        

<table border= "0">
<tr>
    <td>
  <video id="example_video_1" class="video-js vjs-default-skin" controls preload="none" width="640" height="264"
       poster="http://video-js.zencoder.com/oceans-clip.png"
      data-setup="{}">
      
     <!--    
      <source src="jo.mp4" type='video/mp4' />
       -->
   
         
    <source src="http://video-js.zencoder.com/oceans-clip.mp4" type='video/mp4' />
    <source src="http://video-js.zencoder.com/oceans-clip.webm" type='video/webm' />
    <source src="http://video-js.zencoder.com/oceans-clip.ogv" type='video/ogg' />
    
    <track kind="captions" src="demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
    <track kind="subtitles" src="demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
  </video>
   <div id="overlay">
   <marquee></marquee>

</div></td>

<td>
<table border=1 width="600"><tr>
<th width="96" bgcolor="#ACE5EE">Time</th>
<th width="262" bgcolor="#ACE5EE">Comment</th>
<th bgcolor="#ACE5EE">Published on</th></tr>
<table><tr>
<iframe src="script.html" width="600" height="350"></iframe></tr></table>
       

<table><tr>
<!-- button for 'previous' page and 'next' page, and text area for 'go' to certain video time -->
<input id="previous" type="button" value="Previous"/>

<input id="inputTime" rows="1" cols="4" onkeypress="return isNumberKey(event);">
<input type="submit" id="go" value="Go">

<input id="next" type="button" value="Next"/>

<div id="checkTime"></div>  

<script>
    
    var page_num = 0;
//check if the input is number only
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode
    return !(charCode > 31 && (charCode < 48 || charCode > 57));
}

//send the starting time of previous page (5s per page), eg, now is 47s then send 40
document.getElementById("previous").onclick = function() {getVideoTime_previous()};
function getVideoTime_previous() {
    --page_num;
    var myPlayer = videojs('example_video_1');
    var videoTime = 0;
    videoTime = myPlayer.currentTime();
    videoTime = videoTime+page_num*5;
    if(videoTime<0){
        videoTime = 0;
        ++page_num;
    }else{
        videoTime = videoTime - videoTime%5;
    }
    //document.getElementById("checkTime").innerHTML = "" + videoTime;
	send_time(videoTime);
}

//send the starting time of chosen page (5s per page), eg, input is 47s then send 45
document.getElementById("go").onclick = function() {getVideoTime()};
function getVideoTime(){
        var myPlayer = videojs('example_video_1');
        var duration = myPlayer.duration();
        var videoTime = document.getElementById('inputTime').value;
        if(videoTime<0){
            videoTime = 0;
        }else if(videoTime>duration){
            videoTime = duration-duration%5;
        }else{
            videoTime = videoTime - videoTime%5;
        }
        var currentTime = myPlayer.currentTime();
        currentTime = currentTime-currentTime%5;
        page_num = (videoTime-currentTime)/5;
        
	//document.getElementById("checkTime").innerHTML = "" + videoTime;
	send_time(videoTime);
}

//send the starting time of next page (5s per page), eg, now is 47s then send 50
document.getElementById("next").onclick = function() {getVideoTime_next()};
function getVideoTime_next(){
    ++page_num;
    var myPlayer = videojs('example_video_1');
    var videoTime = 0;
    videoTime = myPlayer.currentTime();
    videoTime = videoTime+page_num*5;
    var duration = myPlayer.duration();
    duration = duration - duration%5;
    if(videoTime>=duration){
        videoTime = duration;
        --page_num;
    }else{
        videoTime = videoTime - videoTime%5;
    }
    //document.getElementById("checkTime").innerHTML = "" + videoTime;
	send_time(videoTime);
}

function commentTime(comment){
    var myPlayer = videojs('example_video_1');
    var videoTime=myPlayer.currentTime();
//    document.getElementById("checkTime").innerHTML = "" + comment+videoTime;
    var url = "submitComment.php?comment="+comment+"&video_time="+videoTime;
//    document.getElementById("checkTime").innerHTML = "" + url;

    var xmlhttp;
    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
    }else{// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function(){
	if (xmlhttp.readyState==4 && xmlhttp.status==200){
//	    document.getElementById("submit").innerHTML=xmlhttp.responseText;
        }
    }
//        document.getElementById( "iframe" ).src = "RefreshTable.php"; 
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
    
    //documents.forms['submitComment'].elements['comment'].value="";
    videoTime = videoTime - videoTime%5;
    var src = "RefreshTable.php?videoTime="+videoTime;
    document.submitComment.attributes["action"].value  = src;

}

</script>

<!--text area of comments, with max capacity of 200 words-->
<form action="" method="post" onSubmit="return datacheck();" target="iframe" name="submitComment">
<textarea type="text" name="comment" placeholder="Maximum 200 words..." rows="3" cols="40" wrap=PHYSICAL onKeyDown="gbcount(this.form.comment,this.form.total,this.form.used,this.form.remain);" onKeyUp="gbcount(this.form.comment,this.form.total,this.form.used,this.form.remain);"></textarea>
<input type="submit" id="submit" value="Submit" onclick="commentTime(comment.value)">

<p>Max words:
<input disabled maxLength="4" name="total" size="3" value="200" >
Written:
<input disabled maxLength="4" name="used" size="3" value="0" >
Left:
<input disabled maxLength="4" name="remain" size="3" value="200" >
</p>
</form>


<div id = 'scrollBox'>
<p id = 't'><p>
</div></tr></table>
</table>
</table>

</body>


</html>