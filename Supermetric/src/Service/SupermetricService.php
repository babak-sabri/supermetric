<?php
namespace Supermetric\Service;

use Supermetric\Auth\AuthenticationInterface;
use Supermetric\Repository\PostRepositoryInterface;

class SupermetricService implements SupermetricServiceInterface
{
	private $auth;
	private $repository;

	public function __construct(AuthenticationInterface $auth, PostRepositoryInterface $repository)
	{
		$this->auth			= $auth;
		$this->repository	= $repository;
		$this->repository->setToken(
			$this->auth->getToken()
		);
	}

	public function getStatistics(int $maxPageNum=10): array
	{
		$monthCharSum			= [];
		$monthMaxPost			= [];
		$weekPostsSum			= [];
		$userMonthPostsSum		= [];
		$monthAvarage			= [];
		$userPerMonthAverage	= [];
		$userData				= [];
		for($pageNumber	= 1; $pageNumber <= $maxPageNum; $pageNumber++) {
			$posts	= $this->repository->getPosts($pageNumber);
			foreach ($posts as $post) {
				$postTime					= strtotime($post['created_time']);
				$month						= date('Y-m-F', $postTime);
				$weekNumber					= date('YW', $postTime);
				$userData[$post['from_id']]	= $post['from_name'];
				if(!isset($monthCharSum[$month])) {
					$monthCharSum[$month]	= [
						'char_sum'	=> 0,
						'post_num'	=> 0,
					];
					$monthMaxPost[$month]	= [
						'year'		=> date('Y', $postTime),
						'month'		=> date('F', $postTime),
						'length'	=> 0
					];
				}
				
				if(!isset($weekPostsSum[$weekNumber])) {
					$weekPostsSum[$weekNumber]	= [
						'week_number'	=> $weekNumber,
						'post_count'	=> 0,
					];
				}
				if(!isset($userMonthPostsSum[$post['from_id']][$month])) {
					$userMonthPostsSum[$post['from_id']][$month]	= 0;
				}
				
				$weekPostsSum[$weekNumber]['post_count']++;
				$postLength				= strlen($post['message']);
				$monthCharSum[$month]['char_sum']	+= $postLength;
				$monthCharSum[$month]['post_num']++;
				
				if($monthMaxPost[$month]['length']<$postLength) {
					$monthMaxPost[$month]['length']	= $postLength;
					$monthMaxPost[$month]['post']	= $post;
				}
				$userMonthPostsSum[$post['from_id']][$month]++;
			}
		}
		
		ksort($monthCharSum);
		ksort($monthMaxPost);
		ksort($weekPostsSum);
		ksort($userMonthPostsSum);
		foreach ($monthCharSum as $date=>$value) {
			$date	= explode('-', $date);
			$monthAvarage[]	= [
				'year'	=> $date[0],
				'month'	=> $date[2],
				'average'	=> round($value['char_sum']/$value['post_num'], 2)
			];
		}

		foreach ($userMonthPostsSum as $userId=>$data) {
			$userPerMonthAverage[]	= [
				'from_id'		=> $userId,
				'from_name'		=> $userData[$userId],
				'average_posts'	=> round(array_sum($data)/count($data), 2)
			];
		}
		
		return [
			'avg_char'		=> $monthAvarage,
			'month_longest'	=> array_values($monthMaxPost),
			'week_posts'	=> array_values($weekPostsSum),
			'avg_user_post'	=> $userPerMonthAverage,
		];
	}
}