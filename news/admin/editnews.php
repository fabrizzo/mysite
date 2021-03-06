﻿<?php
  ///////////////////////////////////////////////////
  // Блок "Новости"
  // 2003-2006 (C) IT-студия SoftTime (http://www.softtime.ru)
  // Симдянов И.В. (simdyanov@softtime.ru)
  // Голышев С.В. (softtime@softtime.ru)
  ///////////////////////////////////////////////////
  // Выставляем уровень обработки ошибок (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 

  // Устнавливаем соединение с базой данных
  include "../config.php";

  // Проверим - достаточно ли информации для занесения в базу данных
  if(empty($_POST['name'])) links("Отсутствует заголовок");
  if(empty($_POST['body'])) links("Содержание не введено");
  if(empty($_POST['url_text']) && !empty($_POST['url'])) $_POST['url_text'] = $_POST['url'];
  // Проверяем параметр id_news, предотвращая SQL-инъекцию
  if(!preg_match("|^[\d]*$|",$_POST['id_news'])) puterror("Ошибка при обращении к блоку новостей");
  // Определяем, скрыта новоть или нет
  if($_POST['hide'] == "on") $showhide = "show";
  else $showhide = "hide";
  // Добавляем протокол в url, если пользователь забыл это сделать сам
  $_POST['url'] = strtr($_POST['url'], "HTTP", "http");
  if (!empty($_POST['url'])) { 
    if (strtolower((substr($_POST['url'], 0, 7))!="http://") && (strtolower(substr($_POST['url'], 0, 7))!="ftp://")) $url="http://".$_POST['url'];
  } 
  // Проверяем параметр id_news, предотвращая SQL-инъекцию
  if(!preg_match("|^[\d]*$|",$_POST['id_news'])) puterror("Ошибка при обращении к блоку новостей");
  // Проверяем время
  if(!preg_match("|^[\d]+$|",$_POST['date_year'])) puterror("Ошибка при обращении к блоку новостей");
  if(!preg_match("|^[\d]+$|",$_POST['date_month'])) puterror("Ошибка при обращении к блоку новостей");
  if(!preg_match("|^[\d]+$|",$_POST['date_day'])) puterror("Ошибка при обращении к блоку новостей");
  if(!preg_match("|^[\d]+$|",$_POST['date_hour'])) puterror("Ошибка при обращении к блоку новостей");
  if(!preg_match("|^[\d]+$|",$_POST['date_minute'])) puterror("Ошибка при обращении к блоку новостей");

  // Заменяем одинарные кавычки обратными, чтобы избежать конфликта
  // при добавлении информации в таблицу
  if (!get_magic_quotes_gpc())
  {
    $_POST['name'] = mysql_escape_string($_POST['name']);
    $_POST['body'] = mysql_escape_string($_POST['body']);
  }

  // Если у данной новости имеется изображение и оператор
  // запрашивает его удаление или вместо этого изображения 
  // загружает другое - удаляем старое изображение
  if($_POST['chk_delete'] == "on" || $_POST['chk_filename'] == "on")
  {
    $query = "SELECT * FROM news WHERE id_news = $_POST[id_news]";
    $nws = mysql_query($query);
    if(!$nws) links("Ошибка при редактировании блока \"Новости\"");
    $news = mysql_fetch_array($nws);
    if(!empty($news['url_pict']))
    {
      if(file_exists("../".$news['url_pict'])) @unlink("../".$news['url_pict']);
    }
    $path_image = "url_pict = '',";
  }

  // Если требуется загрузить файл - загружаем
  $path = "";
  if($_POST['chk_filename'] == "on")
  {
    if (!empty($_FILES['filename']['tmp_name']))
    {
      // Формируем путь к файлу    
      $path = "files/".date("YmdHis",time());
      // Если оператор пожелал переименовать файл - переименовываем 
      if($_POST['chk_rename'] == "on")
      {
        // Проверяем, чтобы не было прямых и обратных слешей
        $_POST['rename'] = str_replace("\\","",$_POST['rename']);
        $_POST['rename'] = str_replace("/","",$_POST['rename']);
        $_POST['rename'] = stripcslashes($_POST['rename']);
        $path = "files/".substr($_POST['rename'], 0, strrpos($_POST['rename'], ".")); 
      }
      
      // Проверяем, не является ли файл скриптом PHP или Perl, html, если это так преобразуем его в формат .txt
      $extentions = array("#\.php#is",
                          "#\.phtml#is",
                          "#\.php3#is",
                          "#\.html#is",
                          "#\.htm#is",
                          "#\.hta#is",
                          "#\.pl#is",
                          "#\.xml#is",
                          "#\.inc#is",
                          "#\.shtml#is", 
                          "#\.xht#is", 
                          "#\.xhtml#is");
      // Извлекаем из имени файла расширение
      $ext = strrchr($_FILES['filename']['name'], "."); 
      $add = $ext;
      foreach($extentions AS $exten) 
      {
        if(preg_match($exten, $ext)) $add = ".txt"; 
      }
      $path .= $add; 
  
      // Перемещаем файл из временной директории сервера в
      // директорию /files Web-приложения
      if (copy($_FILES['filename']['tmp_name'], "../".$path))
      {
        // Уничтожаем файл во временной директории
        unlink($_FILES['filename']['tmp_name']);
        // Изменяем права доступа к файлу
        chmod("../".$path, 0644);
      }
    }
    else links("Не указан файл для загрузки");
    if(!empty($path)) $path_image = "url_pict = '$path',";
  } 
  // Формируем и выполняем SQL-запрос на обновление новостной позиции
  $query = "UPDATE news SET name='".$_POST['name']."',
                            body='".$_POST['body']."',
                            url='".$_POST['url']."',
                            url_text='".$_POST['url_text']."',
                            putdate = '".$_POST['date_year']."-".$_POST['date_month']."-".$_POST['date_day']." ".sprintf("%02d",$_POST['date_hour']).":".sprintf("%02d",$_POST['date_minute']).":00',
                            $path_image
                            hide = '$showhide'
            WHERE id_news=".$_POST['id_news'];
  if(mysql_query($query)) header("Location: index.php?page=".$_GET['page']);
  else links("Ошибка при редактировании новостей (база данных)");

  // Вспомогательная функция для вывода ссылок возврата
  function links($msg)
  {
    echo "<p>".$msg."</p>";
    echo "<p><a href=# onClick='history.back()'>Вернуться к правке новостей</a></p>";
    echo "<p><a href=index.php>Администрирование новостей</a></p>";
    exit();
  }
?>