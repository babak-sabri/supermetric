<?php
namespace Supermetric\RemoteApi;

class RemoteApi implements RemoteApiInterface
{
	/**
	 * 
	 * set the curl error number
	 * 
	 * @var integer
	 */
	private $hasError		= 0;
	
	/**
	 * 
	 * set the error message
	 * 
	 * @var string
	 */
	private $errorMessage	= '';
	
	/**
	 * API response status code
	 * 
	 * @var integer
	 */
	private $statusCode		= 0;

	/**
	 * 
	 * Call a remote API
	 * 
	 * @param string $metod the call method type (POST|GET)
	 * @param string $url the remote url
	 * @param array $data data for sending to remote API
	 * @return array the result
	 */
	public function call(string $metod, string $url, array $data=[]): array
	{
		$resultArray	= [];
		
		//if the request is GET the data should be transfered to query string
		if($metod==self::GET && !empty ($data)) {
			$url	.= '?'.http_build_query($data);
		}

		$ch				= curl_init($url);
		
		
		//if the request is POST the data should be added as request body
		if($metod==self::POST) {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		}
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT,30);
		$result	= curl_exec($ch);
		$this->statusCode	= curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if (curl_errno($ch)) {
			$this->hasError	= curl_errno($ch);
			$this->errorMessage = curl_error($ch);
		} else {
			$resultArray	= json_decode($result, true);
		}

		curl_close($ch);
		return $resultArray;
	}
	
	/**
	 * 
	 * return the api status code
	 * 
	 * @return int
	 */
	public function getStatusCode() : int
	{
		return $this->statusCode;
	}
	
	/**
	 * 
	 * if the request has error return true
	 * 
	 * @return bool
	 */
	public function hasError() : bool
	{
		return $this->hasError>0;
	}
	
	/**
	 * 
	 * get request error message
	 * 
	 * @return string
	 */
	public function getErrorMessage() : string
	{
		return $this->errorMessage;
	}

	/**
	 * 
	 * Call a GET request
	 * 
	 * @param string $url the remote url
	 * @param array $data data for sending to remote API
	 * @return array the result
	 */
	public function get(string $url, array $data): array
	{
		return $this->call(self::GET, $url, $data);
	}

	/**
	 * 
	 * Call a POST request
	 * 
	 * @param string $url the remote url
	 * @param array $data data for sending to remote API
	 * @return array the result
	 */
	public function post(string $url, array $data): array
	{
		return $this->call(self::POST, $url, $data);
	}
}