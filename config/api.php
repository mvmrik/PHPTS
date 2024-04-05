<?php

class handleRequest
{
	public function handleRequest($className, $methodName, $post)
	{
		if (method_exists($className, $methodName)) {
			$obj = new $className();

			$array_data = array_map(function ($row) {
				if (is_object($row)) {
					return $row->toArray();
				} else {
					return $row;
				}
			}, $obj->$methodName($post));

			$array_data = array_values($array_data);
			return json_encode($array_data);
		} else {
			return json_encode(['error' => 'Method not found']);
		}
	}
}

$post = json_decode(file_get_contents('php://input'));

if (!is_object($post)) {
	$post = new stdClass();
}

if (!empty($_POST)) {
	$postForm = (object)$_POST;

	foreach ($postForm as $key => $value) {
		$post->$key = $value;
	}
}

if (isset($post->path)) {
	require __DIR__ . "/../vendor/autoload.php";
	require __DIR__ . '/../config/dotenv.php';
	$path = explode('/', $post->path);
	require_once __DIR__ . "/../controllers/$path[0]/$path[1].php";

	$obj = new handleRequest;

	echo $obj->handleRequest("Controllers\\$path[0]\\" . $path[1], $path[2], $post);
} else {
	echo json_encode(['error' => 'Invalid request']);
}
