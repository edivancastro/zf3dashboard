<?php
namespace Admin\Service;

use Admin\Model\Mensagem;
use Zend\Session\Container;
use Admin\Model\Usuario;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as Adapter;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Zend\Paginator\Paginator;

class MensagemService extends ServiceAbstract{

    public function getMensagensRecebidas($options=['ItemPerPage'=>10,'CurrentPage'=>1,'order'=>'desc']){
       $usuario = $this->session->usuario;
       
       $query = $this->entityManager->createQueryBuilder()
                           ->select('m')
                           ->from('Admin\Model\Mensagem','m')
                           ->where(':usuario MEMBER OF m.destinatarios')
                           ->setParameter('usuario',$usuario->getId())
                           ->orderBy('m.dataenvio',$options['order'])
                           ->getQuery();
       
      $adapter = new Adapter(new DoctrinePaginator($query,false));
      
      $paginator = new Paginator($adapter);
      $paginator->setItemCountPerPage($options['ItemPerPage']);
      $paginator->setCurrentPageNumber($options['CurrentPage']);
      
      return $paginator;
    }
        
    public function getMensagensEnviadas($options=['ItemPerPage'=>10,'CurrentPage'=>1,'order'=>'desc']){
        $usuario = $this->session->usuario;
        
        $query = $this->entityManager->createQueryBuilder()
        ->select('m')
        ->from('Admin\Model\Mensagem','m')
        ->where('m.remetente = :usuario')
        ->setParameter('usuario',$usuario->getId())
        ->orderBy('m.dataenvio',$options['order'])
        ->getQuery();
        
        $adapter = new Adapter(new DoctrinePaginator($query,false));
        
        $paginator = new Paginator($adapter);
        $paginator->setItemCountPerPage($options['ItemPerPage']);
        $paginator->setCurrentPageNumber($options['CurrentPage']);
        
        return $paginator;
    }
    
    public function get($id){
        $usuario = $this->session->usuario;
        
        $result = $this->entityManager->createQueryBuilder()
                      ->select('m')
                      ->from('Admin\Model\Mensagem','m')
                      ->leftJoin('m.destinatarios','d')
                      ->where('m.id=:id')
                      ->andWhere('m.remetente=:usuario or d.id=:usuario')
                      ->setParameter('usuario',$usuario->getId())
                      ->setParameter('id', $id)
                      ->setMaxResults(1)
                      ->getQuery()->getResult();
       if(!empty($result)){
           $msg = $result[0];
           if(!$msg->isVisualizada()){
               $msg->setDataleitura(new \DateTime("now"));
               $this->entityManager->persist($msg);
               $this->entityManager->flush();
           }
       }else{
           $msg = $result;
       }
       
        return $msg;
    }

    public function getTotalNaoLidas(){
       $usuario = $this->session->usuario;

      return $this->entityManager->createQueryBuilder()
            ->select('count(m.id)')
            ->from('Admin\Model\Mensagem','m')
            ->leftJoin('m.destinatarios','d')
            ->Where('d.id=:usuario')
            ->andWhere('m.dataleitura is null')
            ->setParameter('usuario', $usuario->getId())
            ->getQuery()->getSingleScalarResult();

    }


	public function enviar(Mensagem $mensagem){
	    $mensagem->setDataenvio(new \DateTime("now"));
		$this->entityManager->persist($mensagem);
		$this->entityManager->flush();
	}

  public function like($valor, $options){
    $query = $this->entityManager->createQueryBuilder()
      ->select('m')
      ->from('Admin\Model\Mensagem','m')
      ->join('m.remetente','r')
      ->where('r.status = :status')
      ->setParameter('status',Usuario::STATUS_ATIVO)
      ->andWhere('r.nome like :valor')
      ->orWhere("m.assunto like :valor")
      ->setParameter('valor',"%$valor%")
      ->getQuery();

    $adapter = new Adapter(new DoctrinePaginator($query,false));  
    $paginator = new Paginator($adapter);
    $paginator->setItemCountPerPage($options['ItemPerPage']);
    $paginator->setCurrentPageNumber($options['CurrentPage']);

    return $paginator;
  }

	
}