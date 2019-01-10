<?php
namespace Admin\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Menu extends AbstractHelper{
	private $html=null;
	protected $itens;
	protected $route;
	protected $serviceManager;

	public function __invoke($itens=[]){
	    $this->itens = $itens;
	    return $this;
    }
	
	public function setItens($itens){
		$this->itens=$itens;
		return $this;
	}

	public function setRouteName($route){
		$this->route=$route;
		return $this;
	}

	public function render(){

		if(empty($this->itens)){return;}

		$this->html = '<ul class="menu nav rounded nav-tabs nav-stacked">';
		
		$this->renderItens($this->itens);

		$this->html .= '</ul>';

		return $this->html;
	}

	public function renderItens($itens){
		foreach($itens as $item){
			
			$icone='';

			if(isset($item['icone'])){
				$icone = "<i class=\"icon {$item['icone']}\"></i>";
			}

			if(isset($item['active']) && in_array($this->route, $item['active'])){
				$active = 'active';
				if(isset($item['submenu'])){
					$expand = 'true';
					$in='in';
				}
			}else{
				$active = '';
				$expand = 'false';
				$in='';
			}

			if(isset($item['submenu'])){
				$permitido = false;
				foreach($item['submenu'] as $subitem){
					if($this->view->permitido($subitem['link'])){
						$permitido = true;
						break;
					}
				}

				if(!$permitido){continue;}

				$this->html .= "<li class=\"dropdown\">";
				$this->html .= "<a class=\"$active\" data-toggle=\"collapse\" href=\"#{$item['id']}\" aria-expanded=\"$expand\">";
				$this->html .= "<i class=\"glyphicon glyphicon-menu-down pull-right\"></i>";
                $this->html .=  "<i class=\"glyphicon glyphicon-menu-up pull-right\"></i>";
				$this->html .= "$icone {$item['label']}";
				$this->html .="</a>";

				$this->html .= "\n<ul class=\"nav collapse $in\" id=\"{$item['id']}\">";
				$this->renderItens($item['submenu']);
				$this->html .= "\n</ul>";
				
				$this->html .= "\n</li>";

			}else{

				if(isset($item['count']) && $item['count']>0){
					$count = $item['count']>10?'+10':$item['count'];
					$widget = '<b class="label '.@$item['countClass'].' pull-right">'.$count.'</b>';
				}else{
					$widget='';
				}
                
				if($this->view->permitido($item['link'])){
			     	$this->html .= "<li><a class=\"$active\" href=\"{$item['link']}\">$icone {$item['label']}{$widget}</a></li>\n";
				}
			}
			
		}
	}

}