@extends('layouts.master')
@section('content')

  <div class="row-fluid">
    <div class="span12">
      
      <div class="widget-box">
          <?php if(Session::has('nonempty')){ ?>
            <div class="alert alert-danger"><?php echo Session::get('nonempty'); ?> </div>
    <?php     } ?>
          <div class="widget-title widget-form-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Inventory Sales List</h5>
            
            </div>

          <div class="widget-content">


           <form id="frmAjaxSender">
             
              <div class="span12">
                @include('common.class_section')
                  
                  <div class="span3">
                <label class="span4">Month </label>
                <div class="span8">
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
               <div class="span3">
                <label class="span4">Item </label>
                <div class="span8">
                  <select name="item_name_id" id="selItem" required>
                    <option value=""></option>
                   <?php   foreach($itemname_data as $item){ ?>
                      <option value="{{$item->item_name_id}}">{{$item->item_name}}</option>
                   <?php } ?>
                  </select>
                  
                </div>
              </div>

              <div class="span3">
                <label class="span4">Quantity</label>
                <div class="span8">
                  <input type="text" name="quantity" required id="quantity" placeholder="Enter quantity" class="span12 m-wrap" >
                </div>
              </div>

                 <div class="span3">
                <label class="span4">Total Price </label>
                <div class="span8">
                  <input type="text" name="price" id="price"  placeholder="Enter price" class="span12 m-wrap" required>
                </div>

              </div>

                <div class="span3">
                <label class="span3">Sold To </label>
                <div class="span8">
                  <select name="sold_to" id="selStudent" required>
                    <option value="">  </option>
                  </select>
                </div>
              </div>


                <input type="hidden" name="rate" id="rate" class="span12 m-wrap" value="">

                 <input type="hidden" name="vendor_id" id="vendor" class="span12 m-wrap" value="">
               
              </div>
            
                 <div class="span12">
              <div class="span11">
                <label class="span1">Narration </label>
                <div class="span8">
                   <textarea type="text"  name="description" id="description" class="span12 m-wrap" required></textarea>
                </div>
              </div>

             
              </div>

              <div class="span12" style="margin-top:10px !important">
                <div class="span6">
                <label class="span3">Sales Returned ?</label>
                <div class="span2">
                  <input type="checkbox" name="status" id="status"  class="span5 m-wrap"  >
                </div>
              </div>
              </div>
             <div class="span12" style="margin-bottom: 10px" >
            <input type="hidden" id="hdnActionType" value="add">
            <button class="btn btn-success" type="button" onclick="saveSales($('#hdnActionType').val())">Save</button>
            </div>
         </form>
          <script>
            function editSales(url){
                $.get(url,function(result){
                    $('#hdnActionType').val(result[0].sales_id);
                    $('#selItem').val(result[0].item_name_id);
                     $('#quantity').val(result[0].quantity);
                      $('#rate').val(result[0].rate);
                         $('#price').val(result[0].price);
                        $('#selStudent').val(result[0].sold_to); 
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
                  url = "<?php echo __setLink('inventory/sales/save');?>";
              }else{
                  url = "<?php echo __setLink('inventory/sales/update');?>";
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
                    sold_to : $('#selStudent').val(),
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
                       $('#selStudent').val('');
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
   
      $.get('<?php echo __setLink('inventory/sales/saleslistjson');?>',function(result){
       
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
              html+='<td class=" ">'+c.student_name+'</td>';
               html+='<td class=" ">'+c.returned_quantity+'</td>';
                html+='<td class=" ">'+c.returned_price+'</td>';
               
            html+='<td>'+c.status+'</td>';
       
        html+='<td class=" ">'+c.description+'</td>';
          html+='<td class="all-icons">';
          html+='<div class="four-icons" style="padding-left:50px;">';
          html+='<a onclick="editSales(&apos;'+c.edit_url+'&apos;);" title="edit"><i class="icon-pencil"></i></a>';
          html+='<a onclick="deleteSales(&apos;'+c.delete_url+'&apos;);" type="select"><i class="icon-trash"></i></a>';
          html+='</div>';
                     
          html+='</td>';  
          html+='</tr>';
           APP.hideLoading();
        });
        $('#tblSalesList tbody').html(html);
      });
      
   }
          </script>

               <div id="tblSalesList" class="dataTables_wrapper" role="grid">
               <table class="table table-bordered data-table dataTable" id="DataTables_Table_0">
              <thead>
                <tr role="row">
                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 25px;"><div class="DataTables_sort_wrapper">S.N.<span class="DataTables_sort_icon css_right ui-icon ui-icon-triangle-1-n"></span></div></th>
                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 329px;"><div class="DataTables_sort_wrapper">
                Item Name
                <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>

                 <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 400px;"><div class="DataTables_sort_wrapper"> Vendor <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
               
                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 50px;"><div class="DataTables_sort_wrapper">Quantity <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>


                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 70px;"><div class="DataTables_sort_wrapper">Rate <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>


                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 100px;"><div class="DataTables_sort_wrapper">Price <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>


                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 400px;"><div class="DataTables_sort_wrapper">Sold To <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>


                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 173px;"><div class="DataTables_sort_wrapper">Sales Return Quantity <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>

                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 173px;"><div class="DataTables_sort_wrapper">Sales Return Price <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>

                    <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 173px;"><div class="DataTables_sort_wrapper">Narration <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
              

                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 173px;"><div class="DataTables_sort_wrapper">Action<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                </tr>
              </thead>
              
            <tbody role="alert" aria-live="polite" aria-relevant="all">
            <?php $i=1; foreach($sales_data as $sales){ ?>

              <tr <?php if($i%2==0){ ?> class="gradeA odd" <?php }else{ ?> class="gradeA even" <?php } ?>>
                  <td class="  sorting_1"><?php echo $i ?></td>
                  <td class=" ">{{$sales->item_name}} </td>
                  <td> {{$sales->vendor_name}}</td>
                  <td>{{$sales->quantity}}</td>
                  <td>{{$sales->rate}}</td>
                  <td>{{$sales->price}}</td>
                  <td>{{$sales->student_name}}</td>
                  <td>{{$sales->returned_quantity}}</td>
                  <td>{{$sales->returned_price}}</td>
                    <td>{{$sales->description}}</td>
                 
                  
                  <td class="all-icons">
                      <a onclick="editSales('<?php echo __setLink('/inventory/sales/edit',array('id'=>$sales->sales_id)); ?>');" title="edit">
                        <i class="icon-pencil"></i>
                      </a> 
                       <a type="select"   onclick="deleteSales('<?php echo __setLink('inventory/sales/delete',array('id'=>$sales->sales_id));?>');"   title="delete">
                            <i class="icon-trash"></i>
                          </a>
                    
                  
                </tr>
              
           <?php $i++;} ?>
             </tbody>
            </table>
  
            </div>
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