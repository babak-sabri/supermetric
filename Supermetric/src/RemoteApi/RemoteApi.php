<?php
namespace Supermetric\RemoteApi;

class RemoteApi implements RemoteApiInterface
{
	private $hasError		= 0;
	private $errorMessage	= '';
	private $statusCode		= 0;

	public function call(string $metod, string $url, array $data=[]): array
	{
		$resultArray	= [];
		if($metod==self::GET && !empty ($data)) {
			$url	.= '?'.http_build_query($data);
		}

		//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$ch				= curl_init($url);
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
	
	public function getStatusCode() : int
	{
		return $this->statusCode;
	}
	
	public function hasError() : int
	{
		return $this->hasError;
	}
	
	public function getErrorMessage() : string
	{
		return $this->errorMessage;
	}

	public function get(string $url, array $data): array
	{
		return $this->call(self::GET, $url, $data);
	}

	public function post(string $url, array $data): array
	{
		return $this->call(self::POST, $url, $data);
	}
}