<?php


namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model{
	protected $table='tbl_vendor';

	public function saveVendor($item_group_id,$name,$address,$email,$contact,$phone,$p_name){
		$this->item_group_id=$item_group_id;
		$this->name=$name;
		$this->address=$address;
		$this->email=$email;
		$this->contact=$contact;
		$this->phone=$phone;
		$this->p_name=$p_name;
		return $this->save();
	}

	public function getVendorById($id){
		return $this->where('vendor_id',$id)->get();
	}
	public function getAllVendor(){
		return $this->all();
	}
	public function updateVendor($id,$item_group_id,$name,$address,$email,$contact,$phone,$p_name){
		return $this->where('vendor_id',$id)->update(['item_group_id'=>$item_group_id,'name'=>$name,'address'=>$address,'email'=>$email,'contact'=>$contact,'phone'=>$phone,'p_name'=>$p_name]);
	}
	public function deleteVendorById($id){
		return $this->where('vendor_id',$id)->delete();
	}
}