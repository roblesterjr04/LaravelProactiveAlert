<?php

namespace Lester\ProactiveAlert\Facades;

use Illuminate\Support\Facades\Facade;

class Proactive extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'proactive';
	}
}
