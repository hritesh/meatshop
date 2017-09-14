@extends('layouts.master')

@section('form-content')
            

              <form id="frmAjaxSender">
                <div class="col-sm-12">
                  <div class="col-sm-3 form-group">
                    <label>Select Item</label>
                    <select name="item_name_id" id="selItem" required>
                          <option value="">  </option>
                              <?php   foreach($itemname_data as $item){ ?>
                                 <option value="{{$item->item_name_id}}">{{$item->item_name}}</option>
                              <?php } ?>
                      </select>
                  </div>
                  <div class="col-sm-3 form-group">
                    <label>Quantity</label>
                    <input type="text" name="quantity" id="quantity" required placeholder="Enter quantity" class="span12 m-wrap" style="padding-left: 0px !important">
                  </div>
                  <div class="col-sm-3 form-group">
                    <label>Unit Cost</label>
                    <input type="text" name="rate" id="rate" placeholder="Enter rate per piece" class="span12 m-wrap" required style="padding-left: 0px !important">
                  </div>
                  <div class="col-sm-3 form-group">
                    <label>Price</label>
                    <input type="text" readonly="true" name="price" id="price"   class="span12 m-wrap" required>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="col-sm-4 form-group">
                    <label>Selling Price</label>
                    <input type="text" name="sell_price" id="sell_price"  placeholder="Enter selling price" class="span12 m-wrap" required style="padding-left: 0px !important">
                  </div>
                  <div class="col-sm-4 form-group">
                    <label>Vendor</label>
                    <select name="vendor_id" id="vendor_id" required>
                      <option value=""></option>
                          <?php   foreach($vendor_data as $vendor){ ?>
                           <option value="{{$vendor->vendor_id}}">{{$vendor->name}}</option>
                          <?php } ?>
                    </select>
                  </div>
                  <div class="col-sm-4 form-group">
                    <label>Month</label>
                    <select id="ddlMonth" name="month">
                     <option>--Select Month--</option>
                     @foreach(getMonthArray() as $key=>$val)
                      <option value="{{$key}}">{{$val}}</option>
                     @endforeach
                   </select>
                  </div>
                  <!--  <div  class="span4">
                          
                              <a id="filterVendor" class="pull-right btn btn-success"> Add vendor
                              </a>
         
                        </div> -->  
                </div>
                <div class="col-sm-12">
                  <div class="col-sm-6 form-group">
                    <label>Narration</label>
                    <textarea type="text" id="description" required  name="description" class="span12 m-wrap"></textarea>
                  </div>
                  <div class="col-sm-6">
                    <div class="col-sm-3">
                      <label>Purchase Returned</label>
                      <input type="checkbox" name="status" id="status"  class="span4 m-wrap"  >   
                    </div>
                    <div class="col-sm-3">
                      <input type="hidden" id="hdnActionType" value="add">
                        <button class="btn btn-success" type="button" onclick="savePurchase($('#hdnActionType').val())" style="margin: 0px !important;">Save</button>
                    </div>
                  </div>
                </div>
              </form>
@stop
@section('table-content')

                                <table id="tblPurchaseList" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Item Name</th>                                    
                                            <th>Quantity</th>
                                              <th>Rate </th>
                                                <th>Total Price</th>
                                                  <th>Selling Price</th>
                                                  <th>Vendor </th>
                                                  <th>Purchased Return Quantity</th>
                                                    <th>Purchase Return Price</th>
                                                  <th>Narration</th>
                                                    <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php $i=1; foreach($purchase_data as $purchase){ ?>

                                <tr <?php if($i%2==0){ ?> class="gradeA odd" <?php }else{ ?> class="gradeA even" <?php } ?>>
                                  <td class="  sorting_1"><?php echo $i ?></td>
                               <td class=" ">{{$purchase->item_name}} </td>
                 
                                  <td>{{$purchase->quantity}}</td>
                                  <td>{{$purchase->rate}}</td>
                                  <td>{{$purchase->price}}</td>
                                  <td class=" ">{{$purchase->sell_price}} </td>
                                  <td>{{$purchase->name}}</td>
                                  <td>{{$purchase->returned_quantity}}</td>
                                  <td>{{$purchase->returned_price}}</td>
                                    <td>{{$purchase->description}}</td>
                                  
                                  <td class="all-icons">
                                      
                                      <a type="select" class="btn btn-primary" onclick="editPurchase('<?php echo '/inventory/purchase/edit/'.$purchase->purchase_id?>');">Edit</a>
                                    <a type="select" class="btn btn-danger"  onclick="deletePurchase('<?php echo '/inventory/purchase/delete/'.$purchase->purchase_id?>');"  title="delete">
                                            Delete
                                          </a>
                                   </td> 
                  
                </tr>
               
           <?php $i++;} ?>
                                    </tbody>
                                </table>
                            



<script type="text/javascript">
        $(document).ready(function(){
            $('#tblPurchaseList').DataTable({
                responsive: true
            });
        });
            
</script>
 <script>
            function editPurchase(url){
                $.get(url,function(result){
                    $('#hdnActionType').val(result[0].purchase_id);
                    $('#selItem').val(result[0].item_name_id);
                     $('#quantity').val(result[0].quantity);
                      $('#rate').val(result[0].rate);
                         $('#price').val(result[0].price);
                        $('#sell_price').val(result[0].sell_price); 
                         $('#vendor_id').val(result[0].vendor_id);
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

           
            function savePurchase(actionType){
              isvalidated = $('#frmAjaxSender')[0].checkValidity();
              if(isvalidated==false){
                $('#frmAjaxSender')[0].reportValidity();
                return false;
              }
              url = "";
              if(actionType=="add"){
                  url = "<?php echo '/inventory/purchase/save';?>";
              }else{
                  url = "<?php echo '/inventory/purchase/update';?>";
              }
               if ($('#status').is(":checked"))
             {
            $('#status').val('1');
              }
              else{
                $('#status').val('');
              }
            
              data = {
                purchase_id : $('#hdnActionType').val(),
                item_name_id : $('#selItem').val(),
                 quantity : $('#quantity').val(),
                  rate : $('#rate').val(),
                   price : $('#price').val(),
                    sell_price : $('#sell_price').val(),
                     vendor_id : $('#vendor_id').val(),
                      description : $('#description').val(),
                     status : $('#status').val(),
                     month : $('#ddlMonth').val(),
               
            
              }
              $.post(url,data,function(result){
                  if(result=="1"){
                    loadPurchaseList();
                     $('#selItem').val('');
                      $('#quantity').val('');
                       $('#rate').val('');
                       $('#price').val('');
                       $('#sell_price').val('');
                         $('#vendor_id').val('');
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
                  function deletePurchase(url){
                bootbox.confirm("Are you sure you want to delete?",function(result){
                  if(result){
                    $.get(url,function(result){
                       if(result=="1"){
                        loadPurchaseList();
                      }else{
                        bootbox.alert('Sorry, Data not saved, try again.');
                      }
                    }); 
                  
                }

             
           });
              }

     function loadPurchaseList(){
   
      $.get('<?php echo '/inventory/purchase/purchaselistjson';?>',function(result){
       
          html = '';
      APP.showLoading();

        if(result.length < 1){

               APP.hideLoading();
               bootbox.alert("No Data");
               $('#tblPurchaseList').html('<tr style="margin-top:100px;"><td style="text-align:center;">0 Record Found.</td></tr>');
                return false;
       }  
        $.each(result,function(i,c){
           
          html+='<tr class="gradeA odd">';
          html+='<td class="  sorting_1">'+i+'</td>';
          html+='<td class=" ">'+c.item_name+'</td>';
           html+='<td class=" ">'+c.quantity+'</td>';
            html+='<td class=" ">'+c.rate+'</td>';
             html+='<td class=" ">'+c.price+'</td>';
             html+='<td class=" ">'+c.sell_price+'</td>';
              html+='<td class=" ">'+c.name+'</td>';
               html+='<td class=" ">'+c.returned_quantity+'</td>';
               html+='<td class=" ">'+c.returned_price+'</td>';
       
        html+='<td class=" ">'+c.description+'</td>';
          html+='<td class="all-icons">';
          html+='<div class="four-icons" style="padding-left:50px;">';
          html+='<a onclick="editPurchase(&apos;'+c.edit_url+'&apos;);" title="edit">Edit</a>';
          html+='<a onclick="deletePurchase(&apos;'+c.delete_url+'&apos;);" type="select">Delete</a>';
          html+='</div>';
                     
          html+='</td>';  
          html+='</tr>';
           APP.hideLoading();
        });
        $('#tblPurchaseList tbody').html(html);
      });
      
   }
          </script>

         

<div id="addItem" class="modal fade filter-modal" tabindex="-1" role="dialog" style="display: none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header filter-modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#fff;">&times;</span></button>
        <h4 class="modal-title">Add Item</h4>
      </div>
      <div class="modal-body">
        <?php $status = 1;?>
        <form method="post" action="<?php echo 'inventory/itemname/save/'.$status; ?>">
          {{ csrf_field() }}

              <div class="span12">
                
                <label class="span2">Item Group </label>
                <div class="span5">
                  <select name="item_group_id">
                    <option value=""></option>
                   <?php   foreach($itemGroup_data as $item){ ?>
                      <option value="{{$item->item_group_id}}">{{$item->category}}</option>
                   <?php } ?>
                  </select>
                  
              
              </div>
              </div>

          <div class="span12">
            <label class="span2">Item Name</label>
            <div class="span8">
            <input type="text" name="item_name" class="form-control"> 
              </div>
          </div>

          <div style="clear:both"></div>
          <button class="btn btn-primary filter-btn" value="submit" type="submit" style="margin-top:10px;">Submit</button>


        </form>
      </div>
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="addVendor" class="modal fade filter-modal" tabindex="-1" role="dialog" style="display: none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header filter-modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#fff;">&times;</span></button>
        <h4 class="modal-title">Filter Body</h4>
      </div>
      <div class="modal-body">

        <form method="post" action="<?php echo 'inventory/vendor/save/'.$status; ?>">
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
  /*  $('#selCategory').on("change",function(){
        categoryid = $('#selCategory').val();
        $.get('/inventory/itemname/'+categoryid+'?to function (res) {
           // $('#s1').select2({data:res,text:res.text,id:res.id});
            //json = eval(res);
            if(res){
              console.log(res);
              $("#selItem").empty(); // remove old options
              data = $.parseJSON(res);
              $.each(data, function(i,c) {
                $("#selItem").append("<option value="+c.item_name_id+">" + c.item_name + "</option>");

              });
            }else{

            }  
    
        });
    }); */
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