<?php
class JogosController {
    private $post;
    private $db;

    public function __construct($post, $db) {
        $this->post = $post;
        $this->db = $db;
    }

    // Atualiza os dados
    public function update(){
        $comando = "";
        if( isset($this->post['id']) || isset($this->post['titulo'])  
            || isset($this->post['capa']) || isset($this->post['lancamento'])
            || isset($this->post['descricao']) || isset($this->post['produtora'])
            || isset($this->post['categoria']) 
        ) {
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
            $sql = "UPDATE jogo SET $comando WHERE (id = '$whereValue')";
            $update = $this->db->update($sql);
            
            if($update) {
                return true;

            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    //Adiciona valores
    public function add() {
        if( isset($this->post['id']) && isset($this->post['titulo'])  
            && isset($this->post['capa']) && isset($this->post['lancamento'])
            && isset($this->post['descricao']) && isset($this->post['produtora'])
            && isset($this->post['categoria']) 
        ) {
            $_post = [];
            foreach($this->post as $post) {
                array_push($_post, $post);
            }

            $preco = floatval($_post[2]);
            $values = (object) array(
                "capa"=>$_post[7],
                "id"=>uniqid(),
                "titulo"=>$_post[1],
                "preco"=>$preco,
                "lancamento"=>$_post[3],
                "descricao"=>$_post[4],
                "produtora"=>$_post[5],
                "categoria"=>$_post[6]
            );

            $insert = $this->db->insert("jogo", $values);

            if($insert) {
                header("Location:dashboard.php?secao=jogos"); 
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    function delete() {
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
            $delete = $this->db->delete('jogo', 'id', $whereValue);
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