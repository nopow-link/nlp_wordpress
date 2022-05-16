<?php

namespace NlpWordpress\Controller;

use NlpWordpress\View\Rewrite;

class Generic
{
	public function __construct()
	{
		self::init();
	}

	protected static function init()
	{
		$page	= New Rewrite();
	}
}
