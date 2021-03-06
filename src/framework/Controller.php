<?php
/**
 * @Author: winterswang
 * @Date:   2014-11-27 14:58:28
 * @Last Modified by:   winterswang
 * @Last Modified time: 2015-03-24 11:17:41
 */
class Controller
{
	protected $server; //启动controller的server实例

	protected $argv = array();
	protected $request;
	protected $fd;

	/**
	 * [__construct 构造函数完成PB数据的解析]
	 * @param [type] $pbData [description]
	 */

	function __construct($server, $fd ,$argv = array()){

		$this ->server = $server;
		$this ->argv = $argv;
		$this ->fd = $fd;
	}

	/**
	 * [addTask 讲实例加入到task进程内]
	 * @param [type] $task [task实例对象]
	 */
	public function addTask($task){
		return $this ->server ->task(serialize($task));
	}


	/**
	 * [init 根据协议解析的数据和server类型，初始化全局变量数据]
	 * @return [type] [description]
	 */
	public function init(){
		if (isset($this ->argv['serverType']) && $this ->argv['serverType'] == 'http') {
			$this ->request = $this ->argv['request'];
		}
	}

	public function addTimer($interval, $userFlag, $obj, $func){
		// 注册到Timer静态类
		if(!Timer::addTimer($interval, $userFlag, array($obj,$func))) return false;
		return $this ->server ->addTimer($interval);
	}

	public function delTimer($interval, $userFlag, $obj){
		// 从Timer静态类中清楚该定时器
		Timer::delTimer($interval, $userFlag);
        if(Timer::getCount($interval) === 0) {
            $this ->server ->delTimer($interval);
        }
	}
}
