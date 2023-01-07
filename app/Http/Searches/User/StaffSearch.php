<?php

namespace App\Http\Searches\User;

use Illuminate\Database\Eloquent\Model;

class StaffSearch extends HttpSearch
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

	protected function thenReturn($staffSearch)
	{
		return $staffSearch;
	}
}