<?php

namespace NlpWordpress;

use NllLib\ApiSettings;
use NllLib\Utils\Path;

use NlpWordpress\Exception\SettingsExcetpion;

class Settings
{
	private static $INSTANCE	= null;

	private $settings;

	private function __construct(array $settings = [])
	{
		$path = new Path(WP_CONTENT_DIR);

		$this->settings 	= $settings;

		$this->api_settings	= ApiSettings::getInstance();
		$this->api_settings->setUrl($this->url);
		$this->api_settings->setCacheFolder($path->absolut('./cache/nlp_wordpress'));
		$this->api_settings->setTimeout($this->timeout);
	}

	public static function getInstance(array $settings = [])
	{
		if (!self::$INSTANCE)
			self::$INSTANCE = new Settings($settings);
		return self::$INSTANCE;
	}

	public function __get($name)
	{
		try
		{
			if (empty($this->settings))
				throw new SettingsException("No settings file has been set");
			if (isset($this->settings[$name]))
				return $this->settings[$name];
			throw new SettingsException($name . " settings key doesn't exist.");
		}
		catch (SettingsException $e)
		{
			echo $e;
		}
	}

	public function get_api_settings()
	{
		return $this->api_settings;
	}
}
