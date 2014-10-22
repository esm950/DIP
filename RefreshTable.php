<?php
session_start();
?>

<!DOCTYPE html>
<html>

 <meta http-equiv='Content-type' content='text/html; charset=utf-8'>

 <!-- refresh page every 10 seconds for updating comments -->
<?php
//$refresh_duration = 10;
//echo"<META HTTP-EQUIV='Refresh' CONTENT='".$refresh_duration."'>";
?>
 
<head>
<title>Comment Bar</title>
  <link rel='stylesheet' href='popbox.css' type='text/css' media='screen' charset='utf-8'>

<?php
//if (!empty($_POST["comment"]) or !empty($_POST["newreply"]) or !empty($_POST["videoTime"])){
//echo '<META http-equiv="refresh" content="0;URL='.$_SERVER['PHP_SELF'].'">';
//}
?>


</head>
<body>
<div id='scrollBox'>
<?php

// Define database related constants
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'wampuser');
define('DB_PASSWORD', 'xxxx');
define('DB_DATABASE', 'danmaku');
define('DB_PORT',     3306);


// Connect to the MySQL server and set the default database
$mysqli = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
!$mysqli->connect_errno
      or die("Error: Failed to CONNECT: ({$mysqli->connect_errno}) {$mysqli->connect_error}");
//echo 'INFO: Connected to MySQL at ' . DB_HOSTNAME . ':' . DB_PORT . '/' . DB_DATABASE . ' (' . DB_USERNAME . ')<br />';

//TODO:USE SESSION TO RETRIEVE VIDEO-ID
$ID_video = 'im3080';
$TB_comment = $ID_video.'_comment';
$TB_like = $ID_video.'_like';
$TB_request = $ID_video.'_request';
$ID_num = $_SESSION ['ID_num'];
$TB_user_block = 'user'.$ID_num.'_block';
//default sort_seq
$sort_seq = 'video_time';

if(!empty($_GET["sort"])){
    $sort_seq = $_GET["sort"]; 
}

$start_position = 0;
if(!empty($_GET["videoTime"])){
    $start_position = $_GET["videoTime"]; 
}
$end_position= $start_position + 5;
//get current video position here, every 5 seconds, refresh the page
$page_index = $start_position / 5 + 1;//start from 1

// CREATE TABLE NAMED AFTER THE VIDEO-ID
// CREATE TB_comment TABLE
$sqlStr = "CREATE TABLE IF NOT EXISTS ".$TB_comment." (
	ID_num INT UNSIGNED        NOT NULL,
	content VARCHAR(2000)      NOT NULL,
	video_time DOUBLE          NOT NULL,
	sending_date VARCHAR(10)   NOT NULL,
	sending_time VARCHAR(10)   NOT NULL,
	like_num INT               NOT NULL,
	dislike_num INT            NOT NULL,
	comment_ID INT             NOT NULL AUTO_INCREMENT,
	reply_ID INT               DEFAULT 0,
	color VARCHAR(10)          NOT NULL DEFAULT '#000000',
	size VARCHAR(10)           NOT NULL DEFAULT 'middle',
	position VARCHAR(10)       NOT NULL DEFAULT 'top',
        isAnno INT                 DEFAULT 0,
        link VARCHAR(200)          ,
        isProf INT                 DEFAULT 0,
	PRIMARY KEY(comment_ID))";

// Use query() to execute a CREATE TABLE statement, which returns TRUE/FALSE
$mysqli->query($sqlStr)
      or die("Error: CREATE TABLE failed: ({$mysqli->errno}) {$mysqli->error}");
//echo 'INFO: Table '.$TB_comment.' created<br />';

// CREARE TB_like TABLE WHICH CONTAINS LIKE/DISLIKE NUMBER OF CERTAIN USER AND COMMENT
$sqlStr = "CREATE TABLE IF NOT EXISTS ".$TB_like."(
	ID_num INT UNSIGNED        NOT NULL,
	comment_ID INT             NOT NULL,
        click_like INT                   NOT NULL DEFAULT 0,
        click_dislike INT                NOT NULL DEFAULT 0)";

// Use query() to execute a CREATE TABLE statement, which returns TRUE/FALSE
$mysqli->query($sqlStr)
      or die("Error: CREATE TABLE failed: ({$mysqli->errno}) {$mysqli->error}");
//echo 'INFO: Table '.$TB_like.' created<br />';

//insert reply info into table, when a reply is submitted
$sqlStr = "CREATE TABLE IF NOT EXISTS ".$TB_request."(
	 comment_ID INT             NOT NULL,
         ID_num INT                NOT NULL,
         isProcessed INT            DEFAULT 0,
         request_date VARCHAR(10)   NOT NULL,
	 request_time VARCHAR(10)   NOT NULL)";
$mysqli->query($sqlStr)
or die("Error: CREATE TABLE failed: ({$mysqli->errno}) {$mysqli->error}");      

$sqlStr = "CREATE TABLE IF NOT EXISTS ".$TB_user_block." (
	ID_num INT UNSIGNED      NOT NULL,
        block_date VARCHAR(10)   NOT NULL,
	block_time VARCHAR(10)   NOT NULL)";
$mysqli->query($sqlStr)
or die("Error: CREATE TABLE failed: ({$mysqli->errno}) {$mysqli->error}");     


if (!empty($_POST["newreply"])){
	$pStmt = $mysqli->prepare("INSERT INTO ".$TB_comment." (ID_num, content, video_time, sending_date, sending_time, like_num, dislike_num, reply_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")
	      or die("Error: create prepared failed: ({$mysqli->errno}) {$mysqli->error}");
	$content = $_POST["newreply"];
	$video_time = $_GET["video_time"];
	date_default_timezone_set('Asia/Singapore');
	$sending_date = date('Ymd');
	$sending_time = date('H:i:s');
	$like_num = 0;
	$dislike_num = 0;
        $reply_ID = $_GET["reply_ID"];
	$pStmt->bind_param('isissiii', $ID_num, $content, $video_time, $sending_date, $sending_time, $like_num, $dislike_num, $reply_ID)
	        and $pStmt->execute()
	      or die("Error: run prepared failed: ({$pStmt->errno}) {$pStmt->error}");
	//echo "INFO: {$pStmt->affected_rows} row(s) inserted<br />";
              
        $video_time = $video_time - $video_time%5;
        $mysqli->real_query('SELECT ID_num, video_time, content, sending_date,
		            sending_time, like_num, dislike_num, comment_ID, isProf FROM '.$TB_comment.' WHERE isAnno=0 AND reply_ID=0 AND video_time>='.$video_time.' AND video_time<'.($video_time+5).' '
                            . 'AND ID_num NOT IN (SELECT ID_num FROM '.$TB_user_block.') ORDER BY '.$sort_seq.' ASC')
        or die("Error: SELECT failed: ({$mysqli->errno}) {$mysqli->error}");

        //echo 'SELECT ID_num, video_time, content, sending_date,
	//	            sending_time, like_num, dislike_num, comment_ID, isProf FROM '.$TB_comment.' WHERE isAnno=0 AND reply_ID=0 AND video_time>='.$start_position.' AND video_time<'.$end_position.' '
        //                  . 'AND ID_num NOT IN (SELECT ID_num FROM '.$TB_user_block.') ORDER BY '.$sort_seq.' ASC';
                
        $resultSet = $mysqli->store_result()
        or die("Error: Store resultset failed: ({$mysqli->errno}) {$mysqli->error}");
        //make the result set into a table
        //TODO:Now we fetch all comments everytime a new comment occurs,what about only add the new one? More cheap?
        tabulate_resultset($resultSet);
        $resultSet->close();  // Close the result set
}else{
        
        //select all existing comments from table ordered by sending time
        $mysqli->real_query('SELECT ID_num, video_time, content, sending_date,
		            sending_time, like_num, dislike_num, comment_ID, isProf FROM '.$TB_comment.' WHERE isAnno=0 AND reply_ID=0 AND video_time>='.$start_position.' AND video_time<'.$end_position.' '
                            . 'AND ID_num NOT IN (SELECT ID_num FROM '.$TB_user_block.') ORDER BY '.$sort_seq.' ASC')
        or die("Error: SELECT failed: ({$mysqli->errno}) {$mysqli->error}");

        //echo 'SELECT ID_num, video_time, content, sending_date,
	//	            sending_time, like_num, dislike_num, comment_ID, isProf FROM '.$TB_comment.' WHERE isAnno=0 AND reply_ID=0 AND video_time>='.$start_position.' AND video_time<'.$end_position.' '
        //                  . 'AND ID_num NOT IN (SELECT ID_num FROM '.$TB_user_block.') ORDER BY '.$sort_seq.' ASC';
                
        $resultSet = $mysqli->store_result()
        or die("Error: Store resultset failed: ({$mysqli->errno}) {$mysqli->error}");
        //make the result set into a table
        //TODO:Now we fetch all comments everytime a new comment occurs,what about only add the new one? More cheap?
        tabulate_resultset($resultSet);
        $resultSet->close();  // Close the result set
}        

//show the result in a table
function tabulate_resultset($resultSet) {
	echo '<table id="commentTable" class="popbox" width = 100% border=1 style="border-collapse: collapse;table-layout: fixed;">'."\n";

	$count = 1;
	// Fetch each row and print table detail row
	foreach ($resultSet as $row) {  // Loop thru all rows in resultset
	//format video time
        echo '<tr>';
        $time = $row['video_time'];
        $second = $time%60;
        $time = (int)($time/60);
        $minute = $time%60;
        $time = (int)($time/60);
        printf('<td>%02d:%02d:%02d</td>',$time,$minute,$second);

       
        echo"<td class ='comment open' width = 70% style='cursor:default;'>";
        echo"<div class='commentCell' id='commentCell' style='text-overflow:ellipsis;white-space: nowrap; overflow: hidden;'>";
        if($row['isProf']==1){
            echo "<font color='red'>".$row['content']."</font>";
        }else{
            echo $count.$row['content'];
            $count+=1;
        }
        
        echo"<span class='commentID'style='display:none'>".$row['comment_ID']."</span>";
        
        echo "</div>"."\n";
        echo '<div class="box rightMenu"><ul>';
        echo '<li><span class="blockUser">Block This User</span></li>';
        echo '<li><span class="seeUser">See All Comments From This User</span></li>';
        echo '</ul></div>';
        
        echo "<div class='collapse'>"."<div class='box downMenu'>";
        echo "<div class='arrow'></div>"."<div class='arrow-border'></div>";
      
       
        $comment_ID = $row['comment_ID'];
        global $TB_comment;
        global $TB_like;
        global $TB_user_block;
        global $ID_num;

        // Print a list of all replies
        $con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
        if (!$con) {
            die('Could not connect: ' . mysqli_error($con));
        }
        mysqli_select_db($con,"danmaku");        
        
        $sql='SELECT video_time, content, sending_date,
		            sending_time, like_num, dislike_num, comment_ID, isProf FROM '.$TB_comment.' WHERE reply_ID='.$comment_ID.' AND ID_num NOT IN (SELECT ID_num FROM '.$TB_user_block.')';
        
        $result = mysqli_query($con,$sql);
        
        echo"<div style='word-wrap: break-word;'>";
        if($row['isProf']==1){
            echo "<font color='red'>".$row['content']."</font>";
        }else{
            echo $row['content'];
        }        tabulate_replyset($result);
        echo"</div>";
      
        //form for reply
        //reply_ID is the same as the comment_ID of the replied comment
        echo"\n"."<br/>"."<form action='RefreshTable.php?reply_ID=".$comment_ID."&video_time=".$row['video_time']."&ID_num=".$ID_num."' method='post' onSubmit='return datacheck()'>"."\n";
        //echo"<div id='reply'><p></p></div>";
        echo"<input type='text' name='newreply'>";
        echo"<input type='submit'  value='Reply' />";
      	echo"</form>";
                
        echo"<br>"."\n";

        $sql_like= 'SELECT * FROM '.$TB_like.' WHERE comment_ID='.$comment_ID.' AND ID_num='.$ID_num;
        $result_like=mysqli_query($con,$sql_like);
        $like_status=check_status($result_like);

        //like button, send data to addLikeNum() function when click
        //echo"<button  id='like_btn".$comment_ID."' onclick='addLikeNum(".$comment_ID.",\"".$TB_comment."\",\"".$TB_like."\",".$ID_num.")'>Like</button>";
        echo"<b style=cursor:default id='like".$comment_ID."' onclick='addLikeNum(".$comment_ID.",\"".$TB_comment."\",\"".$TB_like."\",".$ID_num.")'>";  //the place to show the like number
        if($like_status=='like'){
            echo "LIKED (".$row['like_num'].")";            
        }else{
            echo "LIKE (".$row['like_num'].")";
        }
        echo "</b>";
        
        echo" / "."\n";

      	//dislike button, send data to addDislikeNum() function when click
        //echo"<button  id='dislike_btn".$comment_ID."' onclick='addDislikeNum(".$comment_ID.",\"".$TB_comment."\",\"".$TB_like."\",".$ID_num.")'>Dislike</button>";
        echo"<b style=cursor:default id='dislike".$comment_ID."'onclick='addDislikeNum(".$comment_ID.",\"".$TB_comment."\",\"".$TB_like."\",".$ID_num.")'>";   //the place to show the dislike number
        if($like_status=='dislike'){
            echo "DISLIKED (".$row['dislike_num'].")";            
        }else{
            echo "DISLIKE (".$row['dislike_num'].")";
        }
        echo"</b>"."\n";
        
        global $ID_video;
        
        //copy all
        echo"<button type='button' onClick='copyAll(\"".$ID_video."\", ".$row['video_time'].",".$comment_ID.")'>Copy All</button>";
        
        //request help
        echo"<button type='button' class='requestHelpBtn' onClick='requestHelp(".$comment_ID.",\"".$ID_video."\", ".$ID_num.")'>Request Help</button>";
        echo"<span class='requestSent' style='display:none'>sent</span>";

      	echo"</div></div></div>"."\n";

      	echo "</td>"."\n";

        //format sending time
        $date = intval($row['sending_date']);
        $day = $date%100;
        $date = (int)($date/100);
        $month = $date%100;
        $date = (int)($date/100);
        printf('<td>%02d/%02d/%4d  ',$day,$month,$date);
        echo $row['sending_time'],"</td>";
        echo '</tr>'."\n";
    }
    echo '</table>';
}

//show replies in a table
function tabulate_replyset($result) {
    if($result->num_rows>0){
    	echo '<br/>';
        echo '<table width=100%>';
        
	// Fetch each row and print table detail row
	foreach ($result as $row) {  // Loop thru all rows in resultset
        //format video time
	echo "<tr align='right'>";
        
        
        $comment_ID = $row['comment_ID'];
        global $TB_comment;
        global $TB_like;
        global $ID_num;
        
        //like button of replyif($row['isProf']==1){
        echo "<td>";
        if($row['isProf']==1){
            echo "<font color='red'>".$row['content']."</font>";
        }else{
            echo $row['content'];
        }
        echo "     ";
        
        $con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
        if (!$con) {
            die('Could not connect: ' . mysqli_error($con));
        }
        mysqli_select_db($con,"danmaku");    
        
        $sql_like= 'SELECT * FROM '.$TB_like.' WHERE comment_ID='.$comment_ID.' AND ID_num='.$ID_num;
        $result_like=mysqli_query($con,$sql_like);
        $like_status=check_status($result_like);

        //like button, send data to addLikeNum() function when click
        //echo"<button  id='like_btn".$comment_ID."' onclick='addLikeNum(".$comment_ID.",\"".$TB_comment."\",\"".$TB_like."\",".$ID_num.")'>Like</button>";
        //echo '<br/>';
        echo"<b style=cursor:default id='like".$comment_ID."' onclick='addLikeNum(".$comment_ID.",\"".$TB_comment."\",\"".$TB_like."\",".$ID_num.")'>";  //the place to show the like number
        if($like_status=='like'){
            echo "LIKED (".$row['like_num'].")";            
        }else{
            echo "LIKE (".$row['like_num'].")";
        }
        echo "</b>";
        
        echo" / ";

      	//dislike button, send data to addDislikeNum() function when click
        //echo"<button  id='dislike_btn".$comment_ID."' onclick='addDislikeNum(".$comment_ID.",\"".$TB_comment."\",\"".$TB_like."\",".$ID_num.")'>Dislike</button>";
        echo"<b style=cursor:default id='dislike".$comment_ID."'onclick='addDislikeNum(".$comment_ID.",\"".$TB_comment."\",\"".$TB_like."\",".$ID_num.")'>";   //the place to show the dislike number
        if($like_status=='dislike'){
            echo "DISLIKED (".$row['dislike_num'].")";            
        }else{
            echo "DISLIKE (".$row['dislike_num'].")";
        }
        echo"</b>";

      	echo"</div></div></td>";

        //format the sending time
        
        echo '</tr>';
        }
        echo '</table>';
    }
}

function check_status($result_like){
    if($result_like->num_rows == 1){
        foreach($result_like as $row){
            if($row['click_like']==1){
               return 'like';
            }else{
               return 'dislike';
            }
        }
    }else{
        return 'none';
    }       
}
echo '<p id="page_index" >'.$page_index.'</p>';
?>

</div>
 <script type='text/javascript' charset='utf-8' src='jquery-1.11.1.js'></script>
  <script type='text/javascript' charset='utf-8' src='fixJQueryOffsetSetterBug.js'></script>  
  <script type='text/javascript' charset='utf-8' src='popbox.js'></script>
    <script type='text/javascript' charset='utf-8' src='endRowListener.js'></script>
    
  
  <script type='text/javascript' charset='utf-8'>
    $(document).ready(function(){
      $('.popbox').popbox();
      addEndRowListener();
      
    });
  </script>


<SCRIPT language="javascript">
<!--
function addLikeNum(comment_ID, TB_comment, TB_like, ID_num){
	var xmlhttp;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
	  if (xmlhttp.readyState==4 && xmlhttp.status==200){
	    document.getElementById("like"+comment_ID).innerHTML=xmlhttp.responseText;
	  }
	}
 //       document.getElementById("like_btn"+comment_ID).disabled = 'disabled';
 //       document.getElementById("dislike_btn"+comment_ID).disabled = 'disabled';        
        
        var url = "likeIncre.php?comment_ID=";
        url = url+comment_ID;
        url = url+"&TB_comment="+TB_comment;
        url = url+"&TB_like="+TB_like;
        url = url+"&ID_num="+ID_num;
        
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
}

function addDislikeNum(comment_ID, TB_comment, TB_like, ID_num){
	var xmlhttp;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
	  if (xmlhttp.readyState==4 && xmlhttp.status==200){
	    document.getElementById("dislike"+comment_ID).innerHTML=xmlhttp.responseText;
	  }
	}
//        document.getElementById("dislike_btn"+comment_ID).disabled = 'disabled';        
//        document.getElementById("like_btn"+comment_ID).disabled = 'disabled';
       
	var url = "dislikeIncre.php?comment_ID="
        url = url+comment_ID;
        url = url+"&TB_comment="+TB_comment;
        url = url+"&TB_like="+TB_like;
        url = url+"&ID_num="+ID_num;

        
        xmlhttp.open("GET",url,true);
	xmlhttp.send();
}

function copyAll(ID_video, video_time, comment_ID){
    var url = "addNote.php?comment_ID="+comment_ID+"&video_time="+video_time+"&ID_video="+ID_video;
    alert(url);

    var xmlhttp;
    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
    }else{// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function(){
	if (xmlhttp.readyState==4 && xmlhttp.status==200){
        }
    }
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}

function requestHelp(comment_ID,ID_video, ID_num){
    	var xmlhttp;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
	  if (xmlhttp.readyState==4 && xmlhttp.status==200){
	  }
	}
       
	var url = "requestHelp.php?comment_ID="+comment_ID+"&ID_video="+ID_video+"&ID_num="+ID_num;
        
        xmlhttp.open("GET",url,true);
	xmlhttp.send();
    
}
-->
</script>
</body>
</html>