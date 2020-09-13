<?php
	class BaseInfoFetching {  
	   private $dataURL = 'http://api.waditu.com';
	   private $urlToken = 'aa56f2e0cf3bae8ad6259bf905e6404f5f3638cc197a218690fcbd1d';
       private $params = array();
	   private $post_data = array();
	   private $options = array();
       private $json_all;
	   private $json_insert;

	   public function __construct() {
		  try
		  {
			 //*---options初始化---*//
             $this->options[CURLOPT_URL] = $this->dataURL;
             $this->options[CURLOPT_TIMEOUT] = 15; 
			 $this->options[CURLOPT_RETURNTRANSFER] = true;
             //*---post_data初始化---*//
             $this->post_data['token'] = $this->urlToken; 
          }  
          catch(Exception $e)  
          {   
             die(print_r($e->getMessage()));   
          }  
	   }

       //----------通用方法：数据获取------------
	   public function infoFetching($api_name,$fields) {     
		  //*---post_data、options设置---*//
          $this->post_data['api_name'] = $api_name;
		  $this->post_data['params'] = $this->params;
		  $this->post_data['fields'] = $fields;
		  if(!empty($this->post_data) && is_array($this->post_data)){
			 $this->options[CURLOPT_POST] = true;
			 $this->options[CURLOPT_POSTFIELDS] = json_encode($this->post_data);
		  }
          //*---curl初始化---*//
		  $ch = curl_init();
		  curl_setopt_array($ch,$this->options);
		  if(curl_errno($ch)) {
		     print_r(curl_errno($ch)).PHP_EOL;
		     print_r(curl_getinfo($ch)).PHP_EOL;
		  }
          //*---数据获取---*//
          $this->json_all = json_decode(curl_exec($ch),true);
		  $this->json_insert = $this->json_all['data']['items'];

	   }

       //----------01方法：股票列表（接口：stock_basic）------------
 	   public function getStockBasic($is_hs='',$list_status='',$exchange='',$fields='') {
		  //*---params设置---*//
		  $this->params = array();
          $this->params['is_hs'] = $is_hs;
		  $this->params['list_status'] = $list_status;
		  $this->params['exchange'] = $exchange;
	      //----------数据获取------------
          $this->infoFetching('stock_basic',$fields);
		  return $this->json_insert;
	   }

	   //----------02方法：各大交易所交易日历数据,默认提取的是上交所（接口：stock_company）------------
 	   public function getTradeCal($exchange='',$start_date='',$end_date='',$is_open='',$fields='') {
		  //*---params---*//
		  $this->params = array();
		  $this->params['exchange'] = $exchange;
		  $this->params['start_date'] = $start_date;
		  $this->params['end_date'] = $end_date;
		  $this->params['is_open'] = $is_open;
	      //----------数据获取------------
          $this->infoFetching('trade_cal',$fields);
		  return $this->json_insert;
	   }

	   //----------05方法：上市公司基本信息（接口：stock_company）------------
 	   public function getStockCompany($ts_code='',$exchange='',$fields='') {
		  //*---params---*//
		  $this->params = array();
          $this->params['ts_code'] = $ts_code;
		  $this->params['exchange'] = $exchange;
	      //----------数据获取------------
          $this->infoFetching('stock_company',$fields);
		  return $this->json_insert;	 
	   }

       //----------08方法：IPO新股列表（接口：new_share）------------
 	   public function getNewShare($start_date='',$end_date='',$fields='') {
		  //*---params---*//
		  $this->params = array();
          $this->params['start_date'] = $start_date;
		  $this->params['end_date'] = $end_date;
	      //----------数据获取------------
          $this->infoFetching('new_share',$fields);
		  return $this->json_insert;
	   }

       public function printInfo($display_level='normal') {
          if ( $display_level == 'debug' )
		  {
		     echo '---以下信息为接口返回元数据---'.PHP_EOL;
             //print_r($this->params).print_r($this->post_data).print_r($this->options);            
			 //print_r(array_slice($this->json_all,0,3));
			 //print_r(array_slice($this->json_all['data'],0,2));
			 print_r(current($this->json_all));
			 print_r(next($this->json_all));
			 print_r(next($this->json_all));
			 print_r(next($this->json_all));
			 print_r(next($this->json_all));
		  }
		  else 
		  {
             echo '---以下信息为即将插入数据库的数据---'.PHP_EOL;
		     print_r($this->json_insert);
		  }
	   }

	   function __destruct() {
		  try
	      {
		    //echo 'over'.PHP_EOL;
		  }
          catch(Exception $e)  
          {   
             die(print_r($e->getMessage()));   
          }  
	   }
	}

?>