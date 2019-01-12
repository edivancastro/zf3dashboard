<?php
namespace Admin\Service\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Admin\Service\AuthService;
use Admin\Service\RbacService;

class AuthServiceFactory implements FactoryInterface{
    
    public function __invoke(ContainerInterface $container, $requestedName, array $options=null){
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $config = $container->get('Config');
        $RbacService = $container->get(RbacService::class);
        
        return new AuthService($entityManager,$config['filtro'], $RbacService);
    }
}