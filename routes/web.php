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
Route::get('/inventory/itemname/itemjsonlist','ItemNameController@itemnameListJson');
//inventory
	//purchase
	Route::get('/inventory','InventoryController@index');
	Route::get('/inventory/purchase/_list','InventoryController@purchaseList');
	Route::get('/inventory/purchase/add','InventoryController@addPurchase');
	Route::post('/inventory/purchase/save','InventoryController@purchaseSave');
	Route::get('/inventory/purchase/edit/{id}','InventoryController@editPurchase');
	Route::post('/inventory/purchase/update{id}','InventoryController@purchaseUpdate');
	Route::get('/inventory/purchase/delete{id}','InventoryController@deletePurchase');
	Route::get('/inventory/purchase/purchaselistjson','InventoryController@purchaseListJson');

	//purchase return 
	Route::get('/inventory/purchase/return','InventoryController@purchaseReturnIndex');
	Route::get('/inventory/purchase/return/_list/{item_name_id}/{month}','InventoryController@purchaseReturnList');
	Route::post('/inventory/purchase/return/save','InventoryController@purchaseReturnSave');


	//sales
	Route::get('/inventory/sales/_list','InventoryController@salesList');
	Route::get('/inventory/sales/add','InventoryController@addSales');
	Route::post('/inventory/sales/save','InventoryController@salesSave');
	Route::get('/inventory/sales/edit','InventoryController@editSales');
	Route::post('/inventory/sales/update','InventoryController@salesUpdate');
	Route::get('/inventory/sales/delete','InventoryController@deleteSales');
	Route::get('/inventory/price/{itemid}','InventoryController@getItemById');
	Route::get('/inventory/sales/saleslistjson','InventoryController@salesListJson');
	//stock
	Route::get('/inventory/stock/_list','InventoryController@stockIndex');
	Route::post('/inventory/stock/get','InventoryController@stockList');
//itemname
	Route::get('/inventory/itemname/_list','Inventory/ItemNameController@_list');
	Route::get('/inventory/itemname/add','ItemNameController@add');
	Route::post('/inventory/itemname/save','ItemNameController@save');
	Route::get('/inventory/itemname/edit','ItemNameController@edit');
	Route::post('/inventory/itemname/update','ItemNameController@update');
	Route::get('/inventory/itemname/delete','ItemNameController@delete');
	Route::get('/inventory/itemname/{id}','ItemNameController@getItemsbyItemGroupId');
	

	//itemgroup
	Route::get('/inventory/itemgroup/_list','Inventory\ItemGroupController@_list');
	Route::get('/inventory/itemgroup/add','ItemGroupController@add');
	Route::post('/inventory/itemgroup/save','Inventory\Inventory\ItemGroupController@save');
	Route::get('/inventory/itemgroup/edit/{id}','Inventory\ItemGroupController@edit');
	Route::post('/inventory/itemgroup/update','Inventory\ItemGroupController@update');
	Route::get('/inventory/itemgroup/delete/{id}','Inventory\ItemGroupController@delete');
	Route::get('/inventory/itemgroup/itemgroupjsonlist','Inventory\ItemGroupController@itemGroupListJson');
	
	//vendor
	Route::get('/inventory/vendor/_list','VendorController@_list');
	Route::get('/inventory/vendor/add','VendorController@add');
	Route::post('/inventory/vendor/save','VendorController@save');
	Route::get('/inventory/vendor/edit','VendorController@edit');
	Route::post('/inventory/vendor/update','VendorController@update');
	Route::get('/inventory/vendor/delete','VendorController@delete');
	Route::get('/inventory/vendor/vendorlistjson','VendorController@vendorListJson');
