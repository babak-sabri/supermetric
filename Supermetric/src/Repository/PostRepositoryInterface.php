<?php
namespace Supermetric\Repository;

interface PostRepositoryInterface
{
	/**
	 * 
	 * set the posts remote url
	 * 
	 * @param type $postUrl url
	 * @return void
	 */
	public function setPostUrl($postUrl): void;

	/**
	 * 
	 * return the posts remote url
	 * 
	 * @return string
	 */
	public function getPostUrl(): string;
	
	/**
	 * 
	 * set the remote API token
	 * 
	 * @param type $token
	 * @return void
	 */
	public function setToken($token) : void;
	
	/**
	 * 
	 * return  the remote API token
	 * 
	 * @return string
	 */
	public function getToken() : string;

	/**
	 * 
	 * get posts of specific page
	 * 
	 * @param type $pageNumber the page number
	 * @return array
	 * @throws PostException if the posts could not be read.
	 */
	public function getPosts($pageNumber): array;
}