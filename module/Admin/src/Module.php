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
use Admin\Service\ConfigService;
use Admin\Controller\LoginController;
use Admin\Service\AuthService;

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

            if(is_object($matchedRoute)){

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
        }

        $eventManager = $event->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH,[$this, 'verificaAutenticacao']);
        
        $config = $serviceManager->get(ConfigService::class)->get();

        if(!empty($config)){
            date_default_timezone_set($config->getTimezone());
        }
    }

    public function verificaAutenticacao(MvcEvent $event){
        
        $controllerName = $event->getRouteMatch()->getParam('controller', null);
        $actionName = $event->getRouteMatch()->getParam('action', null);
       
        $authService = $event->getApplication()->getServiceManager()->get(AuthService::class);
        
        if($controllerName<>LoginController::class){
            $result = $authService->filtrar($controllerName, $actionName);

            $controller = $event->getTarget();
            
            if($result == AuthService::REQUER_AUTH){ 
                return $controller->redirect()->toRoute('login');
            }elseif($result == AuthService::ACESSO_NEGADO){
                 return $controller->redirect()->toRoute('acessonegado');
            }
        }
    }



}