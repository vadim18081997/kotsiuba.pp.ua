<?php Head("Лабораторна робота №17");?>

<body>

<div class="wrapper">

	<header class="header">
	</header>
	
	<div class="content">
	
		<?php Menu();?>
		<?php MessageShow();?>
		<div class="page">
		<form method="POST" action="/lr17parser">
			<br><input type="text" name="ldan" placeholder="Розмір поля даних" maxlength="10" required>
			<br><input type="text" name="speed" placeholder="Швидкість передачі" >
			<br><br><input type="submit" name="enter" value="Розрахувати">
			<input type="reset" value="Відмінити">
		</form>
		</div>
	</div>

	<?php Footer();?>
</div>
</body>
</html>