<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Interop\Container\ContainerInterface;
use Zend\Session\SessionManager;
use Zend\Session\Container;
use Admin\Service\Logger;

abstract class ControllerAbstract extends AbstractActionController{
	protected $serviceManager;
	protected $session;
	protected $log;

	public function __construct(ContainerInterface $sm){
		$this->serviceManager = $sm;
		$sessionManager = $this->serviceManager->get(SessionManager::class);
		Container::setDefaultManager($sessionManager);
		$this->session = new Container('Admin\Session');
		$this->log = $sm->get(Logger::class);
	}
}