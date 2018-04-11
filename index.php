<?php 

require_once("vendor/autoload.php");
use \Slim\Slim; //pra não precisar chamar new \Slim\Slim()
use \Classes\Pager; // Pra criar o html


$app = new Slim();

$app->config('debug', true);
//daqui pra cima é o que vou precisar pra aplicação funcionar
//daqui pra baixo é só o que me interessa
$app->get('/', function() {

        $page = new Pager();

        $page->setTpl("index");


});

$app->run();

 ?>