<?php

namespace VoogApi;

use VoogApi\Exceptions\ApiException;
use VoogApi\Helpers\Url;

class Connection
{
	private $_host;
	private $_token;

	public function __construct($host, $token)
	{
		$this->_host = $host;
		$this->_token = $token;
	}

	public function getPage($pageId, $parameters = [])
	{
		$url = new Url("admin/api/pages/".$pageId, $parameters);
		return $this->_sendRequest($url);
	}

	public function getPageContents($pageId, $parameters = [])
	{
		$url = new Url("admin/api/pages/".$pageId."/contents", $parameters);
		return $this->_sendRequest($url);
	}

	public function getPages($parameters)
	{
		$url = new Url("admin/api/pages", $parameters);
		return $this->_sendRequest($url);
	}

	private function _sendRequest(Url $url)
    {
        if (!$this->_host or !$this->_token) {
            throw new \Exception('Missing parameters');
        }

        $fullUrl = $this->_host . $url->getUrlWithArgs();

        $handle = curl_init($fullUrl);

        curl_setopt_array($handle, $url->getCurlParameters());

        curl_setopt($handle, CURLOPT_HTTPHEADER,
            array(
                'X-API-TOKEN: ' . $this->_token,
                'Content-Type: application/json',
            )
        );
        curl_setopt($handle, CURLOPT_HEADER, 0);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);

        //run
        $response = curl_exec($handle);
        $error = curl_error($handle);
        $errorNumber = curl_errno($handle);

        $errorcode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);
        if ($errorcode < 200 || $errorcode >= 300) {
            throw new ApiException($response, $errorcode);
        }

        if ($error) {
            throw new ApiException('CURL error: ' . $response . ':' . $error . ': ' . $errorNumber);
        }

        return json_decode($response);
    }
}