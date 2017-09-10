<?php


namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Sales extends  Model{
	protected $table='tbl_sales';

	public function saveSales($item_name_id,$quantity,$rate,$price,$sold_to,$status,$description,$vendor_id,$month){
		$this->item_name_id=$item_name_id;
		$this->quantity=$quantity;
		$this->rate=$rate;
		$this->price=$price;
		$this->sold_to=$sold_to;
		$this->status=$status;
		
		$this->description=$description;
		$this->vendor_id=$vendor_id;
		$this->month=$month;
		return $this->save();
	}

	public function getAllSales(){
		return $this->all();
	}

	public function getSalesById($id){
		return $this->where('sales_id',$id)->get();
	}
	public function updateSales($id,$item_name_id,$quantity,$rate,$price,$sold_to,$status,$description,$vendor_id){
		return $this->where('sales_id',$id)->update(['item_name_id'=>$item_name_id,'quantity'=>$quantity,'rate'=>$rate,'price'=>$price,'sold_to'=>$sold_to,'status'=>$status,'description'=>$description,'vendor_id'=>$vendor_id]);
	}
	public function deleteSalesById($id){
		return $this->where('sales_id',$id)->delete();
	}

	public function getRecordsByItemId($item_id,$vendor_id){
		return $this->where(['item_name_id'=>$item_id,'vendor_id'=>$vendor_id])->get();
	}

	public function getSalesRecordByStudentMonth($student_id,$month){
		$data =$this->where(['sold_to'=>$student_id,'month'=>$month])->get();
		return $data;
	}

}