<?php
if (!isset($_SESSION['user'])){
	"НЕОБХОДИМО ВОЙТИ";
}
else{
	echo '<form action="index.php" class="form-group" method="post">';
	echo '<table class="table"><thead><tr><th><input type="checkbox" name="itemid[]" value="0" id="d_all"></th>
		<th class="isort">кому <span></span><p>mto</p></th>
		<th class="isort">тема <span></span><p>mtheme</p></th>
		<th class="isort">дата <span></span><p>mdate</p></th></tr></thead></table>
	<table class="table" id="t1"><tbody id="mailtable">';
	echo '</tbody></table>';
	echo '<input type="submit" name="del" value="удалить" class="btn btn-danger" id="del">';
	echo '<input type="submit" name="new" value="новое письмо" class="btn btn-success" id="open_new">';
	echo '<div id="newmess">';
	echo '<input type="text" name="mto" placeholder="кому..." class="form-control">';
	echo '<input type="text" name="mtheme" placeholder="тема..." class="form-control">';
	echo '<textarea name="mtxt" placeholder="текcт..." class="form-control"></textarea>';
	echo '<input type="submit" name="send" value="отправить" class="btn btn-success">';
	echo '<input type="submit" name="chancel" value="отменить" class="btn btn-warning">';
	echo '</div>';
	echo '</form>';
	echo '<div class="jumbotron" id="view_mess"></div>';
	if(isset($_POST['send'])){//нажата кнопка отправить
		$new_mess=new mess('',$_POST['mto'],$_POST['mtxt'],$_POST['mtheme']);
		$new_mess->send();
		echo '<script>window.location.assign("returner.php?back="+window.location.href);</script>';
	}
	if (isset($_POST['del'])){//нажата кнопка удалить
		$itemid=$_POST['itemid'];
		if (count($itemid>0)){//есть выбранные значки
			$str_del='delete from outbox where id in(';
			for ($i=0; $i < count($itemid); $i++) { 
				if ($i>1) $str_del.=',';
				if ($itemid[$i]>0) $str_del.=$itemid[$i];
			}
			$str_del.=')';
			$del=$pdo->query($str_del);
		}
	}
}