<?php
namespace Admin\Service;

use Admin\Model\Mensagem;
use Zend\Session\Container;
use Admin\Model\Usuario;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as Adapter;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Zend\Paginator\Paginator;

class MensagemService extends ServiceAbstract{

    public function getMensagensRecebidas($filter=null){
        return $this->filter($filter, Mensagem::INBOX);       
    }
        
    public function getMensagensEnviadas($filter=null){
        return $this->filter($filter, Mensagem::OUTBOX);
    }
    
    public function get($id){
        $usuario = $this->session->usuario;
        
        $msg = $this->entityManager->createQueryBuilder()
                      ->select('m')
                      ->from('Admin\Model\Mensagem','m')
                      ->where('m.id=:id')
                      ->andWhere('m.remetente=:usuario or :usuario MEMBER OF m.destinatarios')
                      ->setParameter('usuario',$usuario)
                      ->setParameter('id', $id)
                      ->setMaxResults(1)
                      ->getQuery()->getSingleResult();       
      
        
        foreach($msg->getDestinatarioMensagem() as $dm){
            if($dm->getDestinatario()->getId() === $usuario->getId()){
                if($dm->getDataleitura()==null){
                  $dm->setDataLeitura(new \DateTime());
                  $this->entityManager->persist($dm);
                  $this->entityManager->flush();
                  break;
                }
            }
        }
        

        return $msg;
    }

    public function getTotalNaoLidas(){
      $usuario = $this->session->usuario;

      $result = $this->entityManager->createQueryBuilder()
            ->select('count(m.id)')
            ->from('Admin\Model\Mensagem','m')
            ->join('m.destinatarios','d')
            ->Where('d.destinatario=:usuario')
            ->andWhere('d.dataleitura is null')
            ->setParameter('usuario', $usuario)
            ->getQuery()->getSingleScalarResult();
      
      return $result;

    }


	public function enviar(Mensagem $mensagem){
	  $mensagem->setDataenvio(new \DateTime("now"));
		$this->entityManager->persist($mensagem);
		$this->entityManager->flush();
	}

  public function filter($valor=null, $box=Mensagem::INBOX){

    $query = $this->entityManager->createQueryBuilder();
    $query->select('d,m,r')
          ->from('Admin\Model\DestinatarioMensagem','d')
          ->join('d.mensagem','m')
          ->join('m.remetente','r');      
            
     
    if($box==Mensagem::INBOX){
      $query->where('d.destinatario = :usuario');
    }elseif($box==Mensagem::OUTBOX){
      $query->where('m.remetente = :usuario');
    }else{
      $query->where("d.destinatario = :usuario or m.remetente = :usuario");
    }

    $query->setParameter('usuario',$this->session->usuario);            

    if($valor <> null){
      $dataformat = explode('/',$valor);

      if(sizeof($dataformat)==1){
        $dataformat = '%-'.$dataformat[0].'%';
      }elseif(sizeof($dataformat)==2){
        $dataformat = '%-'.$dataformat[1].'-'.$dataformat[0].'%';
      }else{
        $dataformat = $dataformat[2].'-'.$dataformat[1].'-'.$dataformat[0].'%';
      }  

      $query->andWhere("m.assunto like :valor or r.nome like :valor or d.dataleitura like :valor2")
           ->setParameter('valor',"%$valor%")
           ->setParameter('valor2',$dataformat);
    }
    

    
    $query->groupBy('m.id') 
           ->orderBy('m.dataenvio','DESC');


    $adapter = new Adapter(new DoctrinePaginator($query->getQuery(),false));
    $paginator = new Paginator($adapter);

    return $paginator;
  }

	
}