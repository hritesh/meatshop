<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Session;
use App\Users;
use App\ItemGroup;
use App\Vendor;

class VendorController extends SecurityController{
	public function _list(){
		$vendor=new Vendor;
		$vendor_data=$vendor->getAllVendor();
		return view('vendor/_list',['vendor_data'=>$vendor_data]);
	}
	public function vendorListJson(){
		$vendor=new Vendor;
		$vendor_data=$vendor->getAllVendor();
			foreach ($vendor_data as $key => $value) {
				
			
			$vendor_data[$key]->edit_url = 'inventory/vendor/edit/'.$value->vendor_id;
			$vendor_data[$key]->delete_url ='inventory/vendor/delete',$value->vendor_id; 
		} 
		 header("Content-type:application/json");
		echo json_encode($vendor_data);
		exit;
	}

	public function add(){
		$itemgroup=new ItemGroup;
		$itemgroup_data=$itemgroup->getAllItemGroup();

		return view('vendor/add',['itemgroup_data'=>$itemgroup_data]);
	}
	public function save(Request $request){
		
		$vendor=new Vendor;
		$stat=$vendor->saveVendor($request->item_group_id,$request->name,$request->address,$request->email,$request->contact,$request->phone,$request->p_name);
		if($stat){
			if(isset($param->return_status)){
				return redirect('inventory/purchase/add');
			}else{
			echo $stat;
			exit;
		}
	}
	}

	public function edit($id){
		$vendor=new Vendor;
		
		$vendor_data=$vendor->getVendorById($id);
		$itemgroup=new ItemGroup;
		$itemgroup_data=$itemgroup->getAllItemGroup();
		$vendor_data=$vendor_data->toArray();
		 header("Content-type:application/json");
		echo json_encode($vendor_data);
		exit;
	}

	public function update(Request $request){
		$vendor=new Vendor;
		
		$id=$_POST['vendor_id'];
		$stat=$vendor->updateVendor($id,$request->item_group_id,$request->name,$request->address,$request->email,$request->contact,$request->phone,$request->p_name);
		if($stat){
			echo $stat;
			exit;
		}
	}

	public function delete($id){
		
		$vendor=new Vendor;
		$status=$vendor->deleteVendorById($id);
		if($status){
			echo $status;
			exit;
		}
	}
	
}