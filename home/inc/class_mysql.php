<?
class Mysql{
	var $connect_id;
	
	public function connect($db_host,$db_name,$db_user,$db_pass){
		 $this->connect_id = @mysql_connect($db_host,$db_user,$db_pass);
		 if($this->connect_id){
			if(@mysql_select_db($db_name))	return $this->connect_id;	
			else $this->show_error('Not found database. '.mysql_error());
		 } 
		 else $this->show_error('Not the connect to database. '.mysql_error());
	}
	
	public function query_first($query_str){
		$q = $this->query($query_str);
		return $this->fetch_array($q);
	}
	
	public function query($query_str){
		$q = @mysql_query($query_str) or $this->show_error('<b>Mysql error:</b> '.mysql_error(), $query_str);
		return $q;
	}
	public function fetch_array($query_id){
		$fa = @mysql_fetch_array($query_id);
		return $fa;
	}
	
	public function num_rows($query_id){
		$nr = @mysql_num_rows($query_id);
		return $nr;
	}
	
	public function result($query_id, $row = 0, $field = null){
		if($field)
			$r = @mysql_result($query_id, $row, $field);
		else
			$r = @mysql_result($query_id, $row);	
		return $r;	
	}
	
	public function insert_id() {
		$i = @mysql_insert_id($this->connect_id);
		return $i;
	}
	
	public function free_result($result){
		$f = @mysql_free_result($result);
		return $f;
	}
	public function close(){
		$c = mysql_close($this->connect_id);
		return $c;
	}
	
	public function show_error($input, $query){
		$mess = $input.'<br>at query :<br>'.$query;
		die($mess);
	}

}

?>