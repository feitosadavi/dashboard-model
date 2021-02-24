<?php
    require_once("../componentes/ControleBanco.php");
    require_once("../componentes/ControleSessao.php");
    require_once("../componentes/User.php");

    session_start();
    $session = new SessionController();

    if( isset($_POST['username']) && isset($_POST['password']) ) {
        $db = new DbConnection("localhost", 3306, "bd_games", "root", "");
        $db->connect();

		$user = new UserController("usuario", $db);


        $hash = md5($_POST['password']);

        $user = $db->query("*", "usuario", "WHERE NOME = '$_POST[username]' AND SENHA = '$hash'");
        if(sizeOf($user) == 0) {
            $session->addKey("msgLoginError", "Usuário ou senha incorretos");
            header('Location:../../default.php');
        }
        $session->addKey("username", $_POST["username"]);
        header('Location:../../public/dashboard.php');
    }
?>