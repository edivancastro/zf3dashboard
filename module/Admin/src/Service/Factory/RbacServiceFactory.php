<?php
namespace Admin\Service\Factory;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Admin\Service\RbacService;

class RbacServiceFactory implements FactoryInterface{

	public function __invoke(ContainerInterface $container, $requestedName, array $options = null){
	    /*
	     * @var Zend\Cache\Storage
	     */
		$cache = $container->get('FilesystemCache');
		
		$entityManager = $container->get('doctrine.entitymanager.orm_default');
				

		return new RbacService($entityManager, $cache);
	}

}