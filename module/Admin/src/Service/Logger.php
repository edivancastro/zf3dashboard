<?php
namespace Admin\Service;
use Zend\Session\Container;
use Zend\Http\Request;

class Logger{
	protected $logger; 
	protected $request;
	protected $usuario;

	public function __construct($logger, Request $request){
		$this->logger = $logger;
		$this->request = $request;
	}

	//Perigo
	public function warn($message){
		return $this->logger->warn($message, $this->getExtra());
	}

	//atenção
	public function alert($message){
		return $this->logger->alert($message, $this->getExtra());
	}

	//informação
	public function info($message){
		return $this->logger->info($message, $this->getExtra());
	}

	public function getExtra(){
		$session = new Container('Admin\Session');

		$extra['request'] = $this->request->getUriString();
	 	$extra['method'] = $this->request->getMethod();
	 	$extra['headers'] = $this->request->getHeaders()->toString();
	 	$extra['userip'] = $this->request->getServer()->get('REMOTE_ADDR');

	 	if($this->request->isPost()){
            //nÃ£o registra senha no log
            $post = explode('&',$this->request->getPost()->toString());
            for($i=0;$i<sizeof($post);$i++){
                if(strpos($post[$i],'senha=')>-1){
                    unset($post[$i]);
                }
            }
            $extra['post'] = implode('&',$post);          
        }

        $usuario = $session->usuario;
        
	 	if($usuario){
	 		$extra['userlogin'] = $usuario->getLogin();
	 		$extra['userid'] = $usuario->getId();
	 	}

	 	return $extra;
	}
	
}