
function pr(str){
	console.log(str);
}


$(document).keypress(function(e) {
   if (e.which == 13) {
       $("#submit_btn").click();
   }
   $("form[name=form1]").submit(function(){
	   //$("#submit_btn").click();
		return false;
   });
});

//二级联动
//数据格式: {1:{id,name,data:[{id,name},{id,name} ...] ... }}
function setOne(oneobj, twoobj){

	oneobj.empty();
	var option = $("<option>").val("0").text("请选择");
	oneobj.append(option);

	for(var i in one_two_datas ){
		option = $("<option>").val(i).text(one_two_datas[i].name);
		oneobj.append(option);
	}

	if(typeof now_one_id != 'undefined' && now_one_id > 0){
		console.log(now_one_id);
		oneobj.val(now_one_id);
		oneChange(oneobj, twoobj);
	} else {
		oneobj.val("0");
	}
}

//类型改变
function oneChange(oneobj, twoobj){
	var nowId = oneobj.val();
	if(one_two_datas[nowId]){
		var arr = one_two_datas[nowId]['data'];
 		twoobj.empty();

		var option = $("<option>").val("0").text("请选择");
		twoobj.append(option);

		if(arr){
			for(var i=0; i<arr.length; i++){
				option = $("<option>").val(arr[i].id).text(arr[i].name);
				if(arr[i].data){
					option.attr('data', arr[i].data);
				}
				twoobj.append(option);
			}

			if(typeof now_two_id != 'undefined' && now_two_id > 0){
				twoobj.val(now_two_id);
			} else {
				twoobj.val("0");
			}
		}
	}
	
}
