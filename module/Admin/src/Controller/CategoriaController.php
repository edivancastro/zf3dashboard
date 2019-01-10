<?php
namespace Admin\Controller;

use Admin\Service\CategoriaService;
use Admin\Model\Categoria;
use Zend\Captcha\Image as Captcha;
use Admin\Service\ArtigoService;

class CategoriaController extends ControllerAbstract{
    
    public function indexAction(){
        
        switch($this->request->getQuery('ordem')){
            case 2:
                $ordem = ['categoria.descricao'=>'desc'];
                break;
            default:
                $ordem = ['categoria.descricao'=>'asc'];
        }
        
        $categorias = $this->serviceManager->get(CategoriaService::class)->find($this->request->getQuery('busca'), null, $ordem);
        $categorias->setCurrentPageNumber($this->request->getQuery('page',null));
        
        return[
            'categorias' => $categorias,
            'ordem' => $this->request->getQuery("ordem"),
            'busca' => $this->request->getQuery("busca"),
            'page' => $this->request->getQuery("page")
        ];
    }
    
    public function cadastrarAction(){
        if($this->request->isPost()){
            $categoria = new Categoria();
            $categoria->setDescricao($this->request->getPost('descricao'));
            $this->serviceManager->get(CategoriaService::class)->salvar($categoria);
            
            $this->flashMessenger()->addSuccessMessage('Registro salvo');
            $this->log->info('Categoria de conteudo cadastrada');
            
            $this->redirect()->toRoute('categoria');
        }
    }
    
    public function editarAction(){
        
        $categoria = $this->serviceManager->get(CategoriaService::class)->get($this->params('id'));
        
        if($this->request->isPost()){
            $categoria->setDescricao($this->request->getPost('descricao'));
            $this->serviceManager->get(CategoriaService::class)->salvar($categoria);
            
            $this->flashMessenger()->addSuccessMessage('Registro salvo');
            $this->log->info('Categoria de conteudo editada');
            
            $this->redirect()->toRoute('categoria');
        }
        
        return[
            'categoria' => $categoria
        ];
    }
    
    public function detalharAction(){
        $categoria = $this->serviceManager->get(CategoriaService::class)->get($this->params('id'));
        
        if(!$categoria){$this->redirect()->toRoute('categoria');}
        
        return[
            'categoria' => $categoria,
            'artigos' =>  $this->serviceManager->get(ArtigoService::class)->find($categoria, ['categoria'], ['artigo.datacriacao'=>'desc'])
        ];
    }
    
    public function delAction(){
        $ids = explode(',',$this->params('id'));
        $categorias = $this->serviceManager->get(CategoriaService::class)->get($ids);   
        
        if($categorias->count()==0){$this->redirect()->toRoute('categoria');}
        
        $captcha = new Captcha();
        
        if($this->request->isPost() && $captcha->isValid($this->request->getPost('captcha'))){
            $this->serviceManager->get(CategoriaService::class)->remover($ids);
            $this->flashMessenger()->addSuccessMessage("Registro excluido!");
            $this->log->alert("categoria excluida");
            $this->redirect()->toRoute("categoria");
        }
        
        $captcha->setDotNoiseLevel(10)
        ->setImgDir(realpath(ROOT_PATH.'/public/temp/captcha'))
        ->setLineNoiseLevel(0);
        
        $id = $captcha->setFont(ROOT_PATH.'/public/fonts/arial.ttf')->generate();
        
        return ['captcha'=>$id,
            'categorias'=> $categorias
        ];
    }
}