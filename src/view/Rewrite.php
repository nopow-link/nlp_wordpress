<?php

namespace NlpWordpress\View;

use NlpWordpress\Util\Message;

use NllLib\ApiRequest;
use NllLib\LinkPlace;
use NllLib\Exception\NllLibCollectException;

class Rewrite
{

	protected $data;

	public function __construct()
	{
		$request = new ApiRequest();
		$this->data = Null;
		try
		{
			$this->data = $request->collect($_SERVER['REQUEST_URI']);
		}
		catch (NllLibCollectException $e)
		{
			$message = strval($e);
			add_action('init', function() use ($message)
			{
				if (current_user_can('manage_options'))
				{
					$errors = new Message('errors');
					$errors->del_message();
					$errors->set_messages([$message]);
				}
			});
		}
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
