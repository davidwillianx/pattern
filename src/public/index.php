<?php

?>
<DOCTYPE>
<html>
	<header>
		<title>patter</title>
	</header>
		
	<body>

	<?php 
		$storage = $this->getStorage();

		if($message = $storage['message'])
			echo '<span>'.$message.'<span>'

	?>
		<h2>XBEm Vindo estamos no em uma página 
			chamada pelo controllerIndex	method index</h2>
	<form method="post" action="user/register"> 
		Nome: <input type="text" name="nome" />
		Email: <input type="text" name="email" />
		Idade: <input type="text" name="idade" />
		<input type="submit" name="event" value="registrar">
	</form>

	</body>

</html>
