<?php


namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends  Model{
	protected $table='tbl_purchase_return';

	public function savePurchaseReturn($dataArray){
		$this->item_name_id=$dataArray['item_name_id'];
		$this->total_quantity_purchased=$dataArray['total_quantity_purchased'];
		$this->rate=$dataArray['rate'];
		$this->total_price=$dataArray['total_price'];
		$this->vendor_id=$dataArray['vendor_id'];
		
		$this->quantity_returned=$dataArray['quantity_returned'];
		$this->narration=$dataArray['narration'];
		$this->purchase_id=$dataArray['purchase_id'];
		$this->month = $dataArray['month'];
		return $this->save();
	}

	public function getAllPurchaseReturn(){
		return $this->all();
	}

	public function getPurchaseReturnById($id){
		return $this->where('purchase_return_id',$id)->get();
	}


	public function updateRecords($dataArray){
		return $this->where(['item_name_id'=>$dataArray['item_name_id'],'total_quantity_purchased'=>$dataArray['total_quantity_purchased'],'rate'=>$dataArray['rate'],'vendor_id'=>$dataArray['vendor_id'],'purchase_id'=>$dataArray['purchase_id']])->update(['quantity_returned'=>$dataArray['quantity_returned'],'total_price'=>$dataArray['total_price'],'narration'=>$dataArray['narration']]);
	}
	public function getPurchaseRecords($purchase_id,$item_name_id,$total_quantity_purchased,$rate,$vendor_id,$month){

		$data = $this->where(['purchase_id'=>$purchase_id,'item_name_id'=>$item_name_id,'total_quantity_purchased'=>$total_quantity_purchased,'rate'=>$rate,'vendor_id'=>$vendor_id,'month'=>$month])->get();
		return $data;
	}

	public function getRecordsByItemId($item_id,$vendor_id){
		return $this->where(['item_name_id'=>$item_id,'vendor_id'=>$vendor_id])->get();
	}

	public function getRecordsByPurchaseId($purchase_id){
		return $this->where('purchase_id',$purchase_id)->get();
	}

}