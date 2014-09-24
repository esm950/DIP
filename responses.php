 
<?php
session_start();
//connect to database
$link = mysqli_connect("localhost", "wampuser", "xxxx", "danmaku");
ob_start();

$ID_video = 'im3080';
$TB_responses = $ID_video.'_responses';
$ID_num = $_SESSION ['ID_num'];
  
	$sqlStr = "CREATE TABLE IF NOT EXISTS ".$TB_responses." (
	ID_num INT UNSIGNED        NOT NULL,
	choice_satisfied INT       NOT NULL,
	choice_neutral INT         NOT NULL,
	choice_unsatisfied INT       NOT NULL )";
	
$result=mysqli_query($link, $sqlStr);

$result2 = mysqli_query($link,"UPDATE" + $TB_responses + "SET NumberOfVotes = NumberOfVotes + 1 WHERE choice = '" + choice + "'");
while($row = mysqli_fetch_array($result2)) {        //to print the ID_num out
	//echo $row['ID_num'];
	$ID_num = $row['ID_num'];   //define $ID_num
}
?>



      <script type="text/javascript">
	  
      var data =  ['Choice', 'Number of responses'],
	  
		['satisfied', <%  String sqlSatisfied = "UPDATE $TB_responses SET NumberOfVotes = NumberOfVotes + 1 WHERE choice = 'satisfied'"; 									   
				stmt.executeUpdate(sqlSatisfied); %>
		]
		  ['neutral', <% String sqlNeutral = "UPDATE $TB_responses SET NumberOfVotes = NumberOfVotes + 1 WHERE choice = 'neutral'"; 
			stmt.executeUpdate(sqlNeutral);%>
				]
		   ['unsatisfied', <% String sqlNotSatisfied = "UPDATE $TB_responses SET NumberOfVotes = NumberOfVotes + 1 WHERE choice = 'unsatisfied'"; 
				stmt.executeUpdate(sqlNotSatisfied); %>
			]
			
		</script>

	