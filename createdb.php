<?php 
include_once("classes.php");
tools::setparam('localhost','root','123456','mail');
$pdo=tools::connect();
$users='create table users(
	id int not null auto_increment primary key,
	login varchar(32) not null unique,
	email varchar(32) not null unique,
	pass varchar(128) not null
	)default charset=utf8';
$inbox='create table inbox(
	id int not null auto_increment primary key,
	mfrom varchar(32) not null,
	mtheme varchar(32),
	mtxt varchar(1024),
	mdate int not null,
	user int,
	foreign key (user) references users(id)
	on update cascade
	)default charset=utf8';
$outbox='create table outbox(
	id int not null auto_increment primary key,
	mto varchar(32) not null,
	mtxt varchar(1024),
	mtheme varchar(32),
	mdate int not null,
	user int,
	foreign key (user) references users(id)
	on update cascade
	)default charset=utf8';
$pdo->query($users);
$pdo->query($inbox);
$pdo->query($outbox);
 ?>