<?php
namespace Admin\Controller\Plugin\Factory;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Admin\Service\RbacService;
use Admin\Controller\Plugin\PermissaoPlugin;

class PermissaoPluginFactory implements FactoryInterface{
    
    public function __invoke(ContainerInterface $container, $requestedName,array $options=null){
        $rbac = $container->get(RbacService::class);
        return new PermissaoPlugin($rbac); 
    }
}