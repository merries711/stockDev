<?php
	class MarketInfo {  
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

       //----------01方法：港股通十大成交股（接口：ggt_top10）------------
 	   public function getGgtTop10($ts_code,$trade_date,$start_date='',$end_date='',$market_type='',$fields='') {
		  //*---params设置---*//
		  $this->params = array();
          $this->params['ts_code'] = $ts_code;
		  $this->params['trade_date'] = $trade_date;
		  $this->params['start_date'] = $start_date;
		  $this->params['end_date'] = $end_date;
		  $this->params['market_type'] = $market_type;
	      //----------数据获取------------
          $this->infoFetching('ggt_top10',$fields);
		  return $this->json_insert;
	   }

	   //----------04方法：前十大股东（接口：top10_holders）------------
 	   public function getTop10Holders($ts_code,$period='',$ann_date='',$start_date='',$end_date='',$fields='') {
		  //*---params设置---*//
		  $this->params = array();
          $this->params['ts_code'] = $ts_code;
		  $this->params['period'] = $period;
		  $this->params['ann_date'] = $ann_date;
		  $this->params['start_date'] = $start_date;
		  $this->params['end_date'] = $end_date;
	      //----------数据获取------------
          $this->infoFetching('top10_holders',$fields);
		  return $this->json_insert;
	   }

	   //----------05方法：前十大流通股东（接口：top10_floatholders）------------
 	   public function getTop10Floatholders($ts_code,$period='',$ann_date='',$start_date='',$end_date='',$fields='') {
		  //*---params设置---*//
		  $this->params = array();
          $this->params['ts_code'] = $ts_code;
		  $this->params['period'] = $period;
		  $this->params['ann_date'] = $ann_date;
		  $this->params['start_date'] = $start_date;
		  $this->params['end_date'] = $end_date;
	      //----------数据获取------------
          $this->infoFetching('top10_floatholders',$fields);
		  return $this->json_insert;
	   }

	   //----------06方法：龙虎榜每日明细（接口：top_list）------------
 	   public function getTopList($trade_date,$ts_code='',$fields='') {
		  //*---params设置---*//
		  $this->params = array();
		  $this->params['trade_date'] = $trade_date;
          $this->params['ts_code'] = $ts_code;
	      //----------数据获取------------
          $this->infoFetching('top_list',$fields);
		  return $this->json_insert;
	   }

	   //----------07方法：龙虎榜机构明细（接口：top_inst）------------
 	   public function getTopInst($trade_date,$ts_code='',$fields='') {
		  //*---params设置---*//
		  $this->params = array();
		  $this->params['trade_date'] = $trade_date;
          $this->params['ts_code'] = $ts_code;
	      //----------数据获取------------
          $this->infoFetching('top_inst',$fields);
		  return $this->json_insert;
	   }


       public function printInfo($display_level='normal') {
          if ( $display_level == 'debug' )
		  {
		     echo '---以下信息为接口返回元数据---'.PHP_EOL;
             //print_r($this->params).print_r($this->post_data).print_r($this->options);            
			 print_r(array_slice($this->json_all,0,3));
			 print_r(array_slice($this->json_all['data'],0,1));
			 echo '[data][items]_';
			 print_r(array_slice($this->json_all['data']['items'],0,2));
			 print_r(array_slice($this->json_all['data'],2));
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