<?php
	  header("Content-type:text/html;charset=utf-8");
	  date_default_timezone_set('Asia/Chongqing');
	
	  $prosess_start_time = microtime(TRUE);
	  $starttime=date('Y-m-d H:i:s');
	  echo "Start time is $starttime".PHP_EOL;
	  echo "================================================".PHP_EOL;
	
	  include_once "../ClassFiles/class_BaseInfo.php";
	  include_once "../ClassFiles/class_MarketInfo.php";
	  include_once "../ClassFiles/class_DbOpertions.php";

      /* 一、基础数据（每日全量更新）*/
	  $obj = new BaseInfo();
	  $dbOper = new DbOpertions();
      $today = date('Ymd');

      run_First();

	  function run_First() {
          global $obj;
          global $dbOper;
	      //----------02方法：各大交易所交易日历数据,默认提取的是上交所（接口：stock_company）------------
          $dbOper->dbDelete('Base_trade_cal');
          $data_inserted = $obj->getTradeCal();
          $dbOper->dbInsert('Base_trade_cal',$data_inserted);
      }

	  $prosess_end_time = microtime(TRUE);
	  printf("run_First()数据获取及处理，共耗时:%.3f秒 \n", $prosess_end_time - $prosess_start_time);
	  echo PHP_EOL;

?>

