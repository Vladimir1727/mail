<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>returner</title>
</head>
<body>
	<?php 
	if (isset($_GET['back'])){
	echo '<script>window.location.assign("'.$_GET['back'].'")</script>';
	}
 ?>
</body>
</html>

