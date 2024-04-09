## Installation
1. Download zip or clone
2. Run on terminal ```composer inatall```
3. Make copy of .env_example and rename to .env

## Routing
### Calling view
```php
$routes = [
	'/' => [
		'view' => 'index.twig'
	]
];
```
### Calling controller
```php
$routes = [
	'/' => [
		'controller' => => ['category/file, 'method_name']
	]
];

//Example
'controller' => ['Cat/File, 'index']
```
### Send params
```php
$routes = [
	'/' => [
		'view' => 'index.twig'
	],
	'params' => [
		'specialParam' => 'Param value',
	]
];
```
