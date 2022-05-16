<?php

namespace NlpWordpress\Util;

abstract class VirtualPage
{

    private $slug		= '';

    protected $params	= [];

    public function __construct($controller, $slug)
    {
        $this->slug = $slug;
        add_action('nlp_page', function($controller) {
            $controller->add_page($this);
        });
    }

    public function get_slug()
    {
        return $this->slug;
    }

    public function get_params()
    {
        return $this->params;
    }

    public function set_params($params)
    {
        $this->params = $params;
    }

    abstract function render();
}
