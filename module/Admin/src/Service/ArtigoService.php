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
            return $this->entityManager->getRepository(Artigo::class)->findOneBy(['id'=>$id]);
        }
    }
    
    public function salvar(Artigo $artigo){
        $this->entityManager->persist($artigo);
        $this->entityManager->flush();
        return $this;
    }
    
    public function remover($id){
        $artigos = new ArrayCollection($this->entityManager->getRepository(Artigo::class)->findBy(['id'=>$id]));
        
        foreach($artigos as $artigo){
            $artigo->setExcluido(true);
            $this->entityManager->persist($artigo);
            $this->entityManager->flush();
        }
        return $this;
    }
    
    public function find($busca=null, Array $cols = null, Array $order=['artigo.datapublicacao'=>'desc']){
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
 
        if(is_array($busca)){
            if(isset($busca['categoria'])){
                $q->andWhere("categoria = :categoria");
                $q->setParameter('categoria', $busca['categoria']);
            }
            
            if(isset($busca['autor'])){
                $q->andWhere("autor = :autor");
                $q->setParameter('autor', $busca['autor']);
            }
            
            if(isset($busca['editor'])){
                $q->andWhere("editor = :editor");
                $q->setParameter('editor', $busca['editor']);
            }
            
            if(isset($busca['query'])){
                $query = $busca['query'];
            }else{
                $query = null;
            }
            
        }else{
            $query = $busca;
        }
    	
    	if($cols){
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
           
           $q->andwhere($where);
             
       }else{		   
    	   $q->andwhere('artigo.titulo like :query or autor.nome like :query');    
       }
       
    	$q->setParameter('query', "%$query%");
    	
    	$adapter = new Adapter(new DoctrinePaginator($q->getQuery()));
    	$paginator = new Paginator($adapter);
    	$paginator->setItemCountPerPage(15);
    	return $paginator;
    	
    }
    
}