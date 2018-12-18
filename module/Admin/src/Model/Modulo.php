<?php
namespace Admin\Model;

Use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 */
class Modulo{
	/**
	 * 
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(name="id", type="integer")
	 */
	protected $id;
	
	/**
	 * 
	 * @ORM\Column(type="string")
	 */
	protected $descricao;
	
	/**
	 * 
	 * @ORM\OneToMany(targetEntity="Admin\Model\Permissao", mappedBy="modulo")
	 */
	protected $permissoes;
	
	public function __construct(){
		$this->permissoes = new ArrayCollection();
	}
	
	public function setId($id){
		$this->id = $id;
		return $this;
	}
	
	public function setDescricao($descricao){
		$this->descricao = $descricao;
		return $this;
	}
	
	public function AddPermissao(Permissao $permissao){
		$this->permissoes[] = $permissao;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getDescricao(){
		return $this->descricao;
	}
	
	public function getPermissoes(){
		return $this->permissoes;
	}
}