<?php

session_start();
?>

<html>
    <head>
        <title>Show Request</title>
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
    
    $resultSet = $mysqli->query("SELECT *, COUNT(DISTINCT comment_ID) FROM ".$TB_request."  WHERE ID_num=".$ID_num." GROUP BY comment_ID ORDER BY request_date, request_time ASC");
    //$resultSet = $mysqli->query("SELECT im3080_comment.content FROM im3080_comment LEFT JOIN im3080_request ON (im3080_request.comment_ID = im3080_comment.comment_ID OR im3080_comment.reply_ID = im3080_request.comment_ID");
    //ORDER BY request_date, request_time DESC comment_ID ASC");
    print_resultset($resultSet);
    $resultSet->close();
    

function print_resultset($resultSet){
	echo "<table style='width:100%'><tr>";
	echo "<th colspan='2'>Discussion</th>";
	echo "<th>Requested on</th>";
	echo"<th>Status</th>";
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
			
		$sql = "SELECT content, ID_num FROM ".$TB_comment." WHERE comment_ID = ".$row['comment_ID'];
		$result = mysqli_query($con,$sql);
		$original_comment = mysqli_fetch_assoc($result);
			
		//print the original comment
	     	echo"<tr><td>Comments:</td><td width = 60%>";
                if($original_comment['ID_num']==$ID_num){
                    echo"<b>".$original_comment['content']."</b>";
                    
                }else{
                    echo$original_comment['content'];
                }
                echo"</td>";
			//print the requesting time
            $date = intval($row['request_date']);
     	    $day = $date%100;
    	    $date = (int)($date/100);
    	    $month = $date%100;
    	    $date = (int)($date/100);
    	    printf('<td>%02d/%02d/%4d  ',$day,$month,$date);
     	   echo $row['request_time']."</td>";
     	   
     	   //checkbox for solved questions, then delete the record in request table
     	   echo "<td>";
           if($row['isProcessed']==1){
               echo"solved";
           }else{
               echo"in process";
           }
     	   echo"</td></tr>";
     	   echo"<tr><td>Reply:</td>";
     	   
     	   //print replies for each comment
     	   $sql = "SELECT content, isProf, ID_num FROM ".$TB_comment." WHERE reply_ID = ".$row['comment_ID']." ORDER BY comment_ID ASC";
     	   $replySet = mysqli_query($con,$sql);
     	   
     	   foreach($replySet as $replyrow){
                echo"<td>";
               if($replyrow['isProf']==1){
                   echo "<font color='red'>".$replyrow['content']."</font>";
               }else if($replyrow['ID_num']==$ID_num){
                   echo "<b>".$replyrow['content']."</b>";                   
               }else{
                   echo $replyrow['content'];
               }
               echo"</td></tr><tr><td></td>";
     	   }
     	   echo"</tr>";
	   }
	   echo"</table>";
}      
  
?>

        </body>
</html>


