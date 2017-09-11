@extends('layouts.master')
@section('content')

  <div class="row-fluid">
    <div class="span12">
      <div class="widget-box">
           <?php if(Session::has('nonempty')){ ?>
            <div class="alert alert-danger"><?php echo Session::get('nonempty'); ?> </div>
    <?php     } ?>
          <div class="widget-title widget-form-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Vendor List</h5>
          
          </div>
          <div class="widget-content">
            <form id="frmAjaxSender">
        
            <div class="span12">
              
              <div class="span4">
                <label class="span4">Company Name</label>
                <div class="span8">
                  <input type="text" name="name" id="name" required  placeholder="Enter company name" class="span12 m-wrap" >
                </div>
              </div>

              <div class="span4">
                <label class="span4">Address </label>
                <div class="span8">
                  <input type="text" name="address" id="address" required placeholder="Enter address" class="span12 m-wrap" required>
                </div>
              </div>

               <div class="span4">
                <label class="span4">Email </label>
                <div class="span8">
                  <input type="email" name="email"  id="email" placeholder="Enter email" class="span12 m-wrap" required>
                </div>
              </div>

              
              </div>

              

             <div class="span12">

                <div class="span4">
                <label class="span4">Contact Name </label>
                <div class="span8">
                  <input type="text" name="p_name" id="p_name" required  placeholder="Enter contact person name" class="span12 m-wrap" >
                </div>
              </div>

              <div class="span4">
                  <label class="span4">Contact No </label>
                <div class="span8">
                  <input type="text" name="contact"  id="contact" placeholder="Enter phone no" class="span12 m-wrap" required>
                </div>
              </div>

              <div class="span4">
                <label class="span4">Phone No </label>
                <div class="span8">
                  <input type="text" name="phone" id="phone"  placeholder="Enter contact person phone" class="span12 m-wrap" required>
                </div>
              </div>

            </div>
          
              
              <div class="span12" style="margin-bottom: 10px;">
            <input type="hidden" id="hdnActionType" value="add">
            <button class="btn btn-success" type="button" onclick="saveVendor($('#hdnActionType').val())"><i class="icon-save" style="padding-right: 5px;"></i>Save</button>
            </div>
            
         </form>
 <script>
            function editVendor(url){
                $.get(url,function(result){
                    $('#hdnActionType').val(result[0].vendor_id);
                    $('#name').val(result[0].name);
                     $('#address').val(result[0].address);
                      $('#email').val(result[0].email);
                         $('#contact').val(result[0].contact);
                        $('#p_name').val(result[0].p_name); 
                         $('#phone').val(result[0].phone);
                   
                  
                });
            }

           
            function saveVendor(actionType){
              isvalidated = $('#frmAjaxSender')[0].checkValidity();
              if(isvalidated==false){
                $('#frmAjaxSender')[0].reportValidity();
                return false;
              }
              url = "";
              if(actionType=="add"){
                  url = "<?php echo __setLink('inventory/vendor/save');?>";
              }else{
                  url = "<?php echo __setLink('inventory/vendor/update');?>";
              }
            
              data = {
                vendor_id : $('#hdnActionType').val(),
                name : $('#name').val(),
                 address : $('#address').val(),
                  email : $('#email').val(),
                   contact : $('#contact').val(),
                    p_name : $('#p_name').val(),
                     phone : $('#phone').val(),
               
            
              }
              $.post(url,data,function(result){
                  if(result=="1"){
                    loadVendorList();
                     $('#name').val('');
                      $('#address').val('');
                       $('#email').val('');
                       $('#contact').val('');
                       $('#p_name').val('');
                         $('#phone').val('');
                    $('#hdnActionType').val('add');
                    bootbox.alert("Sucessfully Saved");
                  }else{
                    bootbox.alert('Sorry, Data not saved, try again.');
                  }

              })
            }
                  function deleteVendor(url){
                bootbox.confirm("Are you sure you want to delete?",function(result){
                  if(result){
                    $.get(url,function(result){
                       if(result=="1"){
                        loadVendorList();
                      }else{
                        bootbox.alert('Sorry, Data not saved, try again.');
                      }
                    }); 
                  
                }

             
           });
              }

     function loadVendorList(){
   
      $.get('<?php echo __setLink('inventory/vendor/vendorlistjson');?>',function(result){
       
          html = '';
      APP.showLoading();

        if(result.length < 1){

               APP.hideLoading();
               bootbox.alert("No Data");
               $('#tblDivisionList').html('<tr style="margin-top:100px;"><td style="text-align:center;">0 Record Found.</td></tr>');
                return false;
       }  
        $.each(result,function(i,c){
           
          html+='<tr class="gradeA odd">';
          html+='<td class="  sorting_1">'+i+'</td>';
          html+='<td class=" ">'+c.name+'</td>';
           html+='<td class=" ">'+c.address+'</td>';
            html+='<td class=" ">'+c.email+'</td>';
             html+='<td class=" ">'+c.contact+'</td>';
             html+='<td class=" ">'+c.p_name+'</td>';
              html+='<td class=" ">'+c.phone+'</td>';
       
        
          html+='<td class="all-icons">';
          html+='<div class="four-icons" style="padding-left:50px;">';
          html+='<a onclick="editVendor(&apos;'+c.edit_url+'&apos;);" title="edit"><i class="icon-pencil"></i></a>';
          html+='<a onclick="deleteVendor(&apos;'+c.delete_url+'&apos;);" type="select"><i class="icon-trash"></i></a>';
          html+='</div>';
                     
          html+='</td>';  
          html+='</tr>';
           APP.hideLoading();
        });
        $('#tblVendorList tbody').html(html);
      });
      
   }
          </script>


            <div id="tblVendorList" class="dataTables_wrapper" role="grid">
            <table class="table table-bordered data-table dataTable" id="DataTables_Table_0">
              <thead>
                <tr role="row">
                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 25px;"><div class="DataTables_sort_wrapper">S.N.<span class="DataTables_sort_icon css_right ui-icon ui-icon-triangle-1-n"></span></div></th>
                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 329px;"><div class="DataTables_sort_wrapper">
                Company Name
                <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
               
                

                 <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 173px;"><div class="DataTables_sort_wrapper">Company Address <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>

                     <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 173px;"><div class="DataTables_sort_wrapper">Email <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>

                         <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 173px;"><div class="DataTables_sort_wrapper">Contact no <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>

                         <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 173px;"><div class="DataTables_sort_wrapper">Contact Person Name <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                         <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 90px;"><div class="DataTables_sort_wrapper">Phone No.<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                         


                <span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                <th class="ui-state-default" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine : activate to sort column ascending" style="width: 173px;"><div class="DataTables_sort_wrapper">Action<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                </tr>
              </thead>
              
            <tbody role="alert" aria-live="polite" aria-relevant="all">
            <?php $i=1; foreach($vendor_data as $vendor){ ?>

            	<tr <?php if($i%2==0){ ?> class="gradeA odd" <?php }else{ ?> class="gradeA even" <?php } ?>>
                  <td class="  sorting_1"><?php echo $i ?></td>
                  <td class=" ">{{$vendor->name}} </td>
                  <!--<td class=" ">{{$vendor->item_group_id}} </td>-->
                  <td>{{$vendor->address}}</td>
                  <td>{{$vendor->email}}</td>
                  <td>{{$vendor->contact}}</td>
                  <td>{{$vendor->p_name}}</td>
                  <td>{{$vendor->phone}}</td>
                 
                  
                  <td class="all-icons">
                
                        <a onclick="editVendor('<?php echo __setLink('/inventory/vendor/edit',array('id'=>$vendor->vendor_id))?>');"><i class="icon-pencil"></i></a> 
                    <a type="select"   onclick="deleteVendor('<?php echo __setLink('inventory/vendor/delete',array('id'=>$vendor->vendor_id));?>');"  title="delete">
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

@endSection