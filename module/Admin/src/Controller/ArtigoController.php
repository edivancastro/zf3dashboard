<?php
namespace Admin\Controller;

use Admin\Service\ArtigoService;
use Admin\Service\CategoriaService;
use Admin\Model\Artigo;
use Zend\Captcha\Image as Captcha;
use Admin\Service\UsuarioService;

class ArtigoController extends ControllerAbstract{
    
    public function indexAction(){
        
        switch($this->request->getQUery('ordem')){
            case 2:
                $ordem = ['artigo.datacriacao'=>'asc'];
                break;
            case 3:
                $ordem = ['artigo.titulo'=>'asc'];
                break;
            case 4:
                $ordem = ['artigo.titulo'=>'desc'];
                break;
            case 5:
                $ordem = ['autor.nome'=>'asc'];
                break;
            case 6:
                $ordem = ['autor.nome'=>'desc'];
                break;
            default:
                $ordem = ['artigo.datacriacao'=>'desc'];
                break;
        }
        
        $categoria = $this->serviceManager->get(CategoriaService::class)->get($this->request->getQuery('cat'));
        $busca = array();
        if(is_object($categoria)){
            $busca['categoria'] = $categoria;   
        }
        $busca['query'] = $this->request->getPost('busca');
        
        $artigos = $this->serviceManager->get(ArtigoService::class)->find($busca,null,$ordem);
        $artigos->setCurrentPageNumber($this->request->getQuery('page',null));
        
        return[
           'artigos' => $artigos,
            'categorias' => $this->serviceManager->get(CategoriaService::class)->find(),
            'busca' => $this->request->getQuery('busca',null),
            'page'=> $this->request->getQuery('page',null),
            'ordem'=>$this->request->getQuery('ordem',null),
            'categoria'=>$this->request->getQuery('cat',null)
        ];
    }
    
    public function cadastrarAction(){
        if($this->request->isPost()){
            $artigo = new Artigo();
            $artigo->setTitulo($this->request->getPost('titulo'))
                   ->setSubTitulo($this->request->getPost('subtitulo'))
                   ->setConteudo($this->request->getPost('conteudo'))
                   ->setDatacriacao(new \DateTime())
                   ->setAutor($this->serviceManager->get(UsuarioService::class)->get($this->session->usuario->getId()))
                   ->setCategoria($this->serviceManager->get(CategoriaService::class)->get($this->request->getPost('categoria')));
            $this->serviceManager->get(ArtigoService::class)->salvar($artigo);
            $this->flashMessenger()->addSuccessMessage("Registro salvo");
            $this->log->info("Artigo cadastrado");
            
            $this->redirect()->toRoute("artigo");
        }
        
        return[
            'categorias' => $this->serviceManager->get(CategoriaService::class)->find(),
        ];
    }
    
    public function editarAction(){
        $artigo = $this->entityManager->getRepository(Artigo::class)->get($this->params('id'));
        
        if($this->request->isPost()){
          
            $artigo->setTitulo($this->request->getPost('titulo'))
            ->setSubTitulo($this->request->getPost('subtitulo'))
            ->setConteudo($this->request->getPost('conteudo'))
            ->setDataedicao(new \DateTime())
            ->setEditor($this->serviceManager->get(UsuarioService::class)->get($this->session->usuario->getId()))
            ->setCategoria($this->serviceManager->get(CategoriaService::class)->get($this->request->getPost('categoria')));
            $this->serviceManager->salvar($artigo);
            $this->flashMessenger()->addSuccessMessage("Registro salvo");
            $this->log->info("Artigo editado");
            
            $this->redirect()->toRoute("artigo");
        }
        
        return[
            'artigo' => $artigo
        ];
    }
    
    public function previewAction(){
        $artigo = $this->serviceManager->get(ArtigoService::class)->get($this->params('id'));
        
        if(!is_object($artigo)){$this->redirect()->toRoute('artigo');}
        
        return [
            'artigo' => $artigo
        ];
    }

    public function delAction(){
        $ids = explode(',',$this->params('id'));
        $artigos = $this->serviceManager->get(ArtigoService::class)->get($ids);
        
        if($artigos->count()==0){$this->redirect()->toRoute('artigo');}
        
        $captcha = new Captcha();
        
        if($this->request->isPost() && $captcha->isValid($this->request->getPost('captcha'))){
            $this->serviceManager->get(ArtigoService::class)->remover($ids);
            $this->flashMessenger()->addSuccessMessage("Registro excluido!");
            $this->log->alert("artigo(s) excluido(s)");
            $this->redirect()->toRoute("artigo");
        }
        
        $captcha->setDotNoiseLevel(10)
        ->setImgDir(realpath(ROOT_PATH.'/public/temp/captcha'))
        ->setLineNoiseLevel(0);
        
        $id = $captcha->setFont(ROOT_PATH.'/public/fonts/arial.ttf')->generate();
        
        return ['captcha'=>$id,
            'artigos'=> $artigos
        ];
    }
    
}