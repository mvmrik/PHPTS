<?php
/* Example
'route_name' => [
	'view' => 'category/file.twig', // this
	'controller' => 'controller' => ['category_path/file, 'method_name'], //or this example: 'controller' => ['Cat/File/File', 'func'],
	'params' => [
		'specialParam' => 'Param value',
	]
]
*/

$routes = [
	'/' => [
		'view' => 'index.twig',
	]
];
