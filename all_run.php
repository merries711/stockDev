<?php
	  header("Content-type:text/html;charset=utf-8");
	  date_default_timezone_set('Asia/Chongqing');
	
	  $prosess_start_time = microtime(TRUE);
	  $starttime=date('Y-m-d H:i:s');
	  echo "Start time is $starttime".PHP_EOL;
	  echo "================================================".PHP_EOL;
	
	  include_once "./class_BaseInfoFetching.php";
	  include_once "./class_MarketInfoFetching.php";
	  include_once "./class_DbOpertions.php";

      /* 一、基础数据（每日全量更新）*/
	  $obj = new BaseInfoFetching();
	  $dbOper = new DbOpertions();

	  function runEveryDay

	  function runFirst

	  function runHistory



      //----------01方法：股票列表（接口：stock_basic）------------
      $dbOper->dbDelete('Base_stock_basic');
      $data_inserted = $obj->getStockBasic('','L');
      //$data_inserted = array_merge($obj->getStockBasic('','L'),$obj->getStockBasic('','D'),$obj->getStockBasic('','P'));
      $dbOper->dbInsert('Base_stock_basic',$data_inserted);

	   //----------02方法：各大交易所交易日历数据,默认提取的是上交所（接口：stock_company）------------
//    $dbOper->dbDelete('Base_trade_cal');
//    $data_inserted = $obj->getTradeCal('','20180101','20201231');
//    $dbOper->dbInsert('Base_trade_cal',$data_inserted);

	 //----------03方法：股票曾用名（接口：namechange）------------
//    $dbOper->dbDelete('Base_namechange');
//    $data_inserted = $obj->getNameChange('');
//    $dbOper->dbInsert('Base_namechange',$data_inserted);

	  //----------04方法：沪深股通成份股（接口：hs_const）------------
	  $dbOper->dbDelete('Base_hs_const');
	  $data_inserted = array_merge($obj->getHsConst('SH'),$obj->getHsConst('SZ'));
	  $dbOper->dbInsert('Base_hs_const',$data_inserted);

	   //----------05方法：上市公司基本信息（接口：stock_company）------------
	  $dbOper->dbDelete('Base_stock_company');
	  $data_inserted = array_merge($obj->getStockCompany('','SSE'),$obj->getStockCompany('','SZSE'));
	  $dbOper->dbInsert('Base_stock_company',$data_inserted);

       //----------08方法：IPO新股列表（接口：new_share）------------
	  $dbOper->dbDelete('Base_new_share');
	  $data_inserted = ($obj->getNewShare('20190101','20201231'));
	  $dbOper->dbInsert('Base_new_share',$data_inserted);

	  $prosess_end_time = microtime(TRUE);
	  printf("数据获取及处理，共耗时:%.3f秒 \n", $prosess_end_time - $prosess_start_time);
	  echo PHP_EOL;






//	$tabs_array = array("Base_stock_basic","Base_trade_cal","Base_namechange",
//	                                "Base_hs_const","Base_stock_company","Base_new_share") 
//	foreach 
//	
//	
//	
//	
//	
//	$obj = new MarketInfoFetching();
//    $data_inserted = $obj->getTop10Holders('600109.SH');
//	$obj->printInfo('debug');
//	//$obj->printInfo();
//
//	$obj = new MarketInfoFetching();
//    $data_inserted = $obj->getTopList('20200914');
//	$obj->printInfo('debug');
//	$obj->printInfo();

//	  $obj->getTradeCal('','20200101','20201231',0);
//   $obj->getStockCompany();
//   $obj->getNewShare('20200821','20200823');

//$data_inserted = $obj->getNewShare();
	//print_r($data_inserted);

//    $dbOper = new DbOpertions();
//   // $dbOper->dbDelete('stock_basic');
//    $dbOper->dbInsert('trade_cal',$data_inserted);
//	//$dbOper->printInfoInserted();



?>