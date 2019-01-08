<?php
namespace Admin\Service;

use Admin\Model\CategoriaArtigo;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as Adapter;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Zend\Paginator\Paginator;

class CategoriaArtigoService extends ServiceAbstract{
    
    public function get($id){
        return $this->entityManager->getRepository(CategoriaArtigo::class)->findBy(['id'=>$id]);
    }
    
    public function salvar(CategoriaArtigo $categoria){
       $this->entityManager->persist($categoria);
       $this->entityManager->flush();
       return $this;
    }
    
    public function excluir($id){
        
        $categoria = $this->entityManager->getRepository(CategoriaArtigo::class)->findBy(['id'=>$id]);
        if($categoria->getArtigos()->filter(function($artigo){return !$artigo->isExcluido();})->count() > 0){
            throw new \Exception("Há artigos nesta categoria que precisam ser excluidos antes");
        }
        
        $categoria->setExcluido(true);
        $this->entityManager->persist($categoria);
        $this->entityManager->flush();
        return $this;
    }
    
    public function find($query=null){
        $q = $this->entityManager->createQueryBuilder()
                  ->select('c')
                  ->from('Admin\Model\CategoriaArtigo','c')
                  ->where('c.excluido = false');
       if($query){
            $q->andWhere("c.descricao like :like")
            ->setParameter('like', "%$query%");               
       }
       
       $adapter = new Adapter(new DoctrinePaginator($q->getQuery()));
       $paginator = new Paginator($adapter);
       return $paginator;
    }
    
}