<?php
/**
 * @package nopow-link
 * @version 0.0.0
 */
/*
Plugin Name: Nopow-Link
Plugin URI:
Description: This is official plugin needed to work with website <a href='https://www.nopow-link.com/'>https://www.nopow-link.com/</a>
Author: Nopow-Link
Version: 0.0.0
Author URI: https://nopow-link.com/
*/

if (is_readable( __DIR__ . '/vendor/autoload.php' ))
{
    require __DIR__ . '/vendor/autoload.php';
}

NlpWordpress\Settings::getInstance([
    'name'		=> 'Nopow-Link',
    'url'		=> 'http://dev.nopow-link.com:8000/',
    'version'	=> '0.0.0',
    'debug'		=> True,
    'root'		=> __DIR__,
    'site'		=> [
        'plugin_url'	=> plugin_dir_url(__FILE__),
        'host'			=> $_SERVER['HTTP_HOST'],
        'protocole'		=> $_SERVER['SERVER_PROTOCOL'],
    ],
]);

register_activation_hook(__FILE__ , "NlpWordpress\Plugin::install");

NlpWordpress\Plugin::run();
