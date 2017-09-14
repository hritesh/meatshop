
 @extends('layouts.master')
@section('form-content')
  
           
          
         <form method="post" action="<?php echo '/inventory/stock/get'?>">
            {{ csrf_field() }}
            <div class="span12">
              <div class="span3">
                <label class="span3">Vendor </label>
                <div class="span8">
                  <select name="vendor_id" id="ddlTeacher" >
                    <option value="">--Select Vendor--</option>
                   <?php   foreach($vendor_data as $vendor){ ?>
                    <?php if(isset($stock_data)){ 
                        if($vendor->vendor_id == $stock_vendor_id){
                          $selected ='selected="true"';  
                        }else{
                          $selected = "";
                        }
                     ?>
                     <option <?php echo $selected; ?> value="{{$vendor->vendor_id}}">{{$vendor->name}}</option>
                    <?php }else{ ?>
                       <option value="{{$vendor->vendor_id}}">{{$vendor->name}}</option>
                    <?php   } ?>
                   <?php } ?>
                  </select>
                  
                </div>
              </div>

              <div class="span3">
              <button type="submit" value="submit"  class="btn btn-success" style="margin: 0px">Submit</button>
            </div>
            </div>
            
          </form>
@stop
@section('table-content')
        </div>
        </div>
          <?php if(isset($stock_data)){ ?>
            <table id="tblStudentFeeList" class="table table-bordered table-striped filter-results">
              <tr>
                <td class="filter-table" style="text-align:center;"><b>SN</b></td>
                <td class="filter-table" style="text-align:center;"><b>Item Name</b></td>
                <td class="filter-table" style="text-align:center;"><b>Total Purchased</b></td>
                <td class="filter-table" style="text-align:center;"><b>Total Purchase Returned</b></td>
                <td class="filter-table" style="text-align:center;"><b>Total Sales</b></td>
                <td class="filter-table" style="text-align:center;"><b>Total Sales Returned</b></td>
                <td class="filter-table" style="text-align:center;"><b>Remaining Stock</b></td>
              </tr>
              <?php $i = 1; ?>
              @foreach($stock_data as $stock)
                <tr>
                  <td>{{$i}}</td>
                  <td>{{$stock['item_name']}}</td>
                  <td>{{$stock['total_purchased']}}</td>
                  <td>{{$stock['total_purchase_returned']}}</td>
                  <td>{{$stock['total_sold']}}</td>
                  <td>{{$stock['total_sale_return']}}</td>
                  <td>{{$stock['stock']}}</td>
                </tr>
              <?php $i++; ?>
              @endforeach
            </table>
            <?php } ?>

      </div>
    </div>
  </div>
  
@endSection