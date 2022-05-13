<?php

namespace NlpWordpress\Util;

class Message
{
	private $identifier;

	private $id;

	private $messages;

	public function __construct($identifier = 'simple')
	{
		if (is_admin())
		{
			$user				= wp_get_current_user();
			$this->identifier	= $identifier;
			$this->id			= 0;
			if ($user->exists && !empty($user->ID))
				$this->id = $user->ID;
			$this->messages	 	= get_transient($this->identifier . $this->id);
		}
		else
			throw new Exception(__CLASS__ . " is only for wordpress admin.");
	}

	public function is_message()
	{
        if ($this->messages === False)
            return False;
        return True;
    }

	public function del_message()
	{
		if ($this->is_message())
			delete_transient($this->identifier . $this->id);
	}

	public function get_messages()
	{
        $message = $this->messages;
		$this->del_message();
		return $message;
    }

	public function set_messages(array $message)
	{
        if (!empty($message))
            set_transient($this->identifier . $this->id, $messages);
    }
}
