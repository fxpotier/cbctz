<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 07/05/2015
 * Time: 14:34
 */

namespace CityByCitizen\Services;

use CityByCitizen\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocalizationService {
	/**
	 * @var
	 */
	private $lang;
	/**
	 * @var array
	 */
	private $acceptedLanguages;

	function __construct(Request $request) {
		$this->request = $request;
		$languages = explode(';', $this->request->server('HTTP_ACCEPT_LANGUAGE'));
		$this->acceptedLanguages = [];

		foreach ($languages as $l) {
			$found = preg_match('#^[^,]+,([a-zA-Z]{2})#', $l, $l);
			if ($found > 0 && !in_array($l[1], $this->acceptedLanguages)) $this->acceptedLanguages[] = $l[1];
		}

		if (!in_array('en', $this->acceptedLanguages)) $this->acceptedLanguages[] = 'en';

		foreach ($this->acceptedLanguages as $l) {
			$this->lang = Language::whereAlias($l)->first();
			if ($this->lang != null) return;
		}
	}

	public function SetLanguage($lang = null) {
		if ($lang != null) {
			if (!($lang instanceof Language)) {
				$lang = Language::whereAlias($lang)->first();
				if ($lang != null) $this->lang = $lang;
			} else $this->lang = $lang;
		}

		if ($this->lang == null) return;

		App::setLocale($this->lang->alias);
	}

	public function GetLanguage() {
		return $this->lang;
	}

    public function GetLanguages() {
        return $this->acceptedLanguages;
    }
}