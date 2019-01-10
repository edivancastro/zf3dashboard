<?php
namespace Admin\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Admin\Service\AuthService;

class Permissao extends AbstractHelper{
    protected $serviceManager;
    
    public function __construct($container){
        $this->serviceManager = $container;    
    }
    
    public function __invoke($url){
        $request = new \Zend\Http\Request();
        $request->setUri($url);        
        
        $router = $this->serviceManager->get('Router');
        $routeMatch = $router->match($request);
        
        if ($routeMatch) {
            $params = $routeMatch->getParams();
            
            $controller = $params['controller'];
            $action = $params['action'];
            unset($params['controller']);
            unset($params['action']);

            return $this->serviceManager->get(AuthService::class)->filtrar($controller, $action, $params);
        }
    }


}