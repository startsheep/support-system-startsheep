<?php

namespace App\Http\Searches;

use Illuminate\Database\Eloquent\Model;

class ExampleSearch extends HttpSearch
{

 	protected function passable()
	{
		return Model::query();
	}

	protected function filters(): array
	{
		return [
 
		];
	}

	protected function thenReturn($exampleSearch)
	{
		return $exampleSearch;
	}
}