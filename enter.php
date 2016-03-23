<?php 
    $dblocation = "localhost";  
    $dbname = "test";  
    $dbuser = "root";  
    $dbpasswd = "";  
    $dbcnx = @mysql_connect($dblocation,$dbuser,$dbpasswd);  
    if (!$dbcnx) 
	{  
      echo( "<P>В настоящий момент сервер базы данных не  
                          доступен, поэтому корректное отображение  
                          страницы невозможно.</P>" );  
      exit();  
    }  
    if (! @mysql_select_db($dbname,$dbcnx) ) 
	{  
      echo( "<P>В настоящий момент база данных не доступна,  
                          поэтому корректное отображение страницы  
                          невозможно.</P>" );  
      exit();  
    }  
    // Формируем и выполняем SQL-запрос для посетителя с  
    // именем $_POST['name']  
    $query = "SELECT password FROM users WHERE USERNAME='".$_POST['name']."'";  
    $nme = mysql_query($query);  
    if(!$nme)  
    {  
      echo mysql_error(); 
      echo "Ошибка выполнения запроса";  
      exit();  
    }  
    // Если запрос вернул результат - производим дальнейшую обработку  
    if(mysql_num_rows($nme) > 0)  
    {  
       // Получаем пароль  
       $password = mysql_result($nme, 0);  
       // Сравниваем пароль из базы данных и введённый посетителем  
       if ($_POST['password'] == $password) 
       { 
         // Идентификация прошла успешно - осуществляем 
         // "вход" посетителя. Для того, чтобы в течении текущей 
         // сесси посетитель не вводил своё имя пароль повторно -  
         // передаём их через сессию 
         if(session_start()) 
         { 
             $_SESSION['user'] = $_POST['name']; 
             $_SESSION['password'] = $_POST['password']; 
		   } 
       } 
       else  
       {  
         echo "Ошибка идентификации: неправильный пароль";  
         exit();  
       }  
    }  
    // Если в результате запроса не получено ни одной  
    // строки - посетитель с таким именем не зарегистрирован  
    else  
    {  
      echo "Ошибка идентификации: посетитель не зарегистрирован";  
      exit();  
    }  
?>