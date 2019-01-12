<?php
namespace Admin\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Zend\Session\Container;
use Admin\Service\UsuarioService;

class Usuario extends AbstractHelper{
    protected $serviceManager;
    
    public function __construct($container){
        $this->serviceManager = $container;
    }
	
	public function __invoke(){
	    $session = new Container('Admin\Session');
	    if(!is_object($session->usuario)){return null;}
	    
	    return $this->serviceManager->get(UsuarioService::class)->get($session->usuario->getId());
	}
}