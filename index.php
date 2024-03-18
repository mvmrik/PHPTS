<?php
require 'vendor/autoload.php';
require 'config/dotenv.php';
require 'routes.php';
if (!str_contains($_SERVER['REQUEST_URI'], 'json.php')) {
	require 'config/template/twig.php';
}


