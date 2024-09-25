<?php
error_reporting(-1);
ini_set('display_errors',1);
header('Content-Type: text/html; charset=utf-8');
$page = (isset($_GET['page']) ? $_GET['page'] : 'main');

$link = mysqli_connect("localhost", "root", "");

if ($link == false){
    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
}
else {
    print("Соединение установлено успешно");
}
?>
<html>
	<link href="/normalize.css" rel="stylesheet">
	<link href="/style.css" rel="stylesheet">
<head>
<title>ID CARD</title>
</head>
<body>
<header>
	<button name="insert" value="Insert">
	<img style="vertical-align: middle; width: 24px;" src="/img/button.png" alt="" />
	Загрузка
	</button>
	<button name="upload" value="Upload">
	<img style="vertical-align: middle; width: 24px;" src="/img/button.png" alt="" />
	Выгрузка
	</button>	
</header>
<div>

<div>

<?php include basename($page).'.php'; ?>

<footer>
    Сайт сделан сегодня и все права принадлежат его создателю :)
</footer>
</body>
</html>