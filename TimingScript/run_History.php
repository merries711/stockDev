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

      run_History('20200901',$today);

	  function run_History($start_date,$end_date) {
          global $obj;
          global $dbOper;

	      //----------03方法：股票曾用名（接口：namechange）------------
          $dbOper->dbDelete('Base_namechange');
          $data_inserted = $obj->getNameChange('',$start_date,$end_date);
          $dbOper->dbInsert('Base_namechange',$data_inserted);

          //----------08方法：IPO新股列表（接口：new_share）------------
          $dbOper->dbDelete('Base_new_share');
	      $data_inserted = $obj->getNewShare($start_date,$end_date);
	      $dbOper->dbInsert('Base_new_share',$data_inserted);
      }

	  $prosess_end_time = microtime(TRUE);
	  printf("run_History()数据获取及处理，共耗时:%.3f秒 \n", $prosess_end_time - $prosess_start_time);
	  echo PHP_EOL;

?>

