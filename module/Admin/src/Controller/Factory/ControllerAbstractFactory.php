<?php
namespace Admin\Controller\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Admin\Controller\LoginController;
use Admin\Service\AuthService;

class ControllerAbstractFactory implements FactoryInterface{
	
	public function __invoke(ContainerInterface $container, $requestedName, array $options=null){
		return new $requestedName($container);
		
	}
}