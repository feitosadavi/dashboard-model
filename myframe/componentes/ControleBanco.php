<?php

 class DbConnection {

    // atributos

    //conecta com o banco de dados
    public $connection;  

    // IP ou endereço http do servidor de BD
    private $host;

    // porta de conexão com o BD
    private $port;

    // nome do database
    private $db;

    // credencial de usuário para o banco
    private $username;

    // senha para acesso ao banco
    private $password;

    // construtores
    function __construct($host, $port, $db, $username, $password){
        $this->host = $host;
        $this->port = $port;
        $this->db = $db;
        $this->username = $username;
        $this->password = $password;
    }

    function __destruct(){

    }

    // metodos
    public function connect(){        
        $parameters = array(
            (!isset($this->host) ? 'host' : null), (!isset($this->port) ? 'porta' : null), 
            (!isset($this->db) ? 'db' : null), (!isset($this->username) ? 'username' : null),
            (!isset($this->password) ? 'password' : null) 
        ); 
        if(empty($parameters)) {
            foreach($parameters as $paramater) {
                echo "Preencha os seguintes parâmetros:";
                echo $paramater.', ';
            }
            exit;
        }
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->db); 
        if($this->connection->connect_errno){
            echo $this->SQL_connectionError.$this->connection->connect_errno;
        }
    }

    public function disconnect() {
        $this->connection = NULL;
    }

    public function query($key, $tableName, $aditionalSql = null) {
        $sql = "SELECT $key FROM $tableName $aditionalSql";
        $query = $this->connection->query($sql);
        $results = array();

        if(!$query) {
            return $this->SQL_commandError;
        } else {
            while($row = $query->fetch_assoc()) {//passa o registro da query para a row. Um de cada vez
                array_push($results, $row);
            }
            if($row === 0) {
                return $this->SQL_notFoundSearch;
            }
        }
        // transforma em json
        $encode = json_encode($results);
        $decode = json_decode($encode);

        return $decode;
    }

    public function insert($tableName, $values, $fields=null) {
        $arrayValues = array();
        $arrayKeys = array();
        foreach($values as $value) {
            array_push($arrayValues, $value);
            array_push($arrayKeys, key($values));
            next($values);
        }

        // Tratamento da keys
        $insertKeys = json_encode($arrayKeys);
        $insertKeys = str_replace("[", "(", $insertKeys);
        $insertKeys = str_replace("]", ")", $insertKeys);
        $insertKeys = str_replace('"', "", $insertKeys);

        //Tratamento das values
        $insertValues = json_encode($arrayValues);
        $insertValues = str_replace("[", "(", $insertValues);
        $insertValues = str_replace("]", ")", $insertValues);

        $sql = "INSERT INTO $tableName $insertKeys VALUES $insertValues";
        if($this->connection->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    function update($sql) {
        if($this->connection->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($tableName, $whereKey, $whereValue) {
        $sql = "DELETE FROM $tableName WHERE $whereKey IN ($whereValue)";
        echo $sql;
		if($this->connection->query($sql)){
			return true;
		} else {
			return false;
		}
	}

    public function toString() {
        var_dump($conexao);
    }
 }

?>