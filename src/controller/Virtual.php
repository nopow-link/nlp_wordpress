<?php

namespace NlpWordpress\Controller;

use NlpWordpress\Util\VirtualLoader;
use NlpWordpress\View\Certify;

class Virtual
{
	public function __construct()
	{
		self::init();
	}

	protected static function init()
	{
		$virtual	= new VirtualLoader();

		add_action('init', array($virtual, 'init'));
		add_filter(
			'do_parse_request',
			array($virtual, 'dispatch'),
			PHP_INT_MAX,
			2
		);
		new Certify($virtual, '/nlp_certify');
	}
}
