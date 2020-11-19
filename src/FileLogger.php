<?php
namespace Jahan\Logger;

/**
 * FileLogger logs to file, using separate files for each log level.
 */
class FileLogger extends AbstractLogger
{
	protected $handle = [];
	protected $one_file_per_level; 
	protected $log_caller_fileline; 
	protected $log_file_extention; 
	protected $log_level;

	/**
	 * @param string $log_folder log folder must be writable by the php process.
	 * @param int	$log_level [FileLogger::DEBUG] is the minimum level to log.
	 * @param bool $log_caller_fileline [true] if set uses backtrace to get file name and line number and inclues in the log line
	 * @param bool $one_file_per_level [true] if set uses separate files for each level to store the logs
	 * @param string $log_file_extention ['.log'] sets the extention used for log files.
	 */
	public function __construct(string $log_folder, int $log_level = 0,bool $log_caller_fileline = true,bool $one_file_per_level = true,string $log_file_extention = '.log')
	{
		$this->log_level = $log_level;
		$this->one_file_per_level = $one_file_per_level;
		$this->log_caller_fileline = $log_caller_fileline;
		$this->log_file_extention = $log_file_extention;
		//if trailing forwardslash missing, add it for ease of use later.
		if(substr($log_folder, -1) != '/') {
			$log_folder .= '/';
		}
		
		if(!file_exists($log_folder)) {
			if(!file_exists(pathinfo($log_folder)['dirname'])) {
				mkdir(pathinfo($log_folder)['dirname'], 0777, true);
			}
		}

		$this->log_folder = $log_folder;
	}


	public function log(int $level,string $message, array $context = [])
	{
		if($level < $this->log_level) {
			return;		//ignore any log level below specified level
		}

		$level_file = $level;

		if(!$this->one_file_per_level) {
			$level_file = $this->log_level;	//if all logs are stored in a single file, for purpose of making the files,
						//	assume the same level for all logs.
		}

		if(empty($this->handle[$level_file])) {
			$this->handle[$level_file] = fopen($this->log_folder . self::LEVEL[$level_file] . $this->log_file_extention, 'a');
		}

		if($this->handle[$level_file] == false) {
			throw new \ErrorException("Unable to open log file for level: " . self::LEVEL[$level],1);
		}

		$log_line  = self::LEVEL[$level] . "\t" . date("Y-m-d H:i:s");

		if($this->log_caller_fileline) {
			$backtrace = debug_backtrace(null, 2);
			$log_line .= ' ' . $backtrace[1]['file'] . ' Line:' . $backtrace[1]['line'];		
		}

		$log_line .= ' Message: ';


		if(empty($context)) {
			$log_line .= $message;
		} else {
			$log_line .= $this->interpolate($message, $context);
		}

		$log_line .= PHP_EOL;

		fwrite($this->handle[$level_file], $log_line);
		fflush($this->handle[$level_file]);
	}

	public function __destruct()
	{
		foreach($this->handle as $h) {
			if(!empty($h)) {
				fclose($h);
			}			
		}
	}
}