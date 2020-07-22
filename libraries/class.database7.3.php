<?php if(!defined('_lib')) die("Error");
class database{ 
	var $db;
	var $result;
	var $insert_id;
	var $sql = "";
	var $refix = "";
	var $servername;
	var $username;
	var $password;
	var $database;	
	var $table = "";
	var $where = "";
	var $order = "";
	var $limit = "";	
	var $error = array();
	
	function __construct($config = array()){
		if(!empty($config)){
			$this->init($config);
			$this->connect();
		}
	}
	function init($config = array()){
		foreach($config as $k=>$v)
			$this->$k = $v;
	}	
	function connect(){
		$this->db = mysqli_connect($this->servername, $this->username, $this->password);
		if( !$this->db){
			die('Could not connect: ' /*. mysql_error()*/);
		}
		if( !mysqli_select_db($this->db,$this->database)){
			die(mysqli_errno($this->db) . ": " . mysqli_error($this->db));
			return false;
		}
		
		mysqli_query($this->db,'SET NAMES "utf8"');
	}	
	function query($sql=""){
		if($sql)
			$this->sql = str_replace('#_', $this->refix, $sql);

		$this->result = mysqli_query($this->db,$this->sql);

		if(!$this->result){
			die(mysqli_errno($this->db) . ": " . mysqli_error($this->db));
			die("syntax error: ".$this->sql);
		}
		return $this->result;	
	}
	function insert($data = array()){
		$key = "";
		$value = "";
		foreach($data as $k => $v){
			$key .= "," . $k;
			$value .= ",'" . $v  ."'";
		}
		if($key{0} == ",") $key{0} = "(";
		$key .= ")";
		if($value{0} == ",") $value{0} = "(";
		$value .= ")";
		$this->sql = "insert ignore into ".$this->refix.$this->table.$key." values ".$value;
		$this->query();
		$con=$this->db;
		$this->insert_id = mysqli_insert_id($con);
		return $this->result;
	}	
	function update($data = array()){//die('ok6');
		$values = "";
		foreach($data as $k => $v){
			$values .= ", " . $k . " = '" . $v  ."' ";
		}
		if($values{0} == ",") $values{0} = " ";
		$this->sql = "update ignore " . $this->refix . $this->table . " set " . $values;
		$this->sql .= $this->where;
		return $this->query();
	}
	
	function delete(){//die('ok7');
		$this->sql = "delete from " . $this->refix . $this->table . $this->where;
		return $this->query();
	}
	
	function select($str = "*"){//die('ok8');
		$this->sql = "select " . $str;
		$this->sql .= " from " . $this->refix .$this->table;
		$this->sql .=  $this->where;
		$this->sql .=  $this->order;
		$this->sql .=  $this->limit;
		return $this->query();
	}
	
	function num_rows(){//die('ok9');
		return mysqli_num_rows($this->result);
	}
	 function num_fields ($query_id) {//die('ok10');
	    return mysqli_num_fields($query_id);
  	}

	function fetch_array(){
		return mysqli_fetch_assoc($this->result);
	}
	
	function result_array(){
		ini_set('memory_limit', '-1');
		$arr = array();
		 $this->sql;
		
		

		 while ($row = mysqli_fetch_assoc($this->result)){
		 	$arr[] = $row;
		 }

		// foreach ($row as $key => $value) {
		// 	$arr[] = $row;
		// }
	
		return $arr; 
	}
	
	function setTable($str){
		$this->table = $str;
	}
	
	function setWhere($key, $value=""){
		if($value!=""){
			if($this->where == "")
				$this->where = " where " . $key . " = '" . $value . "'";
			else
				$this->where .= " and " . $key . " = '" . $value ."'";
		}
		else{
			if($this->where == "")
				$this->where = " where " . $key ;
			else
				$this->where .= " and " . $key ;
		}
	}
	
	function setWhereOr($key, $value){
		if($value!=""){
			if($this->where == "")
				$this->where = " where " . $key . " = " . $value;
			else
				$this->where .= " or " . $key . " = " . $value;
		}
		else{
			if($this->where == "")
				$this->where = " where " . $key ;
			else
				$this->where .= " or " . $key ;
		}
	}
	
	function setOrder($str){
		$this->order = " order by " . $str;
	}
	
	function setLimit($str){
		$this->limit = " limit " . $str;
	}
	
	function setError($msg){
		$this->error[] = $msg;
	}
	
	function showError(){
		foreach($this->error as $value)
			echo '<br>'.$value;
	}
	
	function reset(){
		$this->sql = "";
		$this->result = "";
		$this->where = "";
		$this->order = "";
		$this->limit = "";
		$this->table = "";
	}
	
	function debug(){
		echo "<br> servername: ".$this->servername;
		echo "<br> username: ".$this->username;
		echo "<br> password: ".$this->password;
		echo "<br> database: ".$this->database;
		echo "<br> ".$this->sql;
	}
	
	/**
	 * Escape String
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function escape_str($str) {
		if (is_array($str))
    	{
    		foreach($str as $key => $val)
    		{
    			$str[$key] = $this->escape_str($val);
    		}
    		
    		return $str;
    	}
	
		if (function_exists('mysqli_real_escape_string'))
		{
			return mysqli_real_escape_string($this->db, $str);
		}
		elseif (function_exists('mysqli_escape_string'))
		{
			return mysqli_escape_string($this->db, $str);
		}
		else
		{
			return addslashes($str);
		}
	}
	
	function xssClean($str){
		#$str = htmlentities($str, ENT_QUOTES, "UTF-8");
		$str = str_replace("'", '&#039;', $str);
		$str = str_replace('"', '&quot;', $str);
		$str = str_replace('<', '&lt;', $str);
		$str = str_replace('>', '&gt;', $str);
		#$str = addslashes($str);
		return $str;
	}
}

function mysql_query($stringSQL){
	global $d,$lang;
	 $stringSQL=str_replace('= ',"=''",$stringSQL);
	return $d->query($stringSQL);
}

function mysql_fetch_array($stringSQL){
	global $d,$lang;
	return $d->fetch_array($stringSQL);

	
}

function mysql_insert_id(){
	global $d,$lang;
	return $d->insert_id;
}
function mysql_fetch_assoc(){
		global $d;
	return mysqli_fetch_assoc($d->query($query));
}

?>