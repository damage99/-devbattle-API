<?php
include("../class.php");

$RClass = new Converter();

	if(empty($_POST))
		$RClass->Error("post");
	
	if(empty($_POST['from'])||empty($_POST['to'])||empty($_POST['value']))
		$RClass->Error("args");
	
	$RClass->TryConvert($_POST);

?>
