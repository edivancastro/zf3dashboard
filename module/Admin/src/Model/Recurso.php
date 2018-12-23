<?php
namespace Admin\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * 
 * @ORM\Entity
 *
 */
class Recurso{
    /**
     * 
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * 
     * @ORM\Column(type="string")
     */
    protected $nome;
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="Admin\Model\Permissao", mappedBy="recurso")
     */
    protected $permissoes;
    
    public function __construct(){
        $this->permissoes = new ArrayCollection();
    }
    
    public function setId($id){
        $this->id = $id;
        return $this;
    }
    
    public function setNome($nome){
        $this->nome = $nome;
        return $this;
    }
    
    public function addPermissao(Permissao $permissao){
        $this->permissoes[] = $permissao;
        return $this;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getNome(){
        return $this->nome;
    }
    
    public function getPermissoes(){
        return $this->permissoes;
    }
}