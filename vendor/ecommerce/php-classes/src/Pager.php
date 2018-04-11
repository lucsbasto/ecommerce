<?php

namespace Classes;
use Rain\Tpl;

class Pager{
    private $tpl;
    private $options;
    private $defaults = [
        "data" => []
    ];

    public function __construct($opts = array()){
        $this->options = array_merge($this->defaults, $opts);

        $config = array(
            "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/", //diretorio de views
            "cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/", //diretorio de cache
            "debug"         => false // set to false to improve the speed | true só pra debugar
        );
        Tpl::configure( $config );
        $this->tpl = new Tpl;

        $this->setData($this->options["data"]);

        $this->tpl->draw("header"); //mostra o header

    }

    public function setTpl($name, $date=array(), $returnHtml = false){
        $this->setData($date);
        return $this->tpl->draw($name, $returnHtml);

    }

    public function  __destruct(){
        $this->tpl->draw("footer");//mostra o footer
    }

    private function setData($data = array()){
        foreach($data as $key => $value){
            $this->tpl->assign($key, $value);//faz a ligação
        }
    }
}


?>