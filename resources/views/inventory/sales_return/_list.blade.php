 @extends('layouts.master')
@section('content')
  <div class="row-fluid">
    <div class="span12">
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
			     
          
			   
            
              <div class="span4">
                <label class="span2">Item </label>
                <div class="span6">
                  <select name="teacher_id" id="ddlItem">
                    <option value="">--Select Item--</option>
                   <?php   foreach($sold_data as $sales){ ?>
                      <option value="{{$sales->item_name_id}}-{{$sales->sales_id}}">{{$sales->item_name}}</option>
                   <?php } ?>
                  </select>
                  
                </div>
              </div>
            

            <div class="span4">
                <label class="span2">Month </label>
                <div class="span6">
                   <select id="ddlMonth" onchange="loadGradeList();">
                     <option>--Select Month--</option>
                     @foreach(getMonthArray() as $key=>$val)
                      <option value="{{$key}}">{{$val}}</option>
                     @endforeach
                   </select>
                </div>
              </div>
            
            
                  
           
            
            
            <div style="clear:both"></div>
      	</div>
        </div>

            <table id="tblSoldDataList" class="table table-bordered table-striped filter-results">
              <tr>
                <td style="text-align:center;">0 Record Found.</td>
              </tr>
            </table>
            <div id="btnSaveAll" style="display:none;">
                <button style="margin-bottom:20px;" class="btn btn-success pull-right" type="button" onclick="assignGrade();">Save All</button>
            </div>

      </div>
    </div>
  </div>
  <script type="text/javascript">
  function assignGrade(){
    APP.showLoading();
      salesArray = {};
      $.each($('#tblSoldDataList tr'),function(i,c){
            if(i!=0){
            sales_id = $(c).find('.sales').val();
            returned = $(c).find('.returned').val();
            price = $(c).find('.price').val();
            narration = $(c).find('.narration').val();
             vendor_id=$(c).find('.txtVendor').val();

            salesArray[sales_id] = [returned,price,narration,vendor_id];
          }
            /*
            data={};
            data.sales_id = [n,$(b).find('.sales').val()];
            data.quantity = [n,$(b).find('.quantity').val()];
            data.narration = [n,$(b).find('.narration').val()];
            salesArray.push(data);
            */
         
      });

     
      data = {
         item_id:$('#ddlItem').val(),
         month : $('#ddlMonth').val(),
        salesArray:salesArray
      }
      $.post('/inventory/sales/return/save?token=<?php echo getToken();?>',data,function(result){
        APP.hideLoading();
          bootbox.alert('Successfully Saved.');
      });
  }



  function loadGradeList(){
    APP.showLoading();
    item_id = $('#ddlItem').val();
    month = $('#ddlMonth').val();
    
      
    $.get("/inventory/sales/return/filter/"+item_id+"/"+month+"?token=<?php echo getToken();?>",function(result){
        html = "";

        data = $.parseJSON(result);
        if(data.sales_data.length==0){
          APP.hideLoading();
          bootbox.alert('Sales Record Not Found');
          $('#tblSoldDataList').html('<tr><td style="text-align:center;">0 Record Found.</td></tr>');
          return false;
        }
        html+='<tr>';
        html+='<td class="filter-table" style="text-align:center;"><b>Vendor</td>';
        html+='<td class="filter-table" style="text-align:center;"><b>Sold To</td>';
        html+='<td class="filter-table" style="text-align:center;"><b>Rate</td>';
        html+='<td class="filter-table" style="text-align:center;"><b>Quantity Sold</td>';
         html+='<td class="filter-table" style="text-align:center;"><b>Quantity Returned</td>';
         html+='<td class="filter-table" style="text-align:center;"><b>Returned Price</td>';
         html+='<td class="filter-table" style="text-align:center;"><b>Narration</td>';
       
        html+='</tr>';

        $.each(data.sales_data,function(i,c){
              html+='<tr>';
                html+='<td style="text-align:center;">'+c.vendor_name+'</td>';
              html+='<td style="text-align:center;">'+c.student_name+'</td>';
              html+='<td style="text-align:center;">'+c.rate+'</td>';
              html+='<td style="text-align:center;">'+c.quantity+'</td>';
                 // remark = (c.diary_records[c.teacher_id])?c.diary_records[c.teacher_id][0]:'';
                  html+='<input type="hidden" class="txtVendor" value="'+c.vendor_id+'"/>';
                    quantity = (c.returned_data[c.sales_id])?c.returned_data[c.sales_id][0]:0;
                     price = (c.returned_data[c.sales_id])?c.returned_data[c.sales_id][1]:0;
                    narration = (c.returned_data[c.sales_id])?c.returned_data[c.sales_id][2]:'-';
                   html+='<td><input type="hidden" class="sales" value="'+c.sales_id+'-'+c.quantity+'-'+c.student_id+'-'+c.rate+'">';
                    html+='<input  type="text" onkeypress="return event.charCode >= 48 && event.charCode<= 57"  class="returned" value="'+quantity+'" />';
                    html+='</td>';
                    html+='<td>';
                    html+='<input  type="text" onkeypress="return event.charCode >= 48 && event.charCode<= 57"  class="price" value="'+price+'" />';
                    html+='</td>';
                    html+='<td>';
                    html+='<input  type="text"  class="narration" value="'+narration+'" />';
                    html+='</td>';
                   
                  
              html+='</tr>';
        });
       
        $('#tblSoldDataList').html(html);
        $('#btnSaveAll').show();
        APP.hideLoading();
    });
  }
  </script>






@endSection