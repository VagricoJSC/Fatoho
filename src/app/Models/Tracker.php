<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    protected $fillable=['order_id', 'data', 'created_at', 'updated_at'];

	private $orderStatus = null;
	
    public function getOrderStatusName() {
		if ($this->orderStatus == null) {
			$this->setOrderStatusFromDB();
		}
		
		$stsnm = 'Đang chuyển hàng';
		if ($this->orderStatus == 'new') {
			$stsnm = 'Đang chờ tiếp nhận';
		}
		elseif ($this->orderStatus == 'processing') {
			$stsnm = 'Đang chuẩn bị hàng hóa';
		}
		elseif ($this->orderStatus == 'shipped') {
			$stsnm = 'Đang chuyển hàng';
		}
		elseif ($this->orderStatus == 'delivered') {
			$stsnm = 'Đã giao tới người nhận';
		}
		elseif ($this->orderStatus == 'cancel') {
			$stsnm = 'Đơn hàng đã hủy';
		}
		
		return $stsnm;
	}

	/**
	 * Load order status from DB
	 */
	protected function setOrderStatusFromDB() {
		$shipinfo = json_decode($this->data);
		if (isset($shipinfo->STATUS)) {
			$sts = $shipinfo->STATUS;
			$this->orderStatus = $sts;
		}
		elseif (isset($shipinfo->ORDER_STATUS)) {
			$sts = $shipinfo->ORDER_STATUS;
			if ($sts == '500') {
				$this->orderStatus = 'shipped';
			}
			elseif ($sts == '501') {
				$this->orderStatus = 'delivered';
			}
		}
	}
	
	/**
	 * Get pending statuses
	 */
	public static function createPendingStatusList($osts) {
		// Order cancelled
		if ($osts == 'cancel') {
			return [];
		}
		
		$status_array = ['new', 'processing', 'shipped', 'delivered'];
		$sts_index = array_search($osts, $status_array);
		if ($sts_index == false) {
			$sts_index = 0;
		}
		else {
			$sts_index = $sts_index + 1;
		}
		
		$pending_sts_array = [];
		for ($i = $sts_index; $i < count($status_array); $i ++) {
			$new_track = new Tracker();
			$new_track->orderStatus = $status_array[$i];
			array_push($pending_sts_array, $new_track);
		}
		
		return $pending_sts_array;
	}
	

}
