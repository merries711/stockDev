<?php
	class BaseInfoFetching {  
	   private $dataURL = 'http://api.waditu.com';
	   private $urlToken = 'aa56f2e0cf3bae8ad6259bf905e6404f5f3638cc197a218690fcbd1d';
       private $params = array();
	   private $postData = array();
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
             //*---postData初始化---*//
             $this->postData['token'] = $this->urlToken; 
          }  
          catch(Exception $e)  
          {   
             die(print_r($e->getMessage()));   
          }  
	   }

       //----------通用方法：数据获取------------
	   public function infoFetching($curl_options) {     
		  $ch = curl_init();
		  curl_setopt_array($ch,$curl_options);
		  if(curl_errno($ch)) {
		     print_r(curl_errno($ch)).PHP_EOL;
		     print_r(curl_getinfo($ch)).PHP_EOL;
		  }
          $this->json_all = json_decode(curl_exec($ch),true);
		  $this->json_insert = $this->json_all['data']['items'];
	   }

       //----------01方法：股票列表（接口：stock_basic）------------
 	   public function getStockBasic($is_hs='',$list_status='',$exchange='',$fields='') {
		  //*---params---*//
          $this->params['is_hs'] = $is_hs;
		  $this->params['list_status'] = $list_status;
		  $this->params['exchange'] = $exchange;
          //*---postData---*//
          $this->postData['api_name'] = 'stock_basic';
		  $this->postData['params'] = $this->params;
		  $this->postData['fields'] = $fields;
		  if(!empty($this->postData) && is_array($this->postData)){
			 $this->options[CURLOPT_POST] = true;
			 $this->options[CURLOPT_POSTFIELDS] = json_encode($this->postData);
		  }

	      //----------数据获取------------
          $this->infoFetching($this->options);
		  return $this->json_insert;
	   }

	   //----------05方法：上市公司基本信息（接口：stock_company）------------
 	   public function getStockCompany($ts_code='',$exchange='',$fields='') {
		  //*---params---*//
          $this->params['ts_code'] = $ts_code;
		  $this->params['exchange'] = $exchange;
          //*---postData---*//
          $this->postData['api_name'] = 'stock_company';
		  $this->postData['params'] = $this->params;
		  $this->postData['fields'] = $fields;
		  if(!empty($this->postData) && is_array($this->postData)){
			 $this->options[CURLOPT_POST] = true;
			 $this->options[CURLOPT_POSTFIELDS] = json_encode($this->postData);
		  }

	      //----------数据获取------------
          $this->infoFetching($this->options);
		  return $this->json_insert;
	   }

	   //----------02方法：各大交易所交易日历数据,默认提取的是上交所（接口：stock_company）------------
 	   public function getTradeCal($exchange='',$start_date='',$end_date='',$is_open='',$fields='') {
		  //*---params---*//
		  $this->params['exchange'] = $exchange;
		  $this->params['start_date'] = $start_date;
		  $this->params['end_date'] = $end_date;
		  $this->params['is_open'] = $is_open;
          //*---postData---*//
          $this->postData['api_name'] = 'trade_cal';
		  $this->postData['params'] = $this->params;
		  $this->postData['fields'] = $fields;
		  if(!empty($this->postData) && is_array($this->postData)){
			 $this->options[CURLOPT_POST] = true;
			 $this->options[CURLOPT_POSTFIELDS] = json_encode($this->postData);
		  }

	      //----------数据获取------------
          $this->infoFetching($this->options);
		  return $this->json_insert;
	   }

       //----------方法：IPO新股列表（接口：new_share）------------
 	   public function getNewShare($start_date,$end_date,$fields='') {
		  //*---params---*//
          $this->params['start_date'] = $start_date;
		  $this->params['end_date'] = $end_date;
          //*---postData---*//
          $this->postData['api_name'] = 'new_share';
		  $this->postData['params'] = $this->params;
		  $this->postData['fields'] = $fields;
		  if(!empty($this->postData) && is_array($this->postData)){
			 $this->options[CURLOPT_POST] = true;
			 $this->options[CURLOPT_POSTFIELDS] = json_encode($this->postData);
		  }

	      //----------数据获取------------
          $this->infoFetching($this->options);
		  return $this->json_insert;
	   }


       public function printInfo($display_level='normal') {
          if ( $display_level == 'debug' )
		  {
		     echo '---以下信息为接口初始返回的信息---'.PHP_EOL;
             print_r($this->json_all).PHP_EOL;
		  }
		  else 
		  {
             echo '---以下信息为即将插入数据库的信息---'.PHP_EOL;
		     print_r($this->json_insert).PHP_EOL;
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