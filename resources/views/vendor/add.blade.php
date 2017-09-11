@extends('layouts.master')
@section('content')
  <div class="row-fluid">
    <div class="span6 offset3">
      <div class="widget-box">
        <div class="widget-title widget-form-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Add Vendor</h5>
          
        </div>
        <div class="widget-content">
          @foreach($errors->all() as $err)
            <div class="alert alert-danger">
              {{$err}}
            </div>
          @endforeach

          
           <form method="post" class="form-horizontal" enctype="multipart/form-data" action="<?php echo isset($vendor_data[0])?  __setLink('inventory/vendor/update',array('id'=>$vendor_data[0]['vendor_id'])):  __setLink('inventory/vendor/save'); ?>">
            {{ csrf_field() }}
            <div class="span12">
              <div class="span6">
                <label class="span4">Company Name</label>
                <div class="span8">
                  <input type="text" name="name"  placeholder="Enter company name" class="span12 m-wrap" value="<?php echo isset($vendor_data)?$vendor_data[0]['name']:""; ?>">
                </div>
              </div>

              
              </div>

              <div class="span12">
                <div class="span6">
                <label class="span4">Address </label>
                <div class="span8">
                  <input type="text" name="address"  placeholder="Enter address" class="span12 m-wrap" value="<?php echo isset($vendor_data)?$vendor_data[0]['address']:""; ?>">
                </div>
              </div>

              </div>

                <div class="span12">
              <div class="span6">
                <label class="span4">Email </label>
                <div class="span8">
                  <input type="email" name="email"  placeholder="Enter email" class="span12 m-wrap" value="<?php echo isset($vendor_data)?$vendor_data[0]['email']:""; ?>">
                </div>
              </div>
             </div>

             <div class="span12">

              <div class="span6">
                <label class="span4">Contact No </label>
                <div class="span8">
                  <input type="text" name="contact"  placeholder="Enter Contact No" class="span12 m-wrap" value="<?php echo isset($vendor_data)?$vendor_data[0]['contact']:""; ?>">
                </div>
              </div>

            </div>

                 <div class="span12">
              <div class="span6">
                <label class="span4">Contact Person Name </label>
                <div class="span8">
                  <input type="text" name="p_name"  placeholder="Enter contact person name" class="span12 m-wrap" value="<?php echo isset($vendor_data)?$vendor_data[0]['p_name']:""; ?>">
                </div>
              </div>

              
              </div>

              <div class="span12">
                <div class="span6">
                <label class="span4">Phone No </label>
                <div class="span8">
                  <input type="text" name="phone"  placeholder="Enter contact person phone" class="span12 m-wrap" value="<?php echo isset($vendor_data)?$vendor_data[0]['phone']:""; ?>">
                </div>
              </div>
              </div>
          
              
              <div style="span12">
                <button class="btn btn-danger span3 offset4" value="submit" type="submit">Save </button>
              </div>
            
         </form>
         <div style="clear:both"></div>
        </div>
      </div>
    </div>
  </div>
</div>


@endSection