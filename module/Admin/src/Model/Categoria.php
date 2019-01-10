<?php
namespace Admin\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * 
 * @author Edivan carneiro
 * @ORM\Entity
 */
class Categoria{
    /**
     * 
     * @var Integer
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * 
     * @var String
     * @ORM\Column(type="string")
     */
    protected $descricao;
    
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    protected $excluido = false;
    
    /**
     * 
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Admin\Model\Artigo", mappedBy="categoria", cascade="all")
     * 
     */
    protected $artigos;
    
    
    public function __construct(){
        $this->artigos = new ArrayCollection();
    }
    
    public function setId($id){
        $this->id = $id;
        return $this;
    }
    
    public function setDescricao($descricao){
        $this->descricao = $descricao;
        return $this;
    }
    
    public function setExcluido($bool){
        $this->excluido = $bool;
        return $this;
    }
    
    public function addArtigo(Artigo $artigo){
        $this->artigos[] = $artigo;
        return $this;
    }
    
    public function remArtigo(Artigo $artigo){
        $this->artigos->removeElement($artigo);
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getDescricao(){
        return $this->descricao;
    }
    
    public function getArtigos(){
        $notexcluido = Criteria::expr()->eq('excluido',false);
        $criteria = Criteria::create()->where($notexcluido);
        return $this->artigos->matching($criteria);
    }
    
    public function isExcluido(){
        return $this->excluido;
    }
}