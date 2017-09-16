<?php
/**
 * Created by PhpStorm.
 * User: Hinomi
 * Date: 27/05/2015
 * Time: 15:05
 */

namespace CityByCitizen\Providers;


use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {
	public function boot() {
		View::composer('*', 'CityByCitizen\Http\ViewComposers\UserComposer');
	}

	/**
	 * Register the service provider.
	 * @return void
	 */public function register() {
	}
}