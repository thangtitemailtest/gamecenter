<?php

namespace App\Http\Controllers;

use App\Model\eventname;
use App\Model\games;
use Illuminate\Http\Request;
use App\Model\logevent;

class ReportController extends Controller
{

	function getUserconlaisaulevel(Request $request)
	{
		$params = $request->all();

		$game = new games();
		$listGame = $game->getListGame();

		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
				'gameid' => ''
			];
			$datachart = json_encode($datachart);
			return view('report.userconlaisaulevel', compact('input', 'datachart', 'listGame'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
		}

		$log = new logevent();
		$logevent = $log->SoUserConLaiSauCacLevel($input)->get();

		$deviceid = '';
		foreach ($logevent as $item) {
			if ($item->level > 0) {
				if ($deviceid != $item->deviceid) {
					$lv = $item->level;
					$deviceid = $item->deviceid;
					$datachart[$lv - 1]['soluong']++;
				}
			}
		}
		$datachart = json_encode($datachart);

		return view('report.userconlaisaulevel', compact('input', 'datachart', 'listGame'));
	}

	function getSotiencuausertheolevel(Request $request)
	{
		$params = $request->all();

		$game = new games();
		$listGame = $game->getListGame();

		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
				'gameid' => ''
			];
			return view('report.sotiencuausertheolevel', compact('input', 'listGame'));
		} else {
			$input = $params;
		}

		$log = new logevent();
		$logevent = $log->LocSoTienCuaUser($input)->get();

		$level_truoc = -1;
		$deviceid_truoc = '';

		foreach ($logevent as $key => $item) {
			if ($deviceid_truoc == $item->deviceid && $level_truoc == $item->level) {
				$logevent->forget($key);
			}

			$deviceid_truoc = $item->deviceid;
			$level_truoc = $item->level;
		}

		$logpagi = $logevent->paginate(100);

		return view('report.sotiencuausertheolevel', compact('input', 'logpagi', 'listGame'));
	}

	function getLocsonguoichoipass(Request $request)
	{
		$params = $request->all();

		$game = new games();
		$listGame = $game->getListGame();

		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
				'gameid' => ''
			];
			$datachart = json_encode($datachart);
			return view('report.locsonguoichoipass', compact('input', 'datachart', 'listGame'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
		}

		$log = new logevent();
		$logevent = $log->LocSoNguoiChoiPass($input)->get();

		$deviceid = '';
		$lv_truoc = 0;
		foreach ($logevent as $item) {
			if ($item->level > 0) {
				if ($lv_truoc === $item->level && $deviceid === $item->deviceid) {
					continue;
				}

				$lv = $item->level;
				$datachart[$lv - 1]['soluong']++;

				$deviceid = $item->deviceid;
				$lv_truoc = $item->level;
			}
		}

		$datachart = json_encode($datachart);

		return view('report.locsonguoichoipass', compact('input', 'datachart', 'listGame'));
	}

	function getLocsonguoichoistart(Request $request)
	{
		$params = $request->all();

		$game = new games();
		$listGame = $game->getListGame();

		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
				'gameid' => ''
			];
			$datachart = json_encode($datachart);
			return view('report.locsonguoichoistart', compact('input', 'datachart', 'listGame'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
		}

		$log = new logevent();
		$logevent = $log->LocSoNguoiChoiStart($input)->get();

		$deviceid = '';
		$lv_truoc = 0;
		foreach ($logevent as $item) {
			if ($item->level > 0) {
				if ($lv_truoc === $item->level && $deviceid === $item->deviceid) {
					continue;
				}

				$lv = $item->level;
				$datachart[$lv - 1]['soluong']++;

				$deviceid = $item->deviceid;
				$lv_truoc = $item->level;
			}
		}

		$datachart = json_encode($datachart);

		return view('report.locsonguoichoistart', compact('input', 'datachart', 'listGame'));
	}

	function getLocsonguoichoilose(Request $request)
	{
		$params = $request->all();

		$game = new games();
		$listGame = $game->getListGame();

		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
				'gameid' => ''
			];
			$datachart = json_encode($datachart);
			return view('report.locsonguoichoilose', compact('input', 'datachart', 'listGame'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
		}

		$log = new logevent();
		$logevent = $log->LocSoNguoiChoiLose($input)->get();

		$deviceid = '';
		$lv_truoc = 0;
		foreach ($logevent as $item) {
			if ($item->level > 0) {
				if ($lv_truoc === $item->level && $deviceid === $item->deviceid) {
					continue;
				}

				$lv = $item->level;
				$datachart[$lv - 1]['soluong']++;

				$deviceid = $item->deviceid;
				$lv_truoc = $item->level;
			}
		}

		$datachart = json_encode($datachart);

		return view('report.locsonguoichoilose', compact('input', 'datachart', 'listGame'));
	}

	function getLocsotiennguoichoipass(Request $request)
	{
		$params = $request->all();

		$game = new games();
		$listGame = $game->getListGame();

		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
				'gameid' => ''
			];
			$datachart = json_encode($datachart);

			return view('report.locsotiennguoichoipass', compact('input', 'datachart', 'listGame'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
			$datachart[$i - 1]['vang'] = 0;
		}

		$log = new logevent();
		$logevent = $log->LocSoTienNguoiChoiPass($input)->get();

		foreach ($logevent as $item) {
			if ($item->level > 0) {
				$lv = $item->level;
				$vang = $item->c_gold;
				$datachart[$lv - 1]['soluong']++;
				$datachart[$lv - 1]['vang'] += $vang;
			}
		}

		foreach ($datachart as $key => $item) {
			if (empty($item['soluong'])) {
				$vang_tb = 0;
			} else {
				$vang_tb = $item['vang'] / $item['soluong'];
			}

			$datachart[$key]['vangtb'] = round($vang_tb);
		}

		$datachart = json_encode($datachart);

		return view('report.locsotiennguoichoipass', compact('input', 'datachart', 'listGame'));
	}

	function getLocsotiennguoichoilose(Request $request)
	{
		$params = $request->all();

		$game = new games();
		$listGame = $game->getListGame();

		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
				'gameid' => ''
			];
			$datachart = json_encode($datachart);

			return view('report.locsotiennguoichoilose', compact('input', 'datachart', 'listGame'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
			$datachart[$i - 1]['vang'] = 0;
		}

		$log = new logevent();
		$logevent = $log->LocSoTienNguoiChoiLose($input)->get();

		foreach ($logevent as $item) {
			if ($item->level > 0) {
				$lv = $item->level;
				$vang = $item->c_gold;
				$datachart[$lv - 1]['soluong']++;
				$datachart[$lv - 1]['vang'] += $vang;
			}
		}

		foreach ($datachart as $key => $item) {
			if (empty($item['soluong'])) {
				$vang_tb = 0;
			} else {
				$vang_tb = $item['vang'] / $item['soluong'];
			}

			$datachart[$key]['vangtb'] = round($vang_tb);
		}

		$datachart = json_encode($datachart);

		return view('report.locsotiennguoichoilose', compact('input', 'datachart', 'listGame'));
	}

	function getQuocgiacosologinnhieunhat(Request $request)
	{
		$params = $request->all();

		$game = new games();
		$listGame = $game->getListGame();

		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
				'gameid' => ''
			];
			$datachart = json_encode($datachart);

			return view('report.quocgiacosologinnhieunhat', compact('input', 'datachart', 'listGame'));
		} else {
			$input = $params;
		}

		$log = new logevent();
		$logevent = $log->QuocGiaCoSoLoginNhieuNhat($input)->get();

		$arr_country = [];
		foreach ($logevent as $item) {
			if (empty($arr_country[$item->country])) $arr_country[$item->country] = 0;
			$arr_country[$item->country]++;
		}

		arsort($arr_country);
		$dem = 0;
		foreach ($arr_country as $key => $item) {
			if ($dem < 5) {
				$datachart[$dem]['label'] = $key;
				$datachart[$dem]['value'] = $item;
			}
			$dem++;
		}

		$datachart = json_encode($datachart);

		return view('report.quocgiacosologinnhieunhat', compact('input', 'datachart', 'listGame'));
	}

	function getLevelusermuainapp(Request $request)
	{
		$params = $request->all();

		$game = new games();
		$listGame = $game->getListGame();

		$datachart = [];
		if (empty($params['time'])) {
			$input = [
				'week' => '',
				'time' => 'week',
				'gameid' => ''
			];
			$datachart = json_encode($datachart);
			return view('report.levelusermuainapp', compact('input', 'datachart', 'listGame'));
		} else {
			$input = $params;
		}

		for ($i = 1; $i < 101; $i++) {
			$datachart[$i - 1]['level'] = $i;
			$datachart[$i - 1]['soluong'] = 0;
		}

		$log = new logevent();
		$logevent = $log->LocLevelUserMuaInapp($input)->get();

		foreach ($logevent as $item) {
			if ($item->level > 0) {
				$lv = $item->level;
				$datachart[$lv - 1]['soluong']++;
			}
		}

		$datachart = json_encode($datachart);

		return view('report.levelusermuainapp', compact('input', 'datachart', 'listGame'));
	}

	function getLogevent(Request $request)
	{
		$params = $request->all();

		$game = new games();
		$listGame = $game->getListGame();

		$eventname = new eventname();
		$listEventname = $eventname->getListeventname();

		$log = new logevent();
		$listColumnLog = $log->getColumn();

		if (empty($params['time'])) {
			$input = [
				'eventname' => '',
				'week' => '',
				'time' => 'homnay',
				'gameid' => ''
			];
			return view('report.logevent', compact('input', 'listEventname', 'listColumnLog', 'listGame'));
		} else {
			$input = $params;
		}


		$logevent = $log->LogLogevent($input)->get();

		$logpagi = $logevent->paginate(50);

		return view('report.logevent', compact('input', 'logpagi', 'listEventname', 'listColumnLog', 'listGame'));
	}

}
