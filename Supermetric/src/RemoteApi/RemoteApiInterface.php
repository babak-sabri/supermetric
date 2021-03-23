<?php
namespace Supermetric\RemoteApi;

interface RemoteApiInterface
{
	const POST	= 'POST';
	const GET	= 'GET';
	
	/**
	 * 
	 * Call a remote API
	 * 
	 * @param string $metod the call method type (POST|GET)
	 * @param string $url the remote url
	 * @param array $data data for sending to remote API
	 * @return array the result
	 */
	public function call(string $metod, string $url, array $data=[]): array;
	
	/**
	 * 
	 * return the api status code
	 * 
	 * @return int
	 */
	public function getStatusCode() : int;
	
	/**
	 * 
	 * if the request has error return true
	 * 
	 * @return bool
	 */
	public function hasError() : bool;
	
	/**
	 * 
	 * get request error message
	 * 
	 * @return string
	 */
	public function getErrorMessage() : string;

	/**
	 * 
	 * Call a GET request
	 * 
	 * @param string $url the remote url
	 * @param array $data data for sending to remote API
	 * @return array the result
	 */
	public function get(string $url, array $data): array;

	/**
	 * 
	 * Call a POST request
	 * 
	 * @param string $url the remote url
	 * @param array $data data for sending to remote API
	 * @return array the result
	 */
	public function post(string $url, array $data): array;
}