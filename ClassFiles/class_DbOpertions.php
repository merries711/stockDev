<?php
    class DbOpertions {  
	   private $server_ip = '192.168.1.7';
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
		  //---��������������---
		  $query = "select name from syscolumns where id=OBJECT_ID('$tab_name') order by colorder";
		  $stmt = $this->conn->prepare($query,array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
		  $stmt->execute();  
		  $row_count = $stmt->rowCount();  
		  //---����ռλ��---
		  $bit="?";
		  for ($i = 1; $i <= $row_count-1; $i++) {
			 $bit .= ", ?";
		  }
		  //---ִ�в������--- 
		  $tsql="insert into ".$tab_name." values (".$bit.")";
		  $stmt = $this->conn->prepare($tsql,array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL)); 
		  $input_time = date("Y-m-d H:i:s");
          $inserted_rows = 0;
		  foreach ( $data_input as $v ) {
			 $v[] = $input_time;
			 $stmt->execute($v);
          }
		  //---ͳ�Ʊ��β��������---
          $tsql = "select count(*) from $tab_name where dataCreateDate = '$input_time'";
          $stmt = $this->conn->query($tsql);  
          printf("���� %1s ������������ %2d ������\n", $tab_name , $stmt->fetchColumn(0));
       }


	   function dbDelete($tab_name) {
		  //---ִ��ɾ������--- 
		  $tsql="delete from ".$tab_name;
		  $stmt = $this->conn->prepare($tsql,array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL)); 
		  $stmt->execute();
          printf("���� %1s ��������ɾ�� %2d ������\n", $tab_name , $stmt->rowCount());
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