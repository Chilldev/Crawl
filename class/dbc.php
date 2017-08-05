<?php
class dbc{
	protected $host;
	protected $username;
	protected $password;
	protected $dbname;
	protected $conn;

	function __construct($config){
		dbc::filtering(extract($config));
		$this->host     = $host;
		$this->username = $username;
		$this->password = $password;
		$this->dbname   = $dbname;
	}

	protected function dbconnect(){
		$this->conn = mysqli_connect($this->host,$this->username,$this->password,$this->dbname);
		$this->conn->set_charset("utf8");
		mysqli_query($this->conn,"SET CHARACTER_SET utf8;");
		mysqli_query($this->conn,"SET NAMES utf8;");
		return $this->conn;
	}

	public function insert($table,$data){
		$sql = dbc::filtering("INSERT into $this->dbname.$table VALUES ($data);");
		return $this->set_to_database($sql);
	}

	public function update($table,$data,$clause){
		$sql = dbc::filtering("UPDATE $this->dbname.$table SET $data WHERE $clause;");
		return $this->set_to_database($sql);
	}

	public function delete($table,$column,$clause){
		$sql = dbc::filtering("DELETE FROM $this->dbname.$table WHERE $table.$column = '$clause';");
		return $this->set_to_database($sql);
	}
	
	public function deleteand($table,$clause){
		$sql = dbc::filtering("DELETE FROM $this->dbname.$table WHERE $clause;");
		return $this->set_to_database($sql);
	}

	public function select($selection,$table,$clause){
		$sql = dbc::filtering("select $selection from $table where $clause;");
		return $this->get_from_database($sql);
	}

	public function select_all($table,$order=''){
		$sql = dbc::filtering("select * from $this->dbname.$table $order;");
		return $this->get_from_database($sql);
	}

	function insertpathes($table,$data){
		$sql="insert into $table VALUES ($data);";
	    return $this->set_to_database($sql);
	}

	function selectpathes($selection,$table,$clause){
		$sql ="select $selection from $this->dbname.$table WHERE $clause;";
		return $this->get_from_database($sql);
	}

	function set_to_database($sql){
		if(!mysqli_query($this->dbconnect(),$sql)){
			return mysqli_error(dbc::dbconnect());
		}else{
			return true;
		}
	}


	function get_from_database($sql){
		if(!$result=mysqli_query($this->dbconnect(),$sql)){
			return mysqli_error(dbc::dbconnect());
		}else{
			return $result;
		}
	}


	private function filtering($data){
   	    $data = mysqli_real_escape_string(dbc::dbconnect(),$data);
		$data = trim($data);
  		$data = stripslashes($data);
 		return $data;
	}
}
