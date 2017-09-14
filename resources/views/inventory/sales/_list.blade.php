@extends('layouts.master')

@section('form-content')
           
           <form id="frmAjaxSender">
             
              <div class="col-sm-12">
                <div class="col-sm-4 form-group">
                <label class="">Month </label>
                   <select id="ddlMonth" name="month">
                     <option>--Select Month--</option>
                     @foreach(getMonthArray() as $key=>$val)
                      <option value="{{$key}}">{{$val}}</option>
                     @endforeach
                   </select>
              </div>

              



                <div class="col-sm-4 form-group">
                <label class="">Item </label>
                  <select name="item_name_id" id="selItem" required>
                    <option value=""></option>
                   <?php   foreach($itemname_data as $item){ ?>
                      <option value="{{$item->item_name_id}}">{{$item->item_name}}</option>
                   <?php } ?>
                  </select>
              </div>

              <div class="col-sm-4 form-group">
                <label class="">Quantity</label>
                  <input type="text" name="quantity" required id="quantity" placeholder="Enter quantity" class="span12 m-wrap" >
              </div>
            </div>
            <div class="col-sm-12">

                <div class="col-sm-4 form-group">
                <label class="">Total Price </label>
                  <input type="text" name="price" id="price"  placeholder="Enter price" class="span12 m-wrap" required>

              </div>

              <div class="col-sm-4 form-group">
                <label class="">Sold To </label>
                 <input type="text" name="sold_to" id="sold_to"  placeholder="Enter name" class="span12 m-wrap" required>
                </select>
              </div>


                <input type="hidden" name="rate" id="rate" class="span12 m-wrap" value="">

                 <input type="hidden" name="vendor_id" id="vendor" class="span12 m-wrap" value="">
               
           
            
                 
              <div class="col-sm-4 form-group">
                <label class="span1">Narration </label>
                <div class="">
                   <textarea type="text"  name="description" id="description" class="span12 m-wrap" required></textarea>
                </div>
              </div>

              <div class="span12" style="margin-top:10px !important">
                <div class="span6">
                <label class="">Sales Returned ?</label>
                <div class="span2">
                  <input type="checkbox" name="status" id="status"  class="span5 m-wrap"  >
                </div>
              </div>
              </div>

                    <div class="">
                        <input type="hidden" id="hdnActionType" value="add">
                        <button class="btn btn-success" type="button" onclick="saveSales($('#hdnActionType').val())" style="margin: 0px !important;">Save</button>
                        </div>
                        </div>
            </form>
@stop
@section('table-content')

                                <table id="tblSalesList" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Item Name</th>
                                            <th>Vendor</th>
                                            <th>Quantity</th>
                                              <th>Rate </th>
                                                <th>Price</th>
                                                  <th>Sold To</th>
                                                  <th>Sales Return Quantity </th>
                                                  <th>Sales Return Price</th>
                                                    <th>Status</th>
                                                  <th>Narration</th>
                                                    <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php $i=1; foreach($sales_data as $sales){ ?>

                                <tr <?php if($i%2==0){ ?> class="gradeA odd" <?php }else{ ?> class="gradeA even" <?php } ?>>
                                  <td class="  sorting_1"><?php echo $i ?></td>
                              <td class=" ">{{$sales->item_name}} </td>
                                <td> {{$sales->vendor_name}}</td>
                                <td>{{$sales->quantity}}</td>
                                <td>{{$sales->rate}}</td>
                                <td>{{$sales->price}}</td>
                                <td>{{$sales->sold_to}}</td>
                                <td>{{$sales->returned_quantity}}</td>
                                <td>{{$sales->returned_price}}</td>
                                <td>{{$sales->status}}</td>
                                  <td>{{$sales->description}}</td>
                                  
                                  <td class="all-icons">
                                      
                                      <a onclick="editSales('<?php echo '/inventory/sales/edit/'.$sales->sales_id?>');">Edit</a>
                                    <a type="select"   onclick="deleteSales('<?php echo '/inventory/sales/delete/'.$sales->sales_id?>');"  title="delete">
                                            Delete
                                          </a>
                                   </td> 
                  
                </tr>
               
           <?php $i++;} ?>
                                    </tbody>
                                </table>






          <script>
            function editSales(url){
                $.get(url,function(result){
                    $('#hdnActionType').val(result[0].sales_id);
                    $('#selItem').val(result[0].item_name_id);
                     $('#quantity').val(result[0].quantity);
                      $('#rate').val(result[0].rate);
                         $('#price').val(result[0].price);
                        $('#sold_to').val(result[0].sold_to); 
                         $('#vendor').val(result[0].vendor_id);
                           $('#description').val(result[0].description);
                            $('#ddlMonth').val(result[0].month);
                         if(result[0].status == 1){
                      $('#status').attr('checked',true);
                    }
                    else if(result[0].status == 0){
                       $('#status').removeAttr('checked');
                    }
                   
                  
                });
            }

           
            function saveSales(actionType){
              isvalidated = $('#frmAjaxSender')[0].checkValidity();
              if(isvalidated==false){
                $('#frmAjaxSender')[0].reportValidity();
                return false;
              }
              url = "";
              if(actionType=="add"){
                  url = "<?php echo '/inventory/sales/save'?>";
              }else{
                  url = "<?php echo '/inventory/sales/update'?>";
              }
               if ($('#status').is(":checked"))
             {
            $('#status').val('1');
              }
              else{
                $('#status').val('');
              }
            
              data = {
                sales_id : $('#hdnActionType').val(),
                item_name_id : $('#selItem').val(),
                 quantity : $('#quantity').val(),
                  rate : $('#rate').val(),
                   price : $('#price').val(),
                    sold_to : $('#sold_to').val(),
                    vendor_id : $('#vendor').val(),
                    description : $('#description').val(),
                    status : $('#status').val(),
                      month : $('#ddlMonth').val(),
               
            
              }
              $.post(url,data,function(result){
                  if(result=="1"){
                    loadSalesList();
                     $('#selItem').val('');
                      $('#quantity').val('');
                       $('#rate').val('');
                       $('#price').val('');
                       $('#sold_to').val('');
                         $('#vendor').val('');
                            $('#description').val('');
                          $('#ddlMonth').val('');     
                         $('#status').attr('checked',false);
                    $('#hdnActionType').val('add');
                    bootbox.alert("Sucessfully Saved");
                  }else{
                    bootbox.alert('Sorry, Data not saved, try again.');
                  }

              })
            }
                  function deleteSales(url){
                bootbox.confirm("Are you sure you want to delete?",function(result){
                  if(result){
                    $.get(url,function(result){
                       if(result=="1"){
                        loadSalesList();
                      }else{
                        bootbox.alert('Sorry, Data not saved, try again.');
                      }
                    }); 
                  
                }

             
           });
              }

     function loadSalesList(){
   
      $.get('<?php echo '/inventory/sales/saleslistjson'?>',function(result){
       
          html = '';
      APP.showLoading();

        if(result.length < 1){

               APP.hideLoading();
               bootbox.alert("No Data");
               $('#tblSalesList').html('<tr style="margin-top:100px;"><td style="text-align:center;">0 Record Found.</td></tr>');
                return false;
       }  
        $.each(result,function(i,c){
           
          html+='<tr class="gradeA odd">';
          html+='<td class="  sorting_1">'+i+'</td>';
          html+='<td class=" ">'+c.item_name+'</td>';
           html+='<td class=" ">'+c.vendor_name+'</td>';
            html+='<td class=" ">'+c.quantity+'</td>';
             html+='<td class=" ">'+c.rate+'</td>';
             html+='<td class=" ">'+c.price+'</td>';
              html+='<td class=" ">'+c.sold_to+'</td>';
               html+='<td class=" ">'+c.returned_quantity+'</td>';
                html+='<td class=" ">'+c.returned_price+'</td>';
               
            html+='<td>'+c.status+'</td>';
       
        html+='<td class=" ">'+c.description+'</td>';
          html+='<td class="all-icons">';
          html+='<div class="four-icons" style="padding-left:50px;">';
          html+='<a onclick="editSales(&apos;'+c.edit_url+'&apos;);" title="edit">Edit</a>';
          html+='<a onclick="deleteSales(&apos;'+c.delete_url+'&apos;);" type="select">Delete</a>';
          html+='</div>';
                     
          html+='</td>';  
          html+='</tr>';
           APP.hideLoading();
        });
        $('#tblSalesList tbody').html(html);
      });
      
   }
          </script>

            




<script type="text/javascript">
$(document).ready(function(){
    $('#selItem').on("change",function(){
        itemid = $('#selItem').val();
        $.get('/inventory/price/'+itemid+' ?>', function (res) {
       
            if(res){
              data = $.parseJSON(res);
              $.each(data, function(i,c) {
                $("#rate").val(c.sell_price);
                  $("#vendor").val(c.vendor_id); 
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
            $('#tblSalesList').DataTable({
                responsive: true
            });
        });
            
</script>



@endSection