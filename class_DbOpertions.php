<?php
    class DbOpertions {  
	   private $server_ip = '192.168.1.37';
	   private $database = 'MyStock';
	   private $uid = 'sa';
	   private $pwd = '123';
	   private $conn;
	   private $rows;

	   public function __construct() {
		  try
		  {
			$this->conn = new PDO("sqlsrv:server=$this->server_ip;Database=$this->database",$this->uid,$this->pwd); 
			$this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
		  }  
		  catch(Exception $e)  
		  {   
		     die(print_r($e->getMessage()));   
		  }  
	   }

	   function dbInsert($tab_name,$data_input) {
		   //---计算插入表的列数---
		  $query = "select name from syscolumns where id=OBJECT_ID('$tab_name') order by colorder";
		  $stmt = $this->conn->prepare($query,array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
		  $stmt->execute();  
		  $row_count = $stmt->rowCount();  
		  //---生成占位符---
		  $bit="?";
		  for ($i = 1; $i <= $row_count-1; $i++) {
			 $bit .= ", ?";
		  }
		  //---执行插入操作--- 
		  $tsql="insert into ".$tab_name." values (".$bit.")";
		  $stmt = $this->conn->prepare($tsql,array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL)); 
		  $input_time = date("Y-m-d H:i:s");
		  foreach ( $data_input as $v ) {
			 $v[] = $input_time;
			 $stmt->execute($v);
		  }
	   }

	   function dbDelete($tab_name) {
		  //---执行删除操作--- 
		  $tsql="delete from ".$tab_name;
		  $stmt = $this->conn->prepare($tsql,array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL)); 
		  $stmt->execute();
	   }

	   function printInfoInserted() {
		  foreach($this->rows as $v) 
			 {
				print_r($v).PHP_EOL;
			 }
		  }

	   function __destruct() {
		  try
		  {
			unset($this->stmt);
			unset($this->conn);
		  }
		  catch(Exception $e)  
		  {   
		     die(print_r($e->getMessage()));   
		  }  
	   }
    }

?>