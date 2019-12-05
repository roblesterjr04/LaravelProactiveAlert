<?php

namespace Lester\ProactiveAlert\Tests;

use Orchestra\Testbench\TestCase;
use Lester\ProactiveAlert\Facades\Proactive;
use Lester\ProactiveAlert\ServiceProvider;

class ProactiveTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    public function testFacade()
    {

        $this->assertTrue(Proactive::test());

    }

    public function testSubmit()
    {
        Proactive::body('Test message.')->submit();
    }

    public function setUp(): void
	{
		parent::setUp();

        config([
            'proactive' => [
                'default' => 'default_keyset', // the key of a configured keyset below.

                'keysets' => [
                    'default_keyset' => [
                        'site_id' => getenv('PROACTVE_SITE_ID'),
                        'consumer_key' => getenv('PROACTIVE_CONSUMER_KEY'),
                        'consumer_secret' => getenv('PROACTIVE_CONSUMER_SECRET'),
                        'token' => getenv('PROACTIVE_TOKEN'),
                        'token_secret' => getenv('PROACTIVE_TOKEN_SECRET'),
                        'domain' => 'https://va.ivrdeflect.liveperson.net',
                    ],

                    // Add more key sets here to use different instances of the alert API.
                ]
            ]
        ]);
    }

    public function createApplication()
	{
		if (getenv('SCRUT_TEST')) return parent::createApplication();

        $env = file_get_contents(__DIR__.'/../.env');

        $lines = explode("\n", $env);

        foreach ($lines as $line) {
            if ($line) putenv(trim($line));
        }

		return parent::createApplication();
	}
}
