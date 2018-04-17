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

$app->get('/admin/', function(){
    User::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl("index");
});

$app->get('/admin/login/', function(){
    $page = new PageAdmin(array(
        "header"=>false,
        "footer"=> false
    ));
    $page->setTpl("login");
});

$app->post('/admin/login', function() {
    User::login($_POST["login"], $_POST["password"]);
    //header("Location: /admin");
    exit;
});

$app->get('/admin/logout/', function(){
    User::logout();
    header("Location: /admin/login/");
    exit;
});

$app->get('/admin/users', function (){
    User::verifyLogin();
    $users = User::listAll();

    $page = new PageAdmin();
    $page->setTpl('users', array("users"=>$users));
});

$app->get('/admin/users/create', function (){
    User::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl('users-create');

});

$app->get('/admin/users/:id/delete', function ($id){
    User::verifyLogin();
});

$app->get('/admin/users/:id/', function ($id){
    User::verifyLogin();
    $user = new User();
    $user->get((int)$id);
    $page = new PageAdmin();
    $page->setTpl('users-update', array(
        "user"=> $user->getValues()
    ));
});

$app->post("/admin/users/create", function() {

    User::verifyLogin();
    $user = new User();
    $_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
    $user->setData($_POST);
    $user->save();
    header("Location: /admin/users");
    exit;

});

$app->post('/admin/users/:id', function ($id){
    User::verifyLogin();
    $user = new User();
    $_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
    $user->get($id);
    $user->setData($_POST);
    $user->update();
    header("Location: /admin/users");
    exit;

});

$app->get('/admin/users/:id/delete', function ($id){
    User::verifyLogin();
});


$app->run();

 ?>









