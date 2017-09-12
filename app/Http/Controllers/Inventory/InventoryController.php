<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Session;
use App\Models\Inventory\Purchase;
use App\Models\Inventory\ItemName;
use App\Models\Inventory\Vendor;
use App\Models\Inventory\ItemGroup;
use App\Models\Inventory\Sales;
use App\Models\Inventory\PurchaseReturn;
use App\Models\Inventory\SalesReturn;

class InventoryController extends Controller
{
	public function index(Request $request){
		return view('inventory/index');
	}
	public function purchaseListJson(){
		$purchaseReturnObject = new PurchaseReturn;
		$purchase_data= DB::table('tbl_purchase')
						
						->join('tbl_item_name','tbl_purchase.item_name_id','=','tbl_item_name.item_name_id')
						->join('tbl_vendor','tbl_purchase.vendor_id','=','tbl_vendor.vendor_id')
						->select('tbl_purchase.*','tbl_item_name.item_name','tbl_vendor.name')
						->get();
		foreach ($purchase_data as $key => $value) {
			$purchase_data[$key]->edit_url= 'inventory/purchase/edit'.$value->purchase_id;
			$purchase_data[$key]->delete_url='inventory/purchase/delete'.$value->purchase_id;
			$purchasedReturnedData = $purchaseReturnObject->getRecordsByPurchaseId($value->purchase_id);
			if(count($purchasedReturnedData)>0){
				$purchase_data[$key]->returned_quantity = $purchasedReturnedData->quantity_returned;
				$purchase_data[$key]->returned_price = $purchasedReturnedData->total_price;
			}else{
				$purchase_data[$key]->returned_quantity = 0;
				$purchase_data[$key]->returned_price = 0;
			}
		}
		 header("Content-type:application/json");
		echo json_encode($purchase_data);
		exit;
	}

	public function purchaseList(){
		$purchaseReturnObject = new PurchaseReturn;
		$itemgroup=new ItemGroup;
		$itemGroup_data=$itemgroup->getAllItemGroup();
		//$purchase=new Purchase;
		$itemname=new ItemName;
		$itemname_data=$itemname->getAllItem();

		$vendor=new Vendor;
		$vendor_data=$vendor->getAllVendor();
		$purchase_data= DB::table('tbl_purchase')
						
						->join('tbl_item_name','tbl_purchase.item_name_id','=','tbl_item_name.item_name_id')
						->join('tbl_vendor','tbl_purchase.vendor_id','=','tbl_vendor.vendor_id')
						->select('tbl_purchase.*','tbl_item_name.item_name','tbl_vendor.name')
						->get();
		foreach ($purchase_data as $key => $value) {
			$purchasedReturnedData = $purchaseReturnObject->getRecordsByPurchaseId($value->purchase_id);
			if(count($purchasedReturnedData)>0){
				$purchase_data[$key]->returned_quantity = $purchasedReturnedData[0]->quantity_returned;
				$purchase_data[$key]->returned_price = $purchasedReturnedData[0]->total_price;
			}else{
				$purchase_data[$key]->returned_quantity = 0;
				$purchase_data[$key]->returned_price = 0;
			}
		}
		return view('inventory/purchase/_list',['purchase_data'=>$purchase_data,'itemGroup_data'=>$itemGroup_data,'itemname_data'=>$itemname_data, 'vendor_data'=>$vendor_data]);
	}

	public function addPurchase(){
		$itemgroup=new ItemGroup;
		$itemGroup_data=$itemgroup->getAllItemGroup();
		$itemname=new ItemName;
		$itemname_data=$itemname->getAllItem();

		$vendor=new Vendor;
		$vendor_data=$vendor->getAllVendor();
		return view('inventory/purchase/add',['itemname_data'=>$itemname_data, 'vendor_data'=>$vendor_data,'itemGroup_data'=>$itemGroup_data]);
	}

	public function purchaseSave(Request $request){
		$this->validate($request,['item_name_id'=>'required','quantity'=>'required','rate'=>'required','price'=>'required','vendor_id'=>'required','description'=>'required','sell_price'=>'required']);
		$purchase=new Purchase;

		if(isset($request->status)){
			$status =1;
		}
		else{
			$status=0;
		}

		$stat=$purchase->savePurchase($request->item_name_id,$request->quantity,$request->rate,$request->price,$request->vendor_id,$status,$request->description,$request->sell_price,$request->month);
		if($stat){
			echo $stat;
			exit;
		}
	}

	public function purchaseUpdate(Request $request){
		
		$this->validate($request,['item_name_id'=>'required','quantity'=>'required','rate'=>'required','price'=>'required','vendor_id'=>'required','description'=>'required','sell_price'=>'required']);
		$purchase=new Purchase;
		$id=$_POST['purchase_id'];
		if(isset($request->status)){
			$status =1;
		}
		else{
			$status=0;
		}

		$stat=$purchase->updatePurchase($id,$request->item_name_id,$request->quantity,$request->rate,$request->price,$request->vendor_id,$status,$request->description,$request->sell_price);
		if($stat){
			echo $stat;
			exit;
		}
	}

	public function editPurchase(){
		
		$purchase=new Purchase;
		$purchase_data=$purchase->getPurchaseById($param->id);
		

		$itemname=new ItemName;
		$itemname_data=$itemname->getAllItem();


		$vendor=new Vendor;
		$vendor_data=$vendor->getAllVendor();
		$purchase_data=$purchase_data->toArray();

		 header("Content-type:application/json");
		echo json_encode($purchase_data);
		exit;

	}
	public function deletePurchase(){
		$param=__decryptToken();
			$purchase=new Purchase;
		$status=$purchase->deletePurchaseById($param->id);
		if($status){
			echo $status;
			exit;
		}
	}
	//sales

	public function salesListJson(){
		$sales=new Sales;
		$salesReturnObject = new SalesReturn;
		$sales_data=DB::table('tbl_sales')
						
						->join('tbl_item_name','tbl_sales.item_name_id','=','tbl_item_name.item_name_id')
						->join('tbl_student_details','tbl_sales.sold_to','=','tbl_student_details.student_id')
						->join('tbl_vendor','tbl_sales.vendor_id','=','tbl_vendor.vendor_id')
						->select('tbl_sales.*','tbl_item_name.item_name','tbl_student_details.student_name','tbl_vendor.name as vendor_name')
						->get();
		
			foreach ($sales_data as $key => $value) {
				$sales_return_data = $salesReturnObject->getRecordsBySalesid($value->sales_id);
				if(count($sales_return_data)>0){
					$sales_data[$key]->returned_quantity = $sales_return_data[0]->returned_quantity;
					$sales_data[$key]->returned_price = $sales_return_data[0]->returned_price;
				}else{
					$sales_data[$key]->returned_quantity = 0;
					$sales_data[$key]->returned_price = 0;
				}
			}
		 header("Content-type:application/json");
		echo json_encode($sales_data);
		exit;
	}

	public function salesList(){
		$salesReturnObject = new SalesReturn;
			$itemname=new ItemName;
		$itemname_data=$itemname->getAllItem();
		$purchase=new Purchase;
		$purchase_data=$purchase->getAllPurchase();
		$itemgroup=new ItemGroup;
		$itemgroup_data=$itemgroup->getAllItemGroup();
		$class=new Classes;
		$class_data=$class->getAllClass();
		$vendor=new Vendor;
		$vendor_data=$vendor->getAllVendor();
		$sales=new Sales;
		$sales_data=DB::table('tbl_sales')
						
						->join('tbl_item_name','tbl_sales.item_name_id','=','tbl_item_name.item_name_id')
						->join('tbl_student_details','tbl_sales.sold_to','=','tbl_student_details.student_id')
						->join('tbl_vendor','tbl_sales.vendor_id','=','tbl_vendor.vendor_id')
						->select('tbl_sales.*','tbl_item_name.item_name','tbl_student_details.student_name','tbl_vendor.name as vendor_name')
						->get();
		foreach ($sales_data as $key => $value) {
			$sales_return_data = $salesReturnObject->getRecordsBySalesid($value->sales_id);
			if(count($sales_return_data)>0){
				$sales_data[$key]->returned_quantity = $sales_return_data[0]->returned_quantity;
				$sales_data[$key]->returned_price = $sales_return_data[0]->returned_price;
			}else{
				$sales_data[$key]->returned_quantity = 0;
				$sales_data[$key]->returned_price = 0;
			}
		}
		return view('inventory/sales/_list',['sales_data'=>$sales_data,'itemgroup_data'=>$itemgroup_data,'itemname_data'=>$itemname_data, 'vendor_data'=>$vendor_data,'purchase_data'=>$purchase_data,'class_data'=>$class_data]);

	}

		public function addSales(){
		$itemname=new ItemName;
		$itemname_data=$itemname->getAllItem();
		$purchase=new Purchase;
		$purchase_data=$purchase->getAllPurchase();
		$itemgroup=new ItemGroup;
		$itemgroup_data=$itemgroup->getAllItemGroup();
		$class=new Classes;
		$class_data=$class->getAllClass();
		$vendor=new Vendor;
		$vendor_data=$vendor->getAllVendor();
		return view('inventory/sales/add',['itemgroup_data'=>$itemgroup_data,'itemname_data'=>$itemname_data, 'vendor_data'=>$vendor_data,'purchase_data'=>$purchase_data,'class_data'=>$class_data]);
	}

	public function salesSave(Request $request){
		$this->validate($request,['item_name_id'=>'required','quantity'=>'required','rate'=>'required','price'=>'required','sold_to'=>'required','description'=>'required']);
		$sales=new Sales;

		if(isset($request->status)){
			$status =1;
		}
		else{
			$status=0;
		}
		

		$stat=$sales->saveSales($request->item_name_id,$request->quantity,$request->rate,$request->price,$request->sold_to,$status,$request->description,$request->vendor_id,$request->month);
		if($stat){
			echo $stat;
			exit;
		}
	}

	public function salesUpdate(Request $request){
		
		$this->validate($request,['item_name_id'=>'required','quantity'=>'required','rate'=>'required','price'=>'required','sold_to'=>'required','description'=>'required']);
		$sales=new Sales;
		$id=$_POST['sales_id'];
		if(isset($request->status)){
			$status =1;
		}
		else{
			$status=0;
		}
		

		$stat=$sales->updateSales($id,$request->item_name_id,$request->quantity,$request->rate,$request->price,$request->sold_to,$status,$request->description,$request->vendor_id);
		if($stat){
			echo $stat;
			exit;
		}
	}

	public function editSales(){
		
		$sales=new Sales;
		$sales_data=$sales->getSalesById($param->id);
		
		$class=new Classes;
		$class_data=$class->getAllClass();
		$itemname=new ItemName;
		$itemname_data=$itemname->getAllItem();

	

		$vendor=new Vendor;
		$vendor_data=$vendor->getAllVendor();
		$sales_data=$sales_data->toArray();

		 header("Content-type:application/json");
		echo json_encode($sales_data);
		exit;
	}

	public function deleteSales(){
		$param=__decryptToken();
			$sales=new Sales;
		$status=$sales->deleteSalesById($param->id);
		if($status){
			echo $status;
			exit;
		}
	}

	public function getItemById($itemid){
		$purchase = new Purchase;
		$purchase_data = $purchase->getRecordsByItemId($itemid);
		echo json_encode($purchase_data);
	}

	//purchase return


	public function purchasereturnIndex(){
		$purchase_data= DB::table('tbl_purchase')			
						->join('tbl_item_name','tbl_purchase.item_name_id','=','tbl_item_name.item_name_id')
						->select('tbl_purchase.*','tbl_item_name.item_name')
						->get();
		return view('inventory/purchase_return/_list',['purchase_data'=>$purchase_data]);

	}
		public function purchaseReturnList($item_name_id,$month){

		$id = explode('-', $item_name_id)[0];
		$purchase_id = explode('-', $item_name_id)[1];
		$purchase=new PurchaseReturn;
		$purchase_data=DB::table('tbl_purchase')->where(['tbl_purchase.item_name_id'=>$id,'tbl_purchase.month'=>$month])
			->join('tbl_item_name','tbl_purchase.item_name_id','=','tbl_item_name.item_name_id')
			->join('tbl_vendor','tbl_purchase.vendor_id','=','tbl_vendor.vendor_id')
			->get();
		foreach($purchase_data as $key=>$value){

		
			$data=DB::table('tbl_purchase_return')->where(['item_name_id'=>$value->item_name_id,'purchase_id'=>$value->purchase_id,'rate'=>$value->rate])
			->get();
			
			$final_purchase_array = [];
			foreach($data as $purchase=>$purchase_value){
				$final_purchase_array[$purchase_value->purchase_id] =[$purchase_value->quantity_returned, $purchase_value->total_price,$purchase_value->narration];
			}
			$purchase_data[$key]->purchase_records=$final_purchase_array;
		}
		echo json_encode(array("purchase"=>$purchase_data));
		
	}

		
public function purchaseReturnSave(){
		//print_r($_POST['advance_array']);exit;
			$array = [];
			foreach($_POST['purchaseArray'] as $key=>$value){

				$array = array(
					"month"=>$_POST['month'],
					"purchase_id"=>$key,
					
					"item_name_id"=> explode('-',$_POST['item_name_id'])[0],
				
					"total_quantity_purchased"=>$value['0'],
					"quantity_returned"=>$value['1'],
					"rate"=>$value['2'],
					"total_price"=>$value['3'],
					"vendor_id"=>$value['4'],
					"narration"=>$value['5']
					);

			$purchase=new PurchaseReturn;
			$data = $purchase->getPurchaseRecords($key,$_POST['item_name_id'],$value['0'],$value['2'],$value['4'],$_POST['month']);
			if(count($data)>0){
				$purchase->updateRecords($array);
			}else{
				$purchase->savePurchaseReturn($array);
			}
		}
		
	}

	public function salesReturnIndex(){
		$sales=new Sales;
		$sales_data=DB::table('tbl_sales')
						
						->join('tbl_item_name','tbl_sales.item_name_id','=','tbl_item_name.item_name_id')
						
						->select('tbl_sales.*','tbl_item_name.item_name')
						->get();
		return view('inventory/sales_return/_list',['sold_data'=>$sales_data]);

	}

	public function salesReturnFilter($item_id,$month){
		$id = explode('-', $item_id)[0];
		$sales_id = explode('-', $item_id)[1];
		//$salesReturnObject = new SalesReturn;
		$sales_return_data = DB::table('tbl_sales')->where(['tbl_sales.item_name_id'=>$id,'tbl_sales.month'=>$month])
			->join('tbl_student_details','tbl_sales.sold_to','=','tbl_student_details.student_id')
			->join('tbl_vendor','tbl_sales.vendor_id','=','tbl_vendor.vendor_id')
			->select('tbl_sales.*','tbl_student_details.student_name','tbl_student_details.student_id','tbl_vendor.name as vendor_name')
			->get();
			$final_sales_array = [];
			foreach($sales_return_data as $key=>$value){
				$salesReturnObject = new SalesReturn;
				$data= $salesReturnObject->getRecordsByItemAndSalesId($value->sales_id,$value->item_name_id);
				foreach($data as $d){
					$final_sales_array[$value->sales_id] = [$d->returned_quantity,$d->returned_price,$d->description];
				}
				$sales_return_data[$key]->returned_data = $final_sales_array;
			}

					echo json_encode(array('sales_data'=>$sales_return_data));

		exit;

	}

	public function saveSalesReturn(){
		
		$array = array();
		foreach($_POST['salesArray'] as $key=>$value){
			$sales_id = explode('-',$key)[0];
			$original_quantity = explode('-', $key)[1];
			$returned_by = explode('-', $key)[2];
			$rate= explode('-', $key)[3];
			$returned_quantity = $value[0];
			$returned_price = $value[1];
			$narration = $value[2];
			$vendor_id= $value[3];
			$item_id = explode('-', $_POST['item_id'])[0];
			$array = array('sales_id'=>$sales_id,
							'original_quantity'=>$original_quantity,
							'returned_by'=>$returned_by,
							'returned_quantity'=>$returned_quantity,
							'narration'=>$narration,
							'returned_price'=>$returned_price,
							'rate'=>$rate,
							'item_id'=>$item_id,
							'vendor_id'=>$vendor_id,
							'month'=>$_POST['month']
					);
			$salesReturnObject = new SalesReturn;
			$data = $salesReturnObject->getRecords($array);
			if(count($data)>0){
				$salesReturnObject->updateRecords($array);
				
			}else{
				$salesReturnObject->saveRecords($array);
			}
		}
	}

	public function stockIndex(){
		$vendor = new Vendor;
		$vendor_data = $vendor->getAllVendor();
		
		return view('inventory/stock/_list',['vendor_data'=>$vendor_data]);
	}
	public function stockList(Request $request){
			/*$stock=new Stock;

		$stock_data=DB::table('tbl_purchase')->where(['tbl_purchase.school_id'=>,'tbl_purchase.item_name_id'=>$id])
			->join('tbl_item_name','tbl_purchase.item_name_id','=','tbl_item_name.item_name_id')
			->join('tbl_vendor','tbl_purchase.vendor_id','=','tbl_vendor.vendor_id')
			->get();
			*/
			$purchaseObject = new Purchase;
			$purchaseReturnObject = new PurchaseReturn;
			$salesObject = new Sales;
			$salesReturnObject = new SalesReturn;
			$purchased_items = $purchaseObject->getRecordsByVendorId($request->vendor_id);
			$items_array = array();
			foreach($purchased_items as $pkey=>$pval){
				$purchased_item_array = array();
				$purchased_return_array = array();
				$sold_item_array = array();
				$sold_return_array = array();
				$item_id = $pval->item_name_id;
				$itemObject = new ItemName;
				$itemObjectData = $itemObject->getItemById($item_id);
				$item_name = $itemObjectData[0]->item_name;
				$purchacsedItemData = $purchaseObject->getRecordsByItemId($item_id,$request->vendor_id);
				//purchase and purchase_returned
				foreach($purchacsedItemData as $ikey=>$ivalue){
					$purchased_item_array[$item_id][] = $ivalue->quantity;  
				}
				
				$purchasedReturnedData = $purchaseReturnObject->getRecordsByItemId($item_id,$request->vendor_id);
				if(count($purchasedReturnedData)>0){
					foreach($purchasedReturnedData as $prkey=>$prvalue){
						$purchased_return_array[$item_id][] = $prvalue->quantity_returned;

					}
					$total_purchase_returned = array_sum($purchased_return_array[$item_id]);
				}else{
					$total_purchase_returned = 0;
				}
				
				$total_purchased = array_sum($purchased_item_array[$item_id]);

				//sales and sales_returned
				$soldItemData = $salesObject->getRecordsByItemId($item_id,$request->vendor_id);
				if(count($soldItemData)>0){
					foreach($soldItemData as $skey=>$svalue){
						$sold_item_array[$item_id][] = $svalue->quantity;
					}
					$total_sold = array_sum($sold_item_array[$item_id]);
				}else{
					$total_sold = 0;
				}
				$soldReturnData = $salesReturnObject->getRecordsByItemId($item_id,$request->vendor_id);
				if(count($soldReturnData)>0){
					foreach($soldReturnData as $srkey=>$srvalue){
						$sold_return_array[$item_id][] = $srvalue->returned_quantity;
					}
					$total_sale_return = array_sum($sold_return_array[$item_id]);
				}else{
					$total_sale_return = 0;
				}
				 $total_sale_return;
				$items_array[$item_id] = array('item_id'=>$item_id,
											'item_name'=>$item_name,
											'total_purchased'=>$total_purchased,
											'total_purchase_returned'=>$total_purchase_returned,
											'total_sold'=>$total_sold,
											'total_sale_return'=>$total_sale_return,
											'stock'=>($total_purchased - $total_purchase_returned)-($total_sold-$total_sale_return),
											'vendor_id'=>$request->vendor_id
										);

			}
			$vendor = new Vendor;
		$vendor_data = $vendor->getAllVendor();
			return view('inventory/stock/_list',['stock_data'=>$items_array,'vendor_data'=>$vendor_data,'stock_vendor_id'=>$request->vendor_id]);
	}
}