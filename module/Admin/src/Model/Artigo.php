<?php
namespace Admin\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @author Edivan carneiro
 * @ORM\Entity
 */
class Artigo{
    
    /** 
     * @var Integer
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer");
     */
    protected $id;
    
    /**
     * 
     * @var String
     * @ORM\Column(type="string")
     */
    protected $titulo;
    
    /**
     * 
     * @var String
     * @ORM\Column(type="text");
     */
    protected $conteudo;
    
    /**
     * 
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $datacriacao;
    
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $dataedicao;

    /**
    *@var boolean
    *@ORM\column(type="boolean")
    */
    protected $excluido = false;
    
    /**
     * 
     * @var Usuario
     * @ORM\ManyToOne(targetEntity="Admin\Model\Usuario", inversedBy="artigoscriados")
     * @ORM\JoinColumn(name="criado_por", referencedColumnName="id")
     */
    protected $autor;
    
    /**
     * 
     * @var Usuario
     * @ORM\ManyToOne(targetEntity="Admin\Model\Usuario", inversedBy="artigoseditados");
     * @ORM\JoinColumn(name="editado_por", referencedColumnName="id")
     */
    protected $editor;
    
    /**
     *
     * @var Categoria
     * @ORM\ManyToOne(targetEntity="Admin\Model\Categoria");
     * @ORM\JoinColumn(name="Categoria_id", referencedColumnName="id")
     */
    protected $categoria;
    
    public function setId($id){
        $this->id = $id;
        return $this;
    }
    
    public function setTitulo($titulo){
        $this->titulo = $titulo;
        return $this;
    }
    
    public function setConteudo($conteudo){
        $this->conteudo = $conteudo;
        return $this;
    }
    
    public function setDatacriacao(\Datetime $data){
        $this->datacriacao = $data;
        return $this;
    }
    
    public function setDataedicao(\Datetime $data){
        $this->dataedicao = $data;
        return $this;
    }
    
    public function setExcluido($bool){
        $this->excluido = $bool;
        return $this;
    }
    
    public function setAutor(Usuario $autor){
        $this->autor = $autor;
        return $this;
    }
    
    public function setEditor(Usuario $editor){
        $this->editor = $editor;
        return $this;
    }
    
    public function setCategoria(Categoria $categoria){
        $this->categoria = $categoria;
        return $this;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getTitulo(){
        return $this->titulo;
    }
    
    public function getConteudo(){
        return $this->conteudo;
    }
    
    public function getDatacriacao(){
        return $this->datacriacao;
    }
    
    public function getDataedicao(){
        return $this->dataedicao;
    }
    
    public function isExcluido(){
        return $this->excluido;
    }
    
    public function getAutor(){
        return $this->autor;
    }
    
    public function getEditor(){
        return $this->editor;
    }
    
    public function getCategoria(){
        return $this->categoria;
    }
    
}