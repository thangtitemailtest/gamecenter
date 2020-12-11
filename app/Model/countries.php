<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class countries extends Model
{
    protected $table = "countries";
	public $timestamps = false;

	public function getListCountryAraay()
	{
		$country_obj = $this::query()->get();
		$arr = [];
		foreach ($country_obj as $item) {
			$arr[$item->code] = $item->name;
		}

		return $arr;
	}

}
