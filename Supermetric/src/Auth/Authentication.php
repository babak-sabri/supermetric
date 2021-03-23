<?php
namespace Supermetric\Auth;

use Supermetric\RemoteApi\RemoteApiInterface;
use Supermetric\Exception\TokenException;

class Authentication implements AuthenticationInterface
{
	/**
	 * remote api call service.
	 * 
	 * @var RemoteApiInterface 
	 */
	private $remoteApi;
	
	/**
	 * the login email for remote api.
	 *
	 * @var string 
	 */
	private $email;
	
	/**
	 * the login name for remote api.
	 * 
	 * @var string 
	 */
	private $name;
	
	/**
	 * token url
	 *
	 * @var string 
	 */
	private $tokenUrl;
	
	/**
	 * the client id
	 * 
	 * @var string 
	 */
	private $clientId;
	
	/**
	 * 
	 * @param RemoteApiInterface $remoteApi
	 * @param type $email
	 * @param type $name
	 */
	public function __construct(RemoteApiInterface $remoteApi, $email, $name)
	{
		$this->remoteApi	= $remoteApi;
		$this->email		= $email;
		$this->name			= $name;
	}
	
	/**
	 * set the client id
	 * 
	 * @param string $clientId the client id
	 * @return void
	 */
	public function setClientId(string $clientId) : void
	{
		$this->clientId	= $clientId;
	}
	
	/**
	 * get client id
	 * 
	 * @return string client id
	 */
	public function getclientId() : string
	{
		return $this->clientId;
	}
	
	/**
	 * set the remote token URL
	 * 
	 * @param string $tokenUrl token URL
	 * @return void
	 */
	public function setTokenUrl(string $tokenUrl) : void
	{
		$this->tokenUrl	= $tokenUrl;
	}
	
	/**
	 * get the token URL
	 * 
	 * @return string token URL
	 */
	public function getTokenUrl() : string
	{
		return $this->tokenUrl;
	}
	
	/**
	 * retrieve a token and return it
	 * 
	 * @return string token
	 * @throws TokenException if token could not be taken.
	 */
	public function getToken(): string
	{
		//Get token
		$data	= $this->remoteApi->post($this->getTokenUrl(), [
			'client_id'	=> $this->getclientId(),
			'email'		=> $this->email,
			'name'		=> $this->name,
		]);
		
		if(!isset($data['data']['sl_token']) || empty($data['data']['sl_token'])) {
			//Log remote api error
			if(isset($data['error']['message'])) {
				$this->log($data['error']['message']);
			}
			throw new TokenException('Token could not be taken.');
		}
		
		//return the token
		return $data['data']['sl_token'];
	}
	
	/**
	 * 
	 * log the error
	 * 
	 * @param type $message
	 */
	private function log($message)
	{
		
	}
}