<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<?php
include_once("functions.php");
$connect = fsockopen("tls://pop.mail.ru", 995,$errno, $errstr, 10);
print fgets($connect,1024);
fputs($connect,"USER dvn16\r\n");
print fgets($connect,1024);
fputs($connect,"PASS 12-ty-89\r\n");
print fgets($connect,1024);
fputs($connect,"STAT\r\n");
print fgets($connect,1024);
fputs($connect,"RETR 4\r\n");
echo "<br>";

    $data="";
    while (!feof($connect)) {
        $buffer = chop(fgets($connect,1024));
        $data .= "$buffer\r\n";
        if(trim($buffer) == ".") break;
    }
    echo $data;


fputs($pop_conn,"QUIT\r\n");
?>

</body>
</html>
