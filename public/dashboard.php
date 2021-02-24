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
	//Realizar processor de atualização com requisições "ajax"
	//Substitua a tabela, o php já tera sido processado e realizado sua mágica 
		require_once("../src/controllers/DashboardController.php");
		require_once("../myframe/componentes/ControleBanco.php");
		require_once("../myframe/componentes/ControleSessao.php");
		require_once("../myframe/componentes/User.php");


		$db = new DbConnection("localhost", 3306, "myframe_db", "root", "");
		$user = new UserController("usuario", $db);
		$session = new SessionController();
		$dashboard = new DashboardController($session, $db, $user);

		$dashboard->startSession();
		$dashboard->verifyLogin();
		$dashboard->connectDB();

		$dashboard->applyPost();

		echo $session->getKey('success'); 
	
	?>
        <header>
            <div class="container_menu">
                <div class="menu_title">
                    DASHBOARD
                </div>
                <div class="menu_content">
                    <nav>
                        <ul>
                            <li>
                                <a href="#">
                                    <div id="content_icon">
                                        <div class="profile-icon">
                                            <img src="images/foto-perfil1.png"
                                                alt="foto de perfil">
                                        </div>
                                        <img src="images/play_arrow-white-18dp.svg"
                                            alt="">
                                    </div>
                                    <div id="content_menu_icon">
                                        <a>Profile</a>
                                        <hr>
                                        <a href="../myframe/server/logout.php">Logout</a>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <main class="container">
            <section>
                <div class="sidebar">
                    <div class="secoes">
                        <a>DASHBOARD MODEL</a>
                        <a href="?secao=jogos"><img class="svg"
                                src="images/sports_esports-white-18dp.svg"
                                alt="">JOGOS</a>
                        <a href="?secao=clientes"><img class="svg"
                                src="images/face-white-18dp.svg"
                                alt="">CLIENTES</a>
                        <a href=""><img class="svg"
                                src="images/bar_chart-white-18dp.svg"
                                alt="">ESTATÍSTICA</a>
                    </div>
                </div>
                </div>
            </section>
            <aside>
                <?php
				if(!isset($_GET['secao'])) {
					echo "<h1>Bem vindo à MyFrame Dashboard</h1>";
				} else {
			?>
                <div class="table_form">
                    <form method="POST">
                        <table>
                            <?php
						if($_GET['secao'] === 'jogos') {
							echo "
							<thead>		
								<tr>
									<th>capa</th>
									<th>id</th>
									<th>titulo</th>
									<th>preco</th>
									<th>lancamento</th>
									<th>descricao</th>
									<th>produtora</th>
									<th>categoria</th>
									<th>#</th>
								</tr>
							</thead>
							";
						} else if($_GET['secao'] === 'clientes'){										
							echo "
								<tr>
									<th>id</th>
									<th>Nome</th>
									<th>Username</th>
									<th>Permissao</th>
									<th>#</th>
								</tr>
							";
						} ?>
                            <tbody id="tbody">
                                <?php 	
								foreach($dashboard->getPageContent() as $content) {
									if($_GET['secao'] === 'jogos') {
										echo "
										<tr>
											<td><input type='file' value='$content->capa'/></td>
											<td><input id='id' name='id' type='text' value='$content->id'></td>
											<td><input id='titulo' name='titulo' type='text' value='$content->titulo'></td>
											<td><input id='preco' name='preco' type='text' value='$content->preco'></td>
											<td><input id='lancamento' name='lancamento' type='text' value='$content->lancamento'></td>
											<td><input id='descricao' name='descricao' type='text' value='$content->descricao'></td>
											<td><input id='produtora' name='produtora' type='text' value='$content->produtora'></td>
											<td><input id='categoria' name='categoria' type='text' value='$content->categoria'></td>
											<td><button type='button'>&minus;</button></td>
										</tr>
										";
									} else if($_GET['secao'] === 'clientes'){										
										echo "
											<tr>
												<td><input id='id' name='id' type='text' value='$content->id'></td>
												<td><input id='nome' name='nome' type='text' value='$content->nome'></td>
												<td><input id='username' name='username' type='text' value='$content->username'></td>
												<td><input id='permissao' name='permissao' type='text' value='$content->permissao'></td>
												<td><button type='button'>&minus;</button></td>
											</tr>
										";
									}
								}
							?>
                            </tbody>
                        </table>
                        <?php if($_GET['secao'] === 'clientes') { ?>
                        <button type='submit'
                            name="aplicar"
                            id="tipo">Aplicar</button>
                        <?php } else if($_GET['secao'] === 'jogos') { ?>
                        <button type='submit'
                            name="aplicar"
                            id="tipo">Aplicar</button>
                        <button id='add'
                            type="button">&plus;</button>
                        <?php } ?>
                    </form>
                </div>
                <?php } ?>
            </aside>
        </main>

        <script src="../src/js/script.js"></script>
    </body>

</html>