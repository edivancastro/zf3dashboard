<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Interop\Container\ContainerInterface;
use Zend\Session\SessionManager;
use Zend\Session\Container;

abstract class ControllerAbstract extends AbstractActionController{
	protected $serviceManager;
	protected $session;
	public function __construct(ContainerInterface $sm){
		$this->serviceManager = $sm;
		$sessionManager = $this->serviceManager->get(SessionManager::class);
		Container::setDefaultManager($sessionManager);
		$this->session = new Container('Admin\Session');
	}
}