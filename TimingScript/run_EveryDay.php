<?php
	  header("Content-type:text/html;charset=utf-8");
	  date_default_timezone_set('Asia/Chongqing');
	
	  $prosess_start_time = microtime(TRUE);
	  $starttime=date('Y-m-d H:i:s');
	  echo "Start time is $starttime".PHP_EOL;
	  echo "================================================".PHP_EOL;
	
	  include_once "../ClassFiles/class_BaseInfoFetching.php";
	  include_once "../ClassFiles/class_MarketInfoFetching.php";
	  include_once "../ClassFiles/class_DbOpertions.php";

      /* 一、基础数据（每日全量更新）*/
	  $obj = new BaseInfoFetching();
	  $dbOper = new DbOpertions();
      $today = date('Ymd');

      run_EveryDay($today);

	  function run_EveryDay($run_day) {
          global $obj;
          global $dbOper;

          //----------01方法：股票列表（接口：stock_basic）------------
          $dbOper->dbDelete('Base_stock_basic');
          $data_inserted = $obj->getStockBasic('','L');
          //$data_inserted = array_merge($obj->getStockBasic('','L'),$obj->getStockBasic('','D'),$obj->getStockBasic('','P'));
          $dbOper->dbInsert('Base_stock_basic',$data_inserted);

          //----------05方法：上市公司基本信息（接口：stock_company）------------
          $dbOper->dbDelete('Base_stock_company');
          $data_inserted = array_merge($obj->getStockCompany('','SSE'),$obj->getStockCompany('','SZSE'));
          $dbOper->dbInsert('Base_stock_company',$data_inserted);

          //----------04方法：沪深股通成份股（接口：hs_const）------------
	      $dbOper->dbDelete('Base_hs_const');
	      $data_inserted = array_merge($obj->getHsConst('SH'),$obj->getHsConst('SZ'));
	      $dbOper->dbInsert('Base_hs_const',$data_inserted);

          //----------08方法：IPO新股列表（接口：new_share）------------
          $dbOper->dbDelete('Base_new_share');
	      $data_inserted = $obj->getNewShare('20170101',$run_day);
	      $dbOper->dbInsert('Base_new_share',$data_inserted);
      }

	  $prosess_end_time = microtime(TRUE);
	  printf("run_EveryDay($today)数据获取及处理，共耗时:%.3f秒 \n", $prosess_end_time - $prosess_start_time);
	  echo PHP_EOL;

?>