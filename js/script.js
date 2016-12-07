(function($){$(function(){

$.fn.try_add=function(arr){//функция проверки на пустые поля при нажатии кнопки
var butt=this;
	butt.click(function(){
		var f=true;
		for (var i = arr.length - 1; i >= 0; i--){
			test=$("#"+arr[i]);
			if (test.val().length>0) test.val(test.val().trim());
			if (test.val().trim().length<1 || test.val().trim()=="0"){
				test.css({"border":"1px red solid"})
				f=false;
			}
			else test.css({"border":"1px #ccc solid"});
		}
	if (f==true) return true;
	return false;
	});
}

//вкладка категорий
//$('#add_cat').try_add(['input_cat']);
//$('#add_sub').try_add(['input_sub','sel_cat1']);
//вкладка товара
//$('#add_item').try_add(['itemname','pricein','pricesale','info','sel_cat2','subid','itempic']);
//вкладка картинки
//$('#addpics').try_add(['sel_cat3','subid2','itemlist','files']);
//регистрация
//$('#adduser').try_add(['pass1','pass2','login','file_pic']);
//$('#enter').try_add(['login0','pass0']);

sort('mtxt','f',(document.getElementById('user_name').innerHTML));
show_mes(35);

})})(jQuery)