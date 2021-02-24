<?php
    class ClientesController {
        private $post;
        private $user;

        public function __construct($post, $user) {
            $this->post = $post;
            $this->user = $user;
        }

        public function update() {
            if( isset($this->post['id']) || isset($this->post['nome']) || isset($this->post['username']) || isset($this->post['permissao']) ) {	
                $comando = "";
                $whereValue = "";
                foreach($_POST as $key=>$value) {
                    $key = explode("_", $key);

                    // pega as keys que foram alteradas pelo usuário
                    if($key[0] === 'atualizar') {
                        $setKey = $key[1];
                    }

                    //se achou keys para atualizar, monta o comando
                    if(isset($setKey) && $setKey !== 'id') {
                        $index = "atualizar_$setKey";
                        $setValue = $this->post[$index];
                        $comando = $comando."$setKey = '$setValue',";

                    // a key não pode ser um id, pois id's não podem sofrer mudanças
                    } else if(isset($setKey) && $setKey === 'id') {
                        $index = "atualizar_$setKey";
                        $whereValue = $this->post[$index];
                    }
                }
                $comando = substr($comando, 0, -1);// tira a vírgula do final do comando para não dar erro no mysql
                $sql = "SET $comando WHERE (id = '$whereValue')";
                $update = $this->user->update($comando, 'id', $whereValue);
                if($update) {
                    return true;

                } else {
                    return false;
                }
                
            } else {
                $session->editKey('error', "Não há dados para atualizar");
                $session->editKey('success', null);
            }
        }

        public function delete() {
            if( isset($this->post['id']) || isset($this->post['nome']) || isset($this->post['username']) || isset($this->post['permissao']) ) {	
                $comando = "";
                $whereValue = "";
                foreach($_POST as $key=>$value) {
                    $key = explode("_", $key);

                    // pega as keys que foram deletadas pelo usuário
                    if($key[0] === 'deletar') {
                        $setKey = $key[1];
                    }
    
                    //se achou keys para atualizar, monta o comando
                    if(isset($setKey)) {
                        $index = "deletar_$setKey";
                        $setValue = $this->post[$index];
                        $whereValue = $whereValue."'$setValue',";
                    } 
                }
                $whereValue = substr($whereValue, 0, -1);// tira a vírgula do final do comando para não dar erro no mysql
                $delete = $this->user->delete('id', $whereValue);
                if($delete) {
                    return true;

                } else {
                    return false;
                }
                
            } else {
                return false;
            }
        }
    }
?>