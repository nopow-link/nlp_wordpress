<?php

namespace NlpWordpress\View\Admin;

use NlpWordpress\Settings;
use NlpWordpress\Util\Message;

use NllLib\ApiCache;
use NllLib\ApiRequest;
use NllLib\Exception\NllLibCertifyException;

class Certify
{
	private static $title	= "Nopow-Link";

	private static $slug	= "nlp-certify";

	protected $settings;

	protected $cache;

	protected $errors;

	protected $success;

	public function __construct()
	{
		self::init();
		$this->settings			= Settings::getInstance();
		$this->cache			= ApiCache::getInstance();
	}

	protected static function init()
	{
		add_action('admin_head', array('NlpWordpress\Plugin', 'load_style'));
	}

	/**
	* Retourne le titre de la page.
	*/
	public function get_title()
	{
		return self::$title;
	}

	/**
	* Retourne le slug de la page.
	*/
	public function get_slug()
	{
		return self::$slug;
	}

	/**
	* Fonction qui retourne le contenu de la page suite à une requête GET.
	*/
	public function get_view()
	{
		if (!current_user_can('manage_options'))
			wp_die('Permission denied');
		$this->errors		= new Message('errors');
		$this->success 		= new Message('success');

		$api_key = $this->cache->keyRetrieve();
		?>
			<div class="wrap">
				<h1 class="pb-1">Nopow-Link</h1>
				<div class="py-1">
					<div class="d-flex justify-content-between px-2">
						<p class="my-0">Version : <?= $this->settings->version ?></p>
						<p class="my-0"><a href="<?= $this->settings->url ?>" target="_blank">Register</a></p>
					</div>
				</div>
				<div class="container form-wrap">
					<h2>Certify API Key :</h2>
					<form method="post" action="<?= admin_url("admin-post.php")?>">
						<?php
						 	if ($this->errors->is_message()) {
								?>
									<div class="errors">
										Please fix the following Validation Errors:
										<ul>
											<li> <?= implode('</li><li>', $this->errors->get_messages()); ?></li>
										</ul>
									</div>
								<?php
							}
						?>
						<?php
						 	if ($this->success->is_message()) {
								?>
									<div class="success">
										<ul>
											<li> <?= implode('</li><li>', $this->success->get_messages()); ?></li>
										</ul>
									</div>
								<?php
							}
						?>
						<div class="form-field form-required term-name-wrap px-3">
							<p>Enter your plugin security key of your account. <a href="#">Get help</a></p>
							<input class="w-100" placeholder="Security key" name="api-key" id="tag-name" type="text" value="<?= $api_key ?>" size="40" aria-required="true">
							<input type="hidden" name="action" value="<?= $this->get_slug() ?>">
						</div>
						<div class="form-wrap edit-term-notes mt-1 px-3">
							<p>Nopow-Link API keys are free, never trust someone who want to sell you a key. API key is only to connect your Nopow-Link account to your WordPress.</p>
						</div>
						<p class="submit w-100 px-3">
							<input type="submit" name="submit" id="submit" class="button button-primary" value="Certify plugin"><span class="spinner"></span>
						</p>
					</form>
				</div>
			</div>
		<?php
	}

	/**
	* Fonction qui traite les requêtes POST de la page.
	*/
	public function post_view()
	{
		if (!current_user_can('manage_options'))
			wp_die('Permission denied');
		$this->errors		= new Message('errors');
		$this->success 		= new Message('success');

		$url 		= wp_get_referer();
		$request 	= new ApiRequest();
		$this->errors->del_message();
		$this->success->del_message();
		if (!empty($_POST['api-key']))
		{
			$api_key = $_POST['api-key'];
			$this->cache->keySave($api_key);
			try
			{
				$request->certify($api_key);
				$this->success->set_messages([
					"Your plugin has been certify successfuly. Welcome!"
					]);
			}
			catch (NllLibCertifyException $e)
			{
				$this->cache->keyDelete();
				$this->errors->set_messages([$e]);
			}
		}
		wp_redirect($url);
		exit;
	}
}
