<?php

namespace MultiLanguage\Classes;

include_once(PLUGIN_PATH . "/vth_support/traits/Singleton.php");

define('MULTI_LANGUAGE_KEY', 'multi_language');

class LanguageProvider
{

	use \VthSupport\Traits\Singleton;

	protected $defaultLanguage = 'en';

	protected $CI;

	protected $languages;

	protected static $jsonLanguages = [];



	public function __construct()
	{

		$this->CI = &get_instance();
		$config = getConfigPlugin('multi_language');
		$default = isset($config['languages']['default']) ? $config['languages']['default'] : 'vi';

		$list = isset($config['languages']['list']) ? $config['languages']['list'] : [];
		$this->languages = $list;

		$this->defaultLanguage = $default;
	}

	public function setLanguages($languages)
	{

		$this->languages = $languages;
	}

	public function getLanguages()
	{

		return $this->languages;
	}

	public function setLanguage($lang)
	{

		$this->CI->session->set_userdata(MULTI_LANGUAGE_KEY, $lang);
	}

	public function hasLanguage()
	{

		return $this->CI->session->has_userdata(MULTI_LANGUAGE_KEY);
	}

	public function getLanguage()
	{

		if ($this->hasLanguage()) {

			return $this->CI->session->userdata(MULTI_LANGUAGE_KEY);
		}

		return $this->defaultLanguage;
	}

	public function validateLang($lang)
	{

		return in_array($lang, $this->languages);
	}

	public function getDefaultLanguage()
	{

		return $this->defaultLanguage;
	}

	public function setDefaultLanguage($lang)
	{

		$this->defaultLanguage = $lang;
	}

	public function flags()
	{

		if (count(static::$jsonLanguages) == 0) {

			$json = file_get_contents(PLUGIN_PATH . '/multi_language/theme/json/lang.json');

			static::$jsonLanguages = json_decode($json, true);
		}

		return static::$jsonLanguages;
	}
}
