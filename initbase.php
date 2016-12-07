<?php 
include_once('classes.php');
Tools::SetParam('localhost','root','123456','mail');
$pdo=Tools::connect();
//пользователи
$ins=$pdo->query('insert into users(login,email,pass) values ("vova","vova@mail.ru","'.md5('123').'")');
$ins=$pdo->query('insert into users(login,email,pass) values ("max","max@ukr.net","'.md5('321').'")');
//почта
$ins=$pdo->query('insert into outbox(mto,mtxt,mtheme,mdate,user) values
	("max@ukr.net","текст сообщения 1","тема сообщения 1",'.time().',1),
	("masha@ukr.net","текст сообщения 2","тема сообщения 2",'.time().',1),
	("mira@ukr.net","текст сообщения 3","тема сообщения 3",'.time().',1),
	("lilya@ukr.net","текст сообщения 4","тема сообщения 4",'.time().',1),
	("vera@ukr.net","текст сообщения 5","тема сообщения 5",'.time().',1),
	("vova@ukr.net","текст сообщения 6","тема сообщения 6",'.time().',2),
	("vanya@ukr.net","текст сообщения 7","тема сообщения 7",'.time().',2),
	("edik@ukr.net","текст сообщения 8","тема сообщения 8",'.time().',2),
	("yura@ukr.net","текст сообщения 9","тема сообщения 9",'.time().',2),
	("job@ukr.net","текст сообщения 10","тема сообщения 10",'.time().',2)
	');
 