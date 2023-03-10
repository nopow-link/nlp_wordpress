<?php

namespace NlpWordpress\View;

use NllLib\ApiCache;

use NlpWordpress\Util\VirtualPage;

class Certify extends VirtualPage
{
	public function __construct($controller, $slug)
	{
		parent::__construct($controller, $slug);

		$this->cache = ApiCache::getInstance();
	}

	public function render()
	{
		if ($this->params && isset($this->params['key']))
        {
            $key = $this->params['key'];
            $check = $this->cache->keyRetrieve();
			if ( ! headers_sent() )
				header('Content-Type: application/json; charset=' . get_option( 'blog_charset' ));
            if (strcmp($key, $check) == 0)
			{
                return "{'data': { 'valid' : True }}";
            }
			return "{'data': { 'valid' : False }}";
        }
	}
}
