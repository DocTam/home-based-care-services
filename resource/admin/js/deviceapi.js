// JavaScript Document
var W_OK =  0;//检查成功
var W_TRY = 1;//试用
var W_NO_FOUND =2;//没有找到校验服务器
var W_EXCEED_NUM =3;//超过用户数了


function getEvent(parseEvent) {
//	if(g_msg) return;
	$.ajax({ 
		type: "post", 
		url: "http://127.0.0.1:3001/msg/", 
		dataType: "jsonp", 
		timeout: 30000,
		data: {"act": "get"},
		success: function (data,textStatus) { 
			// $("#StatusArea").append("--- " + data );
			if(textStatus == "success")
			{
				getEvent(parseEvent);		
			}
			if(data != null)
			{
			 	//AppendStatus(data+ "--\r\n");
				parseEvent(data.ch,data.e_type,data.e_handle,data.l_result,data.e_data);
			}
		}, 
		 complete:function(XMLHttpRequest,textStatus){  
					if(XMLHttpRequest.readyState=="4"){  
						//alert(XMLHttpRequest.responseText);  
					}  
			},  		
		error: function (XMLHttpRequest, textStatus, errorThrown) { 
			//$("#StatusArea").append("[state: " + textStatus + ", error: " + errorThrown + " ]<br/>");
			if (textStatus == "timeout") { // 请求超时
					  // 递归调用
					getEvent(parseEvent);
				// 其他错误，如网络错误等
				} else { 
					 getEvent(parseEvent);
				}
		} 
	});
	 //setTimeout(getEvent ,1000);
}

function sendCmd(cmd_name,paraObj,resultCallback)
{
	var nResult = -99;
	var bSync = false;
	$.ajax({ 
		type: "post", 
		url: "http://127.0.0.1:3001/cmd/", 
		dataType: "jsonp", 
		data: {"act": cmd_name,"para":JSON.stringify(paraObj)},
		async:false,
		success: function (data,textStatus) { 
			// $("#StatusArea").append("--- " + data );
			bSync = true;
			nResult = data.result;
			if(resultCallback!="" && resultCallback != null)
				resultCallback(nResult);
			return nResult;
		}, 
		 complete:function(XMLHttpRequest,textStatus){  
					if(XMLHttpRequest.readyState=="4"){  
						//alert(XMLHttpRequest.responseText);  
					}  
			},  		
		error: function (XMLHttpRequest, textStatus, errorThrown) { 
			alert("网络错误! " + textStatus + ", error: " + errorThrown );
			if (textStatus == "timeout") { // 请求超时
					//getEvent(); // 递归调用
				// 其他错误，如网络错误等
				} else { 
					//getEvent();
				}
			bSync = true;
		} 
	});	
//	Sleep(500);
 //	var timestamp=new Date().getTime();
 //	alert(timestamp+"---"+ nResult);
	return nResult;
}
//检查本地设备服务程序是否安装命令
function check_ver(iVer,nextFunc)
{
	var nResult = -99;
	var paraObj={};
	paraObj.a= iVer;
	$.ajax({ 
		type: "post", 
		url: "http://127.0.0.1:3001/cmd/", 
		dataType: "jsonp", 
		data: {"act": "check_ver","para":JSON.stringify(paraObj)},
		timeout: 1000,
		//async:false,
		success: function (data,textStatus) { 
			// $("#StatusArea").append("--- " + data );
			nResult = data.result;
			if(nextFunc!="" && nextFunc != null)
				nextFunc(nResult);
			return nResult;
		}, 
		 complete:function(XMLHttpRequest,textStatus){  
					if(XMLHttpRequest.readyState=="4"){  
						//alert(XMLHttpRequest.responseText);  
					}  
			},  		
		error: function (XMLHttpRequest, textStatus, errorThrown) { 
			//alert("没有安装! " + textStatus + ", error: " + errorThrown );
			nextFunc(nResult);
			if (textStatus == "timeout") { // 请求超时
					//getEvent(); // 递归调用
				// 其他错误，如网络错误等
				} else { 
					//getEvent();
				}
			return nResult;
		} 
	});	
	return nResult;	
}
function set_check_data_url(strUrl,nextFunc)
{
	var nResult = -99;
	var paraObj={};
	paraObj.a= strUrl;
	nResult = sendCmd("set_check_url",paraObj,nextFunc);
	return nResult;	
}
//最右边的是执行下一个函数的参数
//下一步函数格式为function nextFunc(nResult)内含上次函数执行后返回的结果
function OpenDevice(nDevice_type,nextFunc) {

	var nResult = -99;
	var paraObj={};
	paraObj.a=nDevice_type;
	paraObj.b = 0;
	nResult = sendCmd("QNV_OpenDevice",paraObj,nextFunc);
	return nResult;
}
function CloseDevice(nDevice_type,nextFunc) {
	var nResult = -99;
	var paraObj={};
	paraObj.a=nDevice_type;
	paraObj.b = 0;
	nResult = sendCmd("QNV_CloseDevice",paraObj,nextFunc);
	return nResult;	
}
function SetDevCtrl( nChannelID, uCtrlType, nValue,nextFunc)
{
	var nResult = -99;
	var paraObj = {};
	paraObj.a = nChannelID;
	paraObj.b = uCtrlType;
	paraObj.c = nValue;
	nResult = sendCmd("QNV_SetDevCtrl",paraObj,nextFunc);
	return nResult;		
}
function GetDevCtrl(nChannelID,uCtrlType,nextFunc)
{
	var nResult = -99;
	var paraObj = {};
	paraObj.a = nChannelID;
	paraObj.b = uCtrlType;
	nResult = sendCmd("QNV_GetDevCtrl",paraObj,nextFunc);
	return nResult;			
}
function SetParam(  nChannelID,  uParamType,  nValue,nextFunc)
{
	var nResult = -99;
	var paraObj = {};
	paraObj.a = nChannelID;
	paraObj.b = uParamType;
	paraObj.c = nValue;
	nResult = sendCmd("QNV_SetParam",paraObj,nextFunc);
	return nResult;		
}
function GetParam(  nChannelID,  uParamType,nextFunc )
{
	var nResult = -99;
	var paraObj = {};
	paraObj.a = nChannelID;
	paraObj.b = uParamType;
	nResult = sendCmd("QNV_GetParam",paraObj,nextFunc);
	return nResult;		
}
function PlayFile(  nChannelID,  uPlayType,  nValue,  nValueEx, pValue,nextFunc)
{
	var nResult = -99;
	var paraObj = {};
	paraObj.a = nChannelID;
	paraObj.b = uPlayType;
	paraObj.c = nValue;
	paraObj.d = nValueEx;
	paraObj.e = pValue;
	nResult = sendCmd("QNV_PlayFile",paraObj,nextFunc);
	return nResult;		
}
function PlayMultiFile(  nChannelID,  uPlayType,  nValue,  nValueEx, pValue,nextFunc)
{
	var nResult = -99;
	var paraObj = {};
	paraObj.a = nChannelID;
	paraObj.b = uPlayType;
	paraObj.c = nValue;
	paraObj.d = nValueEx;
	paraObj.e = pValue;
	nResult = sendCmd("QNV_PlayMultiFile",paraObj,nextFunc);
	return nResult;			
}
function PlayString(  nChannelID,  uPlayType,  nValue,  nValueEx, pValue,nextFunc)
{
	var nResult = -99;
	var paraObj = {};
	paraObj.a = nChannelID;
	paraObj.b = uPlayType;
	paraObj.c = nValue;
	paraObj.d = nValueEx;
	paraObj.e = pValue;
	nResult = sendCmd("QNV_PlayString",paraObj,nextFunc);
	return nResult;			
}
function RecordFile(  nChannelID,  uRecordType,  nValue,  nValueEx, pValue,nextFunc)
{
	var nResult = -99;
	var paraObj = {};
	paraObj.a = nChannelID;
	paraObj.b = uRecordType;
	paraObj.c = nValue;
	paraObj.d = nValueEx;
	paraObj.e = pValue;
	nResult = sendCmd("QNV_RecordFile",paraObj,nextFunc);
	return nResult;	
}
function Conference(  nChannelID,  nConfID,  uConfType,  nValue, pValue,nextFunc)
{
	var nResult = -99;
	var paraObj = {};
	paraObj.a = nChannelID;
	paraObj.b = nConfID;
	paraObj.c = uConfType;
	paraObj.d = nValue;
	paraObj.e = pValue;
	nResult = sendCmd("QNV_Conference",paraObj,nextFunc);
	return nResult;		
}
function General(  nChannelID,  uGeneralType,  nValue, pValue,nextFunc)
{
	var nResult = -99;
	var paraObj = {};
	paraObj.a = nChannelID;
	paraObj.b = uGeneralType;
	paraObj.c = nValue;
	paraObj.d = pValue;
	nResult = sendCmd("QNV_General",paraObj,nextFunc);
	return nResult;		
}
function DevInfo(  nChannelID,  uDevInfoType,nextFunc)
{
	var nResult = -99;
	var paraObj = {};
	paraObj.a = nChannelID;
	paraObj.b = uDevInfoType;
	nResult = sendCmd("QNV_DevInfo",paraObj,nextFunc);
	return nResult;			
}
//nextFunc参数是一个对象包含result和缓存
function  Storage(  nDevID,  uOPType,  uSeek, pPwd, pValue,nextFunc )
{
	var paraObj = {};
	paraObj.a = nDevID;
	paraObj.b = uOPType;
	paraObj.c = uSeek;
	paraObj.d = pPwd;
	paraObj.e = pValue;
	var objResult ={};
	objResult.result = -99;
	$.ajax({ 
		type: "post", 
		url: "http://127.0.0.1:3001/cmd/", 
		dataType: "jsonp", 
		data: {"act": "QNV_Storage","para":JSON.stringify(paraObj)},
		async:false,
		success: function (data) { 
			// $("#StatusArea").append("--- " + data );
			objResult.result = data.result;
			objResult.content = data.content;
			if(data.outbuf != null )
				objResult.outbuf  = decodeURIComponent(data.outbuf);
				if(nextFunc != null)
					nextFunc(objResult);
		}, 
		 complete:function(XMLHttpRequest,textStatus){  
					if(XMLHttpRequest.readyState=="4"){  
						//alert(XMLHttpRequest.responseText);  
					}  
			},  		
		error: function (XMLHttpRequest, textStatus, errorThrown) { 
			alert("网络错误! " + textStatus + ", error: " + errorThrown );
			if (textStatus == "timeout") { // 请求超时
					//getEvent(); // 递归调用
				// 其他错误，如网络错误等
				} else { 
					//getEvent();
				}
		} 
	});		
	return objResult;			
}
//接受文件在asp,php的参数为filedata1="文件名"
function Remote(  uRemoteType,  nValue, pInValue, pInValueEx, pOutValue,  nBufSize,nextFunc)
{
	var nResult = -99;
	var paraObj = {};
	paraObj.a = uRemoteType;
	paraObj.b = nValue;
	paraObj.c = pInValue;
	paraObj.d = pInValueEx;
	paraObj.e = pOutValue;
	
	nResult = sendCmd("QNV_Remote",paraObj,nextFunc);
	return nResult;			
}
//接受文件在asp,php的参数为filedata1="文件名"
function Remote(  uRemoteType,  nValue, pInValue, pInValueEx, pOutValue,  nBufSize,nextFunc)
{
	var nResult = -99;
	var paraObj = {};
	paraObj.a = uRemoteType;
	paraObj.b = nValue;
	paraObj.c = pInValue;
	paraObj.d = pInValueEx;
	paraObj.e = pOutValue;
	
	nResult = sendCmd("QNV_Remote",paraObj,nextFunc);
	return nResult;			
}
//返回一个结果对象
function Tool(  uToolType,  nValue, pInValue, pInValueEx, nextFunc )
{
	var objResult ={};
	var paraObj = {};
	paraObj.a = uToolType;
	paraObj.b = nValue;
	paraObj.c = pInValue;
	paraObj.d = pInValueEx;
	objResult.result = -99;
	$.ajax({ 
		type: "post", 
		url: "http://127.0.0.1:3001/cmd/", 
		dataType: "jsonp", 
		data: {"act": "QNV_Tool","para":JSON.stringify(paraObj)},
		async:false,
		success: function (data) { 
			// $("#StatusArea").append("--- " + data );
			objResult.result = data.result;
			objResult.content = data.content;
			objResult.outbuf = "";
			if(data.outbuf != null )
			{
				objResult.outbuf = decodeURIComponent(data.outbuf);	 
			}
			 switch(uToolType) {
			 case 	QNV_TOOL_PSTNEND:
			 case	QNV_TOOL_CODETYPE:
				 if(nextFunc != null)
					nextFunc(objResult.result);
				return objResult.result;
			 case QNV_TOOL_LOCATION:
				 {
					 if(nextFunc != null)
						nextFunc(objResult.outbuf);
					return objResult.outbuf;
				 }
			 case QNV_TOOL_DISKFREESPACE:
			 case QNV_TOOL_DISKTOTALSPACE:
			 {
				 if(nextFunc != null)
			 		nextFunc(objResult.result);
				return objResult.result;
			 }
			 case QNV_TOOL_DISKLIST:
				 {
					 if(nextFunc != null)
						nextFunc(objResult.outbuf);
					return objResult.outbuf;
				 }
			 case QNV_TOOL_CONVERTFMT:
				 if(nextFunc != null)
			 		nextFunc(objResult.result);
				return objResult.result;
			 case QNV_TOOL_SELECTDIRECTORY:
				 {
					 if(nextFunc != null)
						nextFunc(objResult.outbuf);
					return objResult.outbuf;
				 }
			 case QNV_TOOL_SELECTFILE:
				 {
					 if(nextFunc != null)
					 {
						 nextFunc(objResult.outbuf);
					 }
					return objResult.outbuf;
				 }
			 case QNV_TOOL_CONVERTTOTIFF:
			 {
				 if(nextFunc != null)
					nextFunc(objResult.result);
				return objResult.result;
			 }
			 case QNV_TOOL_SLEEP:
				 if(nextFunc != null)
			 		nextFunc(objResult.result);
				return objResult.result;
			 }					
		}, 
		 complete:function(XMLHttpRequest,textStatus){  
					if(XMLHttpRequest.readyState=="4"){  
						//alert(XMLHttpRequest.responseText);  
					}  
			},  		
		error: function (XMLHttpRequest, textStatus, errorThrown) { 
			alert("网络错误! " + textStatus + ", error: " + errorThrown );
			if (textStatus == "timeout") { // 请求超时
					//getEvent(); // 递归调用
				// 其他错误，如网络错误等
				} else { 
					//getEvent();
				}
		} 
	});		

	return objResult;		
}

function CallLog( nChannelID, uLogType,nextFunc)
{
	var objResult ={};
	var paraObj = {};
	paraObj.a = nChannelID;
	paraObj.b = uLogType;
	objResult.result = -99;
	$.ajax({ 
		type: "post", 
		url: "http://127.0.0.1:3001/cmd/", 
		dataType: "jsonp", 
		data: {"act": "QNV_CallLog","para":JSON.stringify(paraObj)},
		async:false,
		success: function (data) { 
			// $("#StatusArea").append("--- " + data );
			objResult.result = data.result;
			objResult.content = data.content;
			if(data.outbuf != null )
				objResult.outbuf = decodeURIComponent(data.outbuf);
				 switch(uToolType) {
				 case 	QNV_CALLLOG_BEGINTIME:
				 case	QNV_CALLLOG_RINGBACKTIME:
				 case   QNV_CALLLOG_CONNECTEDTIME:
				 case   QNV_CALLLOG_ENDTIME:
				 case   QNV_CALLLOG_CALLTYPE:
				 case   QNV_CALLLOG_CALLRESULT:
				 case   QNV_CALLLOG_DELRECFILE:
				 case	QNV_CALLLOG_RESET:
					 if(nextFunc != null)
				 		nextFunc(objResult.result);
					return objResult.result;
				 case QNV_CALLLOG_CALLID:
				 case QNV_CALLLOG_CALLRECFILE:
					 if(nextFunc != null)
				 		nextFunc(objResult.outbuf);
					return objResult.outbuf;;
				 }
				
		}, 
		 complete:function(XMLHttpRequest,textStatus){  
					if(XMLHttpRequest.readyState=="4"){  
						//alert(XMLHttpRequest.responseText);  
					}  
			},  		
		error: function (XMLHttpRequest, textStatus, errorThrown) { 
			alert("网络错误! " + textStatus + ", error: " + errorThrown );
			if (textStatus == "timeout") { // 请求超时
					//getEvent(); // 递归调用
				// 其他错误，如网络错误等
				} else { 
					//getEvent();
				}
		} 
	});		

	return objResult;			
}
//URL中所有参数可以以p1=v1&p2=v2赋值，以post格式传送
////接受文件在asp,php的参数为file="文件名
//strFilePath问文件本地路径
//nextFunc下一条函数
function UploadFile(  strUrl,  strFilePath,nextFunc)
{
	var nResult = -99;
	var paraObj = {};
	paraObj.a = strUrl;
	paraObj.b = strFilePath;
	
	nResult = sendCmd("UploadFile",paraObj,nextFunc);
	return nResult;			
}