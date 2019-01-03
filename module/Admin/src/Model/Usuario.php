<?php
namespace Admin\Model;
Use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 */
class Usuario implements \JsonSerializable{
	const STATUS_ATIVO = 1;
	const STATUS_EXCLUIDO = 2;
	const STATUS_DESATIVADO = 3;

	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(name="id", type="integer")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $nome;
	
	/**
	 * @ORM\Column(name="email", type="string")
	 */
	protected $email;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $login;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $senha;
	
	/**
	 * @ORM\Column(type="integer");
	 */
	protected $status;
	
	/** 
	 * @ORM\ManyToOne(targetEntity="Admin\Model\Role", inversedBy="usuarios")
	 * @ORM\joinColumn(name="Role_id", referencedColumnName="id")
	 */
	protected $role;

	/**
	* @ORM\OneToMany(targetEntity="Admin\Model\Mensagem", mappedBy="remetente")
	*/
	protected $mensagensenviadas;

	/**
	* @ORM\OneToMany(targetEntity="Admin\Model\DestinatarioMensagem", mappedBy="destinatario")
	*/
	protected $mensagensrecebidas;

	
	public function __construct(){
		$this->mensagensenviadas = new ArrayCollection();
		$this->mensagensrecebidas = new ArrayCollection();
	}
	

	public function setId($id){
		$this->id = $id;
		return $this;
	}
	
	public function setNome($nome){
		$this->nome = $nome;
		return $this;
	}
	
	public function setEmail($email){
		$this->email = $email;
		return $this;
	}
	
	public function setLogin($login){
		$this->login = $login;
		return $this;
	}	
	
	public function setSenha($senha){
		$this->senha = $senha;
		return $this;
	}
	
	public function setStatus($status){
		$this->status = $status;
		return $this;
	}
	
	public function setRole($role){
		$this->role = $role;
		return $this;
	}

	public function addMensagemEnviada(Mensagem $mensagem){
		$this->mensagensenviadas[] = $mensagem;	
	}


	public function addMensagemRecebida(Mensagem $mensagem){
		$this->mensagensrecebidas[] = $mensagem;	
	}

	public function getId(){
		return $this->id;
	}
	
	public function getNome(){
		return $this->nome;
	}
	
	public function getEmail(){
		return $this->email;
	}
	
	public function getLogin(){
		return $this->login;
	}
	
	public function getSenha(){
		return $this->senha;
	}
	
	public function getStatus(){
		return $this->status;
	}

	public function getMensagensEnviadas(){
		return $this->mensagensenviadas;
	}
	
	public function getMensagensRecebidas(){
		return $this->mensagensrecebidas;
	}
	
	public function getRole(){
		return $this->role;
	}

	public function jsonSerialize(){
		$vars = get_object_vars($this);
		return $vars;
	}
	
}