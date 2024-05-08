<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


class MY_Security extends CI_Security {


	protected function _do_never_allowed($str)
	{
		$str = str_replace(array_keys($this->_never_allowed_str), $this->_never_allowed_str, $str);

		foreach ($this->_never_allowed_regex as $regex)
		{
			$str = preg_replace('#'.$regex.'#is', '', $str);
		}

		return $str;
	}
	public function xss_clean($str, $is_image = FALSE) {
        // Do whatever you need here with the input ... ($str, $is_image)

        $str = parent::xss_clean($str, $is_image);

      	$str = str_replace("[removed]", "", $str);

        return $str;
    }
    public function csrf_verify()
	{
		// If it's not a POST request we will set the CSRF cookie
		if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST')
		{
			return $this->csrf_set_cookie();
		}

		// Check if URI has been whitelisted from CSRF checks
		$exclude_uris = config_item('csrf_exclude_uris');
		$exclude_uris[] = 'Vindex/tech5sManagerControl';
		$uri = load_class('URI', 'core');
		foreach ($exclude_uris as $excluded)
		{
			if (preg_match('#^'.$excluded.'$#i'.(UTF8_ENABLED ? 'u' : ''), $uri->uri_string()))
			{
				return $this;
			}
		}

		// Check CSRF token validity, but don't error on mismatch just yet - we'll want to regenerate
		$valid = isset($_POST[$this->_csrf_token_name], $_COOKIE[$this->_csrf_cookie_name])
			&& is_string($_POST[$this->_csrf_token_name]) && is_string($_COOKIE[$this->_csrf_cookie_name])
			&& hash_equals($_POST[$this->_csrf_token_name], $_COOKIE[$this->_csrf_cookie_name]);

		// We kill this since we're done and we don't want to pollute the _POST array
		unset($_POST[$this->_csrf_token_name]);

		// Regenerate on every submission?
		if (config_item('csrf_regenerate'))
		{
			// Nothing should last forever
			unset($_COOKIE[$this->_csrf_cookie_name]);
			$this->_csrf_hash = NULL;
		}

		$this->_csrf_set_hash();
		$this->csrf_set_cookie();

		if ($valid !== TRUE)
		{
			$this->csrf_show_error();
		}

		log_message('info', 'CSRF token verified');
		return $this;
	}
}