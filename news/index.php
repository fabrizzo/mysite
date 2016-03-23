<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Новости</title>
<link rel="StyleSheet" type="text/css" href="news.css">
</head>
<?php
  Error_Reporting(E_ALL & ~E_NOTICE); 
  require_once("config.php");
?>
<p class="zagblock">НОВОСТИ</p>
<?php

  $tot = mysql_query("SELECT count(*) FROM news WHERE hide='show' AND putdate <= NOW()");
  if ($tot)
  {
    $total = mysql_result($tot,0);
    if($pnumber < $total) echo "<p class='linkblock'><a href=news.php class='linkblock'>Все новости</a>";
  }
  else puterror("Ошибка при обращении к блоку новостей");
  $query = "SELECT * FROM news 
            WHERE hide='show' AND putdate <= NOW()
            ORDER BY putdate DESC
            LIMIT $pnumber";
  $new = mysql_query($query);
  if(!$new) puterror("Ошибка при обращении к блоку новостей");
  if(mysql_num_rows($new) > 0)
  {
    while($news = mysql_fetch_array($new))
    {
      echo "<p class=newsblockzag><b>".$news['name']."</b></p>";
      $pos = strpos(substr($news['body'],$numchar), " ");
      if(strlen($news['body'])>$numchar) $srttmpend = "...";
      else $strtmpend = "";
      echo "<p class=newsblock>".substr($news['body'], 0, $numchar+$pos).$srttmpend;
      echo "<br><a class=anewsblock href=news.php?id_news=".$news['id_news'].">подробнее</a></p>";
    }
  }
?>
