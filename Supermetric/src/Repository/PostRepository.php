<?php
namespace Supermetric\Repository;

use Supermetric\RemoteApi\RemoteApiInterface;
use Supermetric\Exception\PostException;

class PostRepository implements PostRepositoryInterface
{
	/**
	 * remote api call service.
	 * 
	 * @var RemoteApiInterface 
	 */
	private $remoteApi;
	
	/**
	 * the posts url.
	 *
	 * @var string 
	 */
	private $postUrl;
	
	/**
	 * 
	 * the token
	 * 
	 * @var string
	 */
	private $token;
	
	/**
	 * 
	 * @param RemoteApiInterface $remoteApi
	 */
	public function __construct(RemoteApiInterface $remoteApi)
	{
		$this->remoteApi	= $remoteApi;
	}

	/**
	 * 
	 * set the posts remote url
	 * 
	 * @param type $postUrl url
	 * @return void
	 */
	public function setPostUrl($postUrl): void
	{
		$this->postUrl	= $postUrl;
	}

	/**
	 * 
	 * return the posts remote url
	 * 
	 * @return string
	 */
	public function getPostUrl(): string
	{
		return $this->postUrl;
	}
	
	/**
	 * 
	 * set the remote API token
	 * 
	 * @param type $token
	 * @return void
	 */
	public function setToken($token) : void
	{
		$this->token	= $token;
	}
	
	/**
	 * 
	 * return  the remote API token
	 * 
	 * @return string
	 */
	public function getToken() : string
	{
		return $this->token;
	}

	/**
	 * 
	 * get posts of specific page
	 * 
	 * @param type $pageNumber the page number
	 * @return array
	 * @throws PostException if the posts could not be read.
	 */
	public function getPosts($pageNumber): array
	{
		//Read the posts
		$data	= $this->remoteApi->get($this->postUrl, [
			'sl_token'	=> $this->getToken(),
			'page'		=> $pageNumber
		]);
		
		if(!isset($data['data']['posts']) || empty($data['data']['posts'])) {
			//Log the remote server error
			if(isset($data['error']['message'])) {
				$this->log($data['error']['message']);
			}
			throw new PostException('Posts could not be read.');
		}
		
		//return the posts
		return $data['data']['posts'];
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