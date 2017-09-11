<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Session;
use App\Users;
use App\Models\Inventory\ItemGroup;
use App\Sales;
use App\SalesReturn;

class ItemGroupController extends Controller{
	public function _list(){
		$itemgroup=new ItemGroup;
		$itemgroup_data=$itemgroup->getAllItemGroup();
		return view('inventory/itemgroup/_list',['itemgroup_data'=>$itemgroup_data]);

	}
	public function  itemGroupListJson(){
		$itemgroup=new ItemGroup;
		$itemgroup_data=$itemgroup->getAllItemGroup();
		foreach ($itemgroup_data as $key => $levelObject) {
			
			$itemgroup_data[$key]->edit_url = 'inventory/itemgroup/edit/'.$levelObject->item_group_id;
			$itemgroup_data[$key]->delete_url ='inventory/itemgroup/delete/'.$levelObject->item_group_id; 
		} 
		 header("Content-type:application/json");
		echo json_encode($itemgroup_data);
		exit;

	}

	public function add(){
		return view('inventory/itemgroup/add');
	}

	public function save(Request $request){
		
		$this->validate($request,['category'=>'required']);
		$itemgroup=new ItemGroup;
		if(isset($request->status)){
			$status =1;
		}
		else{
			$status=0;
		}

		$stat=$itemgroup->saveItemGroup($request->category,$status);
		if($stat){
			if(isset($return_status)){
				return redirect('inventory/itemname/_list');
			}
			else{
			echo $stat;
			exit;
		}
		}

	}

	public function edit($id){
		
		$itemgroup=new ItemGroup;
		$itemgroup_data=$itemgroup->getItemgroupById($id);
		$itemgroup_data=$itemgroup_data->toArray();
		 header("Content-type:application/json");
		echo json_encode($itemgroup_data);
		exit;
	}

	public function update(Request $request){
		$this->validate($request,['category'=>'required']);
		$itemgroup=new ItemGroup;
		$id=$_POST['item_group_id'];
		if(isset($request->status)){
			$status =1;
		}
		else{
			$status=0;
		}
		
		$stat=$itemgroup->updateItemGroup($id,$request->category,$status);
		if($stat){
			echo $stat;
			exit;
		}
	}

	public function delete($id){
		
		$itemgroup=new ItemGroup;
		$status=$itemgroup->deleteItemGroupById($id);
		if($status){
			echo $status;exit;
		}
	}
}


