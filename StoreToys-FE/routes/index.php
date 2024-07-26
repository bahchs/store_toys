<?php
//	$controllerName = ucfirst(strtolower($_GET['controller']) ?? 'Welcome') . 'Controller'; // to low giúp tránh lỗi trên LINUX
//	require_once("../API/$controllerName.php");
//	$controllerObject = new $controllerName();
//	$controllerObject->index();
	if(isset($_GET['view'])){
		$viewName = $_GET['view'];
		if($viewName == "category"){
			
		} 
	}else{
		header("Location: Views/home/Home.html?param1=$param1");
		}
?>