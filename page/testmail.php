<?php
	$config['smtp_username'] = 'admin@kotsiuba.pp.ua';  //Смените на имя своего почтового ящика.
	$config['smtp_port']	 = '25'; // Порт работы. Не меняйте, если не уверены.
	$config['smtp_host']	 = 'localhost';  //сервер для отправки почты
	$config['smtp_password'] = 'GRUNDIG1997';  //Измените пароль
	$config['smtp_debug']	= true;  //Если Вы хотите видеть сообщения ошибок, укажите true вместо false
	$config['smtp_charset']  = 'UTF-8';	//кодировка сообщений. (или UTF-8, итд)
	$config['smtp_from']	 = 'DKtech|ICCT'; //Ваше имя - или имя Вашего сайта. Будет показывать при прочтении в поле "От кого"
	
	//smtpmail('dom35344@ro.ru', 'Знакомство с DKtech', $message);
	//mail('dom35344@mail.ru', 'Знакомство с DKtech', $message, 'From: admin@kotsiuba.pp.ua');
	
?>