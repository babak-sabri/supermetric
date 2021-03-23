<?php
use Supermetric\Service\SupermetricService;
use Supermetric\Service\SupermetricServiceInterface;
use Supermetric\Auth\AuthenticationInterface;
use Supermetric\Auth\Authentication;
use Supermetric\Repository\PostRepositoryInterface;
use Supermetric\Repository\PostRepository;
use Supermetric\RemoteApi\RemoteApiInterface;
use Supermetric\RemoteApi\RemoteApi;

return [
	/*
    |--------------------------------------------------------------------------
    | Client id
    |--------------------------------------------------------------------------
    |
    | The client id
    | 
    */
	'clientId'	=> 'ju16a6m81mhid5ue1z3v2g0uh',
	
	/*
    |--------------------------------------------------------------------------
    | Token URL
    |--------------------------------------------------------------------------
    |
    | Specify the token url
    | 
    */
	'TokenUrl'	=> 'https://api.supermetrics.com/assignment/register',
	
	/*
    |--------------------------------------------------------------------------
    | Post URL
    |--------------------------------------------------------------------------
    |
    | Specify the post url
    | 
    */
	'PostUrl'	=> 'https://api.supermetrics.com/assignment/posts',
	
	/*
    |--------------------------------------------------------------------------
    | Remote API call service
    |--------------------------------------------------------------------------
    */
	RemoteApiInterface::class	=> DI\create(RemoteApi::class),
	
	/*
    |--------------------------------------------------------------------------
    | Authentication service
    |--------------------------------------------------------------------------
    */
	AuthenticationInterface::class	=> DI\create(Authentication::class)
										->constructor(
											DI\get(RemoteApiInterface::class),
											'sabri.babak@gmail.com',
											'Babak Sabri'
										)
										 ->method('setTokenUrl', DI\get('TokenUrl'))
										 ->method('setClientId', DI\get('clientId'))
										,

	/*
    |--------------------------------------------------------------------------
    | Post Repository service
    |--------------------------------------------------------------------------
    */
	PostRepositoryInterface::class	=> DI\create(PostRepository::class)
										->constructor(DI\get(RemoteApiInterface::class))
										->method('setPostUrl', DI\get('PostUrl'))
										,

	/*
    |--------------------------------------------------------------------------
    | Supermetric service
    |--------------------------------------------------------------------------
    */
	SupermetricServiceInterface::class	=> DI\create(SupermetricService::class)
											->constructor(
												DI\get(AuthenticationInterface::class),
												DI\get(PostRepositoryInterface::class),
											)
];