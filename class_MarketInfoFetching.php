<?php
//    header("Content-type:text/html;charset=utf-8");
//	date_default_timezone_set('Asia/Chongqing');

	class MarketInfoFetching {  
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
			 //*---options---*//
             $this->options[CURLOPT_URL] = $this->dataURL;
             $this->options[CURLOPT_TIMEOUT] = 15; 
			 $this->options[CURLOPT_RETURNTRANSFER] = true;
             //*---postData---*//
             $this->postData['token'] = $this->urlToken; 
          }  
          catch(Exception $e)  
          {   
          die(print_r($e->getMessage()));   
          }  
	   }

 	   public function getTopInfo($api_name,$trade_date,$ts_code='',$fields='') {
		  //*---params---*//
          $this->params['trade_date'] = $trade_date;
		  $this->params['ts_code'] = $ts_code;
          //*---postData---*//
          $this->postData['api_name'] = $api_name;
		  $this->postData['params'] = $this->params;
		  $this->postData['fields'] = $fields;
          //*---postData---*//
		  if(!empty($this->postData) && is_array($this->postData)){
			 $this->options[CURLOPT_POST] = true;
			 $this->options[CURLOPT_POSTFIELDS] = json_encode($this->postData);
		  }

	      //----------数据获取------------
		  $ch = curl_init();
		  curl_setopt_array($ch,$this->options);

		  if(curl_errno($ch)) {
		     print_r(curl_errno($ch));
		     echo "\n----------------------------------------------\n";
		     print_r(curl_getinfo($ch));
		     echo "------------------------------------------------\n";
		  }

          $this->json_all = json_decode(curl_exec($ch),true);
		  $this->json_insert = $this->json_all['data']['items'];
	   }

       public function printTopInfo() {
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

	$fetch_info = new StockInfoFetching;
    $fetch_info->getTopInfo('top_inst','20200823');
    //$fetch_info->printTopInfo();

?>