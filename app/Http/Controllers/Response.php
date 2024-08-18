<?php

namespace App\Http\Controllers;

use Cache;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response as LaravelResponse;
use Illuminate\Routing\Controller as BaseController;
use League\Fractal;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer;
use League\Fractal\TransformerAbstract;
use Request;
use Symfony\Component\HttpFoundation\Response as Codes;

/**
 * @class Response
 * @package Http/Controllers
 * @project ChalkySticks API
 */
abstract class Response extends BaseController {
	/**
	 * Resource key attached to JSON output
	 * @var string
	 */
	protected $resourceKey = null;

	/**
	 * Additional ModelInterface embeds to include
	 * @var string
	 */
	protected $includes = null;

	/**
	 * Additional Metadata to include
	 * @var object
	 */
	protected $responseMeta = null;

	/**
	 * @constructor
	 */
	public function __construct() {
		$this->includes = Request::query('include', []);
	}

	/**
	 * @param mixed $model
	 * @param TransformerAbstract $transformer
	 * @return LaravelResponse
	 */
	public function item($model, TransformerAbstract $transformer): LaravelResponse {
		return $this->model($model, $transformer);
	}

	/**
	 * @param mixed $model
	 * @param TransformerAbstract $transformer
	 * @return LaravelResponse
	 */
	public function items($model, TransformerAbstract $transformer): LaravelResponse {
		return $this->collection($model, $transformer);
	}

	/**
	 * @param mixed $model
	 * @param TransformerAbstract $transformer
	 * @param ?string $resourceKey
	 * @return LaravelResponse
	 */
	public function model($model, TransformerAbstract $transformer, ?string $resourceKey = null): LaravelResponse {
		$resourceKey = $resourceKey ?: $this->resourceKey;
		$resource = new Fractal\Resource\Item($model, $transformer, $resourceKey);

		return $this->response($resource);
	}

	/**
	 * @param mixed $model
	 * @param TransformerAbstract $transformer
	 * @param ?string $resourceKey
	 * @return LaravelResponse
	 */
	public function collection($collection, TransformerAbstract $transformer, ?string $resourceKey = null): LaravelResponse {
		$resourceKey = $resourceKey ?: $this->resourceKey;
		$resource = new Fractal\Resource\Collection($collection, $transformer, $resourceKey);

		return $this->response($resource);
	}

	/**
	 * @param mixed $paginator
	 * @param TransformerAbstract $transformer
	 * @param ?string $resourceKey
	 * @return LaravelResponse
	 */
	public function paginate($paginator, TransformerAbstract $transformer, ?string $resourceKey = null): LaravelResponse {
		$resourceKey = $resourceKey ?: $this->resourceKey;
		$collection = $paginator->getCollection();
		$currentPage = 1;
		$lastPage = (int) $paginator->lastPage();

		$queryParams = array_diff_key($_GET, array_flip(['page']));

		// foreach ($queryParams as $key => $value) {
		// 	$paginator->addQuery($key, $value);
		// }

		$resource = new Fractal\Resource\Collection($collection, $transformer, $resourceKey);
		$resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

		return $this->response($resource);
	}

	/**
	 * Returns a successful 204 no content
	 *
	 * @return LaravelResponse
	 */
	public function noContent(): LaravelResponse {
		return $this->simpleResponse(null, Codes::HTTP_NO_CONTENT);
	}

	/**
	 * Returns a successful 201 created
	 *
	 * @param mixed $model
	 * @param TransformerAbstract $transformer
	 * @return LaravelResponse
	 */
	public function created($model = null, TransformerAbstract $transformer = null): LaravelResponse {
		if ($model) {
			return $this->model($model, $transformer);
		}

		return $this->simpleResponse(null, Codes::HTTP_CREATED);
	}

	/**
	 * Returns a 400 Bad Request based on a DB error, such as integrity
	 * violations.
	 *
	 * @param QueryException $exception
	 * @return LaravelResponse
	 */
	public function errorDatabase($exception): LaravelResponse {
		$code = is_numeric($exception) ? $exception : $exception->getCode();

		switch ($code) {
			case '1062':
			case '23000':
				$content = 'Duplicate entry found.';
				break;

			default:
				$content = 'Couldn\'t create entry.';
				break;
		}

		return $this->errorBadRequest($content);
	}

	/**
	 * Returns a 400 Bad Request error
	 *
	 * @param string $content
	 * @return LaravelResponse
	 */
	public function errorBadRequest($content = ''): LaravelResponse {
		return $this->error($content, Codes::HTTP_BAD_REQUEST);
	}

	/**
	 * Returns a 409 Conflict error
	 *
	 * @param string $content
	 * @return LaravelResponse
	 */
	public function errorConflict($content = ''): LaravelResponse {
		return $this->error($content, Codes::HTTP_CONFLICT);
	}

	/**
	 * Returns a 401 Unauthorized error
	 *
	 * @param string $content
	 * @return LaravelResponse
	 */
	public function errorUnauthorized($content = ''): LaravelResponse {
		return $this->error($content, Codes::HTTP_UNAUTHORIZED);
	}

	/**
	 * Returns a 401 Unauthorized error
	 *
	 * @param string $content
	 * @return LaravelResponse
	 */
	public function errorPermissions($content = ''): LaravelResponse {
		return $this->error($content ?: 'User does not have permissions to do this.', Codes::HTTP_UNAUTHORIZED);
	}

	/**
	 * Returns a 404 Not Found error
	 *
	 * @param string $content
	 * @return LaravelResponse
	 */
	public function errorNotFound($content = ''): LaravelResponse {
		return $this->error($content, Codes::HTTP_NOT_FOUND);
	}

	/**
	 * Returns a 405 Method Not Allowed error
	 *
	 * @param string $content
	 * @return LaravelResponse
	 */
	public function errorNotAllowed($content = ''): LaravelResponse {
		return $this->error($content, Codes::HTTP_METHOD_NOT_ALLOWED);
	}

	/**
	 * Returns a 406 Not Acceptable error
	 *
	 * @param string $content
	 * @return LaravelResponse
	 */
	public function errorNotAcceptable($content = ''): LaravelResponse {
		return $this->error($content, Codes::HTTP_NOT_ACCEPTABLE);
	}

	/**
	 * Returns a 422 Unprocessable Entity error
	 *
	 * @param string $content
	 * @return LaravelResponse
	 */
	public function errorUnprocessable($content = ''): LaravelResponse {
		return $this->error($content, Codes::HTTP_UNPROCESSABLE_ENTITY);
	}

	/**
	 * Returns a 500 Internal Server Error
	 *
	 * @param string $content
	 * @return LaravelResponse
	 */
	public function errorInternal($content = ''): LaravelResponse {
		return $this->error($content, Codes::HTTP_INTERNAL_SERVER_ERROR);
	}

	// Getters / Setters
	// ----------------------------------------------------------------------

	/**
	 * Adds includes to the existing includes array.
	 *
	 * @param string|array $includes The includes to add
	 * @return void
	 */
	public function addInclude(string|array $includes) {
		if (is_string($includes)) {
			$includes = [$includes];
		}

		$this->includes = array_merge($this->includes, $includes);
	}

	/**
	 * @return array|string|null
	 */
	public function getIncludes() {
		return Request::query('include', []);
	}

	/**
	 * @return string
	 */
	protected function getCacheKey() {
		$input = Request::all();
		ksort($input);
		$queryString = http_build_query($input);
		return Request::path() . '?$queryString';
	}

	/**
	 * @return bool
	 */
	protected function hasCache() {
		return Cache::has($this->getCacheKey());
	}

	/**
	 * @param string $content
	 * @param int $code
	 * @return LaravelResponse
	 */
	protected function error($content = '', int $code = 0): LaravelResponse {
		$response = new LaravelResponse($content, $code);
		$response->header('Content-Type', 'application/json');
		$response->header('Cache-Control', 'public');
		$response->setContent([
			'error' => true,
			'message' => $content,
			'status' => 'error',
		]);

		$response->sendHeaders();
		$response->sendContent();

		return $response;
		// throw new ApiException($content, null, null, [], $code);
	}

	/**
	 * @param mixed $resource
	 * @param int $code
	 * @return LaravelResponse
	 */
	protected function response($resource, int $code = 200): LaravelResponse {
		$resource->setResourceKey('data');

		if (isset($this->responseMeta)) {
			// $resource->setMetaValue('foo', 'bar');
			$resource->setMeta($this->responseMeta);
		}

		$manager = new Fractal\Manager;
		$manager->setSerializer(new Serializer\ArraySerializer());
		$manager->parseIncludes($this->getIncludes());

		$content = $manager->createData($resource)->toJson();

		// set cache
		if (getenv('API_CACHE') == 'true') {
			$key = $this->getCacheKey();
			$expiry = 3600; // 1 hour @todo: make this configurable
			$expiresAt = Carbon::now()->addMinutes($expiry);

			Cache::put($key, $content, $expiresAt);
			Cache::put($key . '-expiry', $expiresAt, $expiresAt);
		}

		return $this->simpleResponse($content, 200);
	}

	/**
	 * @param string $content
	 * @param int $code
	 * @param array $headers
	 * @return LaravelResponse
	 */
	protected function simpleResponse(string $content = '', int $code = 200, array $headers = []): LaravelResponse {
		$response = new LaravelResponse($content, $code);
		$response->header('Content-Type', 'application/json');
		$response->header('Cache-Control', 'public');
		$response->setExpires(@$headers['X-MCACHE-EXPIRY'] ?: new DateTime('+5 minutes'));

		// additional headers
		foreach ($headers as $key => $value) {
			$response->header($key, $value);
		}

		return $response;
	}

	/**
	 * @param object $object
	 * @param int $code
	 * @param array $headers
	 * @return LaravelResponse
	 */
	protected function json(object $object, int $code = 200, array $headers = []): LaravelResponse {
		$content = json_encode($object);
		return $this->simpleResponse($content, $code, $headers);
	}

	/**
	 * @return LaravelResponse
	 */
	protected function useCache(): LaravelResponse {
		$key = $this->getCacheKey();
		$content = Cache::get($key);
		$expiry = Cache::get($key . '-expiry');

		return $this->simpleResponse($content, 200, array(
			'X-MCACHE' => 'HIT',
			'X-MCACHE-KEY' => getenv('API_DEBUG') == 'true' ? $key : null,
			'X-MCACHE-EXPIRY' => $expiry,
		));
	}
}
