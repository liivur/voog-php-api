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

	public function getPage($pageId, $params = [])
	{
		$parameters = array_merge(
			[
				'include_children' => 1,
			],
			$params
		);
		return $this->_connection->getPage($pageId, $parameters);
	}

	public function getPages($params = [])
	{
		$parameters = array_merge(
			[
				'page' => 1,
				'per_page' => 250,
			],
			$params
		);
		return $this->_connection->getPages($parameters);
	}
}