<?php


namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Purchase extends  Model{
	protected $table='tbl_purchase';

	public function savePurchase($school_id,$item_name_id,$quantity,$rate,$price,$vendor_id,$status,$description,$sell_price,$month){
		$this->item_name_id=$item_name_id;
		$this->quantity=$quantity;
		$this->rate=$rate;
		$this->price=$price;
		$this->vendor_id=$vendor_id;
		$this->status=$status;
		$this->school_id=$school_id;
		$this->sell_price=$sell_price;
		$this->description=$description;
		$this->month=$month;
		return $this->save();
	}

	public function getAllPurchase($school_id){
		return $this->where('school_id',$school_id)->get();
	}

	public function getPurchaseById($id){
		return $this->where('purchase_id',$id)->get();
	}
	public function updatePurchase($id,$school_id,$item_name_id,$quantity,$rate,$price,$vendor_id,$status,$description,$sell_price){
		return $this->where('purchase_id',$id)->update(['school_id'=>$school_id,'item_name_id'=>$item_name_id,'quantity'=>$quantity,'rate'=>$rate,'price'=>$price,'vendor_id'=>$vendor_id,'status'=>$status,'description'=>$description,'sell_price'=>$sell_price]);
	}
	public function deletePurchaseById($id){
		return $this->where('purchase_id',$id)->delete();
	}

	public function getRecordsByItemId($itemid){
		return $this->where(['item_name_id'=>$itemid])->get();
	}

	public function getRecordsByVendorId($vendor_id){
		return $this->where('vendor_id',$vendor_id)->get();
	}

	
}