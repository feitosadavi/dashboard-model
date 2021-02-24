<?php
    require_once("../componentes/User.php");
    require_once("../componentes/ControleBanco.php");
    require_once("../componentes/ControleSessao.php");

    $db = new DbConnection("localhost", 3306, "myframe_db", "root", "");
    $db->connect();
    $session = new SessionController();

    $user = new UserController("usuario", $db);

    if( isset($_POST['nome']) && isset($_POST['username']) && isset($_POST['password']) ) {
        $hash = md5($_POST['password']);

        $values = (object) array(
            "id"=>uniqid(),
            "nome"=>$_POST['nome'],
            "username"=>$_POST['username'],
            "senha"=>$hash,
        );

        $user->add($values);

        $session->addKey("username", $_POST["username"]);
        header('Location:../../public/dashboard.php');
    }	

?>