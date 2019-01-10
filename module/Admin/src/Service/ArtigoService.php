<?php
namespace Admin\Service;

use Admin\Model\Artigo;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as Adapter;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Zend\Paginator\Paginator;
use Admin\Model\Categoria;
use Doctrine\Common\Collections\ArrayCollection;

class ArtigoService extends ServiceAbstract{
    
    public function get($id){
        if(is_array($id)){
            return new ArrayCollection($this->entityManager->getRepository(Artigo::class)->findBy(['id'=>$id]));
        }else{
            return $this->entityManager->getRepository(Artigo::class)->finOnedBy(['id'=>$id]);
        }
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
    
    public function find($query=null, Array $cols = null, Array $order=['artigo.datacriacao'=>'desc']){
    	$q = $this->entityManager->createQueryBuilder()
    			  ->select('artigo')
    			  ->from('Admin\Model\Artigo','artigo')
    			  ->join('artigo.categoria', 'categoria')
    			  ->join('artigo.autor','autor')
    			  ->leftjoin('artigo.editor','editor')
    			  ->where('artigo.excluido=false')
    	          ->andWhere('categoria.excluido=false');
    	
       if($order){
   	      $q->orderBy(key($order), $order[key($order)]);
       }
       
       if(is_object($query)){
           $where = '';
           $i=0;
           $len = sizeof($cols);
           
           foreach($cols as $col){
               $where .= "$col = :query";
               if($i < ($len-1)){
                   $where .= ' or ';
               }
               $i++;
           }
          
           $q->andWhere($where)
             ->setParameter('query', $query);
           
       }
       elseif($cols){
           $where = '';
           $i=0;
           $len = sizeof($cols);
           foreach($cols as $col){
               $where .= "$col like :$query";
               if($i < ($len-1)){
                   $where .= ' or ';
               }
               $i++;
           }
           
           $q->andwhere($where)
             ->setParameter('query',"%$query%");
       }else{		   
    	   $q->andwhere('artigo.titulo like :query or categoria.descricao like :query')
             ->setParameter('query',"%$query%");	 
       }
       
    	
    	$adapter = new Adapter(new DoctrinePaginator($q->getQuery()));
    	$paginator = new Paginator($adapter);
    	$paginator->setItemCountPerPage(15);
    	return $paginator;
    	
    }
    
}