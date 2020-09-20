


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

      /* һ���������ݣ�ÿ��ȫ�����£�*/
	  $obj = new BaseInfoFetching();
	  $dbOper = new DbOpertions();
      $today = date('Ymd');

      run_EveryDay($today);

      //run_First();

      //run_History('20170101','20200917');

	  function run_EveryDay($run_day) {
          global $obj;
          global $dbOper;

          //----------01��������Ʊ�б��ӿڣ�stock_basic��------------
          $dbOper->dbDelete('Base_stock_basic');
          $data_inserted = $obj->getStockBasic('','L');
          //$data_inserted = array_merge($obj->getStockBasic('','L'),$obj->getStockBasic('','D'),$obj->getStockBasic('','P'));
          $dbOper->dbInsert('Base_stock_basic',$data_inserted);

          //----------05���������й�˾������Ϣ���ӿڣ�stock_company��------------
          $dbOper->dbDelete('Base_stock_company');
          $data_inserted = array_merge($obj->getStockCompany('','SSE'),$obj->getStockCompany('','SZSE'));
          $dbOper->dbInsert('Base_stock_company',$data_inserted);

          //----------04�����������ͨ�ɷݹɣ��ӿڣ�hs_const��------------
	      $dbOper->dbDelete('Base_hs_const');
	      $data_inserted = array_merge($obj->getHsConst('SH'),$obj->getHsConst('SZ'));
	      $dbOper->dbInsert('Base_hs_const',$data_inserted);

          //----------08������IPO�¹��б��ӿڣ�new_share��------------
          $dbOper->dbDelete('Base_new_share');
	      $data_inserted = $obj->getNewShare('20170101',$run_day);
	      $dbOper->dbInsert('Base_new_share',$data_inserted);
      }


	  function run_First() {
          global $obj;
          global $dbOper;
	      //----------02��������������������������,Ĭ����ȡ�����Ͻ������ӿڣ�stock_company��------------
          $dbOper->dbDelete('Base_trade_cal');
          $data_inserted = $obj->getTradeCal();
          $dbOper->dbInsert('Base_trade_cal',$data_inserted);
      }

	  function run_History($start_date,$end_date) {
          global $obj;
          global $dbOper;

	      //----------03��������Ʊ���������ӿڣ�namechange��------------
          $dbOper->dbDelete('Base_namechange');
          $data_inserted = $obj->getNameChange('',$start_date,$end_date);
          $dbOper->dbInsert('Base_namechange',$data_inserted);

          //----------08������IPO�¹��б��ӿڣ�new_share��------------
          $dbOper->dbDelete('Base_new_share');
	      $data_inserted = $obj->getNewShare($start_date,$end_date);
	      $dbOper->dbInsert('Base_new_share',$data_inserted);
      }


	  $prosess_end_time = microtime(TRUE);
	  printf("���ݻ�ȡ����������ʱ:%.3f�� \n", $prosess_end_time - $prosess_start_time);
	  echo PHP_EOL;


?>