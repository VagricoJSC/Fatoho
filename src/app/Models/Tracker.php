<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    protected $fillable=['order_id', 'data', 'created_at', 'updated_at'];

    public function getOrderStatusName() {
		$stsnm = 'Đang chuyển hàng';
		$shipinfo = json_decode($this->data);
		if (isset($shipinfo->STATUS)) {
			$sts = $shipinfo->STATUS;
			if ($sts == 'new') {
				$stsnm = 'Đang chờ tiếp nhận';
			}
			elseif ($sts == 'processing') {
				$stsnm = 'Đang chuẩn bị xuất hàng';
			}
			elseif ($sts == 'shipped') {
				$stsnm = 'Đang chuyển hàng';
			}
			elseif ($sts == 'delivered') {
				$stsnm = 'Đã giao tới người nhận';
			}
		}
		elseif (isset($shipinfo->ORDER_STATUS)) {
			$sts = $shipinfo->ORDER_STATUS;
			if ($sts == '500') {
				$stsnm = 'Đang chuyển hàng';
			}
			elseif ($sts == '501') {
				$stsnm = 'Đã giao tới người nhận';
			}
		}
		
		return $stsnm;
	}
	
	public static function createPendingStatusList($orderStatus) {
	}
	

}
