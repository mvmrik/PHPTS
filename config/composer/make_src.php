<?php

if ($argc != 3 && $argc != 4) {
	echo "Usage: make:src <category> <filename> <view>(not required)\n";
	exit(1);
}

$category_name = ucwords($argv[1]);
$fetch_name = ucwords($argv[2]);

$directory_php = "controllers/$category_name";
$directory_ts = "src/$category_name";

if (!file_exists($directory_php)) {
	mkdir($directory_php, 0755, true);
}
if (!file_exists($directory_ts)) {
	mkdir($directory_ts, 0755, true);
}

$class_filename = "{$directory_php}/{$fetch_name}.php";
$ts_filename = "{$directory_ts}/{$fetch_name}.ts";

$class_content = <<<HTML
<?php

namespace Controllers\\{$category_name};

use Config\Database;

class {$fetch_name} extends Database
{
	public function index(){
		return ['view' => '{$category_name}/{$fetch_name}.twig', 'params' => []];
	}
}
HTML;

$ts_content = <<<HTML
import { tsFetch } from './../global.js';

HTML;

$view_content = <<<HTML
{% extends 'layouts/base.twig' %}

{% block title %}

{% endblock %}

{% block content %}
	
{% endblock %}

{% block scripts %}
<script type="module" src="{{ asset('js/{$category_name}/{$fetch_name}.js') }}"></script>
{% endblock %}
HTML;

file_put_contents($class_filename, $class_content);
file_put_contents($ts_filename, $ts_content);

if ($argv[3] && $argv[3] == 'view') {
	$directory_view = "views/$category_name";
	$view_filename = "{$directory_view}/{$fetch_name}.twig";

	if (!file_exists("$directory_view/$fetch_name")) {
		mkdir("$directory_view", 0755, true);
	}

	file_put_contents($view_filename, $view_content);
}
