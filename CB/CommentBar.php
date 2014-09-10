<!DOCTYPE html>
<html>

 <meta http-equiv='Content-type' content='text/html; charset=utf-8'>
<head>
<title>Comment Bar</title>
  <!-- IMPORT CSS for REPLYBOX  -->
  <link rel='stylesheet' href='popbox.css' type='text/css' media='screen' charset='utf-8'>
  <!-- iMPORT js for REPLYBOX -->

  <script type='text/javascript' charset='utf-8' src='jquery-1.11.1.js'></script>
  <script type='text/javascript' charset='utf-8' src='popbox.js'></script>


  <!-- script for REPLYBOX -->
  <script type='text/javascript' charset='utf-8'>
    $(document).ready(function(){
      $('.popbox').popbox();
    });
  </script>


<SCRIPT language="javascript">
<!--
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

-->
</script>

<?php
if (!empty($_POST["comment"]) or !empty($_POST["newreply"])){
echo '<META http-equiv="refresh" content="0;URL='.$_SERVER['PHP_SELF'].'">';
}
?>


</head>
<body>
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
echo 'INFO: Connected to MySQL at ' . DB_HOSTNAME . ':' . DB_PORT . '/' . DB_DATABASE . ' (' . DB_USERNAME . ')<br />';

//TODO:USE SESSION TO RETRIEVE VIDEO-ID
$ID_video = 'im3080';
$TB_comment = $ID_video.'_comment';
$TB_like = $ID_video.'_like';
$ID_num = 1201;


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
	PRIMARY KEY(comment_ID))";

// Use query() to execute a CREATE TABLE statement, which returns TRUE/FALSE
$mysqli->query($sqlStr)
      or die("Error: CREATE TABLE failed: ({$mysqli->errno}) {$mysqli->error}");
echo 'INFO: Table '.$TB_comment.' created<br />';

// CREARE TB_like TABLE WHICH CONTAINS LIKE/DISLIKE NUMBER OF CERTAIN USER AND COMMENT
$sqlStr = "CREATE TABLE IF NOT EXISTS ".$TB_like."(
	ID_num INT UNSIGNED        NOT NULL,
	comment_ID INT             NOT NULL,
        click_like INT                   NOT NULL DEFAULT 0,
        click_dislike INT                NOT NULL DEFAULT 0)";

// Use query() to execute a CREATE TABLE statement, which returns TRUE/FALSE
$mysqli->query($sqlStr)
      or die("Error: CREATE TABLE failed: ({$mysqli->errno}) {$mysqli->error}");
echo 'INFO: Table '.$TB_like.' created<br />';

//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//  if (empty($_POST["comment"])) {
//    $commentErr = "Comment is required";
//  }
//}

//insert reply info into table, when a reply is submitted
if (!empty($_POST["newreply"])){
	$pStmt = $mysqli->prepare("INSERT INTO ".$TB_comment." (ID_num, content, video_time, sending_date, sending_time, like_num, dislike_num, reply_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")
	      or die("Error: create prepared failed: ({$mysqli->errno}) {$mysqli->error}");
//	$ID_num = $_GET["ID_num"];
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
	echo "INFO: {$pStmt->affected_rows} row(s) inserted<br />";
}

//insert comment info into table, when a comment is submitted
if (!empty($_POST["comment"])){
	$pStmt = $mysqli->prepare("INSERT INTO ".$TB_comment." (ID_num, content, video_time, sending_date, sending_time, like_num, dislike_num) VALUES (?, ?, ?, ?, ?, ?, ?)")
	      or die("Error: create prepared failed: ({$mysqli->errno}) {$mysqli->error}");
	$content = $_POST["comment"];
	$video_time = 327;
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


//select all existing comments from table ordered by sending time
$mysqli->real_query('SELECT ID_num, video_time, content, sending_date,
		            sending_time, like_num, dislike_num, comment_ID FROM '.$TB_comment.' WHERE reply_ID=0 ORDER BY video_time ASC')
      or die("Error: SELECT failed: ({$mysqli->errno}) {$mysqli->error}");

$resultSet = $mysqli->store_result()
      or die("Error: Store resultset failed: ({$mysqli->errno}) {$mysqli->error}");
//make the result set into a table
//TODO:Now we fetch all comments everytime a new comment occurs,what about only add the new one? More cheap?
tabulate_resultset($resultSet);
$resultSet->close();  // Close the result set

//show the result in a table
function tabulate_resultset($resultSet) {
	echo '<table border=1><tr>';
	// Get fields' name and print table header row
	echo "<th>Time</th>";
	echo "<th width=70% >Comment</th>";
	echo "<th>Published on</th>";
	echo '</tr>';


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

        //print a clickable button for each comment
        //Q:<a class = 'open' href = #> what's the diff?
        echo "<td style=cursor:default>"."<div class='popbox'>"."<a class = 'open'>".$row['content']."</a>";
        echo "<div class='collapse'>"."<div class='box'>";
        echo "<div class='arrow'></div>"."<div class='arrow-border'></div>";
       
        $comment_ID = $row['comment_ID'];
        global $TB_comment;
        global $TB_like;
        global $ID_num;

        // Print a list of all replies
        $con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
        if (!$con) {
            die('Could not connect: ' . mysqli_error($con));
        }
        mysqli_select_db($con,"danmaku");        
        
        $sql='SELECT video_time, content, sending_date,
		            sending_time, like_num, dislike_num, comment_ID FROM '.$TB_comment.' WHERE reply_ID='.$comment_ID;
        
        $result = mysqli_query($con,$sql);
        tabulate_replyset($result);
        
        //TODO add action="<?php  PHP code here  wenhao>"
        //form for reply
        //reply_ID is the same as the comment_ID of the replied comment
        echo"<br/>"."<form action='CommentBar.php?reply_ID=".$comment_ID."&video_time=".$row['video_time']."&ID_num=".$ID_num."' method='post' onSubmit='return datacheck()'>";
        //echo"<div id='reply'><p></p></div>";
        echo"<input type='text' name='newreply'>";
        echo"<input type='submit'  value='Reply' />";
        // add onclick="<?php  PHP code here  wenhao>"
      	echo"</form>";
        echo"<br>";

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

      	echo"</div></div></div></td>";


        //format sending time
        $date = intval($row['sending_date']);
        $day = $date%100;
        $date = (int)($date/100);
        $month = $date%100;
        $date = (int)($date/100);
        printf('<td>%02d/%02d/%4d  ',$day,$month,$date);
        echo $row['sending_time'],"</td>";
        echo '</tr>';
    }
    echo '</table>';
}

//show replies in a table
function tabulate_replyset($result) {
    if($result->num_rows>0){
        echo '<table border=1><tr>';
	// Get fields' name and print table header row
	echo "<th>Time</th>";
	echo "<th width=70% >Comment</th>";
	echo "<th>Published on</th>";
	echo '</tr>';


	// Fetch each row and print table detail row
	foreach ($result as $row) {  // Loop thru all rows in resultset
        //format video time
	echo '<tr>';
        $time = $row['video_time'];
        $second = $time%60;
        $time = (int)($time/60);
        $minute = $time%60;
        $time = (int)($time/60);
        printf('<td>%02d:%02d:%02d</td>',$time,$minute,$second);
        
        $comment_ID = $row['comment_ID'];
        global $TB_comment;
        global $TB_like;
        global $ID_num;
        
        //like button of reply
        echo "<td>".$row['content'];
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

      	echo"</div></div></div></td>";

        //format the sending time
        $date = intval($row['sending_date']);
        $day = $date%100;
        $date = (int)($date/100);
        $month = $date%100;
        $date = (int)($date/100);
        printf('<td>%02d/%02d/%4d  ',$day,$month,$date);
        echo $row['sending_time'],"</td>";
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

?>

<!--text area of comments, with max capacity of 200 words-->
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" onSubmit="return datacheck();">
<textarea type="text" name="comment" placeholder="Maximum 200 words..." rows="3" cols="40" wrap=PHYSICAL onKeyDown="gbcount(this.form.comment,this.form.total,this.form.used,this.form.remain);" onKeyUp="gbcount(this.form.comment,this.form.total,this.form.used,this.form.remain);"></textarea>
<input type="submit" value="Submit">

<!--check for words used-->
<p>Max words:
<input disabled maxLength="4" name="total" size="3" value="200" >
Written:
<input disabled maxLength="4" name="used" size="3" value="0" >
Left:
<input disabled maxLength="4" name="remain" size="3" value="200" >
</p>
</form>


</body>
</html>