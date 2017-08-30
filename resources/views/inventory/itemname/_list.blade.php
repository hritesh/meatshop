@extends('layouts.master')
@section('content')

  <div class="row-fluid">
    <div class="span12">
      <div class="widget-box">
         <?php if(Session::has('nonempty')){ ?>
            <div class="alert alert-danger"><?php echo Session::get('nonempty'); ?> </div>
    <?php     } ?>
          <div class="widget-title widget-form-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Item Group List</h5>
          
          </div>
          <div class="widget-content">


          <form id="frmAjaxSender"  class="form-horizontal" >

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
                  url = "<?php echo __setLink('inventory/itemgroup/save');?>";
              }else{
                  url = "<?php echo __setLink('inventory/itemgroup/update');?>";
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
                    loadItemList();
                
                    $('#category').val('');
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
      $.get('<?php echo __setLink('inventory/itemgroup/itemgroupjsonlist');?>',function(result){
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

            <div id="tblItemList" class="dataTables_wrapper" role="grid">
            <table class="table table-bordered data-table dataTable" id="DataTables_Table_0">
              <thead>
                <tr role="row">
                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 25px;"><div class="DataTables_sort_wrapper">S.N.<span class="DataTables_sort_icon css_right ui-icon ui-icon-triangle-1-n"></span></div></th>
                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 329px;"><div class="DataTables_sort_wrapper">
                Category
                <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
               
                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 30px;"><div class="DataTables_sort_wrapper">Status <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>

              

                <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 173px;"><div class="DataTables_sort_wrapper">Action<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                </tr>
              </thead>
              
            <tbody role="alert" aria-live="polite" aria-relevant="all">
            <?php $i=1; foreach($itemgroup_data as $item){ ?>

            	<tr <?php if($i%2==0){ ?> class="gradeA odd" <?php }else{ ?> class="gradeA even" <?php } ?>>
                  <td class="  sorting_1"><?php echo $i ?></td>
                  <td class=" ">{{$item->category}} </td>
                  <td>{{$item->status}}</td>
                 
                  
                  <td class="all-icons">
                      <a onclick="editItem('<?php echo __setLink('/inventory/itemgroup/edit',array('id'=>$item->item_group_id)); ?>');"><i class="icon-pencil"></i></a>
                    <a type="select"   onclick="deleteItem('<?php echo __setLink('inventory/itemgroup/delete',array('id'=>$item->item_group_id));?>');"  title="delete">
                            <i class="icon-trash"></i>
                          </a>
                   </td> 
                  
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

function showConfirm(id){
  bootbox.confirm({
    message: "Are you sure you want to delete?",
    buttons: {
        confirm: {
            label: 'Yes',
            className: 'btn-success'
        },
        cancel: {
            label: 'No',
            className: 'btn-danger'
        }
    },
    callback: function(result){ /* result is a boolean; true = OK, false = Cancel*/
          if(result){
            $.get('/inventory/itemgroup/delete/'+id+'?token='+'<?php echo getToken();?>',function(){
              location.reload(true);
            })
          }
    }

});
}

</script>


@endSection