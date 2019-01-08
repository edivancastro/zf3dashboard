<?php
namespace Admin\Service;

use Admin\Model\Artigo;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as Adapter;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Zend\Paginator\Paginator;

class ArtigoService extends ServiceAbstract{
    
    public function get($id){
        return $this->entityManager->getRepository(Artigo::class)->findBy(['id'=>$id]);    
    }
    
    public function salvar(Artigo $artigo){
        $this->entityManager->persist($artigo);
        $this->entityManager->flush();
        return $this;
    }
    
    public function remover($id){
        $artigo = $this->entityManager->getRepository(Artigo::class)->find($id);
        if(!is_object($artigo)){return false;}
        $artigo->setExcluido(true);
        $this->entityManager->persist($artigo);
        $this->entityManager->flush();
        return $this;
    }

    public function find($query=null){
    	$q = $this->entityManager->createQueryBuilder()
    			  ->select('a')
    			  ->from('Admin\Model\Artigo','a')
    			  ->join('a.categoria', 'c')
    			  ->where('a.excluido=false')
    	          ->orderBy("a.id",'desc');
        if($query){
    	   $q->andwhere('a.titulo like :query or c.descricao like :query')
    	     ->setParameter('query',"%$query%");
    	}
    	
    	
    	$adapter = new Adapter(new DoctrinePaginator($q->getQuery()));
    	$paginator = new Paginator($adapter);
    	return $paginator;
    	
    }
    
}