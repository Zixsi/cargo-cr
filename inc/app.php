<?php

function check_recaptcha()
{
	try
	{
		$query = array(
			'secret' => '6LdTk5EUAAAAANV5SNZv01K2RzwcxlUeLEScCZqS', 
			'response' => (isset($_POST['g-recaptcha-response'])?$_POST['g-recaptcha-response']:'')
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if($res = curl_exec($ch))
		{
			curl_close($ch);

			$res = json_decode($res, true);
			return (isset($res['success']) && boolval($res['success']) === true)?true:false;
		}
		curl_close($ch);
	}
	catch(Exception $e)
	{
		// empty
	}

	return false;
}

function send_mail_attachment($mailTo, $From, $subject_text, $message, $files = array())
{

	$to = $mailTo;

	$EOL = "\r\n"; // ограничитель строк, некоторые почтовые сервера требуют \n - подобрать опытным путём
	$boundary     = "--".md5(uniqid(time()));  // любая строка, которой не будет ниже в потоке данных. 

	$subject= '=?utf-8?B?' . base64_encode($subject_text) . '?=';

	$headers    = "MIME-Version: 1.0;$EOL";   
	$headers   .= "Content-Type: multipart/mixed; boundary=\"$boundary\"$EOL";  
	$headers   .= "From: $From\nReply-To: $From\n";  

	$multipart  = "--$boundary$EOL";   
	$multipart .= "Content-Type: text/html; charset=utf-8$EOL";   
	$multipart .= "Content-Transfer-Encoding: base64$EOL";   
	$multipart .= $EOL; // раздел между заголовками и телом html-части 
	$multipart .= chunk_split(base64_encode($message));   

	#начало вставки файлов
	if(is_array($files) && count($files) && isset($files["file"]["name"]))
	{
		var_dump($files);
		foreach($files["file"]["name"] as $key => $value){
			$filename = $files["file"]["tmp_name"][$key];
			$file = fopen($filename, "rb");
			$data = fread($file,  filesize( $filename ) );
			fclose($file);
			$NameFile = $files["file"]["name"][$key]; // в этой переменной надо сформировать имя файла (без всякого пути);
			$File = $data;
			$multipart .=  "$EOL--$boundary$EOL";   
			$multipart .= "Content-Type: application/octet-stream; name=\"$NameFile\"$EOL";   
			$multipart .= "Content-Transfer-Encoding: base64$EOL";   
			$multipart .= "Content-Disposition: attachment; filename=\"$NameFile\"$EOL";   
			$multipart .= $EOL; // раздел между заголовками и телом прикрепленного файла 
			$multipart .= chunk_split(base64_encode($File));   
		}
	}

	#>>конец вставки файлов

	$multipart .= "$EOL--$boundary--$EOL";

	return mail($to, $subject, $multipart, $headers);
}