<?php
namespace Supermetric\Repository;

use Supermetric\RemoteApi\RemoteApiInterface;
use Supermetric\Exception\PostException;
use Exception;

class PostRepository implements PostRepositoryInterface
{
	private $remoteApi;
	private $postUrl;
	private $token;
	
	public function __construct(RemoteApiInterface $remoteApi)
	{
		$this->remoteApi	= $remoteApi;
	}

	public function setPostUrl($postUrl): void
	{
		$this->postUrl	= $postUrl;
	}

	public function getPostUrl(): string
	{
		return $this->postUrl;
	}
	
	public function setToken($token) : void
	{
		$this->token	= $token;
	}
	
	public function getToken() : string
	{
		return $this->token;
	}

	public function getPosts($pageNumber): array
	{
		
		$data	= $this->remoteApi->get($this->postUrl, [
			'sl_token'	=> $this->getToken(),
			'page'		=> $pageNumber
		]);
		
		if(!isset($data['data']['posts']) || empty($data['data']['posts'])) {
			if(isset($data['error']['message'])) {
				$this->log($data['error']['message']);
			}
			throw new PostException('Posts could not be read.');
		}
		
		return $data['data']['posts'];
	}
	
	private function log($message)
	{
		
	}
}