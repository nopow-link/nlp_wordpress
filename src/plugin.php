<?php

namespace NlpWordpress;

use NlpWordpress\Settings;
use NlpWordpress\View\Admin\Certify;

class Plugin
{
	public static function install() {}

	public static function load_style()
	{
		$settings = Settings::getInstance();

		wp_register_style(
			'nlp_bootstrap_css',
			$settings->site['plugin_url'] . 'assets/css/bootstrap-grid.min.css',
			array(),
			$settings->version
		);
		wp_register_style(
			'nlp_css',
			$settings->site['plugin_url'] . 'assets/css/index.min.css',
			array(),
			$settings->version
		);
		wp_enqueue_style('nlp_bootstrap_css');
		wp_enqueue_style('nlp_css');
	}

	public static function load_icon()
	{
		$settings = Settings::getInstance();

		wp_register_style(
			'nlp_icon_css',
			$settings->site['plugin_url'] . '/assets/css/icons.min.css',
			array(),
			$settings->version
		);
		wp_enqueue_style('nlp_icons_css');
	}

	public static function admin_menu()
	{
		$menu_title		= "Nopow-Link"
		$main_page		= new Certify()

		add_menu_page(
			$main_page->get_title(),
			$menu_title,
			"manage_options",
			$main_page->get_slug(),
			array($main_page->get_view()),
			'nlp-icon',
			4
		);
	}

	public static function run() {}
}
