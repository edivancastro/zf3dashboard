<?php
namespace Admin\Service\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Admin\Service\AuthService;

class ServiceFactory implements FactoryInterface{
	
	public function __invoke(ContainerInterface $container, $requestedName, array $options=null){
		$entityManager = $container->get('doctrine.entitymanager.orm_default');
		
		return new $requestedName($entityManager);
	}
}