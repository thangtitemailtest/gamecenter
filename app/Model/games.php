<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class games extends Model
{
	protected $table = "games";
	public $timestamps = false;

	public function getGame($gameid)
	{
		$game = $this::where('game_id', '=', $gameid)->first();

		return $game;
	}

	public function getListGame()
	{
		$game = $this::get();

		return $game;
	}
}
