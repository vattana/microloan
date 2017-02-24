///////////////// number only /////////////////////////////
	function handleEnter (field, event) {
		var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
		if (keyCode == 13) {
			var i;
			for (i = 0; i < field.form.elements.length; i++)
				if (field == field.form.elements[i])
					break;
			i = (i + 1) % field.form.elements.length;
			field.form.elements[i].focus();
			return false;
		} 
		else
		return true;
	}      
/////////////////////// format date dd/mm/yyyy ///////////////////////

		var monthNames = ['01','02','03','04','05','06','07','08','09','10','11','12'];
			
			function doDate( el, erID )
			{
			var s = el.value;
			var d, m, y;
			var erString = '<font color=red> => success </font>';
			var len = s.length;
			if (10 == len){
			d = s.substring(0,2);
			m = s.substring(3,5);
			y = s.substring(6,10);
			} else if (8 == len) {
			d = s.substring(0,2);
			m = s.substring(2,4);
			y = s.substring(4,8);
			} else if (6 == len) {
			d = s.substring(0,2);
			m = s.substring(2,4);
			y = '20' + s.substring(4,6);
			}
			if (checkDate(y,m,d)){
			el.value =d+'-'+monthNames[m-1]+'-'+y;
			erString = '';
			}
			if (document.getElementById){
			document.getElementById(erID).innerHTML = erString;
			}
			if (erString){
			if (el.focus) el.focus();
			}
			}
			
			function checkDate(y, m, d)
			{
			m = '' + (m-1);
			var checkDate = new Date(y,m,d);
			return ( checkDate.getMonth() == m
			&& checkDate.getFullYear() == y);
			}
/////////////////////// format date yyyy/mm/dd ///////////////////////

		var monthNames = ['01','02','03','04','05','06','07','08','09','10','11','12'];
			
			function doDate1( el, erID )
			{
			var s = el.value;
			var d, m, y;
			var erString = '<font color=red> => success </font>';
			var len = s.length;
			if (10 == len){
			d = s.substring(0,2);
			m = s.substring(3,5);
			y = s.substring(6,10);
			} else if (8 == len) {
			d = s.substring(0,2);
			m = s.substring(2,4);
			y = s.substring(4,8);
			} else if (6 == len) {
			d = s.substring(0,2);
			m = s.substring(2,4);
			y = '20' + s.substring(4,6);
			}
			if (checkDate(y,m,d)){
			el.value =y+'-'+monthNames[m-1]+'-'+d;
			erString = '';
			}
			if (document.getElementById){
			document.getElementById(erID).innerHTML = erString;
			}
			if (erString){
			if (el.focus) el.focus();
			}
			}
			
			function checkDate(y, m, d)
			{
			m = '' + (m-1);
			var checkDate = new Date(y,m,d);
			return ( checkDate.getMonth() == m
			&& checkDate.getFullYear() == y);
			}
//////////////////////////////////////////////
			function stopRKey(evt) {
				  var evt = (evt) ? evt : ((event) ? event : null);
				  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
				  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
			}
			document.onkeypress = stopRKey;
//////////////////////////////////////////////
			function isNumberKey(evt)
				  {
					 var charCode = (evt.which) ? evt.which : event.keyCode
						
					 if (charCode > 31 && (charCode < 48 || charCode > 57))
						return false;
			
				 
					
					 return true;
				  }
/////////////////////////////
 function ChangeCase(elem)
    {
        elem.value = elem.value.toUpperCase();
    }
/////////
function formatCurrency(num) {
			num = num.toString();
			if(isNaN(num))
			num = "0";
			sign = (num == (num = Math.abs(num)));
			num = Math.floor(num*100+0.50000000001);
			cents = num%100;
			num = Math.floor(num/100).toString();
			if(cents<10)
			cents = "0" + cents;
			for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
			num = num.substring(0,num.length-(4*i+3))+','+ num.substring(num.length-(4*i+3));
		return (((sign)?'':'-') + '' + num + '.' + cents);
		}
///////////////
