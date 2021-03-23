<?php
namespace Supermetric\Auth;

interface AuthenticationInterface
{
	public function getToken(): string;
	
	public function setTokenUrl(string $tokenUrl) : void;
	
	public function getTokenUrl() : string;
}