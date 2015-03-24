<?php

/**
 * @Author: winterswang
 * @Date:   2015-02-28 12:18:52
 * @Last Modified by:   winterswang
 * @Last Modified time: 2015-02-28 16:30:30
 */

	// $client = new swoole_client(SWOOLE_SOCK_UDP, SWOOLE_SOCK_SYNC);
	// if(!$client->connect('10.213.168.89',9505))
	// {
	//     exit("connect failed\n");
	// }
	// $data = array('cmd' =>2,'seq' => 1);
	// $client->send(serialize($data));
	// $data = $client->recv();
	// var_dump(unserialize($data));


	require_once "../require.php";
	//引入lib
	$path = TestAutoLoad::getFatherPath(dirname(__FILE__),2).'/lib'; //win \lib linux /lib
	TestAutoLoad::addRoot($path);
	TestAutoLoad::addRoot(dirname(dirname(__FILE__)));

	//异步使用client
	$client = new Swoole\Client\AsyncUdpClient();
	$test = new TestCall();
	$data = array('cmd' =>2,'seq' => 1);
	$client ->send('10.213.168.89',9505,serialize($data),array($test,'call_back'));
	// $client ->send('127.0.0.1',9905,'async',array($test,'call_back'));
	class TestCall {
		/**
		 * [test 异步回包处理函数]
		 * @param  [type] $r    [返回状态]
		 * @param  [type] $data [返回pb包数据]
		 * @return [type]       [description]
		 */
		public function call_back($r,$data){
			var_dump(unserialize($data));
		}
	}
?>