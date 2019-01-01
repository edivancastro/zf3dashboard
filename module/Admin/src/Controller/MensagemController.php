<?php
namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Admin\Service\MensagemService;
use Admin\Service\UsuarioService;
use Admin\Service\RoleService;
use Admin\Model\Mensagem;

class MensagemController extends ControllerAbstract{
	
	//caixa de entrada
	public function indexAction(){
	    
	    $options['ItemPerPage'] = 8;
	    $options['order']='desc';
	    $options['CurrentPage'] = $this->request->getQuery('page') <> '' ? $this->request->getQuery('page'):1;
	    
	    $mensagens = $this->serviceManager->get(MensagemService::class)->getMensagensRecebidas($options);

		$view = new ViewModel();
		$view->box=1;
		$view->mensagens = $mensagens;
		return $view;
	}

	//itens enviados
	public function enviadasAction(){
	    $options['ItemPerPage'] = 8;
	    $options['order']='desc';
	    $options['CurrentPage'] = $this->request->getQuery('page') <> '' ? $this->request->getQuery('page'):1;
	    
	    $mensagens = $this->serviceManager->get(MensagemService::class)->getMensagensEnviadas($options);
		
		$view = new ViewModel();
		$view->setTemplate('admin\mensagem\index');
		$view->box=2;
		$view->mensagens = $mensagens;
		return $view;
	}
	
	//ler mensagem
	public function readAction(){
	    $mensagem = $this->serviceManager->get(MensagemService::class)->get($this->params('id'));
	    
	    if(empty($mensagem)){
	        $this->redirect()->toRoute('home');
	    }
	    
	    return ['mensagem'=>$mensagem];
	}
	
	public function writeAction(){
		

	    if($this->request->isPost()){
	    	$usrService = $this->serviceManager->get(UsuarioService::class);
			$msg = new Mensagem();
			$msg->setRemetente($usrService->get($this->session->usuario));
	    	
	    	$msg->setAssunto($this->request->getPost('assunto'));
	    	$msg->setTexto($this->request->getPost('texto'));

	    	foreach($this->request->getPost('user') as $user){
	    		$user = $usrService->get($user);
	    		$msg->addDestinatario($user);
	    	}

	    	$this->serviceManager->get(MensagemService::class)->enviar($msg);

	    	$this->redirect()->toRoute('msg');
	    }

	    $view = new ViewModel();

	    if($this->request->getQuery('users')){
	    	$view = new ViewModel();
	    	$view->setTemplate('admin/mensagem/lista-usuarios');
	    	$view->setTerminal(true);
	    	$view->perfis = $this->serviceManager->get(RoleService::class)->getAll();
	    	return $view;
	    }

	    if($this->request->getQuery('resp')){
	  		$reply = $this->serviceManager->get(MensagemService::class)->get($this->request->getQuery('resp')); 

	  		if(empty($reply)){
	  			$this->redirect()->toRoute('msg');
	  		}

	  		$view->reply = $reply; 
	    }

	    $view->usuario = $this->session->usuario;
	 
	    return $view;

	} 

	public function jsonAction(){

		if($this->request->getQuery('query')==null){
			return $this->redirect()->toRoute('msg');
		}

		$currentPage = $this->request->getQuery('page') <> '' ? $this->request->getQuery('page'):1;

		$paginator = $this->serviceManager->get(MensagemService::class)->like($this->request->getQuery('query'),['ItemPerPage'=>8,'CurrentPage'=>$currentPage]);


		$json = new JsonModel();
		$json->mensagens = $paginator->getItemsByPage($currentPage);
		
		return $json;
	}
}