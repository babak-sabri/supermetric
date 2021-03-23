<?php
namespace Supermetric\RemoteApi;

interface RemoteApiInterface
{
	const POST	= 'POST';
	const GET	= 'GET';
	
	public function get(string $url, array $data) : array;
	
	public function post(string $url, array $data) : array;
	
	public function call(string $metod, string $url, array $data=[]) : array;
	
	public function hasError() : int;
	
	public function getErrorMessage() : string;
	
	public function getStatusCode() : int;
}