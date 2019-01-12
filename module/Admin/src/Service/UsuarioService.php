<?php
namespace Admin\Service;

use Admin\Model\Usuario;
use Doctrine\Common\Collections\ArrayCollection;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as Adapter;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Zend\Paginator\Paginator;

class UsuarioService extends ServiceAbstract{
	
	public function salvar($usuario){
		$usuario->setStatus(Usuario::STATUS_ATIVO);
		
		if(empty($usuario->getRole())){
			throw new \Exception("� necessario informar uma func�o!");
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
	
	public function find($find=null){
		$query = $this->entityManager->createQueryBuilder()
					  ->select('u')
					  ->from('Admin\Model\Usuario','u')
					  ->join('u.role', 'r')
					  ->where('u.status = :status')
					  ->setParameter('status',Usuario::STATUS_ATIVO)
					  ->orderBy('u.id','ASC');
		if($find){
			$query->andWhere('u.nome like :find or u.login like :find or r.descricao like :find')
			->setParameter('find',"%$find%");
		}
		

		$adapter = new Adapter(new DoctrinePaginator($query->getQuery(),false));
    	$paginator = new Paginator($adapter);
    	$paginator->setItemCountPerPage(15);

		return $paginator;
	}

	
	
}