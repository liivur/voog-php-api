<?php

namespace VoogApi;

use VoogApi\Connection;

class Client
{
	private $_connection;

	public function __construct($host, $token)
	{
		$this->setConnection($host, $token);
	}

	public function setConnection($host, $token)
	{
		$this->_connection = new Connection($host, $token);
	}

	public function getPage($pageId, $parameters = [])
	{
		$defaultArgs = [
			'include_children' => 1,
		];
		return $this->_connection->getPage($pageId, array_merge($defaultArgs, $parameters));
	}

	public function getPageContents($pageId, $parameters = [])
	{
		$defaultArgs = [
			'page' => 1,
			'per_page' => 250,
		];
		return $this->_connection->getPageContents($pageId, array_merge($defaultArgs, $parameters));
	}

	public function getPages($parameters = [])
	{
		$defaultArgs = [
			'page' => 1,
			'per_page' => 250,
		];
		return $this->_connection->getPages(array_merge($defaultArgs, $parameters));
	}
}