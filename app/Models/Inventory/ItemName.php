<?php


namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class ItemName extends Model{
	protected $table='tbl_item_name';

	public function saveItem($item_group_id,$item_name,$status){
		$this->item_group_id=$item_group_id;
		$this->item_name=$item_name;
		$this->status=$status;
		return $this->save();
	}

	public function getItemById($id){
		return $this->where('item_name_id',$id)->get();
	}
	public function getAllItem(){
		return $this->all();
	}
	public function updateItem($id,$item_group_id,$item_name,$status){
		return $this->where('item_name_id',$id)->update(['item_group_id'=>$item_group_id,'item_name'=>$item_name,'status'=>$status]);
	}
	public function deleteItemById($id){
		return $this->where('item_name_id',$id)->delete();
	}

	public function getItemsbyGroupId($id){
		return $this->where('item_group_id',$id)->get();
	}
	
}