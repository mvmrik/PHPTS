<?php
require_once 'AppExtension.php';

$path = isset($_GET['path']) ? rtrim($_GET['path'], '/') : '/';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../views/');

$appEnv = $_ENV['APP_ENV'] ?? 'production';
if ($appEnv === 'local') {
	$twigOptions = [
		'cache' => false,
		'auto_reload' => true,
		'debug' => true,
	];
} else {
	$twigOptions = [
		'cache' => __DIR__ . '/../../cache/',
		'auto_reload' => false,
		'debug' => false,
	];
}
$twig = new \Twig\Environment($loader, $twigOptions);

$twig->addExtension(new \Twig\Extension\DebugExtension());
$twig->addExtension(new \Twig\AppExtension());

$allFunctions = array_merge(get_defined_functions()['internal'], get_defined_functions()['user']);
foreach ($allFunctions as $functionName) {
	$twig->addFunction(new \Twig\TwigFunction($functionName, $functionName));
}

$routeFound = false;

foreach ($routes as $key => $route) {

	if (preg_match('/^(\w+)\{(.*?)\}$/', $key, $matchesRouteParams)) { // if isset dynamic param in route
		$routeDynamicParam = $matchesRouteParams[2];

		$key = $matchesRouteParams[1];
		if (preg_match("/^$key\/([a-zA-Z0-9_-]+)$/", $path, $matchesRouteDynamicValue)) {
			$routeWithParamValue = "$key/{$matchesRouteDynamicValue[1]}";
		}
	}

	if ($path === $key || $path === $routeWithParamValue) {
		$routeFound = true;

		if ($route['controller']) {
			$fullyQualifiedClassName = 'Controllers\\' . str_replace('/', '\\', $route['controller'][0]);
			$class_object = new $fullyQualifiedClassName();
			$method = $route['controller'][1];
			$params = array_merge(['baseUrl' => $_ENV['BASE_URL'], 'get' => $_GET], $route['params'] ?? [], $class_object->$method()['params'] ?? []);
			echo $twig->render($class_object->$method()['view'], $params);
		} elseif ($route['view']) {
			$params = array_merge(['baseUrl' => $_ENV['BASE_URL'], 'get' => $_GET, $routeDynamicParam => $matchesRouteDynamicValue[1]], $route['params'] ?? []);
			echo $twig->render($route['view'], $params);
		} else {
			$routeFound = false;
		}
	}
}

if (!$routeFound) {
	http_response_code(404);
	echo $twig->render('404.twig', ['baseUrl' => $_ENV['BASE_URL'], 'message' => 'Page not found']);
}
