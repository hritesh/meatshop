<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/inventory/itemname/itemjsonlist','Inventory\ItemNameController@itemnameListJson');
//inventory
	//purchase
	Route::get('/inventory','Inventory\InventoryController@index');
	Route::get('/inventory/purchase/_list','Inventory\InventoryController@purchaseList');
	Route::get('/inventory/purchase/add','Inventory\InventoryController@addPurchase');
	Route::post('/inventory/purchase/save','Inventory\InventoryController@purchaseSave');
	Route::get('/inventory/purchase/edit/{id}','Inventory\InventoryController@editPurchase');
	Route::post('/inventory/purchase/update{id}','Inventory\InventoryController@purchaseUpdate');
	Route::get('/inventory/purchase/delete{id}','Inventory\InventoryController@deletePurchase');
	Route::get('/inventory/purchase/purchaselistjson','Inventory\InventoryController@purchaseListJson');

	//purchase return 
	Route::get('/inventory/purchase/return','Inventory\InventoryController@purchaseReturnIndex');
	Route::get('/inventory/purchase/return/_list/{item_name_id}/{month}','Inventory\InventoryController@purchaseReturnList');
	Route::post('/inventory/purchase/return/save','Inventory\InventoryController@purchaseReturnSave');


	//sales
	Route::get('/inventory/sales/_list','Inventory\InventoryController@salesList');
	Route::get('/inventory/sales/add','Inventory\InventoryController@addSales');
	Route::post('/inventory/sales/save','Inventory\InventoryController@salesSave');
	Route::get('/inventory/sales/edit/{id}','Inventory\InventoryController@editSales');
	Route::post('/inventory/sales/update','Inventory\InventoryController@salesUpdate');
	Route::get('/inventory/sales/delete/{id}','Inventory\InventoryController@deleteSales');
	Route::get('/inventory/price/{itemid}','Inventory\InventoryController@getItemById');
	Route::get('/inventory/sales/saleslistjson','Inventory\InventoryController@salesListJson');
	//stock
	Route::get('/inventory/stock/_list','Inventory\InventoryController@stockIndex');
	Route::post('/inventory/stock/get','Inventory\InventoryController@stockList');
//itemname
	Route::get('/inventory/itemname/_list','Inventory\ItemNameController@_list');
	Route::get('/inventory/itemname/add','Inventory\ItemNameController@add');
	Route::post('/inventory/itemname/save','Inventory\ItemNameController@save');
	Route::get('/inventory/itemname/edit/{id}','Inventory\ItemNameController@edit');
	Route::post('/inventory/itemname/update','Inventory\ItemNameController@update');
	Route::get('/inventory/itemname/delete/{id}','Inventory\ItemNameController@delete');
	Route::get('/inventory/itemname/{id}','Inventory\ItemNameController@getItemsbyItemGroupId');
	

	//itemgroup
	Route::get('/inventory/itemgroup/_list','Inventory\ItemGroupController@_list');
	Route::get('/inventory/itemgroup/add','Inventory\ItemGroupController@add');
	Route::post('/inventory/itemgroup/save','Inventory\Inventory\ItemGroupController@save');
	Route::get('/inventory/itemgroup/edit/{id}','Inventory\ItemGroupController@edit');
	Route::post('/inventory/itemgroup/update','Inventory\ItemGroupController@update');
	Route::get('/inventory/itemgroup/delete/{id}','Inventory\ItemGroupController@delete');
	Route::get('/inventory/itemgroup/itemgroupjsonlist','Inventory\ItemGroupController@itemGroupListJson');
	
	//vendor
	Route::get('/inventory/vendor/_list','Inventory\VendorController@_list');
	Route::get('/inventory/vendor/add','Inventory\VendorController@add');
	Route::post('/inventory/vendor/save','Inventory\VendorController@save');
	Route::get('/inventory/vendor/edit/{id}','Inventory\VendorController@edit');
	Route::post('/inventory/vendor/update','Inventory\VendorController@update');
	Route::get('/inventory/vendor/delete/{id}','Inventory\VendorController@delete');
	Route::get('/inventory/vendor/vendorlistjson','Inventory\VendorController@vendorListJson');
