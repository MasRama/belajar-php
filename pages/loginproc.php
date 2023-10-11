<?php
$arrUsers = array(
	array(
		"email" => "rama@gmail.com",
		"password" => "rama"
	),
);
$email = $_POST['email'];
$password = $_POST['password'];

$isFound = FALSE;
foreach($arrUsers as $objUser){
	if($objUser['email'] == $email && $objUser['password'] == $password){
		$isFound = TRUE;
		break;
	}
}

if($isFound){
	echo "User Ditemukan";
}else{
	echo "User Tidak Ditemukan";
}