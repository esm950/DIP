<?php
session_start();
?>

<html>
    <head>
        <title>Print Request</title>
        <?php
        if ((!empty($_POST["profReply"]))or(!empty($_POST["solved"]))){
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
    $TB_comment = $ID_video.'_comment';
    $TB_request = $ID_video.'_request';
    $ID_num = $_SESSION ['ID_num'];
    
    //get reply from professors, insert into comment table and print on this page, also print on the try.html
    //TODO: isProf = 1
    if (!empty($_POST["profReply"])){
        $target_comment = $_GET["reply_ID"];
        $sqlStr = $mysqli->real_query("SELECT * FROM ".$TB_comment." WHERE comment_ID=".$target_comment);
        $resultSet = $mysqli->store_result();
        foreach ($resultSet as $row) {
            $video_time = $row['video_time'];
        }
        $reply_ID = $_GET["reply_ID"];

        
    	$pStmt = $mysqli->prepare("INSERT INTO ".$TB_comment." (ID_num, content, video_time, sending_date, sending_time, like_num, dislike_num, reply_ID, color, isProf) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")
    	or die("Error: create prepared failed: ({$mysqli->errno}) {$mysqli->error}");
    	$content = $_POST["profReply"];
    	date_default_timezone_set('Asia/Singapore');
    	$sending_date = date('Ymd');
    	$sending_time = date('H:i:s');
    	$like_num = 0;
    	$dislike_num = 0;
        $color = "#FF0000";
    	$isPof = 1;
    	$pStmt->bind_param('isissiiisi', $ID_num, $content, $video_time, $sending_date, $sending_time, $like_num, $dislike_num, $reply_ID, $color, $isPof)
    	and $pStmt->execute()
    	or die("Error: run prepared failed: ({$pStmt->errno}) {$pStmt->error}");
    }
    
    //delete the record from request table
    if (!empty($_POST["solved"])){
    	$mysqli->query("UPDATE ".$TB_request." SET isProcessed = 1 WHERE comment_ID = ".$_GET["comment_ID"]);  	
    }

    $resultSet = $mysqli->query("SELECT *, COUNT(DISTINCT comment_ID) FROM ".$TB_request."  WHERE isProcessed=0 GROUP BY comment_ID ORDER BY request_date, request_time ASC");
    //$resultSet = $mysqli->query("SELECT im3080_comment.content FROM im3080_comment LEFT JOIN im3080_request ON (im3080_request.comment_ID = im3080_comment.comment_ID OR im3080_comment.reply_ID = im3080_request.comment_ID");
    //ORDER BY request_date, request_time DESC comment_ID ASC");
    print_resultset($resultSet);
    $resultSet->close();
    

function print_resultset($resultSet){
	echo "<table style='width:100%'><tr>";
	echo "<th colspan='2'>Discussion</th>";
	echo "<th>Requested on</th>";
	echo"<th>Solved</th>";
	echo '</tr>';
	
	foreach ($resultSet as $row){
		//select the original comment with stored comment_ID
		$con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
		if (!$con) {
				die('Could not connect: ' . mysqli_error($con));
		}
		mysqli_select_db($con,"danmaku");
			
		global $ID_num;
                global $TB_comment;
		global $TB_request;
			
		$sql = "SELECT content FROM ".$TB_comment." WHERE comment_ID = ".$row['comment_ID'];
		$result = mysqli_query($con,$sql);
		$original_comment = mysqli_fetch_assoc($result);
			
		//print the original comment
	     	echo"<tr><td>Comments:</td><td width = 60%>".$original_comment['content']."</td>";
			//print the requesting time
			$date = intval($row['request_date']);
     	    $day = $date%100;
    	    $date = (int)($date/100);
    	    $month = $date%100;
    	    $date = (int)($date/100);
    	    printf('<td>%02d/%02d/%4d  ',$day,$month,$date);
     	   echo $row['request_time']."</td>";
     	   
     	   //checkbox for solved questions, then delete the record in request table
     	   echo "<td><form action='printRequest.php?comment_ID=".$row['comment_ID']."' method='post' onSubmit='return datacheck()'>";
     	   echo"<input type='checkbox' name='solved' onChange='this.form.submit()'>Problem solved";
     	   echo"</form></td></tr>";
     	   echo"<tr><td>Reply:</td>";
     	   
     	   //print replies for each comment
     	   $sql = "SELECT content, ID_num FROM ".$TB_comment." WHERE reply_ID = ".$row['comment_ID']." ORDER BY comment_ID ASC";
     	   $replySet = mysqli_query($con,$sql);
     	   
     	   foreach($replySet as $replyrow){
     	   	echo"<td>";
                if($replyrow['ID_num']==$ID_num){
                   echo "<font color='red'>".$replyrow['content']."</font>";                    
                }else{
                echo$replyrow['content'];                    
                }
                echo"</td></tr><tr><td></td>";
     	   }
     	   echo"</tr>";
     	   
     	   //reply from professors
     	   echo"<tr><td></td><td><form action='printRequest.php?reply_ID=".$row['comment_ID']."' method='post' onSubmit='return datacheck()'>";
     	   echo"<input type='text' name='profReply'>";
     	   echo"<input type='submit' value='Reply' />";
     	   echo"</form></td></tr>";
	   }
	   echo"</table>";
}      
  
?>

        </body>
</html>


