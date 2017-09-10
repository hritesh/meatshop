<?php


namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class SalesReturn extends  Model{
	protected $table='tbl_sales_return';

	public function saveRecords($array){
		$this->sales_id = $array['sales_id'];
		$this->item_name_id=$array['item_id'];
		$this->original_quantity=$array['original_quantity'];
		$this->rate=$array['rate'];
		$this->returned_price=$array['returned_price'];
		$this->returned_by=$array['returned_by'];
		$this->returned_quantity = $array['returned_quantity'];
		
		$this->description=$array['narration'];
		
		$this->vendor_id=$array['vendor_id'];
		$this->month = $array['month'];
		return $this->save();
	}

	public function getRecords($array){
		return $this->where(['sales_id'=>$array['sales_id'],'item_name_id'=>$array['item_id'],'month'=>$array['month']])->get();
	}

	public function updateRecords($array){
		return $this->where(['sales_id'=>$array['sales_id'],'item_name_id'=>$array['item_id'],'vendor_id'=>$array['vendor_id']])->update(['returned_quantity'=>$array['returned_quantity'],'returned_price'=>$array['returned_price'],'description'=>$array['narration']]);
	}

	public function getRecordsByItemAndSalesId($sales_id,$item_id){
		return $this->where(['sales_id'=>$sales_id,'item_name_id'=>$item_id])->get();
	}

	public function getRecordsByItemId($item_id,$vendor_id){
		return $this->where(['item_name_id'=>$item_id,'vendor_id'=>$vendor_id])->get();
	}

	public function getSalesReturnRecordByStudentMonth($student_id,$month){
		$data = $this->where(['returned_by'=>$student_id,'month'=>$month])->get();
		return $data;
	}

	public function getRecordsBySalesid($sales_id){
		return $this->where('sales_id',$sales_id)->get();
	}

}