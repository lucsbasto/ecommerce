<?php
session_start();

require_once("vendor/autoload.php");
use \Slim\Slim; //pra não precisar chamar new \Slim\Slim()
use \Classes\Page; // Pra criar o html do site
use \Classes\PageAdmin; //Pra criar o html do admin
use \Classes\Model\User;


$app = new Slim();

$app->config('debug', true);
//daqui pra cima é o que vou precisar pra aplicação funcionar
//daqui pra baixo é só o que me interessa
$app->get('/', function() {

    $page = new Page();
    $page->setTpl("index");

});

$app->get('/admin', function(){
    User::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl("index");
});

$app->get('/admin/login', function(){
    $page = new PageAdmin(array('header' => false, 'footer'=>false));
    $page->setTpl("login");
});

$app->post('/admin/login', function() {
    User::login($_POST["login"], $_POST["password"]);
    header("Location: /admin");
});


$app->run();

 ?>