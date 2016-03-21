<?php
	include_once 'setting.php';
	
	session_start();
	$CONNECT = mysqli_connect(HOST, USER, PASSWD, DB);

	if ($_SERVER['REQUEST_URI'] == '/'){
		
		$page = 'index';
		$module = 'index';
	
	} else {
	
		$URL_Path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		$URL_Parts = explode('/', trim($URL_Path, ' /'));
		$page = array_shift($URL_Parts);
		$module = array_shift($URL_Parts);
		
		if(!empty($module)){
			
			$param = array();
			for ($i = 0; $i < count($URL_Parts); $i++){
				$param[$URL_Parts[$i]] = $URL_Parts[++$i];
			}
			
		}
	
	}
	
	if($page == 'index' && $module == 'index') include ('page/index.php');
	else if ($page == 'registration') include('page/registration.php');
	else if ($page == 'login') include('page/login.php');
	else if ($page == 'account') include('action/account.php');
	else if ($page == 'captcha') include('action/captcha.php');
	else if ($page == 'testmail') include('page/testmail.php');
    else if ($page == 'labs') include('page/labs.php');
    else if ($page == 'lr17')   include('page/lr17.php');
    else if ($page == 'lr17parser') include('action/lr17parser.php');
    else if ($page == 'lr18')   include('page/lr18.php');
    else if ($page == 'lr18parser') include('action/lr18parser.php');

	function Head($title){
		
		echo '<!DOCTYPE html><html><head><meta charset="utf-8" /><title>'.$title.'</title><meta name="keywords" content="" /><meta name="description" content="" /><link href="resource/style.css" rel="stylesheet"></head>';
		
	}
	
	function Menu(){
		
		echo '<div class="MenuHead"><a href="/"><div class="menu">Главная</div></a>
        <a href="/registration"><div class="menu">Регистрация</div></a>
        <a href="/login"><div class="menu">Вход</div></a><a href="/labs"><div class="menu">Лабораторні роботи</div></a></div>';
		
	}
	
	function Footer(){
		
		echo '<footer class="footer">©Copyright DKtech|ICCT Все права защищены. 2015-2016</footer>';
		
	}
	
	function FormChars($str){
		return nl2br(htmlspecialchars(trim($str), ENT_QUOTES), false);
	}
	
	function GenPass($passwd, $login){
		return md5('ICCT'.md5('0936'.$passwd.'6390').md5('1488'.$login.'8841'));
	}
	
	function MessageSend($value1, $value2, $redirect = ''){
		
		if ($value1 == 'err'){
			$value1 = 'Ошибка';
			$_SESSION['message'] = '<div class="MessageErr"><b>'.$value1.$value2
				.'</b></div>';
		} else if ($value1 == 'pod'){
			$value1 = 'Подсказка';
			$_SESSION['message'] = '<div class="MessagePod"><b>'.$value1.$value2
				.'</b></div>';
		} else if ($value1 == 'inf'){
			$value1 = 'Информация';
			$_SESSION['message'] = '<div class="MessageInf"><b>'.$value1.$value2
				.'</b></div>';
		}
		
		if ($redirect) $_SERVER['HTTP_REFERER'] = $redirect;
		exit(header('Location:'.$_SERVER['HTTP_REFERER']));
	}
	
	function MessageShow(){
		
		if ($_SESSION['message']) echo $_SESSION['message'];
		$_SESSION['message']=array();
		
	}
	
	
	//
	//SMTP MAIL FUNCTIONS START
	//
	
	function smtpmail($mail_to, $subject, $message, $headers='') {
	global $config;
	$SEND =	"Date: ".date("D, d M Y H:i:s") . " UT\r\n";
	$SEND .=	'Subject: =?'.$config['smtp_charset'].'?B?'.base64_encode($subject)."=?=\r\n";
	if ($headers) $SEND .= $headers."\r\n\r\n";
	else
	{
        
			$SEND .= "Reply-To: ".$config['smtp_username']."\r\n";
			$SEND .= "MIME-Version: 1.0\r\n";
			$SEND .= "Content-Type: text/plain; charset=\"".$config['smtp_charset']."\"\r\n";
			$SEND .= "Content-Transfer-Encoding: 8bit\r\n";
			$SEND .= "From: \"".$config['smtp_from']."\" <".$config['smtp_username'].">\r\n";
			$SEND .= "To: $mail_to <$mail_to>\r\n";
			$SEND .= "X-Priority: 3\r\n\r\n";
        
	}
	$SEND .=  $message."\r\n";
	 if( !$socket = fsockopen($config['smtp_host'], $config['smtp_port'], $errno, $errstr, 30) ) {
		if ($config['smtp_debug']) echo $errno."<br>".$errstr;
		return false;
	 }
 
	if (!server_parse($socket, "220", __LINE__)) return false;
 
	fputs($socket, "EHLO " . $config['smtp_host'] . "\r\n");
	if (!server_parse($socket, "250", __LINE__)) {
		if ($config['smtp_debug']) echo '<p>Не могу отправить EHLO</p>';
		fclose($socket);
		return false;
	}
	fputs($socket, "AUTH LOGIN\r\n");
	if (!server_parse($socket, "334", __LINE__)) {
		if ($config['smtp_debug']) echo '<p>Не могу найти ответ на запрос авторизаци.</p>';
		fclose($socket);
		return false;
	}
	fputs($socket, base64_encode($config['smtp_username']) . "\r\n");
	if (!server_parse($socket, "334", __LINE__)) {
		if ($config['smtp_debug']) echo '<p>Логин авторизации не был принят сервером!</p>';
		fclose($socket);
		return false;
	}
	fputs($socket, base64_encode($config['smtp_password']) . "\r\n");
	if (!server_parse($socket, "235", __LINE__)) {
		if ($config['smtp_debug']) echo '<p>Пароль не был принят сервером как верный! Ошибка авторизации!</p>';
		fclose($socket);
		return false;
	}
	fputs($socket, "MAIL FROM: <".$config['smtp_username'].">\r\n");
	if (!server_parse($socket, "250", __LINE__)) {
		if ($config['smtp_debug']) echo '<p>Не могу отправить комманду MAIL FROM: </p>';
		fclose($socket);
		return false;
	}
	fputs($socket, "RCPT TO: <" . $mail_to . ">\r\n");
 
	if (!server_parse($socket, "250", __LINE__)) {
		if ($config['smtp_debug']) echo '<p>Не могу отправить комманду RCPT TO: </p>';
		fclose($socket);
		return false;
	}
	fputs($socket, "DATA\r\n");
 
	if (!server_parse($socket, "354", __LINE__)) {
		if ($config['smtp_debug']) echo '<p>Не могу отправить комманду DATA</p>';
		fclose($socket);
		return false;
	}
	fputs($socket, $SEND."\r\n.\r\n");
 
	if (!server_parse($socket, "250", __LINE__)) {
		if ($config['smtp_debug']) echo '<p>Не смог отправить тело письма. Письмо не было отправленно!</p>';
		fclose($socket);
		return false;
	}
	fputs($socket, "QUIT\r\n");
	fclose($socket);
	return TRUE;
}
 
function server_parse($socket, $response, $line = __LINE__) {
	global $config;
	while (@substr($server_response, 3, 1) != ' ') {
		if (!($server_response = fgets($socket, 256))) {
			if ($config['smtp_debug']) echo "<p>Проблемы с отправкой почты!</p>$response<br>$line<br>";
 			return false;
 		}
	}
	if (!(substr($server_response, 0, 3) == $response)) {
		if ($config['smtp_debug']) echo "<p>Проблемы с отправкой почты!</p>$response<br>$line<br>";
		return false;
	}
	return true;
}

//
//SMTP MAIL FUNCTIONS END
//
	
?>
   