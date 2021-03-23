<?php
namespace Supermetric\Service;

interface SupermetricServiceInterface
{
	public function getStatistics(int $maxPageNum=10) : array;
}