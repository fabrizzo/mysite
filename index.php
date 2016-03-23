<html>
<head>
<title>Игромир CS: GO</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name = "author" content = "Dmitriy Perestoronin" />
<meta name = "reply-to" content = "fre-osa@mail.ru" />
<meta name = "site-created" content = "11.02.2016" />
<meta name = "description" content = "На CS:GO маркете можно продать свои игровые вещи из игры Counter-Strike: Global Offensive 
за настоящие деньги и вывести на свои электронные кошельки, а также можно купить игровые вещи в несколько раз дешевле, чем в Steam.">
<meta name = "keywords" content = "кс го магазин, магазин кс го, 
кс го купить вещи, купить вещи кс го, магазин кс го вещей, магазин кс го вещи,
cs go market, оружие кс го магазин, кс го шмот, шмот кс го, кс го маркет, кс го 
продать вещи, продать кс го вещи, csgo market, рандомный магазин кс го, cs go market net, 
вещи кс го купить дешево, купить дешевые вещи кс го, магазин рандомных вещей кс го, рандомные 
вещи кс го магазин, магазин ключей кс го, рандом магазин кс го, магазин аккаунтов кс го, кс го 
магазин дешевый, стим магазин кс го, магазин кейсов кс го, интернет магазин кс го, cs go маркет, 
магазин рандом вещей кс го, рандом вещи кс го купить, магазин ножей кс го, шмот кс го купить, магазин 
скинов кс го, market csgo net, магазин рандомных оружий кс го, кс го онлайн магазин, где купить вещи кс го, 
рандомные вещи кс го купить, рандом шмот кс го, магазин ключей кс го кейсов, ксго маркет, дешевый магазин оружий 
кс го, кс го игровые предметы, покупка игровых вещей, продажа игровых вещей, продать игровой шмот, купить игровой 
шмот, вещи кс го, вещи cs go, продать игровой шмот за реальные деньги"/>
<meta name = "robots" content = "index,follow" /> 
<link href="img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link rel="stylesheet" href="css/main.css">

<script type="text/javascript" src="new_window.js"></script>
</head>
<body background = "img/bg.jpg" bgcolor = "black">
<div class = "regframe">

<form name="forma13" >
<input type="button" value="Зарегистрироваться" onClick="enter()">
<input type="button" value="Войти" onClick="new_reg()">
</form>

</div>
</html>
<?php 
session_start(); 
if(isset($_GET['out'] )) 
{
	session_start ();
	$_SESSION = array ();
    session_destroy();
    header("Location: index.php?logout=1");
}
if(empty($_SESSION['user']) or empty($_SESSION['password']) )
{
echo "<p class = 'wikipedia-text'>Вы вошли на сайт как гость.";  
 }
else
{
  
      echo "<p class ='wikipedia-text'>Здравствуйте, ".$_SESSION['user']." <a href = '?out' > Выйти </a> </p> !"; 
}
?> 

<?php
include_once "class/Engine.php";
$engine = new Engine(); 
include_once "templates/header.php";
if ($engine->getError()) 
{ 
    echo "<div style=\"border:1px solid red;padding:10px;margin: 10px auto; 
        width: 500px;\">" . $engine->getError() . "</div>";
}
echo $engine->getContentPage(); 

include_once "templates/footer.php";
?>