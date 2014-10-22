<?php
session_start();
?>

<html>
    <head>
        <title>See User Comments</title>
        
        <script>
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
	var url = "dislikeIncre.php?comment_ID="
        url = url+comment_ID;
        url = url+"&TB_comment="+TB_comment;
        url = url+"&TB_like="+TB_like;
        url = url+"&ID_num="+ID_num;

        
        xmlhttp.open("GET",url,true);
	xmlhttp.send();
}

        </script>
    </head>
    <body>
     
<?php
$comment_ID=$_GET['comment_ID'];
$ID_video=$_GET['ID_video'];
$ID_num=$_GET['ID_num'];
$TB_user_block = 'user'.$ID_num.'_block';
$TB_comment = $ID_video.'_comment';
$TB_like = $ID_video.'_like';

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
	echo "INFO: {$pStmt->affected_rows} row(s) inserted<br />";
}


      
$mysqli->real_query('SELECT ID_num FROM '.$TB_comment.' WHERE comment_ID='.$comment_ID.' AND ID_num NOT IN (SELECT ID_num FROM '.$TB_user_block.')')
        or die("Error: SELECT failed: ({$mysqli->errno}) {$mysqli->error}");

        $resultSet = $mysqli->store_result()
        or die("Error: Store resultset failed: ({$mysqli->errno}) {$mysqli->error}");
        if($resultSet->num_rows>0){
            foreach ($resultSet as $row) {
                $select_ID=$row['ID_num'];
            }
        }else{
            echo 'No result';
            exit();
        }
        
$mysqli->real_query('SELECT ID_num, video_time, content, sending_date,
		            sending_time, like_num, dislike_num, comment_ID, isProf FROM '.$TB_comment.' WHERE isAnno=0 AND reply_ID=0 AND ID_num='.$select_ID.' ORDER BY video_time ASC')
        or die("Error: SELECT failed: ({$mysqli->errno}) {$mysqli->error}");

        $resultSet = $mysqli->store_result()
        or die("Error: Store resultset failed: ({$mysqli->errno}) {$mysqli->error}");
        //make the result set into a table
        //TODO:Now we fetch all comments everytime a new comment occurs,what about only add the new one? More cheap?
        tabulate_resultset($resultSet);
        $resultSet->close();  // Close the result set
        
function tabulate_resultset($resultSet) {
	echo '<table id="commentTable" width = 100% border=1 style="table-layout: fixed;">';

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

        echo "<td width = 70% style='cursor:default;'>";
        if($row['isProf']==1){
            echo "<font color='red'>".$row['content']."</font>";
        }else{
            echo $row['content'];
        }
              
       
        $comment_ID = $row['comment_ID'];
        global $TB_comment;
        global $TB_like;
        global $TB_user_block;
        global $ID_num;
        global $ID_video;

        // Print a list of all replies
        $con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
        if (!$con) {
            die('Could not connect: ' . mysqli_error($con));
        }
        mysqli_select_db($con,"danmaku");        
        
        $sql='SELECT video_time, content, sending_date,
		            sending_time, like_num, dislike_num, comment_ID, isProf FROM '.$TB_comment.' WHERE reply_ID='.$comment_ID.' AND ID_num NOT IN (SELECT ID_num FROM '.$TB_user_block.')';
        
        $result = mysqli_query($con,$sql);
        
        
        tabulate_replyset($result);
        echo"</div>";
      
        //form for reply
        //reply_ID is the same as the comment_ID of the replied comment
        echo"<br/>"."<form action='seeUser.php?reply_ID=".$comment_ID."&video_time=".$row['video_time']."&ID_num=".$ID_num."&comment_ID=".$comment_ID."&ID_video=".$ID_video."' method='post' onSubmit='return datacheck()'>";
        //echo"<div id='reply'><p></p></div>";
        echo"<input type='text' name='newreply'>";
        echo"<input type='submit'  value='Reply' />";
         // add onclick="<?php  PHP code here  wenhao>"
      	echo"</form>";
                
        echo"<br>";

        $sql_like= 'SELECT * FROM '.$TB_like.' WHERE comment_ID='.$comment_ID.' AND ID_num='.$ID_num;
        $result_like=mysqli_query($con,$sql_like);
        $like_status=check_status($result_like);

        echo"<b style=cursor:default id='like".$comment_ID."' onclick='addLikeNum(".$comment_ID.",\"".$TB_comment."\",\"".$TB_like."\",".$ID_num.")'>";  //the place to show the like number
        if($like_status=='like'){
            echo "LIKED (".$row['like_num'].")";            
        }else{
            echo "LIKE (".$row['like_num'].")";
        }
        echo "</b>";
        
        echo" / ";

        echo"<b style=cursor:default id='dislike".$comment_ID."'onclick='addDislikeNum(".$comment_ID.",\"".$TB_comment."\",\"".$TB_like."\",".$ID_num.")'>";   //the place to show the dislike number
        if($like_status=='dislike'){
            echo "DISLIKED (".$row['dislike_num'].")";            
        }else{
            echo "DISLIKE (".$row['dislike_num'].")";
        }
        echo"</b>";
        
        global $ID_video;
        //request help
        echo"<button type='button' onClick='requestHelp(".$comment_ID.",\"".$ID_video."\", ".$ID_num.")'>Request Help</button>";
        // add onclick="<?php  PHP code here  wenhao>"


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

           
    </body>
</html>
