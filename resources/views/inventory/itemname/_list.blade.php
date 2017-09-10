@extends('layouts.master')
@section('content')
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Inventory-ItemName</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="panel panel-primary">
                  <div class="panel-body">
                    <form id="frmAjaxSender"  class="form-horizontal" >
                      {{csrf_field()}}
                          <div class="form-group col-sm-3">
                            <label>Item Name</label>
                             <input type="text" name="item_name" id="item_name" required placeholder="Enter item name" value="">
                          </div>

                          <div class="form-group col-sm-3">
                            <select name="item_group_id" id="item_group_id" required>
                              <option value="">--Select Category--</option>
                             <?php   foreach($itemgroup_data as $item){ ?>
                                <option value="{{$item->item_group_id}}">{{$item->category}}</option>
                             <?php } ?>
                            </select>
                          </div>
                          <div class="col-sm-3">
                            <label class="col-sm-3">Status </label>
                            <div class="col-sm-2">
                              <input type="checkbox" name="status"   id="status" style="margin-top: 0px !important">
                            </div>
                          </div>

                          <div class="col-sm-3">
                          <input type="hidden" id="hdnActionType" value="add">
                          <button class="btn btn-success" type="button" onclick="saveItem($('#hdnActionType').val())" style="margin: 0px !important;">Save</button>
                          </div>
                
                       </form>
                  </div>
              </div>
              </div>
            </div> 
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Item Name
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="tblItemList" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Item Name</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php $i=1; foreach($itemname_data as $item){ ?>

                                      <tr <?php if($i%2==0){ ?> class="gradeA odd" <?php }else{ ?> class="gradeA even" <?php } ?>>
                                          <td class="  sorting_1"><?php echo $i ?></td>
                                          <td class=" ">{{$item->item_name}} </td>
                                          <td class=" ">{{$item->category}} </td>
                                          <td>{{$item->status}}</td>
                                         
                                          
                                          <td class="all-icons">
                                            <a class="btn btn-primary" onclick="editItem('<?php echo '/inventory/itemname/edit/'.$item->item_name_id?>');">Edit</a> 
                                            <a  class="btn btn-danger"   onclick="deleteItem('<?php echo'/inventory/itemname/delete/'.$item->item_name_id;?>');" >
                                                    Delete
                                                  </a>
                                          </td>  
                                          
                                        </tr>
                                        
                                      <?php $i++;} ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <script type="text/javascript">
        $(document).ready(function(){
            $('#tblItemList').DataTable({
                responsive: true
            });
        });
            
</script>
<script>
            function editItem(urls){
                $.get(urls,function(result){
                    $('#hdnActionType').val(result[0].item_name_id);
                    $('#item_name').val(result[0].item_name);
                    $('#item_group_id').val(result[0].item_group_id);
                    if(result[0].status == 1){
                      $('#status').attr('checked',true);
                    }
                    else if(result[0].status == 0){
                       $('#status').removeAttr('checked');
                    }
                  
                });
            }

           
            function saveItem(actionType){
              isvalidated = $('#frmAjaxSender')[0].checkValidity();
              if(isvalidated==false){
                $('#frmAjaxSender')[0].reportValidity();
                return false;
              }
              url = "";
              if(actionType=="add"){
                  url = "<?php echo '/inventory/itemname/save'; ?>";
              }else{
                  url = "<?php echo '/inventory/itemname/update'; ?>";
              }
            if ($('#status').is(":checked"))
             {
            $('#status').val('1');
              }
              else{
                $('#status').val('');
              }
              data = {
                item_name_id : $('#hdnActionType').val(),
                item_name : $('#item_name').val(),
                item_group_id : $('#item_group_id').val(),
                status : $('#status').val(),
            
              }
              $.post(url,data,function(result){
                  if(result=="1"){
                    loadItemList();
                
                    $('#item_name').val('');
                     $('#item_group_id').val('');
                    $('#status').attr('checked',false);
                     $('#hdnActionType').val('add');
                    bootbox.alert("Sucessfully Saved");
                  }else{
                    bootbox.alert('Sorry, Data not saved, try again.');
                  }

              })
            }
                  function deleteItem(url){
                bootbox.confirm("Are you sure you want to delete?",function(result){
                  if(result){
                    $.get(url,function(result){
                       if(result=="1"){
                        loadItemList();
                      }else{
                        bootbox.alert('Sorry, Data not saved, try again.');
                      }
                    }); 
                  
                }

             
           });
              }

      function loadItemList(){
      $.get('<?php echo '/inventory/itemname/itemjsonlist'?>',function(result){
         html = '';
      APP.showLoading();
      
   if(result.length < 1){

               APP.hideLoading();
               bootbox.alert("No Data");
               $('#tblItemList').html('<tr style="margin-top:100px;"><td style="text-align:center;">0 Record Found.</td></tr>');
                return false;
       } 
        $.each(result,function(i,c){
         
          html+='<tr class="gradeA odd">';
          html+='<td class="  sorting_1">'+i+'</td>';
          html+='<td class=" ">'+c.item_name+'</td>';

          html+='<td class=" ">'+c.category+'</td>';
          html+='<td>'+c.status+'</td>';
         
        
          html+='<td class="all-icons">';
          html+='<div class="four-icons" style="padding-left:50px;">';
          html+='<a onclick="editItem(&apos;'+c.edit_url+'&apos;);" title="edit"><i class="icon-pencil"></i></a>';
          html+='<a onclick="deleteItem(&apos;'+c.delete_url+'&apos;);" type="select"><i class="icon-trash"></i></a>';
          html+='</div>';
                     
          html+='</td>';  
          html+='</tr>';
           APP.hideLoading();
        });
        $('#tblItemList tbody').html(html);
      });
      
   }
          </script>
@endSection
@include('includes.footer-scripts')  
 </body>
 </html>
