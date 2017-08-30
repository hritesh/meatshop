@extends('layouts.master')
@section('content')
  <div class="row-fluid">
    <div class="span6 offset3">
      <div class="widget-box">
        <div class="widget-title widget-form-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Sales Return</h5>
          
        </div>
        <div class="widget-content">
          @foreach($errors->all() as $err)
            <div class="alert alert-danger">
              {{$err}}
            </div>
          @endforeach

          <form method="post" class="form-horizontal" enctype="multipart/form-data" action="<?php echo isset($sales_return_data[0])?__setLink('inventory/sales/return/update',array('id'=>$sales_data[0]['sales_id'])):__setLink('inventory/sales/return/save'); ?>">
            {{ csrf_field() }}

             <div class="span12">
            
             
               <div class="control-group">
                <label class="control-label span4">Item </label>
                <div class="controls span8">
                  <select name="item_name_id" id="selItem">
                    <option value=""></option>
                   <?php   foreach($sales_data as $item){ ?>
                      <option value="{{$item->item_name_id}}">{{$item->item_name}}</option>
                   <?php } ?>
                  </select>
                  
                </div>
              </div>
              </div>

            <div class="span12">
              <div class="control-group">
                <label class="control-label span4">Quantity</label>
                <div class="controls span8">
                  <input type="text" name="quantity" id="quantity" placeholder="Enter quantity" class="span12 m-wrap" value="<?php echo isset($sales_return_data)?$sales_return_data[0]['quantity']:""; ?>">
                </div>
              </div>          
              </div>

              
                <div class="span12">
              <div class="control-group">
                <label class="control-label span4">Total Price </label>
                <div class="controls span8">
                  <input type="text" name="price" id="price" placeholder="Enter price" class="span12 m-wrap" value="<?php echo isset($sales_return_data)?$sales_return_data[0]['price']:""; ?>">
                </div>
              </div>


                <input type="hidden" name="rate" id="rate"class="span12 m-wrap" value="<?php echo isset($sales_return_data)?$sales_return_data[0]['rate']:""; ?>">
               
              </div>
              <div class="span12">
                @include('common.class_section')
              </div>
                 <div class="span12">
            
             
               <div class="control-group">
                <label class="control-label span4">Sold To </label>
                <div class="controls span8">
                  <select name="sold_to" id="selStudent">
                    <option value="">  </option>
                  
                  </select>
                  
                </div>
              </div>
              </div>
                 <div class="span12">
              <div class="control-group">
                <label class="control-label span4">Narration </label>
                <div class="controls span8">
                   <textarea type="text"  name="description" class="span12 m-wrap"><?php echo isset($sales_return_data)?$sales_return_data[0]['description']:""; ?></textarea>
                </div>
              </div>
              </div>

              <div class="span12">
                <div class="control-group">
                <label class="control-label span4">Sales Returned ? </label>
                <div class="controls span2">
                  <input type="checkbox" name="status"  class="span5 m-wrap" <?php if(isset($sales_return_data) && $sales_return_data[0]['status'] == 1){ ?> checked="" <?php }else{ } ?> >
                </div>
              </div>
              </div>
            <div class="span12" >
              <button class="btn btn-danger span3 offset4" value="submit" type="submit">Submit</button>
            </div>
            
         </form>
         <div style="clear:both"></div>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript">
$(document).ready(function(){
    $('#selItem').on("change",function(){
        itemid = $('#selItem').val();
        $.get('/inventory/price/'+itemid+'?token='+'<?php echo getToken(); ?>', function (res) {
       
            if(res){
              data = $.parseJSON(res);
              $.each(data, function(i,c) {
                $("#rate").val(c.sell_price);

              });
            }else{

            }  
    
        });
    });  
});
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#quantity').on("change",function(){
      quantity=$('#quantity').val();
      rate=$('#rate').val();
      price=(quantity * rate);   
      $('#price').val(price);
    });
  });

</script>

  <script type="text/javascript">
  $(document).ready(function(){
   
      $('#ddlSection').on("change",function(){
        classid = $('#ddlClass').val();
      sectionid=$('#ddlSection').val();
      
      $.get('/student/'+classid+'/'+sectionid+"?token=<?php echo getToken();?>",function(res){
        if(res){
          $('#selStudent').empty();
          data=$.parseJSON(res);
          $.each(data, function(i,c){
            $('#selStudent').append("<option value="+c.student_id+">"+c.student_name+"</option>");
          });
        }
      });
    });

    });


</script>

@endSection