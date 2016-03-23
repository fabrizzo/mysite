 
<?php
    $dblocation = "localhost";  
    $dbname = "test";  
    $dbuser = "root";  
    $dbpasswd = "";  
   $dbcnx = @mysql_connect($dblocation,$dbuser,$dbpasswd);  
  if (!$dbcnx) {  
      echo( "<P>В настоящий момент сервер базы данных не  
                          доступен, поэтому корректное отображение  
                          страницы невозможно.</P>" );  
      exit();  
    }  
    if (! @mysql_select_db($dbname,$dbcnx) ) {  
      echo( "<P>В настоящий момент база данных не доступна,  
                          поэтому корректное отображение страницы  
                          невозможно.</P>" );  
      exit();  
    }  

     session_start(); //начало сессии для записи
	    function Fix($str) { //очистка полей
	        $str = @trim($str);
	        if(get_magic_quotes_gpc()) {
	            $str = stripslashes($str);
	        }
	        return mysql_real_escape_string($str);
	    }
	    $errmsg = array(); //массив для хранения ошибок 
	    $errflag = false; //флаг ошибки
	    $UID = "12";//уникальный ID
	    $user = Fix($_POST['name']);//имя пользователя
	    $email = $_POST['email']; //Email
	    $password = Fix($_POST['password']);//пароль
	 
	    //проверка, свободно ли имя пользователя
	    if($user != '') {
	        $qry = "SELECT * FROM `users` WHERE `Username` = '$user'"; //запрос к MySQL
	        $result = mysql_query($qry);
	        if($result) {
	            if(mysql_num_rows($result) > 0) {//если имя уже используется
	                $errmsg[] = 'Username already in use'; //сообщение об ошибке
	                $errflag = true; //поднимает флаг в случае ошибки
	            }
	            mysql_free_result($result);
	        }
	    }
	 
	    //если данные не прошли валидацию, направляет обратно к форме регистрации
	    if($errflag) {
	        $_SESSION['ERRMSG'] = $errmsg; //сообщение об ошибке
	        session_write_close(); //закрытие сессии
			echo "ошибка!!";
	        exit();
	    }
	 
	    //добавление данных в базу
	    $qry = "INSERT INTO `users`(`UID`, `Username`, `Email`, `Password`) VALUES('$UID','$user','$email','" . md5($password) . "')";
	    $result = mysql_query($qry);
	     
	    //проверка, был ли успешным запрос на добавление
	    if($result) {
	        echo "Благодарим Вас за регистрацию, " .$user . ". Пожалуйста, входите <a href=\"index.php\">сюда</a>";
	        exit();
	    } else {
	        die("Ошибка, обратитесь позже");
	    }
	
	?>
