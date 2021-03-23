<?php
namespace Supermetric\Auth;

interface AuthenticationInterface
{
	/**
	 * set the client id
	 * 
	 * @param string $clientId the client id
	 * @return void
	 */
	public function setClientId(string $clientId) : void;
	
	/**
	 * get client id
	 * 
	 * @return string  client id
	 */
	public function getclientId() : string;
	
	/**
	 * set the remote token URL
	 * 
	 * @param string $tokenUrl token URL
	 * @return void
	 */
	public function setTokenUrl(string $tokenUrl) : void;
	
	/**
	 * get the token URL
	 * 
	 * @return string token URL
	 */
	public function getTokenUrl() : string;
	
	/**
	 * retrieve a token and return it
	 * 
	 * @return string token
	 * @throws TokenException if token could not be taken.
	 */
	public function getToken(): string;
}