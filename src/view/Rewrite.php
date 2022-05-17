<?php

namespace NlpWordpress\View;

use NllLib\ApiRequest;
use NllLib\LinkPlace;

class Rewrite
{
	public function __construct()
	{
		$request = new ApiRequest();
		$this->data = $request->collect($_SERVER['REQUEST_URI']);
		add_action('template_redirect', array($this, 'startBuffer'), 0);
		add_action("shutdown", array($this, 'endBuffer'), 0);
	}

	public function startBuffer()
	{
		ob_start(array($this, 'rewrite'));
	}

	public function rewrite($html)
	{
		$this->link = new LinkPlace($this->data);
		return $this->link->place($html);
	}

	public function endBuffer()
	{
		if (ob_get_level() > 1000)
			ob_end_flush();
	}
}
