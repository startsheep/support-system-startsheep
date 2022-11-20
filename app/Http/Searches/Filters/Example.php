<?php
namespace App\Http\Searches\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Searches\Contracts\FilterContract;

class Example implements FilterContract
{
	/** @var string|null */
	protected $example;

	/**
	 * @param string|null $example
	 * @return void
	 */
	public function __construct($example)
	{
		$this->example = $example;
	}

	/**
	 * @return mixed
	 */
	public function handle(Builder $query, Closure $next)
	{
		if (!$this->keyword()) {
			return $next($query);
		}
		$query->where('example', 'LIKE', '%' . $this->example . '%');

		return $next($query);
	}

	/**
	 * Get example keyword.
	 *
	 * @return mixed
	 */
	protected function keyword()
	{
		if ($this->example) {
			return $this->example;
	}

		$this->example = request('example', null);

		return request('example');
	}
}