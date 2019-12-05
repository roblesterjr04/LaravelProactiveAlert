<?php

namespace Lester\ProactiveAlert;

use GuzzleHttp\Client as HttpRequest;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Illuminate\Support\Arr;

class ProactiveAlertBuilder
{

    private $keyset;
    private $body = '';

    public function __construct()
    {
        $this->keyset = config('proactive.default');
    }

    public function body($body)
    {
        $this->body = $body;
        return $this;
    }

    public function key($key)
    {
        $this->keyset = $key;
        return $this;
    }

    public function test()
    {
        return true;
    }

    private function config($keyset = null)
    {
        $keyset = $keyset ?: $this->keyset;

        $config = config('proactive.keysets.' . $keyset);

        return $config;
    }

    /**
	 * requestClient
	 *
	 * @access private
	 * @return \GuzzleHttp\Client
	 * @param bool $noauth (default: false)
	 */
	private function client()
	{
        $config = $this->config();

        $stack = HandlerStack::create();
		$auth = new Oauth1(array_merge(Arr::only($config, [
            'consumer_key',
            'consumer_secret',
            'token',
            'token_secret'
        ]), [
			'signature_method'=> Oauth1::SIGNATURE_METHOD_HMAC,
		]));
        $stack->push($auth);
		$client = new HttpRequest([
			'handler' => $stack,
			'auth' => 'oauth',
			'base_uri' => $config['domain'],
			'headers' => [
	        	'content-type' => 'application/json',
	        	'cache-control' => 'no-cache',
	        	'accept' => 'application/json'
        	],
		]);

		return $client;
	}

    public function submit()
    {
        $url = '/api/proactivealert/';
        $config = $this->config();

        $body = [
            'skill' => '',
            'siteId' => $config['site_id'],
            'customerCountryCode' => '1',
            'customerPhoneNumber' => '7179659230',
            'externalCustomerId' => '',
            'externalCustomerIdDescriptor' => '',
            'externalAlertId' => '',
            'alertInfo' => new \StdClass(),
            'firstName' => '',
            'lastName' => '',
            'proactiveChannel' => '',
            'proactiveLanguage' => '',
            'proactiveTemplate' => 'Proactive_Outbound',
            'proactiveVariables' => [
                'sms_text' => $this->body
            ],
        ];
        $response = json_decode($this->client()->post($url, [
            'json' => $body,
        ])->getBody());

    }

}
