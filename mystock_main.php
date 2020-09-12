<?php
	header("Content-type:text/html;charset=utf-8");
	date_default_timezone_set('Asia/Chongqing');
	
	$app_start_time = microtime(TRUE);
	$starttime=date('Y-m-d H:i:s');
	echo "Start time is $starttime".PHP_EOL;
	echo "================================================".PHP_EOL;
	
	include_once "./class_BaseInfoFetching.php";
	//include_once "./class_MarketInfoFetching.php";
	include_once "./class_DbOpertions.php";

	$obj = new BaseInfoFetching();
    $data_inserted = $obj->getTradeCal();
	//$obj->printInfo('debug');
	//print_r($data_inserted);

//    $data_inserted = $obj->getNewShare('20200821','20200823');
//	//$fetch_info->printInfo('debug');
//	print_r($data_inserted);
//
    $dbOper = new DbOpertions();
   // $dbOper->dbDelete('stock_basic');
    $dbOper->dbInsert('trade_cal',$data_inserted);
	//$dbOper->printInfoInserted();



?>