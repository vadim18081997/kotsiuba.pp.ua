<?php
	$config['smtp_username'] = 'admin@kotsiuba.pp.ua';  //Смените на имя своего почтового ящика.
	$config['smtp_port']	 = '25'; // Порт работы. Не меняйте, если не уверены.
	$config['smtp_host']	 = 'localhost';  //сервер для отправки почты
	$config['smtp_password'] = 'GRUNDIG1997';  //Измените пароль
	$config['smtp_debug']	= true;  //Если Вы хотите видеть сообщения ошибок, укажите true вместо false
	$config['smtp_charset']  = 'UTF-8';	//кодировка сообщений. (или UTF-8, итд)
	$config['smtp_from']	 = 'DKtech|ICCT'; //Ваше имя - или имя Вашего сайта. Будет показывать при прочтении в поле "От кого"
	
	if($module == "registration" && $_REQUEST['enter']){
		
		$_REQUEST['login'] = FormChars($_REQUEST['login']);
		$_REQUEST['email'] = FormChars($_REQUEST['email']);
		$_REQUEST['password'] = GenPass(FormChars($_REQUEST['password']), $_REQUEST['login']);
		$_REQUEST['name'] = FormChars($_REQUEST['name']);
		$_REQUEST['country'] = FormChars($_REQUEST['country']);
		//$_REQUEST['avatar'] = FormChars($_REQUEST['avatar']);
		//$_REQUEST['avatar'] = 0;
		$_REQUEST['captcha'] = FormChars($_REQUEST['captcha']);
		
		
		if(!$_REQUEST['login'] || !$_REQUEST['email'] || !$_REQUEST['password'] || !$_REQUEST['name'] || $_REQUEST['country'] > 6 || !$_REQUEST['captcha'])
			MessageSend('err',", невозможно обработать форму.");
			
		if($_SESSION['captcha'] != md5($_REQUEST['captcha'])) MessageSend('err',", капча введена неверно.");
			
		$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `login` FROM `users` WHERE `login` = '$_REQUEST[login]'"));
		if($row['login']) exit('Логин <b>'.$_REQUEST['login'].'</b> уже используеться.');
		$row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `email` FROM `users` WHERE `email` = '$_REQUEST[email]'"));
		if($row['email']) exit('E-Mail <b>'.$_REQUEST['email'].'</b> уже используеться.');
		
		mysqli_query($CONNECT, "INSERT INTO `users` VALUES ('', '$_REQUEST[login]', '$_REQUEST[password]', '$_REQUEST[name]', NOW(), '$_REQUEST[email]', $_REQUEST[country], 0, 0)");
		$code = str_replace('=', '', base64_encode($_REQUEST['email']));
		smtpmail($_REQUEST['email'], 'Регистрация на сайте DKtech|ICCT', 'Ссылка для активации: http://kotsiuba.pp.ua/account/activate/code/'.substr($code, 5, strlen($code)).substr($code, 0, 5));
		MessageSend('inf', ': Регистрация аккаунта завершена. На указанный E-Mail адрес отправлено письмо о подтверждении регистрации.');
	}
	
	
	
	else if ($module == 'activate' && $param['code']){
		if(!$_SESSION['USER_ACTIVE_EMAIL']) {
			$email = base64_decode(substr($param['code'], -5).substr($param['code'], 0, -5));
			if (strpos($email, '@') !== false) {
				mysqli_query($CONNECT, "UPDATE `users` SET `active` = 1 WHERE `email` = '$email'");
				$_SESSION['USER_ACTIVE_EMAIL'] = $email;
				MessageSend('inf', ': E-Mail адрес <b>'.$email.'</b> подтвержден.', '/login');
			} 
			else MessageSend('err', ': E-Mail адрес не подтвержден.', '/login');
		} 
		else MessageSend('err', ': E-Mail адрес <b>'.$_SESSION['USER_ACTIVE_EMAIL'].'</b> уже подтвержден.', '/login');
	}
	
?>
