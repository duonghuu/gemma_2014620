<?php
class breadcrumb{
	public $link;
	
	public function add($name,$link){
		$this->link[] = array("name"=>$name,"link"=>$link);
	}
	public function display(){
		$str = '<div class="header-navigate">
			<div class="container"><ul class="breadcrumb breadcrumb-arrow">';
		foreach($this->link as $k=>$v){
			$cls = '';
			if($k==(count($this->link) -1)){
				$cls = 'active';
			}
			if(!empty($v["link"])){
				$str.='<li class="breadcrumb-item '.$cls.'"><a href="'.$v["link"].'">'.$v["name"].'</a></li>';
			}else{
				$str.='<li class="breadcrumb-item '.$cls.'">'.$v["name"].'</li>';
			}
		}
		$str.="</ul></div>
		</div>";
		return $str;
	}
}