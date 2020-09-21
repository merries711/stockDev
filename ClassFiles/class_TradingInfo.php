<?php
	class TradingInfo {  
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

       //----------01方法：日线行情（接口：daily）------------
       //----------数据说明：交易日每天15点～16点之间。本接口是未复权行情，停牌期间不提供数据。------------
       //----------调取说明：基础积分每分钟内最多调取500次，每次5000条数据，相当于23年历史，用户获得超过5000积分正常调取无频次限制。------------
 	   public function getDaily($ts_code='',$trade_date='',$start_date='',$end_date='',$fields='') {
		  //*---params设置---*//
		  $this->params = array();
		  $this->params['ts_code'] = $ts_code;
		  $this->params['trade_date'] = $trade_date;
		  $this->params['start_date'] = $start_date;
		  $this->params['end_date'] = $end_date;
	      //----------数据获取------------
          $this->infoFetching('daily',$fields);
		  return $this->json_insert;
	   }

       public function printInfo($display_level='normal') {
          if ( $display_level == 'debug' )
		  {
		     echo '---以下信息为接口返回元数据---'.PHP_EOL;
             print_r($this->params).print_r($this->post_data).print_r($this->options);            
			 print_r(array_slice($this->json_all,0,3));
			 print_r(array_slice($this->json_all['data'],0,1));
			 echo '[data][items]_';
			 print_r(array_slice($this->json_all['data']['items'],0,2));
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