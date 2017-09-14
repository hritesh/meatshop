 @extends('layouts.master')
@section('form-content')
<form>
    <div class="col-sm-12">
      <div class="col-sm-4 form-group">
        <label>Item </label>
        <select name="teacher_id" id="ddlItem" >
          <option value="">--Select Item--</option>
         <?php   foreach($purchase_data as $item){ ?>
            <option value="{{$item->item_name_id}}-{{$item->purchase_id}}">{{$item->item_name}}</option>
         <?php } ?>
        </select>
      </div>
      <div class="col-sm-4 form-group">
        <label>Month </label>
        <select id="ddlMonth"  onchange="loadGradeList();">
           <option>--Select Month--</option>
           @foreach(getMonthArray() as $key=>$val)
            <option value="{{$key}}">{{$val}}</option>
           @endforeach
         </select>

      </div>
    </div>
  </form>
@stop

@section('table-content')
            <table id="tblStudentFeeList" class="table table-bordered table-striped filter-results">
              <tr>
                <td style="text-align:center;">0 Record Found.</td>
              </tr>
            </table>
            <div id="btnSaveAll" style="display:none;">
                <button style="margin-bottom:20px;" class="btn btn-success pull-right" type="button" onclick="assignGrade();">Save All</button>
            </div>


 
  <script type="text/javascript">
  function assignGrade(){
    APP.showLoading();
      purchase_array = {};
      $.each($('#tblStudentFeeList tr'),function(i,c){
        purchase_id=$(c).find('.txtPurchase').val();
         total_quantity_purchased=$(c).find('.txtTotalQuantity').val();
          quantity_returned=$(c).find('.txtReturnedQuantity').val();
          rate=$(c).find('.txtRate').val();
          total_price=$(c).find('.txtPrice').val();
          vendor_id=$(c).find('.txtVendor').val();
          narration=$(c).find('.txtNarration').val();

        if(i!=0 ){
          
          purchase_array[purchase_id] = [total_quantity_purchased,quantity_returned,rate,total_price,vendor_id,narration];
        }
      });

     
      data = {
         item_name_id:$('#ddlItem').val(),
          month : $('#ddlMonth').val(),
        purchaseArray:purchase_array
      }
      $.post('/inventory/purchase/return/save',data,function(result){
        APP.hideLoading();
          bootbox.alert('Successfully Saved.');
      });
  }



  function loadGradeList(){
    APP.showLoading();
    item_name_id = $('#ddlItem').val();
    month = $('#ddlMonth').val();
    
      
    $.get("/inventory/purchase/return/_list/"+item_name_id+"/"+month,function(result){
        html = "";

        data = $.parseJSON(result);
        if(data.purchase.length==0){
          APP.hideLoading();
          bootbox.alert('No Records Found!');
          $('#tblStudentFeeList').html('<tr><td style="text-align:center;">0 Record Found.</td></tr>');
          return false;
        }
        
        html+='<tr>';

        html+='<td class="filter-table" style="text-align:center;"><b>Rate</td>';
        html+='<td class="filter-table" style="text-align:center;"><b>Vendor</td>';
         html+='<td class="filter-table" style="text-align:center;"><b>Total Quantity Purchased</td>';

          html+='<td class="filter-table">';
          html+='<b>Quantity Returned </b>';
          html+='</td>';
            html+='<td class="filter-table" style="text-align:center;"><b>Total Price</td>';
              html+='<td class="filter-table" style="text-align:center;"><b>Narration</td>';
        html+='</tr>';

        $.each(data.purchase,function(i,c){
              html+='<tr>';
           html+='<input type="hidden" class="txtPurchase" value="'+c.purchase_id+'"/>';
            html+='<input type="hidden" class="txtRate" value="'+c.rate+'"/>';
             html+='<input type="hidden" class="txtVendor" value="'+c.vendor_id+'"/>';
              html+='<input type="hidden" class="txtTotalQuantity" value="'+c.quantity+'"/>';

              html+='<td style="text-align:center;">'+c.rate+'</td>';
              html+='<td style="text-align:center;">'+c.name+'</td>';
              html+='<td style="text-align:center;">'+c.quantity+'</td>';
                  quantity = (c.purchase_records[c.purchase_id])?c.purchase_records[c.purchase_id][0]:0;
                     total_price = (c.purchase_records[c.purchase_id])?c.purchase_records[c.purchase_id][1]:0;
                    narration = (c.purchase_records[c.purchase_id])?c.purchase_records[c.purchase_id][2]:'-';
                   html+='<td>';
                    html+='<input  type="text" style="width:50px;!important" class="txtReturnedQuantity" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  class="txtMark" value="'+quantity+'"/>';
                    html+='</td>';
                    html+='<td>';
                    html+='<input  type="text" style="width:50px;!important" class="txtPrice" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="txtMark" value="'+total_price+'"/>';
                    html+='</td>';
                    html+='<td>';
                    html+='<input  type="text"  class="txtNarration" value="'+narration+'"/>';
                    html+='</td>';
                    
                  
              html+='</tr>';
        });
       
        $('#tblStudentFeeList').html(html);
        $('#btnSaveAll').show();
        APP.hideLoading();
    });
  }


  function calculate(){
    var firstValue = parseFloat($('.txtReturnedQuantity').val()); 
    var secondValue = parseFloat($('.txtRate').val()); 
   var totalValue = firstValue * secondValue ;
   $('.txtPrice').val(totalValue);

}

  </script>






@endSection