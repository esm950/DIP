<!DOCTYPE html>
<html>
<head>
<title>Test HTML</title>

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

-->
</script>

<?php
if (!empty($_POST["comment"])){
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

$ID_video = 'im3080';

// CREATE TABLE
$sqlStr = "CREATE TABLE IF NOT EXISTS ".$ID_video." (
	ID_num INT UNSIGNED        NOT NULL,
	content VARCHAR(2000)      NOT NULL,
	video_time DOUBLE          NOT NULL,
	sending_date VARCHAR(10)   NOT NULL,
	sending_time VARCHAR(10)   NOT NULL,
	like_num INT               NOT NULL,
	dislike_num INT            NOT NULL,
	comment_ID INT             NOT NULL AUTO_INCREMENT,
	reply_ID INT               ,
	color VARCHAR(10)          NOT NULL DEFAULT '#000000',
	size VARCHAR(10)           NOT NULL DEFAULT 'middle',
	position VARCHAR(10)       NOT NULL DEFAULT 'top',
	PRIMARY KEY(comment_ID))";

// Use query() to execute a CREATE TABLE statement, which returns TRUE/FALSE
$mysqli->query($sqlStr)
      or die("Error: CREATE TABLE failed: ({$mysqli->errno}) {$mysqli->error}");
echo 'INFO: Table '.$ID_video.' created<br />';

//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//  if (empty($_POST["comment"])) {
//    $commentErr = "Comment is required";
//  }
//}


if (!empty($_POST["comment"])){
	$pStmt = $mysqli->prepare("INSERT INTO ".$ID_video ." (ID_num, content, video_time, sending_date, sending_time, like_num, dislike_num) VALUES (?, ?, ?, ?, ?, ?, ?)")
	      or die("Error: create prepared failed: ({$mysqli->errno}) {$mysqli->error}");
	$ID_num = 1200;
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

if (!empty($_POST["reply"])){
	$pStmt = $mysqli->prepare("INSERT INTO ".$ID_video ." (ID_num, content, video_time, sending_date, sending_time, like_num, dislike_num) VALUES (?, ?, ?, ?, ?, ?, ?)")
	or die("Error: create prepared failed: ({$mysqli->errno}) {$mysqli->error}");
	$ID_num = 12;
	$content = $_POST["reply"];
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
        $time = $row['video_time'];
        $second = $time%60;
        $time = (int)($time/60);
        $minute = $time%60;
        $time = (int)($time/60);
        printf('<td>%02d:%02d:%02d</td>',$time,$minute,$second);

        echo"<td>",$row['content'],"</td>";

        $date = intval($row['sending_date']);
        $day = $date%100;
        $date = (int)($date/100);
        $month = $date%100;
        $date = (int)($date/100);
        printf('<td>%02d/%02d/%4d  ',$day,$month,$date);
        echo $row['sending_time'],"</td>";
      //  echo"<td>",$row['like_num'],"</td>";
      //  echo"<td>",$row['dislike_num'],"</td>";
        echo '</tr>';
    }
    echo '</table>';
}

?>

<!-- Comment bar -->
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" onSubmit="return datacheck();">
Comment: <br><textarea type="text" name="comment" placeholder="Maximum 200 words..." rows="3" cols="40" wrap=PHYSICAL onKeyDown="gbcount(this.form.comment,this.form.total,this.form.used,this.form.remain);" onKeyUp="gbcount(this.form.comment,this.form.total,this.form.used,this.form.remain);"></textarea>
<input type="submit" value="Submit">

<p>Max words:
<input disabled maxLength="4" name="total" size="3" value="200" >
Written：
<input disabled maxLength="4" name="used" size="3" value="0" >
Left：
<input disabled maxLength="4" name="remain" size="3" value="200" >
</p>
</form>


<!-- Reply bar  -->
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" onSubmit="return datacheck();">
Reply: <br><textarea type="text" name="reply" placeholder="Maximum 200 words..." rows="3" cols="40" wrap=PHYSICAL onKeyDown="gbcount(this.form.reply,this.form.total,this.form.used,this.form.remain);" onKeyUp="gbcount(this.form.reply,this.form.total,this.form.used,this.form.remain);"></textarea>
<input type="submit" value="Reply">

<p>Max words:
<input disabled maxLength="4" name="total" size="3" value="200" >
Written：
<input disabled maxLength="4" name="used" size="3" value="0" >
Left：
<input disabled maxLength="4" name="remain" size="3" value="200" >
</p>
</form>

<!-- Like and Dislike button -->
<script type="text/javascript">
var likenum = 0;
function likeIncre(){
     likenum++;
     document.getElementById('displayLikenum').innerHTML = likenum;
}

var dislikenum = 0;
function dislikeIncre(){
     dislikenum++;
     document.getElementById('displayDislikenum').innerHTML = dislikenum;
}
</script>



<button onclick="likeIncre()">LIKE</button>
<div id="displayLikenum"><script type="text/javascript">document.write(likenum);</script></div>

<button onclick="dislikeIncre()">Dislike</button>
<div id="displayDislikenum"><script type="text/javascript">document.write(dislikenum);</script></div>

</body>
</html>
