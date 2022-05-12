<?php

namespace NlpWordpress\View\Admin;

use NlpWordpress\Settings;

class Certify
{
	private static $title	= "Nopow-Link";

	private static $slug	= "nlp-certify";

	private static $params	= array("api-key");

	protected $settings;

	public function __construct()
	{
		self::init();
		$this->settings	= Settings::getInstance();
	}

	protected static function init()
	{
		add_action('admin_head', array('NlpWordpress\Plugin', 'load_style'));
	}

	/**
	* Retourne le titre de la page.
	*/
	public function get_title()
	{
		return self::$title;
	}

	/**
	* Retourne le slug de la page.
	*/
	public function get_slug()
	{
		return self::$slug;
	}

	/**
	* Fonction qui retourne le contenu de la page suite à une requête GET.
	*/
	public function get_view()
	{
		if (!current_user_can('manage_options'))
			wp_die('Permission denied');
	}

	/**
	* Fonction qui traite les requêtes POST de la page.
	*/
	public function post_view()
	{
		if (!current_user_can('manage_options'))
			wp_die('Permission denied');
	}
}
