<?php

namespace NlpWordpress;

use NlpWordpress\Exception\SettingsExcetpion;

class Settings
{
	private static $INSTANCE	= null;

	private $settings;

	private function __construct(array $settings = [])
	{
		$this->settings = $settings;
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
}
