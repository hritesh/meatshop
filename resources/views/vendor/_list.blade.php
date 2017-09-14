@extends('layouts.master')
@section('form-content')
            <form id="frmAjaxSender">
        
            <div class="col-sm-12">
              
              <div class="col-sm-4 form-group">
                <label>Company Name</label>
                  <input type="text" name="name" id="name" required  placeholder="Enter company name" class="span12 m-wrap" >
              </div>

              <div class="col-sm-4 form-group">
                <label>Address </label>
                  <input type="text" name="address" id="address" required placeholder="Enter address" class="span12 m-wrap" required>
              </div>

               <div class="col-sm-4 form-group">
                <label >Email </label>
                  <input type="email" name="email"  id="email" placeholder="Enter email" class="span12 m-wrap" required>
                </div>
            </div>
            <div class="col-sm-12">
              <div class="col-sm-4 form-group">
              <label>Contact Name </label>
              
                <input type="text" name="p_name" id="p_name" required  placeholder="Enter contact person name" class="span12 m-wrap" >
              </div>
              

              <div class="col-sm-4 form-group">
                  <label >Contact No </label>
                  <input type="text" name="contact"  id="contact" placeholder="Enter phone no" class="span12 m-wrap" required>
              </div>

              <div class="col-sm-4 form-group">
                <label >Phone No </label>
                  <input type="text" name="phone" id="phone"  placeholder="Enter contact person phone" class="span12 m-wrap" required>
              </div>
            </div>
            <div class="col-sm-12 form-group">
                        <input type="hidden" id="hdnActionType" value="add">
                        <button class="btn btn-success" type="button" onclick="saveVendor($('#hdnActionType').val())" style="margin: 0px !important;">Save</button>
                        </div>

                     </form>
@stop
@section('table-content')

                                <table id="tblVendorList" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Company Name</th>
                                            <th>Company Address</th>
                                            <th>Email</th>
                                              <th>Contact No</th>
                                                <th>Contact Person Name</th>
                                                  <th>Phone No</th>
                                                    <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
                                      
                                      <a onclick="editVendor('<?php echo '/inventory/vendor/edit/'.$vendor->vendor_id?>');">Edit</a>
                                    <a type="select"   onclick="deleteVendor('<?php echo '/inventory/vendor/delete/'.$vendor->vendor_id?>');"  title="delete">
                                            Delete
                                          </a>
                                   </td> 
                  
                </tr>
               
           <?php $i++;} ?>
                                    </tbody>
                                </table>
                            
            <script type="text/javascript">
        $(document).ready(function(){
            $('#tblVendorList').DataTable({
                responsive: true
            });
        });
            
</script>

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
                  url = "<?php echo '/inventory/vendor/save';?>";
              }else{
                  url = "<?php echo '/inventory/vendor/update';?>";
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
   
      $.get('<?php echo '/inventory/vendor/vendorlistjson';?>',function(result){
       
          html = '';
      APP.showLoading();

        if(result.length < 1){

               APP.hideLoading();
               bootbox.alert("No Data");
               $('#tblVendorList').html('<tr style="margin-top:100px;"><td style="text-align:center;">0 Record Found.</td></tr>');
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
          html+='<a onclick="editVendor(&apos;'+c.edit_url+'&apos;);" title="edit">Edit</a>';
          html+='<a onclick="deleteVendor(&apos;'+c.delete_url+'&apos;);" type="select">Delete</a>';
          html+='</div>';
                     
          html+='</td>';  
          html+='</tr>';
           APP.hideLoading();
        });
        $('#tblVendorList tbody').html(html);
      });
      
   }
          </script>

  
   

@endSection

 