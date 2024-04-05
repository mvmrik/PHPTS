<?php

namespace Config;

use Nette\Database\Connection;
use Nette\Database\Explorer;
use Nette\Database\Structure;
use Nette\Caching\Storages\FileStorage;

class Database
{
	protected $explorer;

	public function __construct()
	{
		$this->initializeExplorer();
	}

	protected function initializeExplorer()
	{
		$host = $_ENV['DB_HOST'];
		$dbname = $_ENV['DB_DATABASE'];
		$user = $_ENV['DB_USERNAME'];
		$password = $_ENV['DB_PASSWORD'];

		$cacheStorage = new FileStorage(__DIR__ . '/../cache');

		$connection = new Connection(
			"mysql:host=$host;dbname=$dbname",
			$user,
			$password
		);
		$structure = new Structure($connection, $cacheStorage);
		$this->db = new Explorer($connection, $structure);
	}
}
