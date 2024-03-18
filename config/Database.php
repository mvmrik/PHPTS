<?php

namespace Config;

use PDO;
use PDOException;

class Database
{
	public function db()
	{
		$host = $_ENV['DB_HOST'];
		$port = $_ENV['DB_PORT'];
		$dbname = $_ENV['DB_DATABASE'];
		$user = $_ENV['DB_USERNAME'];
		$password = $_ENV['DB_PASSWORD'];

		$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

		try {
			$pdo = new PDO($dsn, $user, $password, [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES => false,
			]);
			return $pdo;
		} catch (PDOException $e) {
			die("Could not connect to the database $dbname :" . $e->getMessage());
		}
	}
}