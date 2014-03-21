function randomString(){
    var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZ";
    var string_length = 10;
    var result = "";

    for(var i=0; i<string_length; i++){
      var randomPos = Math.floor( Math.random() * chars.length );
      result += chars.substr(randomPos, 1);
    }   
    return result;
}

function addNewRow(targetDiv, controlName, index){ 
	//alert("hai");
   
    var randStr = randomString();
    $('#'+targetDiv).append("<tr id=\""+randStr+"\"><td  style=\"text-align:center; width:30%;\">"+controlName +' '+ index+"</td><td style=\"text-align:center; width:30%;\"><input type=\"text\" name=\""+controlName+"[]\"  style=\"margin-left:12px;\" /> <a href=\"javascript:void(0);\" title=\"Click here to remove\" onclick=\"removeRow('"+randStr+"');\"  style=\"font-size:24px;color: red; text-decoration:none;\">-</a></td></tr>");
  
} 
   
function removeRow(targetDiv){     
    var parentDiv = $('#'+targetDiv).parents('tbody:eq(0)').attr('id');      
    $('#'+targetDiv).remove();
    $('#'+parentDiv+' tr').each(function (i, row) {
         if(i){               
             ctrlText = $(row).find('td:eq(0)').html().split(" ");            
             txttemp = ctrlText[0] +' '+ i;
             $(row).find('td:eq(0)').html(txttemp);
         }                            
     });    
}

function addOtherRow(targetDiv, controlName1, controlName2){
    var randStr = randomString();
    $('#'+targetDiv).append("<tr id=\""+randStr+"\"><td style=\"background-color: #f6f6f6\"><input type=\"text\" name=\""+controlName1+"[]\" style=\"height:30px\"  placeholder=\"Customize\"/></td><td  style=\"background-color: #f6f6f6\"><input  type=\"text\"  name=\""+controlName2+"[]\" style=\"height:30px\"  /> <a href=\"javascript:void(0);\" title=\"Click here to remove\" onclick=\"removeOtherRow('"+randStr+"');\"><div style=\"color:red;padding:5px;width:85px;float:right;margin-right:150px;\">Remove field</div></a></td></tr>");
} 

function orderDynamicPackage(formId, priceSchemeId, value){       
    $("#"+priceSchemeId).val(value);   
    $("#"+formId).submit();
}




function addNewDiv(targetDiv, controlName){
    var randStr = randomString();
    $('#'+targetDiv).append("<div id=\""+randStr+"\"><input type=\"text\" name=\""+controlName+"[]\" maxlength=\"50\" style=\"height:10px\"/> <a href=\"javascript:void(0);\" title=\"Click here to remove\" onclick=\"removeRow('"+randStr+"');\"><div id=\""+randStr+"\"></a></div>");
} 
   
function removeDiv(targetDiv){
    $('#'+targetDiv).remove();
}

function addOtherDow(targetDiv, controlName1, controlName2){
    var randStr = randomString();
    $('#'+targetDiv).append("<div id=\""+randStr+"\"><input type=\"text\" name=\""+controlName1+"[]\" style=\"height:30px\"/><input  type=\"text\"  name=\""+controlName2+"[]\" maxlength=\"50\" style=\"height:30px\"  /> <a href=\"javascript:void(0);\" title=\"Click here to remove\" onclick=\"removeRow('"+randStr+"');\">-</a></div>");
} 


 function removeOtherRow(targetDiv){
   $('#'+targetDiv).remove();
}
