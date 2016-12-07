<?php

if (isset($_SESSION['user'])){//сессия запущена
	echo '<form action="index.php?page=1';
	if (isset($_GET['page'])) echo '?page='.$_GET['page'];

	echo '" class="form-inline" method="post">';
	echo '<h4 class="text-center">';
	echo ' Вы вошли как <span id="user_name" class="badge">'.$_SESSION['user'].'</span></h4>';
	echo '<h3 class="text-center">'.$_SESSION['email'].'</h3>';
	echo '<input type="submit" value="выйти" id="ex" name="ex" class="btn btn-default btn-group-justified">';
	echo '</form>';
	if (isset($_POST['ex'])) {//нажата кнопка выхода
		unset($_SESSION['user']);
		echo '<script>window.location.reload();</script>';
	}


}
else//сессия не запущена
{
	//меню
	$txt_nav_reg='<ul class="nav nav-tabs">
  					<li><a href="index.php?page=1">Вход</a></li>
  					<li class="active"><a href="index.php?page=2">Регистрация</a></li>
				</ul>';
	$txt_form_reg='<form action="index.php?page=2" method="post">
			<div class="form-group">
				<input type="text" id="login1" class="form-control" name="loginr" placeholder="логин...">
				<input type="password" id="pass1" class="form-control" name="pass1"  placeholder="пароль...">
				<input type="password" id="pass2" class="form-control"  name="pass2" placeholder="подтверждение пароля...">
				<input type="email" id="email" class="form-control" name="emailr" placeholder="email...">
				<input type="submit" class="btn btn-primary" name="adduser" id="adduser" value="зарегестрировать">
			</div>
		</form>';
	$txt_nav_login='<ul class="nav nav-tabs">
  						<li class="active"><a href="index.php?page=1">Вход</a></li>
  						<li><a href="index.php?page=2">Регистрация</a></li>
					</ul>';
	$txt_form_login='<form action="index.php?page=1" class="form-group" method="post">
						<input type="text" name="login" class="form-control" placeholder="логин" id="elogin">
						<input type="password" name="pass"  class="form-control"  placeholder="пароль" id="epass">
						<input type="submit" id="enter" value="войти" class="btn btn-primary" name="enter">
					</form>';
	if (isset($_GET['page'])){//был выбор страницы
		if ($_GET['page']==2){//выбрана регистрация
			echo $txt_nav_reg;
			echo $txt_form_reg;
			if(isset($_POST['loginr'])) echo "пользователь ".$_POST['loginr']." добавлен";
		}
		else{//закладка входа
			echo $txt_nav_login;
			echo $txt_form_login;
		}
	}
	else{//не было выбора страницы
		echo $txt_nav_login;
		echo $txt_form_login;
	}
	if (isset($_POST['adduser']) && $_POST['pass1']==$_POST['pass2'] ) {//добавление нового пользователя
			$ins=$pdo->query('insert into users(login,pass,email) 
			values("'.$_POST['loginr'].'","'.md5($_POST['pass1']).'","'.$_POST['emailr'].'")');
		}
	if (isset($_POST['enter'])){//входим
		$sel=$pdo->query('select * from users where login="'.$_POST['login'].'"
						and pass="'.md5($_POST['pass']).'"');
		$row=$sel->fetch(PDO::FETCH_LAZY);
		$_SESSION['user']=$row['login'];
		$_SESSION['email']=$row['email'];
		echo '<script>window.location.assign("returner.php?back="+window.location.href);</script>';
	}
}



?>