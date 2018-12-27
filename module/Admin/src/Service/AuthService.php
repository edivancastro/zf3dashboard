<?php
namespace Admin\Service;

use Zend\Session\Container;
use Doctrine\ORM\EntityManager;

class AuthService extends ServiceAbstract{
	private $session;
	
	public function __construct(EntityManager $em){
		parent::__construct($em);
		$this->session = new Container('Admin\Session');
	}
	
	public function login($usuario, $senha){
		$result = $this->entityManager->createQueryBuilder()
		->select('a')
		->from('Admin\Model\Usuario','a')
		->where('a.login = :usuario')
		->andWhere('a.senha = :senha')
		->setParameter('usuario', $usuario)
		->setParameter('senha', $senha)
		->getQuery()->getResult();
		
		if(!empty($result)){
			$this->session->usuario = $result[0];
			return true;
		}
		
		return false;
	}

	public function getUser(){
		return $this->session->usuario;
	}	
	
	public function logout(){
		return $this->session->getManager()->getStorage()->clear('Admin\Session');
	}

}