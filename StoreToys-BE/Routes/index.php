<?php
	$requestUri = $_SERVER['REQUEST_URI'];
	// Tách URI thành các thành phần
	$uriParts = parse_url($requestUri);

	// Lấy phần path từ URL
	$path = $uriParts['path'];

	$controllerParts = explode('/', $path);
	$controllerName = ucfirst($controllerParts[3]) . "Controller";
	require_once("../Controller/$controllerName.php");
	$controllerObject = new $controllerName();
	$controllerObject->handleRequest();
?>