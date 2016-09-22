<?php

namespace VoogApi\Helpers;

class Url
{
	public $url;
	public $queryArgs;
	public $method;
	public $postFields;

	public function __construct($url, $queryArgs = [], $method = "GET", $postFields = [])
	{
		$this->url = $url;
		$this->queryArgs = $queryArgs;
		$this->method = $method;
		$this->postFields = $postFields;
	}

	public function getUrlWithArgs()
	{
		$fullUrl = $this->url;
		if (!empty($this->queryArgs)) {
            $fullUrl .= '?' . http_build_query($this->queryArgs);
        }
		return $fullUrl;
	}

	public function getCurlParameters()
	{
		return [
			CURLOPT_CUSTOMREQUEST => $this->method,
            CURLOPT_POSTFIELDS => json_encode($this->postFields),
		];
	}
}