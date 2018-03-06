		$(document).ready(function(){
			
       var li=links();
              
		$('body').on('change','#photoimg', function(){ 
		
	
			
		
			           $("#preview").html('');
				

   var stuff="<img id='img' src='"+li+"img/loader.gif' alt='Uploading....'>";

	document.getElementById("preview").innerHTML=stuff;			
					  
				
			$("#imageform").ajaxForm({
						target: '#preview'
		}).submit();
		
			});	
			
			
			
			

			
			
			
		});
		
	function process_p(){
	
	var li=links();
	
	
	
	var id=$("#submit_p").val();
	var sell=$("#sell").val();
	var cost=$("#cost").val();
	var buy=$("#buy").val();
	var carton=$("#carton").val();
	var opening=$("#open").val();
	var sort=$("#sorting").val();
	var unit=$("#unit").val();
	var category=$("#category").val();
	var ware=$("#ware").val();
	var pname=$("#pname").val();
	var pcode=$("#pcode").val();
	var ptype=$("#price_type").val();
	
	
	
   var test = $("#img").attr('src').split('\/');
    
	var img=test[test.length-1];
	
	if(img == 'loader.gif')
		img="";



	
	if(sell == '' || buy == '' || opening == '' || pname == '' || pcode == ''|| ware== '' || ptype == ''){
		
		alert('Information not complete');
		
	}
	else{
		
		
		
		
		$.ajax({
		type:'POST',
		dataType:'json',
		url:li+'product_con/create_product',
data:{id:id,sell:sell,cost:cost,buy:buy,opening:opening,sort:sort,unit:unit,category:category,ware:ware,pname:pname,pcode:pcode,carton:carton,ptype:ptype,img:img},
		success:function(data)
		{
		
			if(data.id == 1){
				
				alert('product code already created this ware house...');
			}
			else if(data.id == 2){
				
				alert('inserted');
				
			$("#sell").val('');
			$("#cost").val('');
			$("#buy").val('');
			$("#open").val('');
			$("#sorting").val('');
			$("#unit").val('');
			$("#category").val('');
			$("#ware").val('');
			$("#pname").val('');
			$("#pcode").val('');
				
			}
			
			

			
			
		
		},
		error:function(error)
		{
			alert("Server Error");
		}
		});
		
		
		
		
		
	}
	
	
}



$(".closes").click(function(){

 var li=links();

	$("#preview").html('');

 var stuff="<img style='display:none' id='img' src='"+li+"img/loader.gif' alt='Uploading....'>";

                 	document.getElementById("preview").innerHTML=stuff;

   			//$("#img").css({'display':'none'});

			

});






	
	
/*
$(".bhead button").click(function(){
	
	var code=$("#titles p").attr('data-id');
	var name=$("#titles p").attr('data-hveid');
	var cur=$(this).val();
	
	
	var start=$(".start").val();
	var end=$(".end").val();
	
	
	if(code == '' || name == '' || start == '' || end == ''){
		
		alert('check your informatin');
		
		
	}
	else{
		
		
		if(cur == 1)
		{
			
var win = window.open(li+"mains/product_ledger/"+code+"/"+start+"/"+end, '_blank');
	if(win){
    //Browser has allowed it to be opened
    win.focus();
}else{
    //Broswer has blocked it
    alert('Please allow popups for this site');
}		
		//window.location=li+"mains/product_ledger/"+code+"/"+start+"/"+end;		
			
			
		}
		
	
		else{
			
			
			
	var win = window.open(li+"mains/product_ledger_monthly/"+code+"/"+start+"/"+end, '_blank');		
			
			
			
			
			
			
		}
		
		
		
		
		
		
		
		
	}
	
	
	
	
});

	
		
	
	$("#phover a").click(function(){
		
		
		
		var data=$(this).attr('data-id');
		var name=$(this).attr('data-hveid');
		
	
	
	
			$(".notice").show();
	
	
	
	var stuff="<p data-id='"+data+"' data-hveid='"+name+"'>"+data+"</p>";
	
document.getElementById("titles").innerHTML=stuff;
	
		
		
		
	})
	
	
	$("#bhead button").val(data);
	
	
	
	
	
	 // .mouseout(function() {
		 
   
	// $(".notice").hide();
	
	
  // });
	
	
	 
	
	$(".closes").click(function(){

 $("#preview").html('');

 var stuff="<img src='"+li+"img/loader.gif' alt='Uploading....'>";

                 	document.getElementById("preview").innerHTML=stuff;

   			$("#img").css({'display':'none'});

});





function create_product(){
	
	
	
		$("#ltitle").empty();
		$("#lbody").hide();
		$("#pbody").show();
		$("#ltable").hide();
		$("#ptable").hide();
		$("#pbtn").hide();
		$("#pbtn_p").show();
		
		$("#ltitle").append("<h3 style='border-bottom:2px solid;padding-bottom:5px;padding-top:5px;background:black;color:white'>CREATE PRODUCT LEDGER</h3>");
	
	
}


function process_p(){
	
	var id=$("#submit_p").val();
	var sell=$("#sell").val();
	var cost=$("#cost").val();
	var buy=$("#buy").val();
	var carton=$("#carton").val();
	var opening=$("#open").val();
	var sort=$("#sorting").val();
	var unit=$("#unit").val();
	var category=$("#category").val();
	var ware=$("#ware").val();
	var pname=$("#pname").val();
	var pcode=$("#pcode").val();
	var ptype=$("#price_type").val();
	
	
	
   var test = $("#img").attr('src').split('\/');
    
	var img=test[test.length-1];
	
	if(img == 'loader.gif')
		img="";



	
	if(sell == '' || buy == '' || opening == '' || pname == '' || pcode == ''|| ware== '' || ptype == ''){
		
		alert('Information not complete');
		
	}
	else{
		
		
		
		
		$.ajax({
		type:'POST',
		dataType:'json',
		url:li+'admin/create_product',
data:{id:id,sell:sell,cost:cost,buy:buy,opening:opening,sort:sort,unit:unit,category:category,ware:ware,pname:pname,pcode:pcode,carton:carton,ptype:ptype,img:img},
		success:function(data)
		{
		
			if(data.id == 1){
				
				alert('product code already created this ware house...');
			}
			else if(data.id == 2){
				
				alert('inserted');
				
			$("#sell").val('');
			$("#cost").val('');
			$("#buy").val('');
			$("#open").val('');
			$("#sorting").val('');
			$("#unit").val('');
			$("#category").val('');
			$("#ware").val('');
			$("#pname").val('');
			$("#pcode").val('');
				
			}
			
			

			
			
		
		},
		error:function(error)
		{
			alert("Server Error");
		}
		});
		
		
		
		
		
	}
	
	
}*/