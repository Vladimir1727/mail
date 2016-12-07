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
fputs($connect,"RETR 3\r\n");
echo "<br>";

$text.= get_data($connect);
// в переменной $text сейчас все письмо вместе с заголовками.

// разделяем письмо на заголовки и тело, еще раз советую почитать Почтовый стандарт "MIME" (RFC1521) (http://webi.ru/webi_files/26_15_f.html)
$struct=fetch_structure($text);

// теперь раскладываем заголовки по полочкам
// и получаем удобный ассоциативный массив с удобным обращением к любому заголовку.
// например $mass_header['subject'] == "=?windows-1251?B?7/Do4uXy?="
$mass_header=decode_header($struct['header']);

// чтобы воспользоваться заголовком, который может содержать не латинские символы
// например тема письма, нужно прогнать заголовок через функцию декодирования.
$mass_header["subject"] = decode_mime_string($mass_header["subject"]);
// теперь можно использовать тему, теперь тут обычный читаемый текст

// Сейчас разберем заголовок Content-Type, это тип содержимого. Определим, что в письме, только текст или еще и файлы.
// Content-Type: text/plain; charset=Windows-1251 это обычное текстовое письмо
// Content-Type: multipart/mixed; boundary="_----------=_118224799143839" это составное письмо из нескольких частей, с вложенными файлами.
$type = $ctype = $mass_header['content-type'];
$ctype = preg_split("/;/",$ctype);
$types = preg_split("//",$ctype[0]);
$maintype = trim(strtolower($types[0])); // text или multipart
$subtype = trim(strtolower($types[1])); // а это подтип(plain, html, mixed)

// сейчас проверяем тип содержимого письма
// Если это обычное текстовое содержимое (текст или html) без вложений
if($maintype=="text")
{
    // $subtype можно использовать эту переменную для определения текстовое письмо или html
    // эту проверку можете поставить сами
    // Передаем тело письма в функцию, на перекодирование. И так же посылаем заголовки, информирующие о том, как было закодировано письмо.
    $body = compile_body($struct['body'],$mass_header["content-transfer-encoding"],$mass_header["content-type"]);
    print $body;
}

// теперь рассмотрим вариант, если письмо имеет несколько разных частей.
// тут рассматриваю подтипы signed,mixed,related, но есть еще подтип alternative, который служит для альтернативного отображения письма.
// например, письмо в html и к нему же можно добавить альтернативное текстовое содержание.
// подробнее читайте про этот подтип в Почтовом стандарте "MIME" (RFC1521) (http://webi.ru/webi_files/26_15_f.html)
elseif($maintype=="multipart" and ereg($subtype,"signed,mixed,related"))
{
    // получаем метку-разделитель частей письма
    $boundary=get_boundary($mass_header['content-type']);

    // на основе этого разделителя разбиваем письмо на части
    $part = split_parts($boundary,$struct['body']);

    // теперь обрабатываем каждую часть письма
    for($i=0;$i<count($part);$i++) {

        // разбиваем текущую часть на тело и заголовки
        $email = fetch_structure($part[$i]);
        $header = $email["header"];
        $body = $email["body"];

        // разбираем заголовки на массив
        $headers = decode_header($header);
        $ctype = $headers["content-type"];
        $cid = $headers["content-id"];
        $Actype = split(";",$headers["content-type"]);
        $types = split("/",$Actype[0]);
        $rctype = strtolower($Actype[0]);

        // теперь проверяем, является ли эта часть прикрепленным файлом
        $is_download = (ereg("name=",$headers["content-disposition"].$headers["content-type"]) || $headers["content-id"] != "" || $rctype == "message/rfc822");

        // теперь читаем и выводим само тело части, если это обычный текст
        if($rctype == "text/plain" && !$is_download) {
            $body = compile_body($body,$headers["content-transfer-encoding"],$headers["content-type"]);
            print $body;
        }

        // если это html
        elseif($rctype == "text/html" && !$is_download) {
            $body = compile_body($body,$headers["content-transfer-encoding"],$headers["content-type"]);
            print $body;
        }

        // и наконец, если это файл
        elseif($is_download) {

            // Имя файла можно выдернуть из заголовков Content-Type или Content-Disposition
            $cdisp = $headers["content-disposition"];
            $ctype = $headers["content-type"];
            $ctype2 = explode(";",$ctype);
            $ctype2 = $ctype2[0];
            $Atype = split("/\//",$ctype);
            $Acdisp = split(";",$cdisp);
            $fname = $Acdisp[1];
            if(ereg("filename=(.*)",$fname,$regs))
            $filename = $regs[1];
            if($filename == "" && ereg("name=(.*)",$ctype,$regs))
            $filename = $regs[1];
            $filename = ereg_replace("\"(.*)\"","\1",$filename);

            // как получили имя файла, теперь его нужно декодировать
            $filename = trim(decode_mime_string($filename));

            // теперь читаем файл в переменную.
            $body = compile_body($body,$headers["content-transfer-encoding"],$ctype);
            // содержимое файла теперь в переменной $body и сейчас можно отдать содержимое файла в браузер или например сохранить на диске
            $ft=fopen($filename,"wb");
            fwrite($ft,$body);
            fclose($ft);
        }
    }
}



?>


</body>
</html>

