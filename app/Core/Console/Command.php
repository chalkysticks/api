<?php

namespace Core\Console;

use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;

/**
 * @class Command
 * @package Core/Console
 * @project ChalkySticks API
 */
class Command extends \Illuminate\Console\Command {

	const INDENT_NONE = 0;
	const INDENT_ONE = 1;
	const INDENT_TWO = 2;
	const INDENT_THREE = 3;

	/**
	 * @param mixed $arguments
	 */
	public function __construct($arguments = array()) {
		parent::__construct();

		$this->input = new Input\MockInput($arguments);
	}

	/**
	 * Summary of log
	 * @param string $string
	 * @param int $indentation
	 * @return void
	 */
	public function log(string $string, int $indentation = 0) {
		$string = (str_repeat("    ", $indentation)) . $string;

		\Log::info("[$this->name] $string");
	}

	/**
	 * Test echo log method that can be overriden
	 *
	 * @param string $string
	 * @param int $indentation
	 * @return bool
	 */
	public function debug(string $string, int $indentation = 0) {
		$this->log($string, $indentation);

		$log = new Logger($this->name);
		$stream = new StreamHandler($this->getDebugFilepath());
		$formatter = new LineFormatter(null, null, true, true);

		$stream->setFormatter($formatter);
		$log->pushHandler($stream);

		return false;
	}


	// Helpers
	// -------------------------------------------------

	protected function getErrorFilepath() {
		$filename = 'error.' . str_replace('\\', '_', get_called_class()) . '.log';
		$path = storage_path() . '/logs/';

		return $path . $filename;
	}

	protected function getDebugFilepath() {
		$filename = 'debug.' . str_replace('\\', '_', get_called_class()) . '.log';
		$path = storage_path() . '/logs/';

		return $path . $filename;
	}
}
