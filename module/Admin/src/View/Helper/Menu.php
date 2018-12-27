<?php
namespace Admin\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Menu extends AbstractHelper{
	private $html=null;
	protected $itens;
	protected $route;

	public function __construct($itens=[]){
		$this->itens = $itens;
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
				$icone = "<i class=\"glyphicon {$item['icone']}\"></i>";
			}

			$active = '';
			$expand = 'false';
			$in='';

			if(isset($item['routes']) && in_array($this->route, $item['routes'])){
				$active = 'active';
				if(isset($item['submenu'])){
					$expand = 'true';
					$in='in';
				}
			}

			if(isset($item['submenu'])){
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
				$link =
				$this->html .= "<li><a class=\"$active\" href=\"{$item['link']}\">$icone {$item['label']}</a></li>\n";
			}
			
		}
	}

}