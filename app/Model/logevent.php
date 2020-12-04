<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class logevent extends Model
{
	protected $table = "logevent";
	public $timestamps = false;

	/*API*/
	public function insertLogevent($input, $content_get)
	{
		$eventname = isset($input['eventname']) ? $input['eventname'] : "";
		$gameid = isset($input['gameid']) ? $input['gameid'] : 0;
		$deviceid = isset($input['deviceid']) ? $input['deviceid'] : "";
		$country = isset($input['country']) ? $input['country'] : "";
		$level = isset($input['level']) ? $input['level'] : 0;
		$c_gold = isset($input['c_gold']) ? $input['c_gold'] : 0;
		$u_gold = isset($input['u_gold']) ? $input['u_gold'] : 0;
		$g_gold = isset($input['g_gold']) ? $input['g_gold'] : 0;
		$total_ads_full = isset($input['total_ads_full']) ? $input['total_ads_full'] : 0;
		$total_ads_gift = isset($input['total_ads_gift']) ? $input['total_ads_gift'] : 0;
		$sku = isset($input['sku']) ? $input['sku'] : "";

		$logevent = new logevent();
		$logevent->game_id = $gameid;
		$logevent->deviceid = $deviceid;
		$logevent->eventname = $eventname;
		$logevent->level = $level;
		$logevent->c_gold = $c_gold;
		$logevent->u_gold = $u_gold;
		$logevent->g_gold = $g_gold;
		$logevent->total_ads_full = $total_ads_full;
		$logevent->total_ads_gift = $total_ads_gift;
		$logevent->country = $country;
		$logevent->sku = $sku;
		$logevent->extend = $content_get;

		$logevent->save();

		return 1;
	}
	/*END API*/

	/*Report*/
	public function SoUserConLaiSauCacLevel($input)
	{
		$log = $this::select('level', 'deviceid')->where('game_id', '=', $input['gameid'])
			->where('eventname', '=', 'play_level')->where('level', '<', 101);
		$log = $this->checkDate($log, $input);

		return $log->orderBy('deviceid', 'ASC')->orderBy('id', 'DESC');
	}

	public function LocSoTienCuaUser($input)
	{
		$log = $this::select('c_gold', 'level', 'deviceid')->where('game_id', '=', $input['gameid'])
			->where('eventname', '=', 'pass_level');
		$log = $this->checkDate($log, $input);

		return $log->orderBy('deviceid', 'ASC')->orderBy('id', 'ASC');
	}

	public function LocSoNguoiChoiPass($input)
	{
		$log = $this::select('level', 'deviceid')->where('game_id', '=', $input['gameid'])
			->where('eventname', '=', 'pass_level')
			->where('level', '<', 101);
		$log = $this->checkDate($log, $input);

		return $log->orderBy('deviceid', 'ASC')->orderBy('id', 'ASC');
	}

	public function LocSoNguoiChoiLose($input)
	{
		$log = $this::select('level', 'deviceid')->where('game_id', '=', $input['gameid'])
			->where('eventname', '=', 'lose_level')
			->where('level', '<', 101);
		$log = $this->checkDate($log, $input);

		return $log->orderBy('deviceid', 'ASC')->orderBy('id', 'ASC');
	}

	public function LocSoNguoiChoiStart($input)
	{
		$log = $this::select('level', 'deviceid')->where('game_id', '=', $input['gameid'])
			->where('eventname', '=', 'play_level')
			->where('level', '<', 101);
		$log = $this->checkDate($log, $input);

		return $log->orderBy('deviceid', 'ASC')->orderBy('id', 'ASC');
	}

	public function LocSoTienNguoiChoiPass($input)
	{
		$log = $this::select('level', 'c_gold')->where('eventname', '=', 'pass_level')
			->where('level', '<', 101);
		$log = $this->checkDate($log, $input);

		return $log;
	}

	public function LocSoTienNguoiChoiLose($input)
	{
		$log = $this::select('level', 'c_gold')->where('eventname', '=', 'lose_level')
			->where('level', '<', 101);
		$log = $this->checkDate($log, $input);

		return $log;
	}

	public function QuocGiaCoSoLoginNhieuNhat($input)
	{
		$log = $this::select('country')->where('country', '<>', '');
		$log = $this->checkDate($log, $input);

		return $log->groupBy('deviceid');
	}

	public function LocLevelUserMuaInapp($input)
	{
		$log = $this::select('level')->where('game_id', '=', $input['gameid'])
			->where('eventname', '=', 'buy_inapp')
			->where('level', '<', 101);
		$log = $this->checkDate($log, $input);

		return $log;
	}

	public function getColumn()
	{
		$eventname = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());

		return $eventname;
	}

	public function LogLogevent($input)
	{
		$log = $this::where('game_id', '=', $input['gameid']);
		$log = $this->checkDate($log, $input);
		if (isset($input['deviceid']) && !empty($input['deviceid'])) {
			$log->where('deviceid', '=', $input['deviceid']);
		}
		if (isset($input['eventname']) && !empty($input['eventname'])) {
			$log->where('eventname', '=', $input['eventname']);
		}

		return $log->orderBy('id', 'DESC');
	}

	public function checkDate($log, $input, $join = '')
	{
		if (!empty($join)) $join .= ".";
		if (isset($input['time']) && !empty($input['time'])) {
			switch ($input['time']) {
				case "week":
					if (isset($input['week']) && !empty($input['week'])) {
						$week = explode('-W', $input['week']);
						$nam = $week[0];
						$tuan = $week[1];
						$dto = new DateTime();
						$dto->setISODate($nam, $tuan);
						$date['week_start'] = $dto->format('Y-m-d');
						$dto->modify('+7 days');
						$date['week_end'] = $dto->format('Y-m-d') . " 00:00:00";

						$date['week_start'] = date('Y-m-d', strtotime($date['week_start'] . " -1 day")) . " 23:59:59";


						$log->where($join . 'createdate', '>', $date['week_start']);
						$log->where($join . 'createdate', '<', $date['week_end']);
					}

					break;
				case "month":
					if (isset($input['month']) && !empty($input['month'])) {
						$date['month_start'] = date('Y-m-d', strtotime('first day of this month', strtotime($input['month'])));
						$date['month_start'] = date('Y-m-d', strtotime($date['month_start'] . " -1 day")) . " 23:59:59";

						$date['month_end'] = date('Y-m-d', strtotime('last day of this month', strtotime($input['month'])));
						$date['month_end'] = date('Y-m-d', strtotime($date['month_end'] . " +1 day")) . " 00:00:00";

						$log->where($join . 'createdate', '>', $date['month_start']);
						$log->where($join . 'createdate', '<', $date['month_end']);
					}

					break;
				case "tuychon":
					if (isset($input['from-date']) && !empty($input['from-date']) && $input['to-date'] && !empty($input['to-date'])) {
						$from = date('Y-m-d', strtotime($input['from-date'] . " -1 day")) . " 23:59:59";
						$to = date('Y-m-d', strtotime($input['to-date'] . " +1 day")) . " 00:00:00";

						$log->where($join . 'createdate', '>', $from);
						$log->where($join . 'createdate', '<', $to);
					}

					break;
				case "homnay":
					$today = date('Y-m-d');
					$from = $today . " 00:00:00";
					$to = $today . " 23:59:59";

					$log->where($join . 'createdate', '>', $from);
					$log->where($join . 'createdate', '<', $to);

					break;
				default :
					break;
			}
		}

		return $log;
	}
	/*END Report*/

}
