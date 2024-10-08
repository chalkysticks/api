<?php

namespace App\Core\Exception;

use Exception;
use ReflectionFunction;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

/**
 * @class Handler
 * @package Core/Exception
 * @project ChalkySticks API
 */
class Handler {
	/**
	 * Array of exception handlers.
	 *
	 * @var array
	 */
	protected $handlers = [];

	/**
	 * Register a new exception handler.
	 *
	 * @param callable $callback
	 *
	 * @return void
	 */
	public function register(callable $callback) {
		$hint = $this->handlerHint($callback);

		$this->handlers[$hint] = $callback;
	}

	/**
	 * Handle an exception if it has an existing handler.
	 *
	 * @param \Exception $exception
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function handle(Exception $exception) {
		foreach ($this->handlers as $hint => $handler) {
			if (!$exception instanceof $hint) {
				continue;
			}

			$response = $handler($exception);

			if (!is_null($response)) {
				if (!$response instanceof Response) {
					$response = new Response($response, $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 200);
				}

				return $response;
			}
		}

		throw $exception;
	}

	/**
	 * Determine if the handler will handle the given exception.
	 *
	 * @param \Exception $exception
	 *
	 * @return bool
	 */
	public function willHandle(Exception $exception) {
		if ($exception instanceof ApiException) {
			return false;
		}

		if ($exception instanceof MethodNotAllowedHttpException) {
			return false;
		}

		return true;
	}

	/**
	 * Get the hint for an exception handler.
	 *
	 * @param callable $callback
	 *
	 * @return string
	 */
	protected function handlerHint(callable $callback) {
		$reflection = new ReflectionFunction($callback);

		$exception = $reflection->getParameters()[0];

		return $exception->getClass()->getName();
	}

	/**
	 * Get the exception handlers.
	 *
	 * @return array
	 */
	public function getHandlers() {
		return $this->handlers;
	}
}
