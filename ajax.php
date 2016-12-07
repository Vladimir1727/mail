<?php
include_once('classes.php');
if (isset($_GET['sort'])){//вывод таблицы с сортировкой
mess::load_all($_GET['sort'],$_GET['dir'],$_GET['usid']);
}
if (isset($_GET['show'])){//показ сообщения
mess::show_mes($_GET['show']);
}