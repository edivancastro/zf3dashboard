<?php
namespace Admin\Service;

use Admin\Model\Usuario;
use Doctrine\Common\Collections\ArrayCollection;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as Adapter;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Zend\Paginator\Paginator;

class UsuarioService extends ServiceAbstract{
	
	public function cadastrar($usuario){
		$usuario->setStatus(Usuario::STATUS_ATIVO);
		
		if(empty($usuario->getRole())){
			throw new \Exception("É necessário informar uma função!");
		}
		
		$this->entityManager->persist($usuario);
		$this->entityManager->flush();
		return $this;
	}
	
	public function editar($usuario){
		if(empty($usuario->getRole())){
			throw new \Exception("É necessário informar uma função!");
		}
		
		$this->entityManager->persist($usuario);
		
		$this->entityManager->flush();
		return $this;
	}
	
	public function remover($id){
		$usuario = $this->entityManager->getRepository(Usuario::class)->find($id);
		$usuario->setStatus(Usuario::STATUS_EXCLUIDO);
		$this->entityManager->persist($usuario);
		$this->entityManager->flush();
		return $this;
	}

	public function desativar($id){
		$usuario = $this->entityManager->getRepository(Usuario::class)->find($id);
		$usuario->setStatus(Usuario::STATUS_DESATIVADO);
		$this->entityManager->persist($usuario);
		$this->entityManager->flush();
		return $this;
	}
	
	public function get($id){
		return $this->entityManager->getRepository(Usuario::class)->findOneBy(['status'=>Usuario::STATUS_ATIVO, 'id'=>$id]);
	}
	
	public function getAll(){
		return $this->entityManager->getRepository(Usuario::class)->findByStatus(Usuario::STATUS_ATIVO);
	}

	
	
}