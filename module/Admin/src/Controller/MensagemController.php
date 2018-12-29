<?php
namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Admin\Service\MensagemService;
use Admin\Service\UsuarioService;
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
	    
	}
}