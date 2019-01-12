<?php
namespace Admin\Controller;

use Zend\View\Model\JsonModel;

class UploadController extends ControllerAbstract{
    
    public function indexAction(){
        $this->redirect()->toRoute('home');
    }
    
    public function imagemAction(){
        if(!$this->request->isPost()){$this->redirect()->toRoute('home');}
        
        $nome = explode('.', $_FILES['imagem']['name']);
        $ext = array_pop($nome);
        $nome = time().".$ext";
        $destino = ROOT_PATH.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'drive'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.$nome;
        
        if(@move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)){
            $renderer = $this->serviceManager->get('Zend\View\Renderer\RendererInterface');
            $this->log->info('upload de imagem');
            
            return new JsonModel([
                'link'=>$renderer->basePath("/drive/img/$nome")
            ]);
        }  
       exit; 
    }
    
    public function delimagemAction(){
        if(!$this->request->isPost()){$this->redirect()->toRoute('home');}
        $imagem = $this->request->getPost('imagem');
        $ex = explode('/',$imagem);
        $nome = array_pop($ex);
        $local = ROOT_PATH.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'drive'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.$nome;
        unlink($local);
        exit;
    }
    
    public function arquivoAction(){
        if(!$this->request->isPost()){$this->redirect()->toRoute('home');}
        
        $nome = explode('.', $_FILES['arquivo']['name']);
        $ext = array_pop($nome);
        $nome = str_replace(' ','_',array_shift($nome)).'_'.time().".$ext";
        $destino = ROOT_PATH.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'drive'.DIRECTORY_SEPARATOR.'file'.DIRECTORY_SEPARATOR.$nome;
        
        if(@move_uploaded_file($_FILES['arquivo']['tmp_name'], $destino)){
            $renderer = $this->serviceManager->get('Zend\View\Renderer\RendererInterface');
            $this->log->info('upload de arquivo');
            
            return new JsonModel([
                'link'=>$renderer->basePath("/drive/file/$nome")
            ]);
        }
        exit; 
    }
}