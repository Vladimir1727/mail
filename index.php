<?php
session_start();
include_once("classes.php");
tools::setparam('localhost','root','123456','mail');
$pdo=tools::connect();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Diamandi mailer</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/jquery-ui.min.css">
	<link rel="stylesheet/less" href="css/style.less">

</head>
<body>
<div class="row">
	<aside class="col-md-1">
		<a href="#">Входящие</a>
		<a href="#">Отправленные</a>
	</aside>
	<main class="col-md-8">
		<?php include_once("mailbox.php"); ?>
	</main>
	<aside class="col-md-3">
		<?php include_once("regenter.php"); ?>
	</aside>
</div>
<?php

?>
<script src="js/jquery-2.0.0.min.js"></script>
<!-- <script src="js/jquery-ui.min.js"></script> -->
<script src="js/bootstrap.min.js"></script>
<script src="js/less.min.js"></script>
<script src="js/ajax.js"></script>
<script src="js/script.js"></script>
</body>
</html>