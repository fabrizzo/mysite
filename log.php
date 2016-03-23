<?php 
  session_start();
  echo "<html>
<head>
<link rel='stylesheet' href='css/logstyle.css'>
<link href='img/favicon.ico' rel='shortcut icon' type='image/x-icon' /> 
</head>
<body>
<form method='post' action='enter.php' class='login'>
    <p>                        <label for='login'>Логин:</label><input type='text' name='name' id='login'></p>
    <p>                        <label for='password'>Пароль:</label><input type='password' name='password' id='password'></p>
    <p>                        <label for='email'>E-mail:</label><input type='email' name='email' id='password'></p>
    <p class='login-submit'>   <button type='submit' class='login-button' onClick='window.close(); window.opener.location.reload();'>Войти</button></p>
    <p class='forgot-password'><a href='/'>Забыл пароль?</a></p>
  </form>
</html>"  ;
?>
