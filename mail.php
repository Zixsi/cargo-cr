<meta http-equiv='refresh' content='3; url=/contact.html'>
<meta charset="UTF-8" />
<?php
include('inc/app.php');

if (isset($_POST['name'])) {$name = $_POST['name']; if ($name == '') {unset($name);}}
if (isset($_POST['email'])) {$email = $_POST['email']; if ($email == '') {unset($email);}}
if (isset($_POST['sub'])) {$sub = $_POST['sub']; if ($sub == '') {unset($sub);}}
if (isset($_POST['body'])) {$body = $_POST['body']; if ($body == '') {unset($body);}}
 
if(isset($name) && isset($email) && isset($sub) && isset($body))
{
	if(!check_recaptcha())
	{
		echo "Защита от ботов не пройдена!";
		die();
	}

	$address = "info-cr-group@yandex.ru";
	$mes = "Имя: $name \nE-mail: $email \nТема: $sub \nТекст: $body";
	$send = mail ($address,$sub,$mes,"Content-type:text/plain; charset = UTF-8\r\nFrom:$email");
	if($send == 'true')
	{
		echo "Сообщение отправлено успешно, через 3 секунды Вы будете направлены на главную страницу";
	}
	else
	{
		echo "Ошибка, сообщение не отправлено!";
	}
}
else
{
	echo "Вы заполнили не все поля, вернитесь назад и заполните необходимые поля!";
}
?>