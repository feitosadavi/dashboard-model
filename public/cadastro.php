<!DOCTYPE html>
<html>

    <head>
        <title>Dashboard</title>
        <meta charset="UTF-8">
        <meta name="viewport"
            content="width=device-width, user-scalable=0">
        <link rel="stylesheet"
            type="text/css"
            href="../src/css/index.css">
        <link rel="preconnect"
            href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap"
            rel="stylesheet">
    </head>

    <body>
        <?php 
		require_once("../myframe/componentes/ControleBanco.php");
		require_once("../myframe/componentes/ControleSessao.php");
		require_once("../myframe/componentes/User.php");
	?>
        <header>
            <div class="container_menu">
                <div class="menu_title">
                    DASHBOARD
                </div>
            </div>
        </header>

        <main class="container">
            <section>
                <div class="sidebar">
                    <div class="secoes">
                        <a>DASHBOARD MODEL</a>
                        <p>Faça o cadastro para acessar a dashboard da loja</p>
                    </div>
                </div>
            </section>
            <aside>
                <div class="login_form">
                    <h1>Cadastro</h1>
                    <form method="POST"
                        action="../myframe/server/cadastro.php">
                        <label for="nome">Nome</label>
                        <input type="text"
                            id="nome"
                            name="nome">

                        <label for="username">Username</label>
                        <input type="text"
                            id="username"
                            name="username">

                        <label for="password">Password</label>
                        <input type="password"
                            id="password"
                            name="password">

                        <div class="login_footer">
                            <button>Cadastrar</button>
                        </div>
                    </form>
                </div>
            </aside>
        </main>
    </body>

</html>