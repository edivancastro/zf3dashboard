<?php
namespace Admin\Service;


use Admin\Model\Role;

class RoleService extends ServiceAbstract{
	
	public function cadastrar($role){
		
	}
	
	public function editar($role){
		
	}
	
	public function remover($id){
		
	}
	
	public function get($id){
		return $this->entityManager->getRepository(Role::class)->find($id);
	}
	
	public function getAll(){
		return $this->entityManager->getRepository(Role::class)->findBy(['excluido'=>false]);
	}

}