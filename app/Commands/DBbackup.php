<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use DB;
use App\BackupLog;
use Storage;

class DBbackup extends Command implements SelfHandling {

	private $handler;
	private $tables = array();	//需要备份的数据表
	private $file_name = '';
	private $begin_time;
	private $yestoday_date;
	private $is_auto;
	private $dir = 'db/';
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($tables = array(), $file_name = '', $is_auto = 1)
	{
		$this->handler = DB::connection()->getPdo();
		$this->yestoday_date = date('Y-m-d',(time() - 3600*24));
		$this->setTables($tables);
		$this->getFileName($file_name);
		$this->begin_time = microtime(true);
		$this->is_auto = $is_auto;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		set_time_limit(0);
		if(!$this->checkLog()){
			return;
		}

		//存储表定义语句的数组
        $ddl = array();
        //存储数据的数组
        $data = array();

        if (!empty($this->tables))
        {
            foreach ($this->tables as $table)
            {
                $ddl[] = $this->getDDL($table);
                $data[] = $this->getData($table);
            }
            //开始写入
            $result = $this->writeToFile($this->tables, $ddl, $data);

			if($result){
				//记录日志
				$this->addLog();
			}
        }

		return;
	}


	/**
     * 检查是否需要备份
     */
	private function checkLog(){
		$backupLog = new BackupLog();

		//获取最后一天自动备份时间
		$lastLog = $backupLog->Auto()->orderBy('id','desc')->first();

		if($lastLog){
			if($lastLog->days == $this->yestoday_date){
				return false;
			}
		}
		return true;
	}


	/**
	 * 记录备份日志表
	 */
	private function addLog(){
		$backupLog = new BackupLog();

		$backupLog->days = $this->yestoday_date;
		$backupLog->use_time = microtime(true) - $this->begin_time;
		$backupLog->file_name = $this->file_name;
		$backupLog->is_auto = $this->is_auto;

		$backupLog->save();
	}

	/**
     * 设置要备份的表
     * @param array $tables
     */
    private function setTables($tables = array())
    {
        if (!empty($tables) && is_array($tables))
        {
            //备份指定表
            $this->tables = $tables;
        }
        else
        {
            //备份全部表
            $this->tables = $this->getTables();
        }
    }

	/**
     * 获取全部表
     * @return array
     */
    private function getTables()
    {
        $sql = 'SHOW TABLES';
        $list = $this->query($sql);

        $tables = array();
        foreach ($list as $value)
        {
			if(substr($value[0],0,2) == 'y_'){
				$tables[] = $value[0];
			}

        }

        return $tables;
    }


	/**
     * 获取表定义语句
     * @param string $table
     * @return mixed
     */
    private function getDDL($table = '')
    {
        $sql = "SHOW CREATE TABLE `{$table}`";
        $ddl = $this->query($sql)[0][1] . ';';
        return $ddl;
    }


	/**
     * 获取表数据
     * @param string $table
     * @return mixed
     */
    private function getData($table = '')
    {
        $sql = "SHOW COLUMNS FROM `{$table}`";
        $list = $this->query($sql);
        //字段
        $columns = '';
        //需要返回的SQL
        $query = '';
        foreach ($list as $value)
        {
            $columns .= "`{$value[0]}`,";
        }
        $columns = substr($columns, 0, -1);
        $data = $this->query("SELECT * FROM `{$table}`");
        foreach ($data as $value)
        {
            $dataSql = '';
            foreach ($value as $v)
            {
                $dataSql .= "'{$v}',";
            }
            $dataSql = substr($dataSql, 0, -1);
            $query .= "INSERT INTO `{$table}` ({$columns}) VALUES ({$dataSql});\r\n";
        }
        return $query;
    }


	/**
     * 写入文件
     * @param array $tables
     * @param array $ddl
     * @param array $data
     */
    private function writeToFile($tables = array(), $ddl = array(), $data = array())
    {
        $str = "/*\r\nMySQL Database Backup Tools\r\n";
        $str .= "Server:localhost:3306\r\n";
        $str .= "Database:myDatabase\r\n";
        $str .= "Data:" . date('Y-m-d H:i:s', time()) . "\r\n";
		$str .= "Author:smallnews \r\n*/\r\n";
        $str .= "SET FOREIGN_KEY_CHECKS=0;\r\n";
        $i = 0;
        foreach ($tables as $table)
        {
            $str .= "-- ----------------------------\r\n";
            $str .= "-- Table structure for {$table}\r\n";
            $str .= "-- ----------------------------\r\n";
            $str .= "DROP TABLE IF EXISTS `{$table}`;\r\n";
            $str .= $ddl[$i] . "\r\n";
            $str .= "-- ----------------------------\r\n";
            $str .= "-- Records of {$table}\r\n";
            $str .= "-- ----------------------------\r\n";
            $str .= $data[$i] . "\r\n";
            $i++;
        }

		// $files = Storage::allFiles();
		// print_r($files);exit;
		// Storage::put($this->file_name, $str);

		if(Storage::put($this->dir.$this->file_name, $str)){
			return true;
		}else {
			return false;
		}
    }

	/**
     * 查询
     * @param string $sql
     * @return mixed
     */
    private function getFileName($file_name)
    {
		if (!empty($file_name))
        {
			if(pathinfo($file_name, PATHINFO_EXTENSION) == 'sql'){

				$file_name = trim($file_name);
			}else{
				$file_name = str_replace('.','',trim($file_name));
				$file_name .= '.sql';
			}
        }
        else
        {
            //备份全部表
            $file_name = $this->yestoday_date."-auto-backup.sql";
        }
		$this->file_name = $file_name;
    }

	/**
     * 查询
     * @param string $sql
     * @return mixed
     */
    private function query($sql = '')
    {
        $stmt = $this->handler->query($sql);
        $stmt->setFetchMode(\PDO::FETCH_NUM);
		// print_r($stmt);
        $list = $stmt->fetchAll();
        return $list;
    }

}
