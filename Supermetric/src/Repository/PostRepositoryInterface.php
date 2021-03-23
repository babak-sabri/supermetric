<?php
namespace Supermetric\Repository;

interface PostRepositoryInterface
{
	public function setPostUrl(string $postUrl) : void;
	
	public function getPostUrl() : string;
	
	public function getPosts($pageNumber) : array;
	
	public function setToken($token) : void;
	
	public function getToken() : string;
}