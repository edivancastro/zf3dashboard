<?php
namespace Admin\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Admin\Model\Usuario;
use Admin\Service\RbacService;

class PermissaoPlugin extends AbstractPlugin{
    protected $rbacService;
    
    public function __construct(RbacService $rbac){
        $this->rbacService = $rbac;
    }
    
    public function __invoke(Usuario $usuario, $permissao){
        return $this->rbacService->isGranted($usuario, $permissao);
    }
    
}