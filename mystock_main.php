<?php
	header("Content-type:text/html;charset=utf-8");
	date_default_timezone_set('Asia/Chongqing');
	
	$app_start_time = microtime(TRUE);
	$starttime=date('Y-m-d H:i:s');
	echo "Start time is $starttime".PHP_EOL;
	echo "================================================".PHP_EOL;
	
	  include_once "./ClassFiles/class_BaseInfo.php";
	  include_once "./ClassFiles/class_MarketInfo.php";
      include_once "./ClassFiles/class_TradingInfo.php";
	  include_once "./ClassFiles/class_DbOpertions.php";

	$obj = new TradingInfo();
    $data_inserted = $obj->getDaily('','20200918');
	//$obj->printInfo('debug');
	//$obj->printInfo();

    $dbOper = new DbOpertions();
    $dbOper->dbDelete('Trading_daily');
    $dbOper->dbInsert('Trading_daily',$data_inserted);

?>