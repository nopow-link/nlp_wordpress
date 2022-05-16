<?php

namespace NlpWordpress\Util;

use NlpWordpress\Util\VirtualPage;

final class VirtualLoader
{

    private $pages;

    private $params	= [];

    private $slug	= '';

    public function __construct()
	{
        $this->pages	= new \SplObjectStorage;
        $this->url 		= "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        add_action('wp_loaded', array($this, 'parse_params'));
        add_action('wp_loaded', array($this, 'parse_slug'));
    }

    public function parse_params()
	{
        $this->params = array();
        $string_param = parse_url($this->url, PHP_URL_QUERY);
        if ($string_param)
		{
            $params = explode('&', $string_param);
            foreach ($params as $param)
			{
                $value = explode('=', $param);
                if (!empty($value) && count($value) == 2)
                    $this->params[$value[0]] = $value[1];
            }
        }
    }

    public function parse_slug() {
        if (!get_option('permalink_structure'))
		{
            if (isset($this->params['nlp-page']))
			{
				$this->slug = $this->params['nlp-page'];
				unset($this->params['nlp-page']);
			}
        }
        else
            $this->slug = parse_url( $this->url, PHP_URL_PATH );
        $this->slug = trim( $this->slug, '/' );
    }

    function init()
	{
        do_action('nlp_page', $this);
    }

    function add_page($page)
	{
        $this->pages->attach($page);
        return $page;
    }

    private function select_page()
	{
        $this->pages->rewind();
        while($this->pages->valid())
		{
          if (trim( $this->pages->current()->get_slug(), '/' ) === $this->slug)
		  {
            $this->page = $this->pages->current();
            $this->page->set_params($this->params);
            return True;
          }
          $this->pages->next();
        }
        return False;
    }

    function dispatch($bool, \WP $wp)
	{
        if ($this->select_page() && $this->page instanceof VirtualPage)
		{
            echo $this->page->render();
            exit();
        }
        return True;
    }
}
