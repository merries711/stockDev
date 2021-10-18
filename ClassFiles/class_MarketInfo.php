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
			 //*---options��ʼ��---*//
             $this->options[CURLOPT_URL] = $this->dataURL;
             $this->options[CURLOPT_TIMEOUT] = 15; 
			 $this->options[CURLOPT_RETURNTRANSFER] = true;
             //*---post_data��ʼ��---*//
             $this->post_data['token'] = $this->urlToken; 
          }  
          catch(Exception $e)  
          {   
             die(print_r($e->getMessage()));   
          }  
	   }

       //----------ͨ�÷��������ݻ�ȡ------------
	   public function infoFetching($api_name,$fields) {     
		  //*---post_data��options����---*//
          $this->post_data['api_name'] = $api_name;
		  $this->post_data['params'] = $this->params;
		  $this->post_data['fields'] = $fields;
		  if(!empty($this->post_data) && is_array($this->post_data)){
			 $this->options[CURLOPT_POST] = true;
			 $this->options[CURLOPT_POSTFIELDS] = json_encode($this->post_data);
		  }
          //*---curl��ʼ��---*//
		  $ch = curl_init();
		  curl_setopt_array($ch,$this->options);
		  if(curl_errno($ch)) {
		     print_r(curl_errno($ch)).PHP_EOL;
		     print_r(curl_getinfo($ch)).PHP_EOL;
		  }
          //*---���ݻ�ȡ---*//
          $this->json_all = json_decode(curl_exec($ch),true);
		  $this->json_insert = $this->json_all['data']['items'];
	   }

       //----------01�������۹�ͨʮ��ɽ��ɣ��ӿڣ�ggt_top10��------------
 	   public function getGgtTop10($ts_code,$trade_date,$start_date='',$end_date='',$market_type='',$fields='') {
		  //*---params����---*//
		  $this->params = array();
          $this->params['ts_code'] = $ts_code;
		  $this->params['trade_date'] = $trade_date;
		  $this->params['start_date'] = $start_date;
		  $this->params['end_date'] = $end_date;
		  $this->params['market_type'] = $market_type;
	      //----------���ݻ�ȡ------------
          $this->infoFetching('ggt_top10',$fields);
		  return $this->json_insert;
	   }

	   //----------04������ǰʮ��ɶ����ӿڣ�top10_holders��------------
 	   public function getTop10Holders($ts_code,$period='',$ann_date='',$start_date='',$end_date='',$fields='') {
		  //*---params����---*//
		  $this->params = array();
          $this->params['ts_code'] = $ts_code;
		  $this->params['period'] = $period;
		  $this->params['ann_date'] = $ann_date;
		  $this->params['start_date'] = $start_date;
		  $this->params['end_date'] = $end_date;
	      //----------���ݻ�ȡ------------
          $this->infoFetching('top10_holders',$fields);
		  return $this->json_insert;
	   }

	   //----------05������ǰʮ����ͨ�ɶ����ӿڣ�top10_floatholders��------------
 	   public function getTop10Floatholders($ts_code,$period='',$ann_date='',$start_date='',$end_date='',$fields='') {
		  //*---params����---*//
		  $this->params = array();
          $this->params['ts_code'] = $ts_code;
		  $this->params['period'] = $period;
		  $this->params['ann_date'] = $ann_date;
		  $this->params['start_date'] = $start_date;
		  $this->params['end_date'] = $end_date;
	      //----------���ݻ�ȡ------------
          $this->infoFetching('top10_floatholders',$fields);
		  return $this->json_insert;
	   }

	   //----------06������������ÿ����ϸ���ӿڣ�top_list��------------
 	   public function getTopList($trade_date,$ts_code='',$fields='') {
		  //*---params����---*//
		  $this->params = array();
		  $this->params['trade_date'] = $trade_date;
          $this->params['ts_code'] = $ts_code;
	      //----------���ݻ�ȡ------------
          $this->infoFetching('top_list',$fields);
		  return $this->json_insert;
	   }

	   //----------07�����������������ϸ���ӿڣ�top_inst��------------
 	   public function getTopInst($trade_date,$ts_code='',$fields='') {
		  //*---params����---*//
		  $this->params = array();
		  $this->params['trade_date'] = $trade_date;
          $this->params['ts_code'] = $ts_code;
	      //----------���ݻ�ȡ------------
          $this->infoFetching('top_inst',$fields);
		  return $this->json_insert;
	   }


       public function printInfo($display_level='normal') {
          if ( $display_level == 'debug' )
		  {
		     echo '---������ϢΪ�ӿڷ���Ԫ����---'.PHP_EOL;
             //print_r($this->params).print_r($this->post_data).print_r($this->options);            
			 print_r(array_slice($this->json_all,0,3));
			 print_r(array_slice($this->json_all['data'],0,1));
			 echo '[data][items]_';
			 print_r(array_slice($this->json_all['data']['items'],0,2));
			 print_r(array_slice($this->json_all['data'],2));
		  }
		  else 
		  {
             echo '---������ϢΪ�����������ݿ������---'.PHP_EOL;
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