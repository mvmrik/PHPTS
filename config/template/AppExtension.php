<?php

namespace Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
	public function getFunctions()
	{
		return [
			new TwigFunction('asset', [$this, 'getVersionedAssetUrl']),
		];
	}

	public function getVersionedAssetUrl($path)
	{
		$basePath = "{$_SERVER['DOCUMENT_ROOT']}/{$_ENV['BASE_PATH']}/";
		$filePath = "$basePath/public/$path";
		$version = '';

		if (file_exists($filePath)) {
			$version = filemtime($filePath);
		}

		return "{$_ENV['BASE_URL']}/public/$path?v=$version";
	}
}
