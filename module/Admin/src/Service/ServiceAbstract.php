<?php
namespace Admin\Service;

use Doctrine\ORM\EntityManager;
use Zend\Session\Container;

abstract class ServiceAbstract{
	protected $entityManager;
	protected $session;

	public function __construct(EntityManager $em){
		$this->entityManager = $em;
		$this->session = new Container('Admin\Session');
	}
}