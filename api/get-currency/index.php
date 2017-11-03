<?php
include("../class.php");

$RClass = new Converter();

	if(empty($_GET))
		$RClass->Error("get");
	
	$RClass->doPrintAV($_GET);

?>
