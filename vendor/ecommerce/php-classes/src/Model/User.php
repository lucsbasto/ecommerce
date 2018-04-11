<?php

namespace Classes\Model;
use \Classes\DB\Sql;
use Classes\Model;


class User extends Model{
    const SESSION = "User";
    public static function login($login, $pass){
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :login", array(":login"=>$login));
        if(count($results) === 0 ){
            throw new \Exception("Usuário inexistente ou senha inválida", 1);
        }
        $data = $results[0];
        if (password_verify($pass, $data["despassword"])){
            $user = new User();
            $user->setData($data);//metodo da classe model que cria os getters e setters dinamicamente
            $_SESSION[User::SESSION] = $user->getValues();
            return $user;
        }
        else{
            throw new \Exception ("Usuário inexistente ou senha inválida", 1);
        }
    }

    public static function verifyLogin($inadmin = true){
        if(!isset($_SESSION[User::SESSION])
            || !$_SESSION[User::SESSION]
            || !(int)$_SESSION[User::SESSION]["iduser"] > 0
            || (bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin){
            header("Location: /admin/login");
        }
    }
}

?>