<?php
	header("Content-type:text/html;charset=utf-8");
	date_default_timezone_set('Asia/Chongqing');
	
	$app_start_time = microtime(TRUE);
	$starttime=date('Y-m-d H:i:s');
	echo "Start time is $starttime".PHP_EOL;
	echo "================================================".PHP_EOL;
	
	include_once "./class_BaseInfoFetching.php";
	include_once "./class_MarketInfoFetching.php";
	include_once "./class_DbOpertions.php";

	$obj = new MarketInfoFetching();
    $data_inserted = $obj->getTop10Holders('600109.SH');
	$obj->printInfo('debug');
	//$obj->printInfo();

	$obj = new MarketInfoFetching();
    $data_inserted = $obj->getTopList('20200914');
	$obj->printInfo('debug');
	$obj->printInfo();

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