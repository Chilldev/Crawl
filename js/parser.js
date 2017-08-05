$(document).ready(function(){
	var item;
	var xpath;
	var string;
	var elemParParentTagName='';
	var elemParParentAttrVal='';
	var elemParParentTagName='';
	var elemParParentAttrVal='';
	//var string;

	$(".wrap-sub-second").hide();
	$(".wrap-sub-first").show();


	$('.wrap-sub-second').hover(function(){
		
		$('a').attr('href', '#');

		$('a').click(function(event){
            event.preventDefault();
        });

	});

	$('#linksz,#sublistz,#urlsz,#pro_namesz,#imagesz,#pricez').dblclick(function(event){

		$('.wrap-sub-first').hide();
		$('.wrap-sub-second').show();
	 	item = $(event.target).text();
	});

	$('.sub-second').dblclick(function(event){

		elemTagName          = event.target.nodeName;
		elemAttrVal          = event.target.className;
		elemParentTagName    = $(event.target).parent().get( 0 ).nodeName;
		elemParentAttrVal    = $(event.target).parent().get( 0 ).className;
		
		if(elemParentAttrVal.length == 0 && elemAttrVal.length == 0){

			elemParParentTagName = $(event.target).parent().parent().get( 0 ).nodeName;
			elemParParentAttrVal = $(event.target).parent().parent().get( 0 ).className;
		}
		

		if(elemAttrVal.length == 0 ){
			elemAttrVal = '';
		}else{
			if(elemAttrVal.indexOf(' ') >= 0){
				elemAttrVal=elemAttrVal.split(' ');
				elemAttrVal=contains(elemAttrVal);
			}else{
				elemAttrVal = '[@class=\''+elemAttrVal+'\']';
			}
		}

		if(elemParentAttrVal.length == 0){
			elemParentAttrVal = '';
		}else{
			if(elemParentAttrVal.indexOf(' ') >= 0){
				elemParentAttrVal=elemParentAttrVal.split(' ');
				elemParentAttrVal=contains(elemParentAttrVal);
			}else{
				elemParentAttrVal = '[@class=\''+elemParentAttrVal+'\']';
			}
		}

		if(elemParParentAttrVal.length == 0){
			elemParParentAttrVal    = '';
		}else{
			if(elemParParentAttrVal.indexOf(' ') >= 0){
				elemParParentAttrVal=elemParParentAttrVal.split(' ');
				elemParParentAttrVal=contains(elemParParentAttrVal);
			}else{
				elemParParentAttrVal = '[@class=\''+elemParParentAttrVal+'\']/';
			}
		}

		if(elemParParentAttrVal.length == 0 && elemParParentTagName.length != 0 ){
			elemParParentAttrVal    = '/';
		}
		
		xpath = elemParParentTagName.toLowerCase()+elemParParentAttrVal+elemParentTagName.toLowerCase()+elemParentAttrVal+'/'+elemTagName.toLowerCase()+elemAttrVal;
		item = item.trim()
		if(item == 'Links'){
			xpath1 = '//'+xpath+'/text()';
			xpath  = '//'+xpath+'/@href';
			$('#Category').val(xpath1);
		}else if(item == 'Category'){
			xpath1 = '//'+xpath+'/@href';
			xpath  = '//'+xpath+'/text()';
			$('#Links').val(xpath1);
		}else if(item == 'ProURLs'){
			xpath = '//'+xpath+'/@href';
			//$('#proURLs').val(xpath);
		}else if(item == 'ProductName'){
			xpath = '//'+xpath+'/text()';
			//$('#ProductName').val(xpath);
		}else if(item == 'Image'){
			xpath = '//'+xpath+'/@src';
			//$('#Image').val(xpath);
		
		}else{
			xpath = '//'+xpath+'/text()';
			//$('#Price').val(xpath);
		}
		//console.log(item);
		$('#'+item).val(xpath);
		
		//alert('Please Copy This Path To The Form!\n\n'+xpath);
		
		$('.wrap-sub-second').hide();
		$('.wrap-sub-first').show();
	});

	function contains(multiple){
		var i;
		var y      = multiple.length;
		var string ='[';

		for(i=0; i < y; i++){

			if(multiple[i] == " "){
				continue;
			}
			
			if(y-i === 1){
				string += 'contains(@class,\''+multiple[i]+'\')]';
			}else{
				string += 'contains(@class,\''+multiple[i]+'\') and ';
			}
		}
		return string; 		
	}
});
