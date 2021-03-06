<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Session;
use App\Users;
use App\ItemGroup;
use App\ItemName;

class ItemNameController extends SecurityController{

	public function itemnameListJson(){

	$itemname_data = DB::table('tbl_item_name')
	->join('tbl_item_group','tbl_item_name.item_group_id','=','tbl_item_group.item_group_id')
		->select('tbl_item_name.*','tbl_item_group.category')->get();

			foreach ($itemname_data as $key => $value) {
			
			$itemname_data[$key]->edit_url = __setLink('inventory/itemname/edit',array('id'=>$value->item_name_id));
			$itemname_data[$key]->delete_url =__setLink('inventory/itemname/delete',array('id'=>$value->item_name_id)); 
		} 
		 header("Content-type:application/json");
		echo json_encode($itemname_data);
		exit;
	}

	public function _list(){
		$itemgroup=new ItemGroup;
		$itemgroup_data=$itemgroup->getAllItemGroup(getSchoolId());
		//$itemname=new ItemName;
		$itemname_data = DB::table('tbl_item_name')->join('tbl_item_group','tbl_item_name.item_group_id','=','tbl_item_group.item_group_id')
		->select('tbl_item_name.*','tbl_item_group.category')->get();

		return view('inventory/itemname/_list',['itemname_data'=>$itemname_data,'itemgroup_data'=>$itemgroup_data]);
	}
	
	public function add(){
		$itemgroup=new ItemGroup;
		$itemgroup_data=$itemgroup->getAllItemGroup(getSchoolId());

		return view('inventory/itemname/add',['itemgroup_data'=>$itemgroup_data]);
	}
	public function save(Request $request){
		
		$this->validate($request,['item_group_id'=>'required','item_name'=>'required']);
		$itemname=new ItemName;
		if(isset($request->status)){
			$status =1;
		}
		else{
			$status=0;
		}
		$school_id=getSchoolId();
		$stat=$itemname->saveItem($request->item_group_id,$request->item_name,$status,$school_id);
		if($stat){
			if(isset($return_status)){
				return redirect(__setLink('inventory/purchase/_list'));
			}
			else{
			echo $stat;
			exit;
		}
		}
	}

	public function edit(){
		
		$itemname=new ItemName;
		$itemname_data=$itemname->getItemById($id);
		$itemgroup=new ItemGroup;
		$itemgroup_data=$itemgroup->getAllItemGroup(getSchoolId());
		$itemname_data=$itemname_data->toArray();
		 header("Content-type:application/json");
		echo json_encode($itemname_data);
		exit;
	}

	public function update(Request $request){
		$this->validate($request,['item_group_id'=>'required','item_name'=>'required']);
		$itemname=new ItemName;
		if(isset($request->status)){
			$status =1;
		}
		else{
			$status=0;
		}
		$id=$_POST['item_name_id'];
		$school_id=getSchoolId();
		
		$stat=$itemname->updateItem($id,$request->item_group_id,$request->item_name,$status,$school_id);
		if($stat){
			echo $stat;
			exit;
		}

	}

	public function delete(){
		
		$itemname=new ItemName;
		$status=$itemname->deleteItemById($id);
		if($status){
			echo $status;
			exit;
		}

	}

	public function getItemsbyItemGroupId($id){
		$itemname = new ItemName;
		$items = $itemname->getItemsbyGroupId($id);
		//return $items->toArray();
		return json_encode($items->toArray());
	}
}