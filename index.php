<?php

require __DIR__.'/vendor/autoload.php';

use Supermetric\Service\SupermetricServiceInterface;
header('Content-Type: application/json');
set_time_limit (0);

//DI process
$builder	= new DI\ContainerBuilder();
$builder->addDefinitions(__DIR__.'/config/config.php');
$container = $builder->build();


date_default_timezone_set('GMT');
$exitCode	= 200;
try {
	//Retrive the service
	$supermetricService	= $container->get(SupermetricServiceInterface::class);
	
	//Get statistics
	$data				= $supermetricService->getStatistics();
} catch (Exception $ex) {
	$data	= [
		'error'		=> true,
		'message'	=> $ex->getMessage()
	];
	$exitCode	= 500;
}

//Generate the response
echo json_encode($data);
exit($exitCode);
