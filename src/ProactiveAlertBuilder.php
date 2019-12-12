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
    private $channel;
    private $template;
    private $number;
    private $code = 1;
    private $skill;
    private $language;

    public function __construct()
    {
        $this->keyset = config('proactive.default');
        $this->language = config('proactive.keysets.' . $this->keyset . '.language', 'en_US');
        $this->template = config('proactive.keysets.' . $this->keyset . '.template', 'Proactive_Outbound');
        $this->channel = config('proactive.keysets.' . $this->keyset . '.channel', 'sms');
    }

    public function language($lang)
    {
        $this->language = $lang;
        return $this;
    }

    public function skill($skill)
    {
        $this->skill = $skill;
        return $this;
    }

    public function body($body)
    {
        $this->body = $body;
        return $this;
    }

    public function to($number)
    {
        $this->number = $number;
        return $this;
    }

    public function code($code)
    {
        $this->code = $code;
        return $this;
    }

    public function channel($channel)
    {
        $this->channel = $channel;
        return $this;
    }

    public function template($template)
    {
        $this->template = $template;
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
            'skill' => $this->skill,
            'siteId' => $config['site_id'],
            'customerCountryCode' => $this->code,
            'customerPhoneNumber' => $this->number,
            'externalCustomerIdDescriptor' => 'VIP',
            'alertInfo' => [],
            'proactiveChannel' => $this->channel,
            'proactiveLanguage' => $this->language,
            'proactiveTemplate' => $this->template,
            'proactiveVariables' => [
                'sms_text' => $this->body
            ],
        ];

        $response = json_decode($this->client()->post($url, [
            'json' => $body,
        ])->getBody());

        return $response;
    }

}
