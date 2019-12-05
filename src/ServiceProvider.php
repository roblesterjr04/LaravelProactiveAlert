<?php

namespace Lester\ProactiveAlert;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
	const CONFIG_PATH = __DIR__ . '/../config/config.php';

	public function boot()
	{

		$this->publishes([
			self::CONFIG_PATH => config_path('proactive.php'),
		], 'config');

	}

	public function register()
	{

		$this->mergeConfigFrom(
			self::CONFIG_PATH,
			'eloquent_sf'
		);

        $this->app->bind('proactive', function() {
			return new ProactiveAlertBuilder();
		});

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
		$loader->alias('Proactive', 'Lester\ProactiveAlert\Facades\Proactive');

    }
}
