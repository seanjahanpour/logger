# Logger
## Logger Abstract
Basic implementation of Logger Abstract, without log function.

## File Logger
Log entries in a file. Implements Jahan\Logger\AbstractLogger.

#### function __construct(string $log_folder,bool $log_caller_fileline = true,bool $one_file_per_level = true,string $log_file_extention = '.log')
###### Parameters
- string $log_folder log folder must be writable by the php process.
- int $log_level [FileLogger::DEBUG] is the minimum level to log.
- bool $log_caller_fileline [true] if set uses backtrace to get file name and line number and inclues in the log line
- bool $one_file_per_level [true] if set uses separate files for each level to store the logs
- string $log_file_extention ['.log'] sets the extention used for log files.

#### function emergency	(string $message, array $context = [])
#### function alert	(string $message, array $context = [])
#### function critical	(string $message, array $context = [])
#### function error	(string $message, array $context = [])
#### function warning	(string $message, array $context = [])
#### function notice	(string $message, array $context = [])
#### function info	(string $message, array $context = [])
#### function debug	(string $message, array $context = [])

###### Parameters
- string $message is the message to store in the log
- array $context is optional key=>balue array for interpolation.
###### Throws
- ErrorException if unable to open log file.
###### Note
Any log level over mininmum log level specified via contrstuctor is ignored.

#### Example
```
use Jahan\Logger\FileLogger;
...
$logger = new FileLogger('/log_folder');
$logger->info("This is a info log level message");
$logger->critical("This is a critical log level message");
$logger->debug("This is a debug log level message");

$newlogger = new FileLogger('/log_folder', FileLogger::ERROR);
$newlogger->info("This is a info log level message");			//ignored
$newlogger->critical("This is a critical log level message");
$newlogger->debug("This is a debug log level message");			//ignored
```

# Installation
## Composer
```
php composer.phar require jahan/logger
```
