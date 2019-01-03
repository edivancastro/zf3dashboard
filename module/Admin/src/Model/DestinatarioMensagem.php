<?php
namespace Admin\Model;

use Doctrine\ORM\Mapping as ORM;

/**
*@ORM\Entity
*/
class DestinatarioMensagem implements \JsonSerializable{

	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="Admin\Model\Usuario", inversedBy="mensagensrecebidas");
	 * @ORM\joinColumn(name="Usuario_id", referencedColumnName="id");
	 */
	protected $destinatario;
	
	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="Admin\Model\Mensagem", inversedBy="destinatarios");
	 * @ORM\joinColumn(name="Mensagem_id", referencedColumnName="id");
	 */
	protected $mensagem;

	/**
	* @ORM\Column(type="datetime")
	*/
	protected $dataleitura;


	public function setDestinatario($usuario){
		$this->destinatario = $usuario;
		return $this;
	}


	public function setMensagem($msg){
		$this->mensagem = $msg;
		return $this;
	}


	public function setDataleitura($data){
		$this->dataleitura = $data;
		return $this;
	}

	public function getDestinatario(){
		return $this->destinatario;
	}

	public function getMensagem(){
		return $this->mensagem;
	}

	public function getDataleitura(){
		return $this->dataleitura;
	}

	public function jsonSerialize(){
		$vars = get_object_vars($this);
        return $vars;
	}

	public function foiLida(){
		if($this->getDataleitura()<>null){
			return true;
		}else{
			return false;
		}
	}

}