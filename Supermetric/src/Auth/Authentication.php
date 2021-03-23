<?php
namespace Supermetric\Auth;

use Supermetric\RemoteApi\RemoteApiInterface;
use Supermetric\Exception\TokenException;

class Authentication implements AuthenticationInterface
{
	private $remoteApi;
	private $email;
	private $name;
	private $tokenUrl;
	private $clientId;
	
	public function __construct(RemoteApiInterface $remoteApi, $email, $name)
	{
		$this->remoteApi	= $remoteApi;
		$this->email		= $email;
		$this->name			= $name;
	}
	
	public function setClientId(string $clientId) : void
	{
		$this->clientId	= $clientId;
	}
	
	public function getclientId() : string
	{
		return $this->clientId;
	}
	
	public function setTokenUrl(string $tokenUrl) : void
	{
		$this->tokenUrl	= $tokenUrl;
	}
	
	public function getTokenUrl() : string
	{
		return $this->tokenUrl;
	}
	
	public function getToken(): string
	{
		$data	= $this->remoteApi->post($this->getTokenUrl(), [
			'client_id'	=> $this->getclientId(),
			'email'		=> $this->email,
			'name'		=> $this->name,
		]);
		
		if(!isset($data['data']['sl_token']) || empty($data['data']['sl_token'])) {
			if(isset($data['error']['message'])) {
				$this->log($data['error']['message']);
			}
			throw new TokenException('Token could not be taken.');
		}
		
		return $data['data']['sl_token'];
	}
	
	private function log($message)
	{
		
	}
}