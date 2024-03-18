<?php

namespace Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
	public function getFunctions()
	{
		return [
			new TwigFunction('versioned_asset', [$this, 'getVersionedAssetUrl']),
		];
	}

	public function getVersionedAssetUrl($path)
	{
		// Assuming your JS files are in the public directory
		$basePath = "{$_SERVER['DOCUMENT_ROOT']}/{$_ENV['BASE_PATH']}/";
		$filePath = $basePath . $path;
		$version = '';

		if (file_exists($filePath)) {
			$version = filemtime($filePath);
		}

		return $path . '?v=' . $version;
	}
}
