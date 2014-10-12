<!DOCTYPE html>
<html>

<head>

  <meta charset="UTF-8">

  <title>NTULearn</title>

  <link rel='stylesheet' href='http://codepen.io/assets/libs/fullpage/jquery-ui.css'>

    <link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />

</head>

<body>

  <div class="login-card">
    <h1>Log-in</h1><br>
	  <p style="color: #F80000 ;  text-align: center;">Wrong Username/Password</p>
  <form name="form1" method="post" action="checkLogin.php">
    <input type="radio" name="usertype" value="student" checked/> Student
    <input type="radio" name="usertype" value="prof" /> Professor    
    <input type="text" name="user_ID" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <input type="submit" name="login" class="login login-submit" value="login">
  </form>

  <div class="login-help">
    <a href="#">Register</a> • <a href="#">Forgot Password</a>
  </div>
</div>

<!-- <div id="error"><img src="https://dl.dropboxusercontent.com/u/23299152/Delete-icon.png" /> Your caps-lock is on.</div> -->

  <script src='http://codepen.io/assets/libs/fullpage/jquery_and_jqueryui.js'></script>

</body>

</html>