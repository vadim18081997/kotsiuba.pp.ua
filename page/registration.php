<?php Head("Регистрация");?>

<body>

<div class="wrapper">

	<header class="header">
	</header>
	
	<div class="content">
	
		<?php Menu();?>
		<?php MessageShow();?>
		<div class="page">
		<form method="POST" action="/account/registration">
			<br><input type="text" name="login" placeholder="Логин" maxlength="10" pattern="[A-Za-z0-9]{3,10}" title="Не менее 3 и не более 10 латынских букв или цифр." required>
			<br><input type="email" name="email" placeholder="E-Mail" required>
			<br><input type="password" name="password" placeholder="Пароль" maxlength="15" pattern="[A-Za-z0-9]{6,15}" title="Не менее 6 и не более 15 латынских букв или цифр." required>
			<br><input type="text" name="name" placeholder="Имя" >
			<br><select size="1" name="country">
				<option disabled>Выберите страну проживания</option>
				<option value="1">Украина</option>
				<option value="2">Россия</option>
				<option value="3">США</option>
				<option value="4">Германия</option>
				<option value="5">Англия</option>
				<option value="6">Шотландия</option>
			</select>
			<!-- <br><input type="file" name="avatar"> -->
			<div class="captchaDiv">
				<input type="text" class="captchaCap" name="captcha" placeholder="Капча" maxlength="10" pattern="[0-9]{1,5}" title="Только цыфри." required>
					<img src="/captcha" class="captchaImg" alt="Captcha">
			</div>
			<br><br><input type="submit" name="enter" value="Регистрация">
			<input type="reset" value="Очистить">
		</form>
		</div>
	</div>

	<?php Footer();?>
</div>
</body>
</html>