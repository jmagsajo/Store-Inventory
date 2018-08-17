<?php
// ini_set('display_errors', 1);
session_start();

function debug($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}