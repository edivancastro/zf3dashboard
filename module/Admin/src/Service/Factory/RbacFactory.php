<?php
namespace Admin\Service\Factory;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Cache\Storage\

class RbacFactory implements FactoryInterface{

	public function __invoke(ContainerInterface $container, $requestedName, array $options = null){
		$cache = $container->get('FilesystemCache');
		$entityManager = $container->get('doctrine.entitymanager.orm_default');

		$config = $container->get('Config');

		if(isset($config['rbac_manager']['assertions'])){
			$assertionManager=[];
			foreach($config['rbac_manager']['assertions'] as $service){
				$assertionManagers[$service] = $container->get($service);
			}
		}

		return new RbacManager($entitymanager, $cache, $assertionManagers);
	}

}