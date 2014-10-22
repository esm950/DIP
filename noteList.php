<?php
session_start();
?>

<!DOCTYPE html>
<html>

 <meta http-equiv='Content-type' content='text/html; charset=utf-8'>

<head>
<title>Note List</title>

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
$course_code = 'im';
$TB_comment = $ID_video.'_comment';
$TB_like = $ID_video.'_like';
$TB_request = $ID_video.'_request';
    $ID_num = $_SESSION ['ID_num'];
$TB_user_block = 'user'.$ID_num.'_block';
$TB_user_note = $course_code.'_user'.$ID_num.'_note';

$sqlStr = "CREATE TABLE IF NOT EXISTS ".$TB_user_note." (
        ID_note INT                NOT NULL AUTO_INCREMENT, 
	ID_video VARCHAR(50)       NOT NULL,
	content VARCHAR(2000)      NOT NULL,
	sending_date VARCHAR(10)   NOT NULL,
	sending_time VARCHAR(10)   NOT NULL,
        PRIMARY KEY(ID_note))";

$mysqli->query($sqlStr)
      or die("Error: CREATE TABLE failed: ({$mysqli->errno}) {$mysqli->error}");

        $mysqli->real_query("SELECT ID_note, content FROM ".$TB_user_note." WHERE ID_video='".$ID_video."'")
        or die("Error: SELECT failed: ({$mysqli->errno}) {$mysqli->error}");

        $resultSet = $mysqli->store_result()
        or die("Error: Store resultset failed: ({$mysqli->errno}) {$mysqli->error}");
        //make the result set into a table
        //TODO:Now we fetch all comments everytime a new comment occurs,what about only add the new one? More cheap?
        tabulate_resultset($resultSet);
        $resultSet->close();  // Close the result set
        
       
        echo"<textarea type='text' id='newnote' name='newnote' style='width:80%;height:50px;'></textarea>";
        echo"  ";
        echo"<button type='button' onClick='addNote(\"".$ID_video."\", newnote.value)'>New Note</button>";
                
        echo"<br>";
        

//show the result in a table
function tabulate_resultset($resultSet) {
	echo "<table id='noteList' width =100% style='border-collapse: collapse;
			
			table-layout: fixed;'>";
        echo"<div id='TB_note'>";
	// Fetch each row and print table detail row
	foreach ($resultSet as $row) {  // Loop thru all rows in resultset
	//format video time
        //echo"<span id='note_".$row['ID_note']."'>";
        echo "<tr id='note_".$row['ID_note']."'>";
        echo "<td class='note'>";
        echo $row['content'];
        echo "</td></tr>";
 
        //format sending time
        echo"<tr>";
                
        echo"<td align='right' width=50%>";
        echo"<input type='submit' value='Delete' onclick='deleteNote(".$row['ID_note'].")'>";
        echo"</td>";
        
        echo '</tr>';
        //echo"</span>";
    }
    echo"</div>";
    echo '</table>';
}

?>
    
  <script type='text/javascript' charset='utf-8' src='jquery-1.11.1.js'></script>
  <script src="noteBox.js"></script>
    
<SCRIPT language="javascript">
<!--
function addNote(ID_video, content){
    
    var url = "addNote.php?content="+content+"&ID_video="+ID_video;
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

function deleteNote(ID_note){
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
        var url = "deleteNote.php?ID_note=";
        url = url+ID_note;
	xmlhttp.open("GET",url,true);

	xmlhttp.send();
        
        
}

-->
</script>
</body>
</html>