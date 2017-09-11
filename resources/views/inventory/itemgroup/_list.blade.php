@extends('layouts.master')
@section('content')
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Inventory-ItemGroup</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form id="frmAjaxSender"  class="form-horizontal" >
                    {{csrf_field()}}
                        <div class="span12">
                          <div class="span3">
                            <label class="span4">Category </label>
                            <div class="span8">
                              <input type="text" name="category" id="category" required  placeholder="Enter item category" class="span12 m-wrap" value="" style="padding-left: 1px !important;">
                            </div>
                          </div>

                          <div class="span3">
                              <label class="span3">Status </label>
                              <div class="span2">
                                <input type="checkbox" name="status"  class="span12 m-wrap" id="status" style="margin-top: 0px !important">
                              </div>
                            </div>

                            <div class="span3">
                        <input type="hidden" id="hdnActionType" value="add">
                        <button class="btn btn-success" type="button" onclick="saveItem($('#hdnActionType').val())" style="margin: 0px !important;">Save</button>
                        </div>
                        </div>
                     </form>        
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Kitchen Sink
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="tblItemList" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php $i=1; foreach($itemgroup_data as $item){ ?>

                                <tr <?php if($i%2==0){ ?> class="gradeA odd" <?php }else{ ?> class="gradeA even" <?php } ?>>
                                  <td class="  sorting_1"><?php echo $i ?></td>
                                  <td class=" ">{{$item->category}} </td>
                                  <td>{{$item->status}}</td>
                                 
                                  
                                  <td class="all-icons">
                                      <a onclick="editItem('<?php echo '/inventory/itemgroup/edit/'.$item->item_group_id?>');">Edit</a>
                                    <a type="select"   onclick="deleteItem('<?php echo '/inventory/itemgroup/delete/'.$item->item_group_id?>');"  title="delete">
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
            function editItem(url){
                $.get(url,function(result){
                    $('#hdnActionType').val(result[0].item_group_id);
                    $('#category').val(result[0].category);
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
                  url = "<?php echo '/inventory/itemgroup/save';?>";
              }else{
                  url = "<?php echo '/inventory/itemgroup/update'; ?>";
              }
            if ($('#status').is(":checked"))
             {
            $('#status').val('1');
              }
              else{
                $('#status').val('');
              }
              data = {
                item_group_id : $('#hdnActionType').val(),
                category : $('#category').val(),
                status : $('#status').val(),
            
              }
              $.post(url,data,function(result){
                  if(result=="1"){
                    $('#category').val('');
                    $('#status').attr('checked',false);
                     $('#hdnActionType').val('add');
                    bootbox.alert("Sucessfully Saved");
                    loadItemList();
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
      $.get('<?php echo '/inventory/itemgroup/itemgroupjsonlist';?>',function(result){
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
