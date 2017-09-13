@extends('layouts.master')
@section('content')

  <div class="row-fluid">
    <div class="span12">
      
      <div class="widget-box">
       <?php if(Session::has('nonempty')){ ?>
            <div class="alert alert-danger"><?php echo Session::get('nonempty'); ?> </div>
    <?php     } ?>
          <div class="widget-title widget-form-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Inventory Purchase List</h5>
            <div class="pull-right">
            <a id="filter" class="btn btn-primary form-btn"> Add Item
                      </a>
            <a id="filterVendor" class="btn btn-primary form-btn"> Add vendor
                              </a>

             <!-- <input type="hidden" id="hdnActionType" value="add">
            <button class="btn btn-primary form-btn" type="button" onclick="savePurchase($('#hdnActionType').val())">Save</button> -->
            </div>
          </div>
          <div class="widget-content">

              <form id="frmAjaxSender">
  
              <div class="span12">
                
                <div class="span4">
                <label class="span3">Item </label>
                  <div class="span7">
                      <select name="item_name_id" id="selItem" required>
                          <option value="">  </option>
                              <?php   foreach($itemname_data as $item){ ?>
                                 <option value="{{$item->item_name_id}}">{{$item->item_name}}</option>
                              <?php } ?>
                      </select>
                  
                  </div>

                  <!-- <div class="span4">
                      <a id="filter" class="btn btn-success" style="margin-top: 0px"> Add Item
                      </a>
                  </div> -->
                </div>

              <div class="span5">
                <label class="span3">Quantity</label>
                <div class="span7">
                  <input type="text" name="quantity" id="quantity" required placeholder="Enter quantity" class="span12 m-wrap" style="padding-left: 0px !important">
                </div>
              </div>

              <div class="span3">
                <label class="span4">Unit Cost </label>
                <div class="span8">
                  <input type="text" name="rate" id="rate" placeholder="Enter rate per piece" class="span12 m-wrap" required style="padding-left: 0px !important">
                </div>
              </div>

              </div>

            
              

                <div class="span12">
                    <div class="span4">
                        <label class="span3">Price </label>
                          <div class="span7">
                            <input type="text" readonly="true" name="price" id="price"   class="span12 m-wrap" required>
                          </div>
                    </div>

                    <div class="span5">
                      <label class="span3">Selling Price </label>
                        <div class="span7">
                            <input type="text" name="sell_price" id="sell_price"  placeholder="Enter selling price" class="span12 m-wrap" required style="padding-left: 0px !important">
                        </div>
                    </div>

                    <div class="span3">
                        <label class="span4">Vendor </label>
                             <div class="span8">
                                <select name="vendor_id" id="vendor_id" required>
                                  <option value=""></option>
                                      <?php   foreach($vendor_data as $vendor){ ?>
                                       <option value="{{$vendor->vendor_id}}">{{$vendor->name}}</option>
                                      <?php } ?>
                                </select>
                  
                              </div>

                             <!--  <div  class="span4">
                          
                              <a id="filterVendor" class="pull-right btn btn-success"> Add vendor
                              </a>
         
                          </div> -->
                    </div>
                          
                  </div>

              <div class="span12">
              <div class="span6">
                <label class="span2">Narration </label>
                <div class="span10">
                   <textarea type="text" id="description" required  name="description" class="span12 m-wrap"></textarea>
                </div>
              </div>

              <div class="span6">
                <label class="span2">Month </label>
                <div class="span6">
                   <select id="ddlMonth" name="month">
                     <option>--Select Month--</option>
                     @foreach(getMonthArray() as $key=>$val)
                      <option value="{{$key}}">{{$val}}</option>
                     @endforeach
                   </select>
                </div>
              </div>

              </div>

              <div class="span12">
                <div class="span6">
                <label class="span2">Purchase Returned ?</label>
                <div class="span2">
                  <input type="checkbox" name="status" id="status"  class="span4 m-wrap"  >
                </div>
              </div>
               <div class="span12">
            <input type="hidden" id="hdnActionType" value="add">
            <button class="btn btn-success" type="button" onclick="savePurchase($('#hdnActionType').val())" style="margin: 10px;">Save</button>
            </div>
              </div>
            
         </form>
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
   
      $.get('<?php echo 'inventory/purchase/purchaselistjson';?>',function(result){
       
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
          html+='<a onclick="editPurchase(&apos;'+c.edit_url+'&apos;);" title="edit"><i class="icon-pencil"></i></a>';
          html+='<a onclick="deletePurchase(&apos;'+c.delete_url+'&apos;);" type="select"><i class="icon-trash"></i></a>';
          html+='</div>';
                     
          html+='</td>';  
          html+='</tr>';
           APP.hideLoading();
        });
        $('#tblPurchaseList tbody').html(html);
      });
      
   }
          </script>

            <div id="tblPurchaseList" class="dataTables_wrapper" role="grid">
            <table class="table table-bordered data-table dataTable" id="DataTables_Table_0">
              <thead>
                <tr role="row">
                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 25px;"><div class="DataTables_sort_wrapper">S.N.<span class="DataTables_sort_icon css_right ui-icon ui-icon-triangle-1-n"></span></div></th>
                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 329px;"><div class="DataTables_sort_wrapper">
                Item Name
                <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>

                
               
                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 50px;"><div class="DataTables_sort_wrapper">Quantity <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>


                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 70px;"><div class="DataTables_sort_wrapper">Rate <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>


                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 130px;"><div class="DataTables_sort_wrapper">Total Price <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>

                   <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 329px;"><div class="DataTables_sort_wrapper">
                Selling Price
                <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>

                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 230px;"><div class="DataTables_sort_wrapper">Vendor <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>


                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 173px;"><div class="DataTables_sort_wrapper">Purchase Return Quantity <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>

                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 173px;"><div class="DataTables_sort_wrapper">Purchase Return Price <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>

                    <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 173px;"><div class="DataTables_sort_wrapper">Narration <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
              

                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 173px;"><div class="DataTables_sort_wrapper">Action<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                </tr>
              </thead>
              
            <tbody role="alert" aria-live="polite" aria-relevant="all">
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
                 
                  
                  <td>
                    <div class="pull-left all-icons">
                      <a onclick="editPurchase('<?php echo '/inventory/purchase/edit/'.$purchase->purchase_id; ?>');" title="edit">
                        <i class="icon-pencil"></i></a>
                        <a type="select"   onclick="deletePurchase('<?php echo 'inventory/purchase/delete/'.$purchase->purchase_id;?>');"  title="delete">
                            <i class="icon-trash"></i>
                          </a>
                    </div>
                    
                  
                </tr>
               
           <?php $i++;} ?>
            </tbody>
            </table>
         
            </div>
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