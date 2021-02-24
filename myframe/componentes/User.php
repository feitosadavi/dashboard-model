<?php 

	require_once("ControleBanco.php");

	class UserController {

		private $tableName;
		private $db;

		function __construct($tableName, $db) {
			$this->tableName = $tableName;
			$this->db = $db;
		}

		function __destruct(){

    }

		//métodos
		function show($key = "*", $whereKey = null, $whereValue = null, $aditionalSql = null) {//Se não inserir parâmetro será: SELECT * FROM USUÁRIOS
			$where = $whereKey && $whereValue ? "WHERE $whereKey = $whereValue" : null;
			return $this->db->query($key, $this->tableName, "$where $aditionalSql");
		}
		function add($fields_values) {
			return $this->db->insert($this->tableName, $fields_values);
		}
		function update($command, $whereKey = null, $whereValue = null) {
			$sql = "UPDATE $this->tableName SET $command WHERE ($whereKey = '$whereValue')";
			return $this->db->update($sql);
		}
		function delete($whereKey, $whereValue) {
			return $this->db->delete($this->tableName, $whereKey, $whereValue);
		}
	}
?>