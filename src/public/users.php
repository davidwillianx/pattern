<?php 
$storage = $this->getStorage();

foreach ($storage as $user) {
	echo 'Dados: '. $user['nome'].' with email: '.$user['email'];
}
 	
?>