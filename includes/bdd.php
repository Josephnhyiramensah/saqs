<?php
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=saqs;charset=utf8', 'root', '');
	}
	catch(Exception $e)
	{
	    die('Error : '.$e->getMessage());
	}
?>
