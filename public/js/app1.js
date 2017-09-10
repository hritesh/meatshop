var APP = {
	confirm:function($message){
		return confirm($message);
	},
	confirmDelete:function(url){
		//return confirm('Are you sure to delete!');
		
		bootbox.confirm("Are you sure you want to delete?",function(result){
	          if(result){
	            $.get(url,function(){
	              location.reload(true);
	            });
	          }

		});
		return false;
		
	},
	showLoading:function(message,ctrl){
		if(ctrl){
			$(ctrl).append('<div class="loading-panel">'+message+'<img src="/template/img/loading.svg"/></div>');
		}else{
			$('body').append('<div class="loading-panel">'+message+'<img src="/template/img/loading.svg"/></div>');
		}
		
	},
	hideLoading:function(message,ctrl){
		if(ctrl){
			$(ctrl).find('.loading-panel').remove();
		}else{
			$('body').find('.loading-panel').remove();
		}
	},

	allowNumberOnly:function(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       },

       allowStringOnly:function(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode >= 65 && charCode <= 120 
            || (charCode == 32 || charCode == 46))
             return true;

          return false;
       },
};