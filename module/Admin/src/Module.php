<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

use Zend\EventManager\EventInterface as Event;
use Zend\Session\Container;
use Zend\Mvc\MvcEvent;

class Module
{
    const VERSION = '3.0.3-dev';

    protected $routeName;
    protected $controllerName;
    protected $actionName; 

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function onBootstrap(Event $event){
    	$serviceManager = $event->getApplication()->getServiceManager();
    	$router = $serviceManager->get('Router');
    	$request = $serviceManager->get('Request');
    	$matchedRoute = $router->match($request);

    	$params = $matchedRoute->getParams();

        $controller = explode('\\', $params['controller']);
        $this->controllerName = array_pop($controller);
        $this->actionName = $params['action'];
        $this->routeName = $matchedRoute->getMatchedRouteName();

        $view = $event->getViewModel();

        $view->setVariables(
            array(
                'CURRENT_CONTROLLER_NAME' => $this->controllerName,
                'CURRENT_ACTION_NAME' => $this->actionName,
                'CURRENT_ROUTE_NAME' => $this->routeName,
            )
        );

        $eventManager = $event->getApplication()->getEventManager();

        $eventManager->attach(MvcEvent::EVENT_DISPATCH,[$this, 'verificaAutenticacao']);

    }

    public function verificaAutenticacao(MvcEvent $event){
        $session = new Container('Admin\Session');

        if(!is_object($session->usuario) && $this->routeName<>'login'){
            $controller = $event->getTarget();
            $controller->redirect()->toRoute('login');
        }
    }

    
}
