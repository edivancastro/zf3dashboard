<?php
namespace Admin\Controller;

use Admin\Service\ArtigoService;
use Admin\Service\CategoriaArtigoService;
use Admin\Model\Artigo;
use Zend\Captcha\Image as Captcha;

class ArtigoController extends ControllerAbstract{
    
    public function indexAction(){
        
        $artigos = $this->serviceManager->get(ArtigoService::class)->find($this->request->getPost('busca',null));
        $artigos->setItemCountPerPage(15);
        $artigos->setCurrentPageNumber($this->request->getQuery('page',null));
        
        return[
           'artigos' => $artigos,
            'categorias' => $this->serviceManager->get(CategoriaArtigoService::class)->find(),
            'busca' => $this->request->getQuery('busca',null),
        ];
    }
    
    public function cadastrarAction(){
        if($this->request->isPost()){
            $artigo = new Artigo();
            $artigo->setTitulo($this->request->getPost('titulo'))
                   ->setConteudo($this->request->getPost('conteudo'))
                   ->setDatacriacao(new \DateTime())
                   ->setAutor($this->session->usuario->getId())
                   ->setCategoria($this->serviceManager->get(CategoriaArtigoService::class)->get($this->request->getPost('categoria')));
            $this->serviceManager->salvar($artigo);
            $this->flashMessenger()->addSuccessMessage("Registro salvo");
            $this->log->info("Artigo cadastrado");
            
            $this->redirect()->toRoute("artigo");
        }
    }
    
    public function editarAction(){
        if($this->request->isPost()){
            $artigo = $this->entityManager->getRepository(Artigo::class)->get($this->params('id'));
            
            $artigo->setTitulo($this->request->getPost('titulo'))
            ->setConteudo($this->request->getPost('conteudo'))
            ->setDataedicao(new \DateTime())
            ->setEditor($this->session->usuario->getId())
            ->setCategoria($this->serviceManager->get(CategoriaArtigoService::class)->get($this->request->getPost('categoria')));
            $this->serviceManager->salvar($artigo);
            $this->flashMessenger()->addSuccessMessage("Registro salvo");
            $this->log->info("Artigo editado");
            
            $this->redirect()->toRoute("artigo");
        }
    }

    public function delAction(){
        $captcha = new Captcha();
        
        if($this->request->isPost() && $captcha->isValid($this->request->getPost('captcha'))){
            $this->serviceManager->get(ArtigoService::class)->remover($this->params("id"));
            $this->flashMessenger()->addSuccessMessage("Registro excluido!");
            $this->log->alert("Artigo excluido");
            $this->redirect()->toRoute("artigo");
        }
        
        $captcha->setDotNoiseLevel(10)
        ->setImgDir(realpath(ROOT_PATH.'/public/temp/captcha'))
        ->setLineNoiseLevel(0);
        
        $id = $captcha->setFont(ROOT_PATH.'/public/fonts/arial.ttf')->generate();
        
        return ['captcha'=>$id,
            'artigo'=>$this->serviceManager->get(ArtigoService::class)->get($this->params("id"))
        ];
        
    }
    
}