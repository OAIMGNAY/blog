<?php

error_reporting(E_ALL ^E_DEPRECATED);  

/**
 * 创建数据库操作类 M
 */
class M{

	/**
	 * [$prefix description]
	 * @var $prefix    表前缀
	 * @var $table     数据表名称（包含表前缀）
	 * @var $linkID    连接ID
	 * @var $db_config  存放数据库配置信息
	 * @var $sql        存放SQL 语句
	 * @var $charset    编码
	 */
	public $prefix;       
	public $table;     
	public $linkID;       
	public $db_config;
	public $sql;      



	/**
	 * __construct 构造函数
	 * @param [type] $table       [数据表名（没有表前缀）]
	 * @param string $config_path [配置文件]
	 */
	function __construct($table,$config_path='config.php')
	{
		//将数据库配置信息写入到一个变量（db_config）当中
		if (!empty($config_path)) {
			$this->db_config = require($config_path);
		}

		$this->connect();  
		$this->table = $this->prefix.$table;
	}

	/**
	 * 连接数据库
	 * 1、获取连接数据库必要数据
	 * 2、连接数据库
	 * 3、选择数据库
	 * 4、设置编码
	 */
	private function connect(){
		$host = $this->db_config['DB_CONFIG']['DB_HOST'];
		$username = $this->db_config['DB_CONFIG']['DB_USER'];
		$password = $this->db_config['DB_CONFIG']['DB_PWD'];
		$database = $this->db_config['DB_CONFIG']['DB_DATABASE'];
		$charset = $this->db_config['DB_CONFIG']['DB_CHARSET'];
		$this->prefix = $this->db_config['DB_CONFIG']['DB_PREFIX'];

		$this->linkID = mysql_connect($host,$username,$password) or die("连接数据库失败".mysql_error());
		mysql_select_db($database);
		mysql_query("SET NAMES $charset");
	}

	/**
	 * 创建数据库
	 */
	// public function create_DB(){
	// 	$this->sql = "create database $this->table charset $this->charset"
	// }

	/**
	 * 创建数据库表
	 * @param  [array] $data      [字段=>字段类型] 是一个数组类型
	 * @return [type]            [返回true或false]
	 */
	public function create_TAB($data){
		$str= "";
		foreach ($data as $key => $value) {
			$str .= "$key $value,";
		}
		$str = rtrim($str,",");
		$this->sql = "create table $this->table($str)";
		$query = mysql_query($this->sql);
		if ($query) {
			$this->M_LOG($this->sql);
		}else{
			$this->M_LOG($this->sql,mysql_error());
		}
		return $query;
	}

	/**
	 * 向表里添加字段
	 */
	public function add_field($data){
		$str= "";
		foreach ($data as $key => $value) {
			$str .= "$key $value,";
		}
		$str = rtrim($str,",");
		$this->sql = "ALTER TABLE $this->table ADD ($str)";
		$query = mysql_query($this->sql);
		if ($query) {
			$this->M_LOG($this->sql);
		}else{
			$this->M_LOG($this->sql,mysql_error());
		}
		return $query;

	}


	/**
	 * 删除表字段
	 */
	public function drop_field($field){
		$str="";
		foreach ($field as $value) {
			$str .= "drop $value".",";
		}
		$str = rtrim($str,",");
		$this->sql = "ALTER TABLE $this->table $str";
		echo $this->sql;exit;
		$query = mysql_query($this->sql);
		if ($query) {
			$this->M_LOG($this->sql);
		}else{
			$this->M_LOG($this->sql,mysql_error());
		}
		return $query;
	}

	/**
	 * 清空数据库表
	 */
	public function truncate_TAB(){
		$this->sql = "truncate table $this->table";
		$query = mysql_query($this->sql);
		if ($query) {
			$this->M_LOG($this->sql);
		}else{
			$this->M_LOG($this->sql,mysql_error());
		}
		return $query;
	}


	/**
	 * 删除数据库表
	 */
	public function drop_TAB(){
		$this->sql = "drop table $this->table";
		$query = mysql_query($this->sql);
		if ($query) {
			$this->M_LOG($this->sql);
		}else{
			$this->M_LOG($this->sql,mysql_error());
		}
		return $query;
	}





	/**
	 * 根据条件查询数据表this->table，并返回本对象
	 * @param  integer $where [查询条件]
	 * @return [type]  $this  [对象。对象链的需要]
	 * @param  [type]  $findOne [查询一条数据]
	 * @param  [type]  $findAll [查询多条数据]
	 * @return [type]  $data  [返回查到的数据]
	 */
	public function select($where=1,$fun="",$lf_join=0){
		// echo $lf_join;
		if ($fun=="") {
			$this->sql = "SELECT * FROM $this->table WHERE $where";
		}else if($lf_join){
			$this->sql = "SELECT $fun WHERE $where";
		}else{
			$this->sql = "SELECT $fun FROM $this->table WHERE $where";
			// echo $this->sql;
		}
		return $this;
	}
	

	public function orderBy($field = array('','ASC'))
	{
		$this->sql .= " ORDER BY $field[0] $field[1] ";
		return $this;
	}

	public function limit($limit = array(0,1000))
	{
		if(count($limit) == 2){
			$this->sql .=" LIMIT $limit[0],$limit[1]";
		}else{
			$this->sql .=" LIMIT $limit[0]";
		}
		return $this;
	}


	public function findOne(){
		// echo $this->sql;echo "<br />";
		$query = mysql_query($this->sql);

		if ($query) {
			$this->M_LOG($this->sql);
		}else{
			$this->M_LOG($this->sql,mysql_error());
		}
		$data = array();
		while ($res = mysql_fetch_assoc($query)) {
			$data=$res;
		}
		return $data;
	}
	public function findAll(){
		// var_dump($this->sql);
		$query = mysql_query($this->sql);
		if ($query) {
			$this->M_LOG($this->sql);
		}else{
			$this->M_LOG($this->sql,mysql_error());
		}
		$data = array();
		while ($res = mysql_fetch_assoc($query)) {
			$data[]=$res;
		}
		return $data;

	}

	/**
	 * 向数据表this->table插入记录，并返回刚插入的记录id
	 * @param  [array] $data [要插入的数据]（写成array形式，每个key都必须是数据表的字段）
	 * @return [int]       [新记录的id]
	 */
	public function save($data){
		$key = "`".implode("`,`",array_keys($data))."`";
		$value = "'".implode("','", $data)."'";
		$this->sql = "insert into `$this->table`($key) value($value)";
		// echo $this->sql;exit;
		$query = mysql_query($this->sql);
		if ($query) {
			$this->M_LOG($this->sql);
		}else{
			$this->M_LOG($this->sql,mysql_error());
		}
		return mysql_insert_id();
	}

	/**
	 * 向数据表this->table更新一些记录，并返回所影响的记录行数
	 * @param  [array] $data  要更新的数据（写成array形式，每个key都必须是数据表的字段）
	 * @param  [string] $where   查询条件
	 * @return [int]        [所影响的记录行数]
	 */
	public function update($data,$where){
		$str= "";
		foreach ($data as $key => $value) {
			$str .= "$key='$value',";
		}
		$str = rtrim($str,",");
		$this->sql = "UPDATE $this->table SET $str WHERE $where";
		$query = mysql_query($this->sql);
		if ($query) {
			$this->M_LOG($this->sql);
		}else{
			$this->M_LOG($this->sql,mysql_error());
		}
		return mysql_affected_rows();
	}

	/**
	 * 向数据表this->table删除一些记录，并返回所影响的记录行数
	 * @param  [string] $where [查询条件]
	 * @return [int]        [所影响的记录行数]
	 */
	public function delete($where){
		$this->sql = "DELETE FROM $this->table WHERE $where";
		$query = mysql_query($this->sql);
		if ($query) {
			$this->M_LOG($this->sql);
		}else{
			$this->M_LOG($this->sql,mysql_error());
		}
		return mysql_affected_rows();
	}


	/**
	 * @php M_LOG() 数据库操作 日志  
	 * @param [string] $sql   [执行的语句]
	 * @param [string] $error [执行出现的错误]
	 * @php   file_put_contents   以追加方式把日志信息存到当前目录下的log.txt中
	 */
	public function M_LOG($sql,$error=""){
		$insert_sql="";
		if ($error) {
			$insert_sql = "[".date("Y/m/d H:i:s")."]  ".$sql." ; ERROR:  ".$error."\r\n";
		}else{
			$insert_sql = "[".date("Y/m/d H:i:s")."]  ".$sql." ; ERROR: 0 \r\n";
		}

		file_put_contents("log.txt",$insert_sql,FILE_APPEND);

		
	}


}











?>