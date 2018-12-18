<?php
namespace Admin\Service;

use Doctrine\ORM\EntityManager;

abstract class ServiceAbstract{
	protected $entityManager;
	
	public function __construct(EntityManager $em){
		$this->entityManager = $em;
	}
}