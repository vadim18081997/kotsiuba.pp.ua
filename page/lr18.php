<?php Head("Лабораторна робота №18");?>

<body>

<div class="wrapper">

	<header class="header">
	</header>
	
	<div class="content">
	
		<?php Menu();?>
		<?php MessageShow();?>
		<div class="page">
		<form method="POST" action="/lr18parser">
			<br><input type="text" name="kilkSEG" placeholder="Кількість сегментів" maxlength="10" required>
            <br><select size="1" name="typeS1">
				<option value="10Base5">10Base5</option>
				<option value="10Base2">10Base2</option>
				<option value="10BaseT">10BaseT</option>
				<option value="10BaseFB">10BaseFB</option>
				<option value="10BaseFL">10BaseFL</option>
			</select>
            <input type="text" name="l1" placeholder="Довжина сегмента" maxlength="10" >
            
            <br><select size="1" name="typeS2">
				<option value="10Base5">10Base5</option>
				<option value="10Base2">10Base2</option>
				<option value="10BaseT">10BaseT</option>
				<option value="10BaseFB">10BaseFB</option>
				<option value="10BaseFL">10BaseFL</option>
			</select>
            <input type="text" name="l2" placeholder="Довжина сегмента" maxlength="10" >
            
            <br><select size="1" name="typeS3">
				<option value="10Base5">10Base5</option>
				<option value="10Base2">10Base2</option>
				<option value="10BaseT">10BaseT</option>
				<option value="10BaseFB">10BaseFB</option>
				<option value="10BaseFL">10BaseFL</option>
			</select>
            <input type="text" name="l3" placeholder="Довжина сегмента" maxlength="10" >
            
            <br><select size="1" name="typeS4">
				<option value="10Base5">10Base5</option>
                <option value="10Base2">10Base2</option>
				<option value="10BaseT">10BaseT</option>
				<option value="10BaseFB">10BaseFB</option>
				<option value="10BaseFL">10BaseFL</option>
			</select>
            <input type="text" name="l4" placeholder="Довжина сегмента" maxlength="10" >
            
            <br><select size="1" name="typeS5">
				<option value="10Base5">10Base5</option>
				<option value="10Base2">10Base2</option>
				<option value="10BaseT">10BaseT</option>
				<option value="10BaseFB">10BaseFB</option>
				<option value="10BaseFL">10BaseFL</option>
			</select>
            <input type="text" name="l5" placeholder="Довжина сегмента" maxlength="10" >
            
            <br><select size="1" name="typeS6">
				<option value="10Base5">10Base5</option>
				<option value="10Base2">10Base2</option>
                <option value="10BaseT">10BaseT</option>
				<option value="10BaseFB">10BaseFB</option>
				<option value="10BaseFL">10BaseFL</option>
			</select>
			<input type="text" name="l6" placeholder="Довжина сегмента" maxlength="10" >
            
            <br><br><input type="submit" name="enter" value="Розрахувати">
			<input type="reset" value="Відмінити">
		</form>
		</div>
	</div>

	<?php Footer();?>
</div>
</body>
</html>
