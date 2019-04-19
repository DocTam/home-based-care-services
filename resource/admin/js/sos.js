
var sosmp3file = null;
function playSosAudio(){
      var borswer = window.navigator.userAgent.toLowerCase();
	  if(!sosmp3file){
		sosmp3file = $("#sosmp3file").attr("data");
	  }
      if ( borswer.indexOf( "ie" ) >= 0 ){
        //浏览器不支持 audion，则使用 embed 播放
		var embed = document.getElementById( "MPlayer_embed" );
		embed.src = sosmp3file;
        embed.volume = 80;
        embed.play();
      } else{
        //非IE内核浏览器
        var audio = document.getElementById( "MPlayer_audio" );
		audio.src = sosmp3file;
		audio.loop = false;
        audio.play();
      }
}


//有新数据
function donewdata(data){
	playSosAudio(); //播放声音

	//如果是列表页面,则插入html
	if(typeof sospage === 'undefined' || !sospage){
		return;
	}
	var html = '';

	var lastid = 0;
	for(var idx in data){
		var one = '';
		if(sospage == 'map'){//地图页面
			var name = data[idx]["name"];
			var mobile = data[idx]["mobile"];
			var address = data[idx]["address"];
			var lon = data[idx]["lon"];
			var lat = data[idx]["lat"];

			lastid = data[idx]["data_id"];

			one += '<td>' + name + '</td>';
			one += '<td>' + mobile + '</td>';
			one += '<td>' + data[idx]["time_begin"] + '</td>';
			one += '<td><a href="admin.php?c=sos&a=sosinfo&id='+lastid+'">' + data[idx]["status"] + '</a></td>';
			one += '<td><input type="button" value="查看" onclick="showmap('+lastid+');" /></td>';

			html += '<tr align="center" style="color:red;">' +one+ '</tr>';

			member_sos[lastid] = {
				content: name + "," + mobile + "," + address, 
				point:{lon: lon, lat: lat}
			};
			

		} else {
			for(var j in data[idx]){
				one += '<td>' + data[idx][j] + '</td>';
			}
			one += '<td><a href="admin.php?c=sos&a=sosinfo&id='+data[idx]["data_id"]+'" class="tablelink">查看</a></td>';

			html += '<tr style="color:red;">' +one+ '</tr>';
		}
	}
	$("#td_showContent").prepend(html);
	if(lastid>0){
		showmap(lastid);
	}
}


//检查是否有新的数据
function checkSos(){
	var data = {max_record_id: max_record_id};
	jQuery.ajax({
			type: 'post',
			url: 'admin.php?c=sos&a=checkSos',
			data: data,
			dataType: 'json',
			cache: false,
			success: function(res){
				if(typeof res == 'string'){
					res = JSON.parse(res);
				}
				if(res.Success && res.Data && res.Data.length > 0){
					max_record_id = res.max_record_id;
					donewdata(res.Data);
				}
			}
	});
}
