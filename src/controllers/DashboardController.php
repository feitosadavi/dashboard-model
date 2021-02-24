<?php

	//Não tive tempo para trabalhar com os erros
		require_once("../myframe/componentes/ControleBanco.php");
		require_once("../myframe/componentes/ControleSessao.php");

	class DashboardController {
		
		private $session;
		private $db;
		private $user;
		private $pageContent;

		// Mensagens de erro
		private $updateError = "Erro ao atualizar os dados!";
		private $saveError = "Erro ao salvar os dados!"; 
		private $deleteError = "Erro ao deletar os dados!";
	
		// Mensagens de sucesso
		private $updateSuccess = "Dados atualizados com sucesso!";
		private $saveSuccess = "Dados salvos com sucesso!"; 
		private $deleteSuccess = "Dados deletados com sucesso!";

		public function __construct($session, $db, $user) {
			$this->session = $session;
			$this->db = $db;
			$this->user = $user;
		}

		public function startSession() {
			session_start();
			$this->session->addKey('error', null);
			$this->session->addKey('success', null);
		}

		public function verifyLogin() {
			// Verifica se está logado
			if($this->session->getKey('username') === null){
				header('Location: ../default.php');
				$this->session->editKey('error', 'Realize o login para acessar esta página');
				$this->session->destroy();
			}
			if(!count($_POST) < 1) {
				echo "<?php data= _POST; ?>";
			}
		}

		public function connectDB() {
			$this->db->connect();

			if(isset($_GET['secao']) && $_GET['secao'] === 'jogos') {
				$this->pageContent = $this->db->query("*", "jogo");
			} else if(isset($_GET['secao']) && $_GET['secao'] === 'clientes') {
				$this->pageContent = $this->user->show();
			}
		}

		public function applyPost() {
			// Só realiza o bloco se o usuário clicar no botão Aplicar
			if(isset($_POST['aplicar'])) {
				unset($_POST['aplicar']);

				if(isset($_GET['secao'])) {

					if($_GET['secao'] === 'jogos') {
						require_once('JogosController.php');
						$jogos = new JogosController($_POST, $this->db);
						if($jogos->update()) {
							/*
							$this->session->editKey('error', $this->updateSuccess);
							$this->session->editKey('success', null);*/

							header('Location:dashboard.php?secao=jogos');
						} else {
							/*
							$this->session->editKey('error', $this->updateError);
                			$this->session->editKey('success', null);*/
						}

						if($jogos->add()) {
							/*
							$this->session->editKey('error', $this->saveSuccess);
							$this->session->editKey('success', null);*/

							header('Location:dashboard.php?secao=jogos');
						} else {
							/*
							$this->session->editKey('error', $this->saveError);
                			$this->session->editKey('success', null);*/
						}
						if($jogos->delete()) {
							/*
							$this->session->editKey('error', $this->deleteSuccess);
							$this->session->editKey('success', null);*/

							header('Location:dashboard.php?secao=jogos');
						} else {
							/*
							$this->session->editKey('error', $this->deleteError);
                			$this->session->editKey('success', null);*/
						}
						unset($_POST);

						
					} else if ($_GET['secao'] === 'clientes') {
						require_once('ClientesController.php');
						
						$clientes = new ClientesController($_POST, $this->user, $this->session);
						if($clientes->update()) {
							/*
							$this->session->editKey('error', $this->updateSuccess);
							$this->session->editKey('success', null);*/

							header('Location:dashboard.php?secao=clientes');
						} else {
							/*
							$this->session->editKey('error', $this->updateError);
                			$this->session->editKey('success', null);*/
						}

						if($clientes->delete()) {
							/*
							$this->session->editKey('error', $this->deleteSuccess);
							$this->session->editKey('success', null);*/

							header('Location:dashboard.php?secao=clientes');
						} else {
							/*
							$this->session->editKey('error', $this->deleteError);
                			$this->session->editKey('success', null);*/
						}
						unset($_POST);
											
					} else {
						// Se tiver valores não esperados na url, a página não terá conteúdo
						$this->pageContent = [];
					}
				} else {
					$this->pageContent = [];
				}
				
			}
		}

		public function getPageContent() {
			return $this->pageContent;
		}
	}
	//lembrar de atualizar os jogos
	?>