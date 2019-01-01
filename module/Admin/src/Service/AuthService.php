<?php
namespace Admin\Service;

use Zend\Session\Container;
use Admin\Model\Usuario;

class AuthService extends ServiceAbstract{
	
	
	public function login($usuario, $senha){
		$result = $this->entityManager->createQueryBuilder()
		->select('a')
		->from('Admin\Model\Usuario','a')
		->where('a.login = :usuario')
		->andWhere('a.senha = :senha')
		->andWhere('a.status = :status')
		->setParameter('status',Usuario::STATUS_ATIVO)
		->setParameter('usuario', $usuario)
		->setParameter('senha', $senha)
		->getQuery()->getResult();
		
		if(!empty($result)){
			$this->entityManager->detach($result[0]);
			$this->session->usuario = $result[0];
			return true;
		}
		
		return false;
	}
	
	public function logout(){
		return $this->session->getManager()->getStorage()->clear('Admin\Session');
	}

}