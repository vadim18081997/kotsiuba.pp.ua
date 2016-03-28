<?php
	include_once 'setting.php';
    include_once 'objects/classMail.php';
	
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
?>
