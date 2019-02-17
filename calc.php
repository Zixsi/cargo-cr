<meta http-equiv='refresh' content='3; url=/about.html'>
<meta charset="UTF-8" />
<?php
include('inc/app.php');

try
{
	$_POST = array(
		'value' => ((isset($_POST['value']) && !empty($_POST['value']))?$_POST['value']:''),
		'name' => ((isset($_POST['name']) && !empty($_POST['name']))?$_POST['name']:''),
		'from_to' => ((isset($_POST['from_to']) && !empty($_POST['from_to']))?$_POST['from_to']:''),
		'user_name' => ((isset($_POST['user_name']) && !empty($_POST['user_name']))?$_POST['user_name']:''),
		'phone' => ((isset($_POST['phone']) && !empty($_POST['phone']))?$_POST['phone']:''),
		'email' => ((isset($_POST['email']) && !empty($_POST['email']))?$_POST['email']:''),
		'message' => ((isset($_POST['message']) && !empty($_POST['message']))?$_POST['message']:''),
		'g-recaptcha-response' => ((isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))?$_POST['g-recaptcha-response']:'')
	);


	if(empty($_POST['value']) || empty($_POST['name']) || empty($_POST['email']))
	{
		throw new Exception('Вы заполнили не все обязательные поля, вернитесь назад и заполните необходимые поля!', 1);
	}

	if(!check_recaptcha())
	{
		throw new Exception('Защита от ботов не пройдена!', 1);
	}

	$address = 'info-cr-group@yandex.ru';
	$sub = 'Рассчитать стоимость';

	$mes = "Вес(кг)/Объём(м3): ".$_POST['value']."\n
	Наименование товара: ".$_POST['name']."\n
	Откуда/Куда: ".$_POST['from_to']."\n
	Имя: ".$_POST['user_name']."\n
	Контактный телефон: ".$_POST['phone']."\n
	Электронная почта: ".$_POST['email']."\n
	Сообщение: ".$_POST['message']."\n";

	//if(mail($address, $sub, $mes, "Content-type:text/plain; charset = UTF-8\r\nFrom:".$_POST['email']))
	if(send_mail_attachment($address, $_POST['email'], $sub, $mes, $_FILES))
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