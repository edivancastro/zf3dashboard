<?php
namespace Admin\View\Helper\Factory;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class Factory implements FactoryInterface{
	public function __invoke(ContainerInterface $container, $requestedName, array $options=null){
		return new $requestedName($container);
	}
}