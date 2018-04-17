<?php
namespace Classes;


class Model{
    private $values= [];

    public function __call($name, $args){
        $method = substr($name, 0, 3);
        $fieldName = substr($name, 3, strlen($name));
        switch ($method){
            case "get":
                var_dump($this->values[$fieldName]);
                return $this->values[$fieldName];
            break;

            case "set":
                $this->values[$fieldName] = $args[0];
            break;

        }
    }
    public function setData($data = array()){
        foreach ($data as $key => $value){
            //ex: setLogin(parametros){}
            $this->{"set$key"}($value); //faz a chamada dos getters e setters dinamicamente
        }
    }
    public function getValues(){
        return $this->values;
    }
}