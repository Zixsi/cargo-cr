<meta http-equiv='refresh' content='3; url=/'>
<meta charset="UTF-8" />
<?php
include('inc/app.php');

try
{
	$_POST = array(
		'name' => ((isset($_POST['name']) && !empty($_POST['name']))?$_POST['name']:''),
		'phone' => ((isset($_POST['phone']) && !empty($_POST['phone']))?$_POST['phone']:''),
		'g-recaptcha-response' => ((isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))?$_POST['g-recaptcha-response']:'')
	);

	if(empty($_POST['name']) || empty($_POST['phone']))
	{
		throw new Exception('Вы заполнили не все обязательные поля, вернитесь назад и заполните необходимые поля!', 1);
	}

	if(!check_recaptcha())
	{
		throw new Exception('Защита от ботов не пройдена!', 1);
	}

	//$address = 'info-cr-group@yandex.ru';
	$address = "zixxsi@gmail.com";
	$sub = 'Обратный звонок';
	$mes = "Имя: ".$_POST['name']."\n Контактный телефон: ".$_POST['phone']."\n";

	if(mail($address, $sub, $mes, "Content-type:text/plain; charset = UTF-8\r\nFrom:".$address))
	{
		throw new Exception('Сообщение отправлено успешно, через 3 секунды Вы будете направлены на главную страницу', 1);
	}
	else
	{
		throw new Exception('Ошибка, сообщение не отправлено!', 1);
	}
}
catch(Exception $e)
{
	echo $e->getMessage();
}
die();