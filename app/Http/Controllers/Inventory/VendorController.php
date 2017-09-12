<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Session;
use App\Users;
use App\ItemGroup;
use App\Vendor;

class VendorController extends Controller{
	public function _list(){
		$vendor=new Vendor;
		$vendor_data=$vendor->getAllVendor(getSchoolId());
		return view('vendor/_list',['vendor_data'=>$vendor_data]);
	}
	public function vendorListJson(){
		$vendor=new Vendor;
		$vendor_data=$vendor->getAllVendor(getSchoolId());
			foreach ($vendor_data as $key => $value) {
			
			$vendor_data[$key]->edit_url = 'inventory/vendor/edit/id'.$value->vendor_id;
			$vendor_data[$key]->delete_url ='inventory/vendor/delete/id'.$value->vendor_id; 
		} 
		 header("Content-type:application/json");
		echo json_encode($vendor_data);
		exit;
	}

	public function add(){
		$itemgroup=new ItemGroup;
		$itemgroup_data=$itemgroup->getAllItemGroup(getSchoolId());

		return view('vendor/add',['itemgroup_data'=>$itemgroup_data]);
	}
	public function save(Request $request){
		$param=__decryptToken();
		$vendor=new Vendor;
		$school_id=getSchoolId();
		$stat=$vendor->saveVendor($request->item_group_id,$request->name,$school_id,$request->address,$request->email,$request->contact,$request->phone,$request->p_name);
		if($stat){
			if(isset($param->return_status)){
				return redirect('inventory/purchase/add'));
			}else{
			echo $stat;
			exit;
		}
	}
	}

	public function edit(){
		$vendor=new Vendor;
		$param = __decryptToken();
		$vendor_data=$vendor->getVendorById($param->id);
		$itemgroup=new ItemGroup;
		$itemgroup_data=$itemgroup->getAllItemGroup(getSchoolId());
		$vendor_data=$vendor_data->toArray();
		 header("Content-type:application/json");
		echo json_encode($vendor_data);
		exit;
	}

	public function update(Request $request){
		$vendor=new Vendor;
		$school_id=getSchoolId();
		$param = __decryptToken();
		$id=$_POST['vendor_id'];
		$stat=$vendor->updateVendor($id,$request->item_group_id,$request->name,$school_id,$request->address,$request->email,$request->contact,$request->phone,$request->p_name);
		if($stat){
			echo $stat;
			exit;
		}
	}

	public function delete(){
		$param=__decryptToken();
		$vendor=new Vendor;
		$status=$vendor->deleteVendorById($param->id);
		if($status){
			echo $status;
			exit;
		}
	}
	
}