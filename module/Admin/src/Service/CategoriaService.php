<?php
namespace Admin\Service;

use Admin\Model\Categoria;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as Adapter;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Zend\Paginator\Paginator;
use Doctrine\Common\Collections\ArrayCollection;

class CategoriaService extends ServiceAbstract{
    
    public function get($id){
        if(is_array($id)){
            return new ArrayCollection($this->entityManager->getRepository(Categoria::class)->findBy(['id'=>$id,'excluido'=>false]));
        }else{
            return $this->entityManager->getRepository(Categoria::class)->findOneBy(['id'=>$id,'excluido'=>false]);
        }
    }
    
    public function salvar(Categoria $categoria){
       $this->entityManager->persist($categoria);
       $this->entityManager->flush();
       return $this;
    }
    
    public function remover($id){
        $categorias = new ArrayCollection($this->entityManager->getRepository(Categoria::class)->findBy(['id'=>$id]));
        
        foreach($categorias as $categoria){
            $categoria->setExcluido(true);
            $this->entityManager->persist($categoria);
            $this->entityManager->flush();
        }
        return $this;
    }
    
    public function find($query=null, array $cols=null, array $order=['categoria.descricao'=>'asc']){
        $q = $this->entityManager->createQueryBuilder()
                  ->select('categoria')
                  ->from('Admin\Model\Categoria','categoria')
                  ->where('categoria.excluido = false')
                  ->orderBy(key($order), $order[key($order)]);
        
       if($query){
            $q->andWhere("categoria.descricao like :like")
            ->setParameter('like', "%$query%");               
       }
       
       $adapter = new Adapter(new DoctrinePaginator($q->getQuery()));
       $paginator = new Paginator($adapter);
       $paginator->setItemCountPerPage(15);
       return $paginator;
    }
    
}