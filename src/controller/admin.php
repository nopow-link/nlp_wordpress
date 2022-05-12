<?php

namespace NlpWordpress\Controller;

use NlpWordpress\View\Admin\Certify;

class Admin
{
	public function __construct()
	{
		self::init()
	}

	protected static function init()
	{
		add_action('admin_init', ['NlpWordpress\Plugin', 'load_icon']);
		add_action('admin_menu', ['NlpWordpress\Plugin', 'admin_menu']);

		/**
		* Initialisation du traitement de la requête POST de la page cetify.
		*/
		$page = new Certify()
		add_action('admin_post_' . $page.get_slug(), [$page, 'post_view']);
	}
}
