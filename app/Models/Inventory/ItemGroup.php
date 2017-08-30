<?php


namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class ItemGroup extends Model{
	protected $table='tbl_item_group';

	public function saveItemGroup($category,$status){
		$this->category=$category;
		$this->status=$status;
		return $this->save();
	}
	public function getAllItemGroup(){
		return $this->all();
	}
	public function getItemGroupById($id){
		return $this->where('item_group_id',$id)->get();
	}

	public function updateItemGroup($id,$category,$status){
		return $this->where('item_group_id',$id)->update(['category'=>$category,'status'=>$status]);

	}
	public function deleteItemGroupById($id){
		return $this->where('item_group_id',$id)->delete();
	}

}