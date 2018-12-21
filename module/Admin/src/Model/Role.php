<?php
namespace Admin\Model;

Use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Admin\Model\Usuario;

/**
 * @ORM\Entity
 */
class Role{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(name="id",type="integer");
	 */
	protected $id;
	
	/**
	 * @ORM\Column(name="descricao",type="string");
	 */
	protected $descricao;
	
	/**
	 * @ORM\OneToMany(targetEntity="Admin\Model\Usuario", mappedBy="role")
	 */
	protected $usuarios;
	
	/**
	 * 
	 * @ORM\ManyToMany(targetEntity="Admin\Model\Permissao", inversedBy="roles")
	 * @ORM\JoinTable(name="Role_Permissao", joinColumns={@ORM\joinColumn(name="Role_id", referencedColumnName="id")},
	 * 										 inverseJoinColumns={@ORM\joinColumn(name="Permissao_id", referencedColumnName="id")})
	 */
	protected $permissoes;
	
	/**
	 * 
	 * @ORM\Column(type="boolean")
	 */
	protected $excluido;
	
	public function __construct(){
		$this->usuarios = new ArrayCollection();
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
	
	public function setExcluido(Bool $ex){
	    $this->excluido = $ex;
	}
	
	public function addUsuario(Usuario $usuario){
		$this->usuarios[] = $usuario;		
		return $this;
	}
	
	public function addPermissao(Permissao $permissao){
		$this->permissoes[] = $permissao;
		return $this;
	}
	
	public function removeUsuario(Usuario $usuario){
		$this->usuarios->removeElement($usuario);
		return $this;
	}
	
	public function removePermissao(Permissao $permissao){
		$this->permissoes->removeElement($permissao);
		return $this;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getDescricao(){
		return $this->descricao;
	}
	
	public function getUsuarios(){
		return $this->usuarios;
	}
	
	public function getPermissoes(){
		return $this->permissoes;
	}
	
	public function isExcluido(){
	    return $this->excluido;
	}
}