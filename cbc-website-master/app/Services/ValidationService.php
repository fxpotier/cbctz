<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 28/05/2015
 * Time: 09:46
 */

namespace CityByCitizen\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class ValidationService {
	private $rules;

	function __construct() {
		$this->rules = Config::get('rules');
	}

	public function rulesList() {
		return array_keys($this->rules);
	}

	public function getRules($name) {
		return $this->rules[$name];
	}

	public function save($name, $rules) {
		if (!isset($this->rules[$name])) return;
		$this->rules[$name] = $rules;
		file_put_contents(config_path('rules.php'), '<?php return '.var_export($this->rules, true).';');
	}

	public function makeValidator($name, $data) {
		return Validator::make($data, $this->rules[$name]);
	}


}