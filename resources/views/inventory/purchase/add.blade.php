@extends('layouts.master')
@section('content')
  <div class="row-fluid">
    <div class="span12 offset3">
      <div class="widget-box">
        <div class="widget-title widget-form-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
      
          
        </div>
        <div class="widget-content">
          @foreach($errors->all() as $err)
            <div class="alert alert-danger">
              {{$err}}
            </div>
          @endforeach

          <form method="post" class="form-horizontal" enctype="multipart/form-data" action="<?php echo isset($purchase_data[0])?__setLink('/inventory/purchase/update',array('id'=>$purchase_data[0]['purchase_id'])):__setLink('/inventory/purchase/save'); ?>">
            {{ csrf_field() }}

             

              <div class="span12">
                <div class="control-group">
                <label class="control-label span4">Item </label>
                <div class="controls span8" style="margin-left: 59px !important">
                  <select name="item_name_id" id="selItem">
                    <option value="">  </option>
                   <?php   foreach($itemname_data as $item){ ?>
                      <option value="{{$item->item_name_id}}">{{$item->item_name}}</option>
                   <?php } ?>
                  </select>
                  
                </div>
              </div>
              <div  class="control-group termgen span4" style="margin:-10px 0px 10px -145px !important">
                  
            <a id="filter" class="pull-right btn btn-primary form-btn"> Add Item
            </a>
         
              </div>
              </div>

            <div class="span12">
              <div class="control-group">
                <label class="control-label span4">Quantity</label>
                <div class="controls span8" style="margin-left: 35px !important">
                  <input type="text" name="quantity" id="quantity" placeholder="Enter quantity" class="span12 m-wrap" value="<?php echo isset($purchase_data)?$purchase_data[0]['quantity']:""; ?>">
                </div>
              </div>
            </div>

            <div class="span12">
              <div class="control-group">
                <label class="control-label span4">Unit Cost </label>
                <div class="controls span8" style="margin-left: 30px !important">
                  <input type="text" name="rate" id="rate" placeholder="Enter rate per piece" class="span12 m-wrap" value="<?php echo isset($purchase_data)?$purchase_data[0]['rate']:""; ?>">
                </div>
              </div>
              </div>
              

                <div class="span12">
              <div class="control-group">
                <label class="control-label span4">Price </label>
                <div class="controls span8" style="margin-left: 55px !important">
                  <input type="text" readonly="true" name="price" id="price"   class="span12 m-wrap" value="<?php echo isset($purchase_data)?$purchase_data[0]['price']:""; ?>">
                </div>
              </div>

               
              </div>
                <div class="span12">
              <div class="control-group">
                <label class="control-label span4">Selling Price </label>
                <div class="controls span8">
                  <input type="text" name="sell_price"   placeholder="Enter selling price" class="span12 m-wrap" value="<?php echo isset($purchase_data)?$purchase_data[0]['sell_price']:""; ?>">
                </div>
              </div>

               
              </div>

              <div class="span12">
                <div class="control-group">
                <label class="control-label span4">Vendor </label>
                <div class="controls span8" style="margin-left:44px !important">
                  <select name="vendor_id">
                    <option value=""></option>
                   <?php   foreach($vendor_data as $vendor){ ?>
                      <option value="{{$vendor->vendor_id}}">{{$vendor->name}}</option>
                   <?php } ?>
                  </select>
                  
                </div>
              </div>
               <div  class="control-group termgen span4" style="margin:-5px 0px 10px -130px !important">
                  
            <a id="filterVendor" class="pull-right btn btn-primary form-btn"> Add vendor
            </a>
         
              </div>
              </div>

              <div class="span12">
              <div class="control-group">
                <label class="control-label span4">Narration </label>
                <div class="controls span8" style="margin-left:30px !important">
                   <textarea type="text"  name="description" class="span12 m-wrap"><?php echo isset($purchase_data)?$purchase_data[0]['description']:""; ?></textarea>
                </div>
              </div>

              </div>

              <div class="span12">
                <div class="control-group">
                <label class="control-label span4">Purchase Returned ?</label>
                <div class="controls span1">
                  <input type="checkbox" name="status"  class="span4 m-wrap" <?php if(isset($purchase_data) && $purchase_data[0]['status'] == 1){ ?> checked="" <?php }else{ } ?> >
                </div>
              </div>
              </div>
           
                <div class="span12" style="margin-top:20px !important">
              <button class="btn btn-success span3 offset4" value="submit" type="submit">Submit</button>
            </div>
         </form>
         <div style="clear:both"></div>
        </div>
      </div>
    </div>
  </div>

<div id="addItem" class="modal fade filter-modal" tabindex="-1" role="dialog" style="display: none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header filter-modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#fff;">&times;</span></button>
        <h4 class="modal-title">Filter Body</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo __setLink('inventory/itemname/save',array('return_status'=>1)); ?>">
          {{ csrf_field() }}

              <div class="form-group popup-filter">
                
                <label class="control-label span4">Item Group </label>
                <div class="controls span8">
                  <select name="item_group_id">
                    <option value=""></option>
                   <?php   foreach($itemGroup_data as $item){ ?>
                      <option value="{{$item->item_group_id}}">{{$item->category}}</option>
                   <?php } ?>
                  </select>
                  
              
              </div>
              </div>
          <div class="form-group popup-filter">
            <label>Item Name</label>
            <input type="text" name="item_name" class="form-control"> 
          </div>

          <div style="clear:both"></div>
          <button class="btn btn-primary filter-btn" value="submit" type="submit" style="margin-top:10px;">Submit</button>


        </form>
      </div>
      
  
<div id="addVendor" class="modal fade filter-modal" tabindex="-1" role="dialog" style="display: none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header filter-modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#fff;">&times;</span></button>
        <h4 class="modal-title">Filter Body</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo __setLink('inventory/vendor/save',array('return_status'=>1)); ?>">
          {{ csrf_field() }}

             <div class="span12">
              <div class="control-group">
                <label class="control-label span4">Company Name</label>
                <div class="controls span8">
                  <input type="text" name="name"  >
                </div>
              </div>

              
              </div>

              <div class="span12">
                <div class="control-group">
                <label class="control-label span4">Address </label>
                <div class="controls span8">
                  <input type="text" name="address"  >
                </div>
              </div>

              </div>

                <div class="span12">
              <div class="control-group">
                <label class="control-label span4">Email </label>
                <div class="controls span8">
                  <input type="email" name="email"  >
                </div>
              </div>
             </div>

             <div class="span12">

              <div class="control-group">
                <label class="control-label span4">Contact No </label>
                <div class="controls span8">
                  <input type="text" name="contact"  >
                </div>
              </div>

            </div>

                 <div class="span12">
              <div class="control-group">
                <label class="control-label span4">Contact Person Name </label>
                <div class="controls span8">
                  <input type="text" name="p_name"  >
                </div>
              </div>

              
              </div>

              <div class="span12">
                <div class="control-group">
                <label class="control-label span4">Phone No </label>
                <div class="controls span8">
                  <input type="text" name="phone"  >
                </div>
              </div>
              </div>

          <div style="clear:both"></div>
          <button class="btn btn-primary filter-btn" value="submit" type="submit" style="margin-top:10px;">Submit</button>


        </form>
      </div>
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
$(document).ready(function(){
  $('#filter').click(function(){
    $('#addItem').modal('show');
  });
   $('#filterVendor').click(function(){
    $('#addVendor').modal('show');
  });
});
</script>


<script type="text/javascript">
  $(document).ready(function(){
    $('#rate').on("change",function(){
      quantity=$('#quantity').val();
      rate=$('#rate').val();
      price=(quantity * rate);
      
      $('#price').val(price);
    });
  });

</script>


@endSection