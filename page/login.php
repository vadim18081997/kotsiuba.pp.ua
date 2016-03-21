<?php
	
	if($_REQUEST['enter']){
		echo 'Запрос на логин...';
		exit;
	}
?>

<?php Head("Вход");?>

<body>


<div class="wrapper">

	<header class="header">
	</header>
	
	<div class="content">
	
		<?php Menu();?>
		<?php MessageShow();?>
		<div class="page">
		<form method="POST" action="/login">
			<input type="text" name="login" placeholder="Логин" required><br>
			<input type="password" name="password" placeholder="Пароль" required><br>
			<input type="submit" name="enter" value="Войти">	
			<input type="reset" value="Очистить">	
		</form>
		</div>
	</div>

	<?php Footer();?>
</div>
</body>

</html>