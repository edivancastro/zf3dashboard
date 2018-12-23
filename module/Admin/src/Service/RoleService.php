<?php
namespace Admin\Service;


use Admin\Model\Role;
use Admin\Model\Permissao;
use Admin\Model\Recurso;

class RoleService extends ServiceAbstract{
	
	public function cadastrar($role){
		$this->entityManager->persist($role);
		$this->entityManager->flush();
		return $this;
	}
	
	public function editar($role){
	    $this->entityManager->persist($role);
	    $this->entityManager->flush();
	    return $this;
	}
	
	public function remover($id){
		$role = $this->entityManager->getRepository(Role::class)->find($id);
		$role->setExcluido(true);
		$this->entityManager->persist($role);
		$this->entityManager->flush();
		return $this;
	}
	
	public function get($id){
		return $this->entityManager->getRepository(Role::class)->find($id);
	}
	
	public function getAll(){
		return $this->entityManager->getRepository(Role::class)->findBy(['excluido'=>false]);
	}
	
	public function getAllPermissoes(){
	    return $this->entityManager->getRepository(Permissao::class)->findAll();
	}
	
	public function getPermissao($id){
	    return $this->entityManager->getRepository(Permissao::class)->find($id);
	}
	
	public function getAllRecursos(){
	    return $this->entityManager->getRepository(Recurso::class)->findAll();
	}

}