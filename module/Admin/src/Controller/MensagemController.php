<?php
namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Admin\Service\MensagemService;
use Admin\Service\UsuarioService;
use Admin\Service\RoleService;
use Admin\Model\Mensagem;
use Admin\Model\DestinatarioMensagem;

class MensagemController extends ControllerAbstract{
	
	//caixa de entrada
	public function indexAction(){
	    
	    
	    $CurrentPage = $this->request->getQuery('page') <> null ? $this->request->getQuery('page'):1;
	    
	    $mensagens = $this->serviceManager->get(MensagemService::class)->getMensagensRecebidas();
	    $mensagens->setItemCountPerPage(8);
    	$mensagens->setCurrentPageNumber($CurrentPage);

		$view = new ViewModel();
		$view->box=1;
		$view->mensagens = $mensagens;
		return $view;
	}

	//itens enviados
	public function enviadasAction(){
	    $CurrentPage = $this->request->getQuery('page') <> '' ? $this->request->getQuery('page'):1;
	    
	    $mensagens = $this->serviceManager->get(MensagemService::class)->getMensagensEnviadas();
		$mensagens->setItemCountPerPage(8);
    	$mensagens->setCurrentPageNumber($CurrentPage);

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
	    $this->log->info('Leitura de Mensagem');
	    return ['mensagem'=>$mensagem];
	}

	//nova mensagem ou responder mensagem	
	public function writeAction(){
		

	    if($this->request->isPost()){
	    	$usrService = $this->serviceManager->get(UsuarioService::class);
			$msg = new Mensagem();
			$msg->setRemetente($usrService->get($this->session->usuario));
	    	
	    	$msg->setAssunto($this->request->getPost('assunto'));
	    	$msg->setTexto($this->request->getPost('texto'));

	    	foreach($this->request->getPost('user') as $user){
	    		$user = $usrService->get($user);
	    		$destinatario = new DestinatarioMensagem();
	    		$destinatario->setDestinatario($user);
	    		$msg->addDestinatarioMensagem($destinatario);
	    	}

	    	$this->serviceManager->get(MensagemService::class)->enviar($msg);
	    	$this->log->info('Mensagem enviada');
	    	$this->flashMessenger()->addSuccessMessage("Mensagem enviada!");
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

	//filtragem ajax
	public function findAction(){
		error_reporting(E_ALL|E_STRICT);
		ini_set('display_errors', 'off');

		if($this->request->getQuery('box')==null || !$this->request->isXmlHttpRequest()){
			return $this->redirect()->toRoute('msg');
		}

		$currentPage = $this->request->getQuery('page',null);
		$filter = $this->request->getQuery('query'); 
		$box = $this->request->getQuery('box');

		$paginator = $this->serviceManager->get(MensagemService::class)->filter($filter,$box);
		
		$paginator->setItemCountPerPage(8);
    	$paginator->setCurrentPageNumber($currentPage);

		$this->log->info('Pesquisa na caixa de mensagens');

		$json = new JsonModel();
		$json->query = $filter;
		$json->box = $box; 
		$json->mensagens = $paginator->getItemsByPage($currentPage);
		$json->paginator = $paginator->getPages();

		return $json;
	}
}