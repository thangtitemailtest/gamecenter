<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class player extends Model
{
	protected $table = "player";
	public $timestamps = false;

	public function getPlayer($gameid, $deviceid)
	{
		$player = $this::where('game_id', '=', $gameid)->where('deviceid', '=', $deviceid)->first();

		return $player;
	}
}
