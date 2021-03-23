<?php
require __DIR__.'/vendor/autoload.php';

use Supermetric\Service\SupermetricServiceInterface;
header('Content-Type: application/json');
set_time_limit (0);
$builder	= new DI\ContainerBuilder();
$builder->addDefinitions(__DIR__.'/config/config.php');
$container = $builder->build();
date_default_timezone_set('GMT');
$exitCode	= 200;
try {
	$supermetricService	= $container->get(SupermetricServiceInterface::class);
	$data				= $supermetricService->getStatistics();
} catch (Exception $ex) {
	$data	= [
		'error'		=> true,
		'message'	=> $ex->getMessage()
	];
	$exitCode	= 500;
}


echo json_encode($data);
exit($exitCode);
