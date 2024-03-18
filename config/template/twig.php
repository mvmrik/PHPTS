<?php
require_once 'AppExtension.php';

$path = isset($_GET['path']) ? rtrim($_GET['path'], '/') : '/';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../views/');
$twig = new \Twig\Environment($loader, [
	'cache' => __DIR__ . '/../../cache/',
	'auto_reload' => true,
	'debug' => true
]);

$twig->addExtension(new \Twig\Extension\DebugExtension());
$twig->addExtension(new \Twig\AppExtension());

$allFunctions = array_merge(get_defined_functions()['internal'], get_defined_functions()['user']);
foreach ($allFunctions as $functionName) {
	$twig->addFunction(new \Twig\TwigFunction($functionName, $functionName));
}

$routeFound = false;

foreach ($routes as $key => $route) {
	if ($path === $key) {
		$params = array_merge(['baseUrl' => $_ENV['BASE_URL'], 'get' => $_GET], $route['params'] ?? []);
		echo $twig->render($route['template'], $params);
		$routeFound = true;
		break;
	}
}

if (!$routeFound) {
	http_response_code(404);
	echo $twig->render('404.twig', ['baseUrl' => $_ENV['BASE_URL'], 'message' => 'Page not found']);
}
