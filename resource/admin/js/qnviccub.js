var		FALSE				=0;
var		TRUE				=1;
var		NULL				=0;
//2009/10/10
//var		QNV_DLL_VER		      	=0x101;
//var		QNV_DLL_VER_STR		      	='1.01';
//2010/01/08
//var		QNV_DLL_VER		      	=0x102;
//var		QNV_DLL_VER_STR		      	='1.02';
//2010/02/04 增加c/s socket远程通信接口
//var		QNV_DLL_VER			=0x0103;
//var		QNV_DLL_VER_STR			="1.03";
//2010/03/05
//var		QNV_DLL_VER			=0x0104;
//var		QNV_DLL_VER_STR			="1.04";

//2010/09/20
//var		QNV_DLL_VER			=0x0105;
//var		QNV_DLL_VER_STR			="1.05";

//2010/10/29
var		QNV_DLL_VER			=0x0106;
var		QNV_DLL_VER_STR			="1.06";


var		QNV_FILETRANS_VER		=0x30301;


var		QNV_CC_LICENSE			='quniccub_x';

//播放/录音回调时如果返回该值，系统将自动删除该回调模块，下次将不会被回调
var		CB_REMOVELIST				=-1;

var		MULTI_SEPA_CHAR				='|';//多个文件播放列表分割符号

var		RING_BEGIN_SIGN_STR			='0';
var		RING_END_SIGN_STR			='1';
var		RING_BEGIN_SIGN_CH			='0';
var		RING_END_SIGN_CH			='1';

var		RINGBACK_TELDIAL_STR		        ='0';
var		RINGBACK_PCDIAL_STR			='1';
var		RINGBACK_PCDIAL_CH			='1';
var		RINGBACK_TELDIAL_CH			='0';



var		DIAL_DELAY_SECOND			=',';//拨号时号码之间延迟1秒
var		DIAL_DELAY_HSECOND			='.';//拨号时号码之间延迟0.5秒
var		DIAL_CHECK_CITYCODE			=':';//拨号时该符号后自动过滤城市区号

var		CC_PARAM_SPLIT				=',';//CC参数的分隔符号

//自动创建录音文件时的默认目录名
var		RECFILE_DIR				='recfile';
//配置信息里的KEY
var		_INI_QNVICC_				='qnvicc';
//默认配置文件名
var		INI_FILENAME				='cc301config.ini';
//VOIP代拨标记
var		CC_VOIP_SIGN				='VOIP';
//匿名登陆CC,密码跟号码为相同
var		WEB_802ID				='800002000000000000';



var		MAX_USB_COUNT				=64;//支持的最多USB芯片数
var		MAX_CHANNEL_COUNT			=128;//支持的最多通道数
//声卡控制有效通道ID号
//0->255为USB设备通道号
var		SOUND_CHANNELID				=256;
//远程通信通道,HTTP上传/下载
var		REMOTE_CHANNELID			=257;
//CC控制通道
var		CCCTRL_CHANNELID			=258;
//socket 服务器端通道
var		SOCKET_SERVER_CHANNELID			=259;
//socket 终端通道
var		SOCKET_CLIENT_CHANNELID			=260;
//UDP通道
var		SOCKET_UDP_CHANNELID			=261;

var		MAX_CCMSG_LEN				=400;//发送消息的最大长度
var		MAX_CCCMD_LEN				=400;//发送命令的最大长度

var		DEFAULT_FLASH_ELAPSE			=600;//默认拍插簧间隔时间(ms)
var		DEFAULT_FLASHFLASH_ELAPSE		=1000;//默认拍插簧后间隔一定时间回调事件ms
var		DEFAULT_RING_ELAPSE			=1000;//默认给内部话机/交换机震铃时间ms响 1秒
var		DEFAULT_RINGSILENCE_ELAPSE		=4000;//默认给内部话机/交换机震铃后停止ms 4秒
var		DEFAULT_RING_TIMEOUT			=12;//默认给内线震铃超时次数,每次1秒响4秒停,总共时间就为N*5
var		DEFAULT_REFUSE_ELAPSE			=500;//拒接时默认使用间隔(ms)
var		DEFAULT_DIAL_SPEED			=75;//默认拨号速度ms
var		DEFAULT_DIAL_SILENCE			=75;//默认号码之间静音时间ms
var		DEFAULT_CHECKDIALTONE_TIMEOUT		=3000;//检测拨号音超时就强制呼叫ms
var		DEFAULT_CALLINTIMEOUT			=5500;//来电响铃超时ms

//设备类型
var		DEVTYPE_UNKNOW				=-1;//未知设备

//cc301系列
var		DEVTYPE_T1				=0x1009;
var		DEVTYPE_T2				=0x1000;
var		DEVTYPE_T3				=0x1008;
var		DEVTYPE_T4				=0x1005;
var		DEVTYPE_T5				=0x1002;
var		DEVTYPE_T6				=0x1004;

var		DEVTYPE_IR1				=0x8100;

var		DEVTYPE_IA1				=0x8111;
var		DEVTYPE_IA2				=0x8112;
var		DEVTYPE_IA3				=0x8113;
var		DEVTYPE_IA4				=0x8114;
var		DEVTYPE_IA4_F				=0x8115;

var		DEVTYPE_IB1				=0x8121;
var		DEVTYPE_IB2				=0x8122;
var		DEVTYPE_IB3				=0x8123;
var		DEVTYPE_IB4				=0x8124;

var		DEVTYPE_IP1				=0x8131;
var		DEVTYPE_IP1_F				=0x8132;

var		DEVTYPE_IC2_R				=0x8200;
var		DEVTYPE_IC2_LP				=0x8203;
var		DEVTYPE_IC2_LPQ				=0x8207;
var		DEVTYPE_IC2_LPF				=0x8211;

var		DEVTYPE_IC4_R				=0x8400;
var		DEVTYPE_IC4_LP				=0x8403;
var		DEVTYPE_IC4_LPQ				=0x8407;
var		DEVTYPE_IC4_LPF				=0x8411;

var		DEVTYPE_IC7_R				=0x8700;
var		DEVTYPE_IC7_LP				=0x8703;
var		DEVTYPE_IC7_LPQ				=0x8707;
var		DEVTYPE_IC7_LPF				=0x8711;

//玻瑞器
var		DEVTYPE_A1				=0x1100000;
var		DEVTYPE_A2				=0x1200000;
var		DEVTYPE_A3				=0x1300000;
var		DEVTYPE_A4				=0x1400000;
var		DEVTYPE_B1				=0x2100000;
var		DEVTYPE_B2				=0x2200000;
var		DEVTYPE_B3				=0x2300000;
var		DEVTYPE_B4				=0x2400000;
var 		DEVTYPE_C4_L				=0x3100000;
var 		DEVTYPE_C4_P				=0x3200000;
var 		DEVTYPE_C4_LP				=0x3300000;
var 		DEVTYPE_C4_LPQ				=0x3400000;
var		DEVTYPE_C7_L				=0x3500000;	
var		DEVTYPE_C7_P				=0x3600000;
var		DEVTYPE_C7_LP				=0x3700000;
var		DEVTYPE_C7_LPQ				=0x3800000;
var		DEVTYPE_R1				=0x4100000;
var		DEVTYPE_C_PR				=0x4200000;

//--------------------------------------------------------------
//设备功能模块
//是否具有内置喇叭功能
//可以PC播放语音到喇叭/通话时线路声音到喇叭
var		DEVMODULE_DOPLAY			 =0x1;
//是否具有可接入外线获取来电号码(FSK/DTMF双制式)/通话录音功能
//可以来电弹屏/通话录音/通话时获取对方按键(DTMF)
var		DEVMODULE_CALLID			 =0x2;
//是否具有可接入话机进行PSTN通话功能
//可以使用电话机进行PSTN通话/获取话机拨出的号码
var		DEVMODULE_PHONE				 =0x4;
//是否具有继电器切换断开/接通话机功能
//断开话机后可以:来电时话机不响铃/使用话机MIC独立采集录音配合DEVFUNC_RING模块给话机模拟来电震铃
var		DEVMODULE_SWITCH			 =0x8;
//PC播放语音给话机听筒,具有 DEVMODULE_SWITCH模块,switch后播放语音到话机听筒
var		DEVMODULE_PLAY2TEL			 =0x10;
//是否具有话机摘机后拨号/放音给线路的功能
//可以使用PC自动摘机进行拨号/通话时可以给对方播放语音/来电留言/外拨通知/来电IVR(语音答录)
var		DEVMODULE_HOOK				 =0x20;
//是否具有插入MIC/耳机功能
//可以用MIC/耳机进行PSTN通话/使用MIC独立录音/PC播放语音给耳机
var		DEVMODULE_MICSPK			 =0x40;
//是否具有让接在phone口的设备(电话机,交换机等)模拟震铃功能
//可以任意时刻让phone口的设备模拟来电震铃.如:在来电IVR(语音答录)之后进入工服务时给内部话机或交换机模拟震铃
var		DEVMODULE_RING				 =0x80;
//是否具有接收/发送传真功能
//可以发送图片,文档到对方的传真机/可以接收保存对方传真机发送过来的图片
var		DEVMODULE_FAX				 =0x100;
//具有级性反转检测对方摘机的功能
//如果PSTN线路在当地电信部门同时开通该级性反转检测服务,就可以在外拨时精确检测到对方摘机/挂机
//如果没有该功能,只有拨打的号码具有标准回铃才才能检测到对方摘机,对手机彩铃,IP等不具有标准回铃线路的不能检测对方摘机/挂机
var		DEVMODULE_POLARITY			 =0x800;
//----------------------------------------------------------------


//打开设备类型
var		ODT_LBRIDGE				       =0x0;//玻瑞器
var		ODT_SOUND				       =0x1;//声卡
var		ODT_CC					       =0x2;//CC模块
var		ODT_SOCKET_CLIENT			       =0x4;//SOCKET终端模块
var		ODT_SOCKET_SERVER			       =0x8;//SOCKET服务器模块
var		ODT_SOCKET_UDP					=0x10;//UDP模块
var		ODT_ALL					       =0xFF;//全部
var		ODT_CHANNEL				       =0x100;//关闭指定CC301通道
//
//保存用户自定义参数
//保存tool用户数据立即写入文件
var		SUD_WRITEFILE					=0x1;
//加密
var		SUD_ENCRYPT					=0x2;
//
//-----------------------------------------------------
//linein线路选择
var		LINEIN_ID_1				       =0x0;//默认正常状态录音，采集来电号码等
var		LINEIN_ID_2				       =0x1;//电话机断开后话柄录音
var		LINEIN_ID_3				       =0x2;//hook line 软摘机后录音,录音数据可以提高对方的音量,降低本地音量
var		LINEIN_ID_LOOP				       =0x3;//内部环路测试,设备测试使用,建议用户不需要使用
//-----------------------------------------------------

var		ADCIN_ID_MIC				       =0x0;//mic录音
var		ADCIN_ID_LINE				       =0x1;//电话线录音

//adc
var		DOPLAY_CHANNEL1_ADC			       =0x0;
var		DOPLAY_CHANNEL0_ADC			       =0x1;
var		DOPLAY_CHANNEL0_DAC			       =0x2;
var		DOPLAY_CHANNEL1_DAC			       =0x3;

//------------
var		SOFT_FLASH				       =0x1;//使用软件调用拍插完成
var		TEL_FLASH				       =0x2;//使用话机拍插完成
//------------
//拒接时使用模式
var		REFUSE_ASYN					=0x0;//异步模式,调用后函数立即返回，但并不表示拒接完成，拒接完成后将接收到一个拒接完成的事件
var		REFUSE_SYN					=0x1;//同步模式,调用后该函数被堵塞，等待拒接完成返回，系统不再有拒接完成的事件


//拍插簧类型
var		FT_NULL					       =0x0;
var		FT_TEL					       =0x1;//话机拍插簧
var		FT_PC					       =0x2;//软拍插簧
var		FT_ALL					       =0x3;
//-------------------------------

//拨号类型
var		DTT_DIAL				       =0x0;//拨号
var		DTT_SEND				       =0x1;//二次发码/震铃发送CALLID
//-------------------------------

//来电号码模式
var		CALLIDMODE_NULL				       =0x0;//未知
var		CALLIDMODE_FSK				       =0x1;//FSK来电
var		CALLIDMODE_DTMF				       =0x2;//DTMF来电
//

//号码类型
var		CTT_NULL				       =0x0;
var		CTT_MOBILE				       =0x1;//移动号码
var		CTT_PSTN				       =0x2;//普通固话号码
//------------------------------

var		CALLT_NULL				       =0x0;//
var		CALLT_CALLIN				       =0x1;//来电
var		CALLT_CALLOUT				       =0x2;//去电
//-------------------

var		CRESULT_NULL				       =0x0;
var		CRESULT_MISSED				       =0x1;//呼入未接
var		CRESULT_REFUSE				       =0x2;//呼入拒接
var		CRESULT_RINGBACK			       =0x3;//呼叫后回铃了
var		CRESULT_CONNECTED			       =0x4;//接通
//--------------------------------------

var		OPTYPE_NULL				       =0x0;
var		OPTYPE_REMOVE				       =0x1;//上传成功后删除本地文件
//本地保存临时记录,成功后删除,如果没成功，以后可以重新传
var		OPTYPE_SAVE							=0x2;

//设备错误ID
var		DERR_READERR				       =0x0;//读取数据发送错误
var		DERR_WRITEERR				       =0x1;//写入数据错误
var		DERR_FRAMELOST				       =0x2;//丢数据包
var		DERR_REMOVE				       =0x3;//设备移除
var		DERR_SERIAL				       =0x4;//设备序列号冲突
//---------------------------------------

//语音识别时的性别类型
var		SG_NULL					       =0x0;
var		SG_MALE					       =0x1;//男性
var		SG_FEMALE				       =0x2;//女性
var		SG_AUTO					       =0x3;//自动
//--------------------------------

//设备共享模式
var		SM_NOTSHARE				       =0x0 ;
var		SM_SENDVOICE				       =0x1;//发送语音
var		SM_RECVVOICE				       =0x2;//接收语音
//----------------------------------

//----------------------------------------------
//传真接受/发送
var		FAX_TYPE_NULL				       =0x0;
var		FAX_TYPE_SEND				       =0x1;//发送传真
var		FAX_TYPE_RECV				       =0x2;//接收传真
//------------------------------------------------

//
var		TTS_LIST_REINIT				       =0x0;//重新初始化新的TTS列表
var		TTS_LIST_APPEND				       =0x1;//追加TTS列表文件
//------------------------------------------------

//--------------------------------------------------------
var		DIALTYPE_DTMF				       =0x0;//DTMF拨号
var		DIALTYPE_FSK				       =0x1;//FSK拨号
//--------------------------------------------------------

//--------------------------------------------------------
var		PLAYFILE_MASK_REPEAT				=0x1;//循环播放
var		PLAYFILE_MASK_PAUSE				=0x2;//默认暂停
//--------------------------------------------------------

//播放文件回调的状态
var		PLAYFILE_PLAYING				=0x1;//正在播放
var		PLAYFILE_REPEAT					=0x2;//准备重复播放
var		PLAYFILE_END					=0x3;//播放结束


var		CONFERENCE_MASK_DISABLEMIC		        =0x100;//停止MIC,会议中其它成员不能听到该用户说话
var		CONFERENCE_MASK_DISABLESPK		        =0x200;//停止SPK,不能听到会议中其它成员说话


var		RECORD_MASK_ECHO			        =0x1;//回音抵消后的数据
var		RECORD_MASK_AGC				        =0x2;//自动增益后录音
var		RECORD_MASK_PAUSE			        =0x4;//暂停

var		CHECKLINE_MASK_DIALOUT				=0x1;//线路是否有正常拨号音(有就可以正常软拨号)
var		CHECKLINE_MASK_REV				=0x2;//线路LINE口/PHONE口接线是否正常,不正常就表示接反了


var		CHECKDIALTONE_BEGIN				=0x0;//检测拨号音
var		CHECKDIALTONE_ENDDIAL				=0x1;//检测到拨号音准备拨号

var		CHECKDIALTONE_TIMEOUTDIAL			=0x2;//检测拨号音超时强制自动拨号
var		CHECKDIALTONE_FAILED				=0x3;//检测拨号音超时就报告拨号失败,不拨号


var		OUTVALUE_MAX_SIZE			        =260;//location返回的最大长度


//-----------------------------------------------

//cc 消息参数
//具体字体参数意义请查看windows相关文档
var		MSG_KEY_CC				        ='cc:'; //消息来源CC号
var		MSG_KEY_NAME			                ='name:';//消息来源名称，保留
var		MSG_KEY_TIME			                ='time:';//消息来源时间
var		MSG_KEY_FACE			                ='face:';//字体名称
var		MSG_KEY_COLOR			                ='color:';//字体颜色
var		MSG_KEY_SIZE			                ='size:';//字体尺寸
var		MSG_KEY_CHARSET			                ='charset:';//字体特征
var		MSG_KEY_EFFECTS			                ='effects:';//字体效果
var		MSG_KEY_LENGTH			                ='length:';//消息正文长度
//CC文件参数
var		MSG_KEY_FILENAME		                ='filename:';//文件名
var		MSG_KEY_FILESIZE		                ='filesize:';//文件长度
var		MSG_KEY_FILETYPE		                ='filetype:';//文件类型


var		MSG_KEY_IP					="ip:";//接收到的UDP数据的IP地址
var		MSG_KEY_PORT					="port:";//接收到的UDP数据的端口

//
var		MSG_KEY_SPLIT			                ='\r\n';//参数之间分隔符号
var		MSG_TEXT_SPLIT		                	='\r\n\r\n';//消息参数和消息内容的分隔符号




// 本地电话机摘机事件
var BriEvent_PhoneHook					=1;
// 本地电话机挂机事件
var BriEvent_PhoneHang					=2;

// 外线通道来电响铃事件
// BRI_EVENT.lResult		为响铃次数
// BRI_EVENT.szData[0]='0'	开始1秒响铃
// BRI_EVENT.szData[0]='1'	为1秒响铃完成，开始4秒静音
var BriEvent_CallIn					=3;

// 得到来电号码
// BRI_EVENT.lResult		来电号码模式(CALLIDMODE_FSK/CALLIDMODE_DTMF
// BRI_EVENT.szData		保存的来电号码
// 该事件可能在响铃前,也可能在响铃后
var BriEvent_GetCallID					=4;

// 对方停止呼叫(产生一个未接电话)
var BriEvent_StopCallIn					=5;

// 调用开始拨号后，全部号码拨号结束
var BriEvent_DialEnd					=6;

// 播放文件结束事件
// BRI_EVENT.lResult	   播放文件时返回的句柄ID 
var BriEvent_PlayFileEnd			        =7;

// 多文件连播结束事件
// 
var BriEvent_PlayMultiFileEnd		                =8;

//播放字符结束
var BriEvent_PlayStringEnd			        =9;

// 播放文件结束准备重复播放
// BRI_EVENT.lResult	   播放文件时返回的句柄ID 
// 
var BriEvent_RepeatPlayFile			        =10;

// 给本地设备发送震铃信号时发送号码结束
var BriEvent_SendCallIDEnd			        =11;

//给本地设备发送震铃信号时超时
//默认不会超时
var BriEvent_RingTimeOut			        =12;

//正在内线震铃
// BRI_EVENT.lResult	   已经响铃的次数
// BRI_EVENT.szData[0]='0'	开始一次响铃
// BRI_EVENT.szData[0]='1'	一次响铃完成，准备静音
var BriEvent_Ringing				        =13;

// 通话时检测到一定时间的静音.默认为5秒
var BriEvent_Silence				        =14;

// 线路接通时收到DTMF码事件
// 该事件不能区分通话中是本地话机按键还是对方话机按键触发
var BriEvent_GetDTMFChar			        =15;

// 拨号后,被叫方摘机事件（该事件仅做参考,原因如下：）
// 原因：
// 该事件只适用于拨打是标准信号音的号码时，也就是拨号后带有标准回铃音的号码。
// 如：当拨打的对方号码是彩铃(彩铃手机号)或系统提示音(179xx)都不是标准回铃音时该事件无效。
// 
var BriEvent_RemoteHook					=16;

// 挂机事件
// 如果线路检测到被叫方摘机后，被叫方挂机时会触发该事件，不然被叫方挂机后就触发BriEvent_Busy事件
// 该事件或者BriEvent_Busy的触发都表示PSTN线路已经被断开
var BriEvent_RemoteHang					=17;

// 检测到忙音事件,表示PSTN线路已经被断开
var BriEvent_Busy					=18;

// 本地摘机后检测到拨号音
var BriEvent_DialTone				        =19;

// 只有在本地话机摘机，没有调用软摘机时，检测到DTMF拨号
var BriEvent_PhoneDial					=20;

// 电话机拨号结束呼出事件。
// 也就时电话机拨号后接收到标准回铃音或者15秒超时
// BRI_EVENT.lResult=0 检测到回铃音// 注意：如果线路是彩铃是不会触发该类型
// BRI_EVENT.lResult=1 拨号超时
// BRI_EVENT.lResult=2 动态检测拨号码结束(根据中国大陆的号码规则进行智能分析，仅做参考)
// BRI_EVENT.szData[0]='1' 软摘机拨号结束后回铃了
// BRI_EVENT.szData[0]='0' 电话机拨号中回铃了
var BriEvent_RingBack				        =21;

// MIC插入状态
// 只适用具有该功能的设备
var BriEvent_MicIn					=22;
// MIC拔出状态
// 只适用具有该功能的设备
var BriEvent_MicOut					=23;

// 拍插簧(Flash)完成事件，拍插簧完成后可以检测拨号音后进行二次拨号
// BRI_EVENT.lResult=TEL_FLASH  用户使用电话机进行拍叉簧完成
// BRI_EVENT.lResult=SOFT_FLASH 调用StartFlash函数进行拍叉簧完成
var BriEvent_FlashEnd				        =24;

// 拒接完成
var BriEvent_RefuseEnd					=25;

// 语音识别完成 
var BriEvent_SpeechResult		        	=26;

//PSTN线路断开,线路进入空闲状态
//当前没有软摘机而且话机也没摘机
var BriEvent_PSTNFree			        	=27;

// 接收到对方准备发送传真的信号
var BriEvent_RemoteSendFax			        =30;

// 接收传真完成
var BriEvent_FaxRecvFinished	                	=31;
// 接收传真失败
var BriEvent_FaxRecvFailed		        	=32;

// 发送传真完成
var BriEvent_FaxSendFinished		                =33;
// 发送传真失败
var BriEvent_FaxSendFailed		        	=34;

// 启动声卡失败
var BriEvent_OpenSoundFailed		                =35;

// 产生一个PSTN呼入/呼出日志
var BriEvent_CallLog				        =36;

//检测到连续的静音
//使用QNV_GENERAL_CHECKSILENCE启动后检测到设定的静音长度
var BriEvent_RecvSilence			        =37;

//检测到连续的声音
//使用QNV_GENERAL_CHECKVOICE启动后检测到设定的声音长度
var BriEvent_RecvVoice					=38;


//远程上传事件
var BriEvent_UploadSuccess			        =50;
var BriEvent_UploadFailed			        =51;
// 远程连接已被断开
var BriEvent_RemoteDisconnect		                =52;

//HTTP远程下载文件完成
//BRI_EVENT.lResult	   启动下载时返回的本次操作的句柄
var BriEvent_DownloadSuccess				=60;
var BriEvent_DownloadFailed				=61;

//线路检测结果
//BRI_EVENT.lResult 为检测结果信息
var BriEvent_CheckLine					=70;


// 应用层调用软摘机/软挂机成功事件
// BRI_EVENT.lResult=0 软摘机
// BRI_EVENT.lResult=1 软挂机			
var BriEvent_EnableHook					=100;
// 喇叭被打开或者/关闭
// BRI_EVENT.lResult=0 关闭
// BRI_EVENT.lResult=1 打开			
var BriEvent_EnablePlay					=101;
// MIC被打开或者关闭	
// BRI_EVENT.lResult=0 关闭
// BRI_EVENT.lResult=1 打开			
var BriEvent_EnableMic					=102;
// 耳机被打开或者关闭
// BRI_EVENT.lResult=0 关闭
// BRI_EVENT.lResult=1 打开			
var BriEvent_EnableSpk					=103;
// 电话机跟电话线(PSTN)断开/接通(DoPhone)
// BRI_EVENT.lResult=0 断开
// BRI_EVENT.lResult=1 接通		
var BriEvent_EnableRing					=104;
// 修改录音源,(无用/保留)
// BRI_EVENT.lResult 录音源数值
var BriEvent_DoRecSource			        =105;
// 开始软件拨号
// BRI_EVENT.szData	准备拨的号码
var BriEvent_DoStartDial			        =106;

var BriEvent_EnablePlayMux			        =107;
//接受DTMF按键
var BriEvent_RecvedDTMF =	194;
//设备移除
var  BriEvent_PlugOut					=195;
// 接收到FSK信号，包括通话中FSK/来电号码的FSK		
var BriEvent_RecvedFSK					=198;
//设备错误
var BriEvent_DevErr					=199;

//CCCtrl Event
//CC控制相关事件
var BriEvent_CC_ConnectFailed		                =200;//连接失败
var BriEvent_CC_LoginFailed		               	=201;//登陆失败
var BriEvent_CC_LoginSuccess		                =202;//登陆成功
var BriEvent_CC_SystemTimeErr		                =203;//系统时间错误
var BriEvent_CC_CallIn					=204;//有CC呼入请求
var BriEvent_CC_CallOutFailed		                =205;//呼叫失败
var BriEvent_CC_CallOutSuccess		        	=206;//呼叫成功，正在呼叫
var BriEvent_CC_Connecting			        =207;//呼叫正在连接
var BriEvent_CC_Connected			        =208;//呼叫连通
var BriEvent_CC_CallFinished		                =209;//呼叫结束
var BriEvent_CC_ReplyBusy				=210;//对方回复忙过来

var BriEvent_CC_RecvedMsg			        =220;//接收到用户即时消息
var BriEvent_CC_RecvedCmd			        =221;//接收到用户自定义命令

var BriEvent_CC_RegSuccess			        =225;//注册CC成功
var BriEvent_CC_RegFailed			        =226;//注册CC失败
var BriEvent_CC_FindSuccess				=227;//搜索CC服务器IP成功
var BriEvent_CC_FindFailed				=228;//搜索CC服务器IP失败

var BriEvent_CC_RecvFileRequest			        =230;//接收到用户发送的文件请求
var BriEvent_CC_TransFileFinished	                =231;//传输文件结束

var BriEvent_CC_AddContactSuccess	                =240;//增加好友成功
var BriEvent_CC_AddContactFailed	                =241;//增加好友失败
var BriEvent_CC_InviteContact		                =242;//接收到增加好好友邀请
var BriEvent_CC_ReplyAcceptContact	                =243;//对方回复同意为好友
var BriEvent_CC_ReplyRefuseContact	                =244;//对方回复拒绝为好友
var BriEvent_CC_AcceptContactSuccess                  	=245;//接受好友成功
var BriEvent_CC_AcceptContactFailed	                =246;//接受好友失败
var BriEvent_CC_RefuseContactSuccess                  	=247;//拒绝好友成功
var BriEvent_CC_RefuseContactFailed	                =248;//拒绝好友失败
var BriEvent_CC_DeleteContactSuccess                  	=249;//删除好友成功
var BriEvent_CC_DeleteContactFailed                   	=250;//删除好友失败
var BriEvent_CC_ContactUpdateStatus	                =251;//好友登陆状态改变
var BriEvent_CC_ContactDownendStatus                  	=252;//获取到所有好友改变完成

//终端接收到的事件
var BriEvent_Socket_C_ConnectSuccess			=300;//连接成功
var BriEvent_Socket_C_ConnectFailed			=301;//连接失败
var BriEvent_Socket_C_ReConnect				=302;//开始重新连接
var BriEvent_Socket_C_ReConnectFailed			=303;//重新连接失败
var BriEvent_Socket_C_ServerClose			=304;//服务器断开连接
var BriEvent_Socket_C_DisConnect			=305;//连接激活超时
var BriEvent_Socket_C_RecvedData			=306;//接收到服务端发送过来的数据

//UDP事件
var BriEvent_Socket_U_RecvedData			=360;//接收到UDP数据

var BriEvent_EndID					=500;//空ID
var BriEvent_UserID					=1024;//用户自定义ID

///////////////////////////////////////////////////////////////
//消息定义说明
//////////////////////////////////////////////////////////////
var             WM_USER                                 =1024;
var		BRI_EVENT_MESSAGE			=WM_USER+2000;//事件消息
var		BRI_RECBUF_MESSAGE			=WM_USER+2001;//缓冲录音数据消息

//文件录音格式
var		BRI_WAV_FORMAT_DEFAULT			=0; // BRI_AUDIO_FORMAT_PCM8K16B
var		BRI_WAV_FORMAT_ALAW8K			=1; // 8k/s
var		BRI_WAV_FORMAT_ULAW8K			=2; // 8k/s
var		BRI_WAV_FORMAT_IMAADPCM8K4B		=3; // 4k/s
var		BRI_WAV_FORMAT_PCM8K8B			=4; // 8k/s
var		BRI_WAV_FORMAT_PCM8K16B			=5; //16k/s
var		BRI_WAV_FORMAT_MP38K8B			=6; //~1.2k/s //保留
var		BRI_WAV_FORMAT_MP38K16B			=7; //~2.4k/s //保留
var		BRI_WAV_FORMAT_TM8K1B			=8; //~1.5k/s
var		BRI_WAV_FORMAT_GSM6108K			=9; //~2.2k/s
var		BRI_WAV_FORMAT_END			=255; //无效ID
//保留最多256个
////////////////////////////////////////////////////////////

//-------------------------------------------------------------------------------------
//
//
//----------------------------------------------------------------------------------
//设备信息
var		QNV_DEVINFO_GETCHIPTYPE			=1;//获取USB模块类型
var		QNV_DEVINFO_GETCHIPS			=2;//获取USB模块数量,该值等于最后一个通道的DEVID
var		QNV_DEVINFO_GETTYPE			=3;//获取通道类型
var		QNV_DEVINFO_GETMODULE			=4;//获取通道功能模块
var		QNV_DEVINFO_GETCHIPCHID			=5;//获取通道所在USB芯片的中的传输ID(0或者1)
var		QNV_DEVINFO_GETSERIAL			=6;//获取通道序列号(0-n)
var		QNV_DEVINFO_GETCHANNELS			=7;//获取通道数量
var		QNV_DEVINFO_GETDEVID			=8;//获取通道所在的USB模块ID(0-n)
var		QNV_DEVINFO_GETDLLVER		       	=9;//获取DLL版本号
var		QNV_DEVINFO_GETCHIPCHANNEL		=10;//获取该USB模块第一个传输ID所在的通道号
var		QNV_DEVINFO_GETCHANNELTYPE		=11;//通道线路接外线还是话机类型
var		QNV_DEVINFO_GETCHIPCHANNELS		=12;//获取该USB模块第二个传输ID所在的通道号

var		QNV_DEVINFO_FILEVERSION			=20;//获取DLL的文件版本
//-----------------------------------------------------------------

//参数类型列表
//uParamType (可以使用API自动保存/读取)
var		QNV_PARAM_BUSY				=1;//检测到几个忙音回调
var		QNV_PARAM_DTMFLEVEL		        =2;//dtmf检测时允许的性噪声比(0-5)
var		QNV_PARAM_DTMFVOL			=3;//dtmf检测时允许的能量(1-100)
var		QNV_PARAM_DTMFNUM			=4;//dtmf检测时允许的持续时间(2-10)
var		QNV_PARAM_DTMFLOWINHIGH			=5;//dtmf低频不能超过高频值(默认为6)
var		QNV_PARAM_DTMFHIGHINLOW			=6;//dtmf高频不能超过低频值(默认为4)
var		QNV_PARAM_DIALSPEED			=7;//拨号的DTMF长度(1ms-60000ms)
var		QNV_PARAM_DIALSILENCE			=8;//拨号时的间隔静音长度(1ms-60000ms)
var		QNV_PARAM_DIALVOL			=9;//拨号音量大小
var		QNV_PARAM_RINGSILENCE			=10;//来电不响铃多少时间超时算未接电话
var		QNV_PARAM_CONNECTSILENCE		=11;//通话时连续多少时间静音后回调
var		QNV_PARAM_RINGBACKNUM			=12;//拨几个数字以上后检测回铃开始有效//默认为2个,可起到忽略出局号码后检测的回铃音
var		QNV_PARAM_SWITCHLINEIN			=13;//自动切换LINEIN选择
var		QNV_PARAM_FLASHELAPSE			=14;//拍插簧间隔
var		QNV_PARAM_FLASHENDELAPSE		=15;//拍插簧后延迟一定时间再回调事件
var		QNV_PARAM_RINGELAPSE			=16;//内线震铃时时间长度
var		QNV_PARAM_RINGSILENCEELAPSE		=17;//内线震铃时静音长度
var		QNV_PARAM_RINGTIMEOUT			=18;//内线震铃时超时次数
var		QNV_PARAM_RINGCALLIDTYPE		=19;//内线震铃时发送号码的方式dtmf/fsk
var		QNV_PARAM_REFUSEELAPSE			=20;//拒接时间隔时间长度
var		QNV_PARAM_DIALTONETIMEOUT		=21;//检测拨号音超时
var		QNV_PARAM_MINCHKFLASHELAPSE		=22;//拍插簧检测时挂机至少的时间ms,挂机时间小于该值就不算拍插簧
var		QNV_PARAM_MAXCHKFLASHELAPSE		=23;//拍插簧检测时挂机最长的时间ms,挂机时间大于该值就不算拍插簧
var		QNV_PARAM_HANGUPELAPSE			=24;//检测电话机挂机时的至少时间长度ms,//建议挂机检测次数在拍插簧以上，避免发生挂机后又检测到拍插
var		QNV_PARAM_OFFHOOKELAPSE			=25;//检测电话机摘机时的至少时间长度ms
var		QNV_PARAM_RINGHIGHELAPSE		=26;//检测来电震铃时响铃的至少时间长度ms
var		QNV_PARAM_RINGLOWELAPSE			=27;//检测来电震铃时不响铃的至少时间长度ms
var		QNV_PARAM_DIALTONERESULT		=28;//检测拨号音超时后强制拨号还是提示拨号dostartdial失败


var		QNV_PARAM_SPEECHGENDER			=30;//语音设置性别
var		QNV_PARAM_SPEECHTHRESHOLD		=31;//语音识别门限
var		QNV_PARAM_SPEECHSILENCEAM		=32;//语音识别静音门限
var		QNV_PARAM_ECHOTHRESHOLD			=33;//回音抵消处理抵消门限参数
var		QNV_PARAM_ECHODECVALUE			=34;//回音抵消处理减少增益参数
var		QNV_PARAM_SIGSILENCEAM			=35;//信号音/线路通话分析的静音门限

var		QNV_PARAM_LINEINFREQ1TH			=40;//第一组线路双频模式信号音频率
var		QNV_PARAM_LINEINFREQ2TH			=41;//第二组线路双频模式信号音频率
var		QNV_PARAM_LINEINFREQ3TH			=42;//第三组线路双频模式信号音频率

var           	QNV_PARAM_ADBUSYMINFREQ                 =45;//检测忙音叠加时最小频率
var           	QNV_PARAM_ADBUSYMAXFREQ                 =46;//检测忙音叠加时最大频率

//增益控制
var		QNV_PARAM_AM_MIC			=50;//MIC增益
var		QNV_PARAM_AM_SPKOUT			=51;//耳机spk增益
var		QNV_PARAM_AM_LINEIN			=52;//线路输入能量
var		QNV_PARAM_AM_LINEOUT			=53;//mic到线路能量+播放语音到到线路能量
var		QNV_PARAM_AM_DOPLAY			=54;//喇叭输出增益
//

var		QNV_PARAM_CITYCODE			=60;//城市区号,适合中国大陆
var		QNV_PARAM_PROXYDIAL			=61;//代拨号

var		QNV_PARAM_FINDSVRTIMEOUT		=70;//设置自动CC搜索超时时间
var		QNV_PARAM_CONFJITTERBUF			=71;//会议交换的动态缓冲大小

var		QNV_PARAM_RINGTHRESHOLD			=80;//来电响铃信号分析门限

var		QNV_PARAM_DTMFCALLIDLEVEL		=100;//dtmf来电号码检测时允许的性噪声比(0-7)
var		QNV_PARAM_DTMFCALLIDNUM			=101;//dtmf来电号码检测时允许的持续时间(2-10)
var		QNV_PARAM_DTMFCALLIDVOL			=102;//dtmf来电号码检测时允许的能量要求

//设备控制/状态
//uCtrlType
var		QNV_CTRL_DOSHARE			=1;//设备共享
var		QNV_CTRL_DOHOOK				=2;//软件摘挂机控制
var		QNV_CTRL_DOPHONE			=3;//控制电话机是否可用,可控制话机震铃,实现硬拍插簧等
var		QNV_CTRL_DOPLAY				=4;//喇叭控制开关
var		QNV_CTRL_DOLINETOSPK			=5;//线路声音到耳机，用耳机通话时打开
var		QNV_CTRL_DOPLAYTOSPK			=6;//播放的语音到耳机
var		QNV_CTRL_DOMICTOLINE			=7;//MIC说话声到电话线
var		QNV_CTRL_ECHO				=8;//打开/关闭回音抵消
var		QNV_CTRL_RECVFSK			=9;//打开/关闭接收FSK来电号码
var		QNV_CTRL_RECVDTMF			=10;//打开/关闭接收DTMF
var		QNV_CTRL_RECVSIGN			=11;//打开/关闭信号音检测
var		QNV_CTRL_WATCHDOG			=12;//打开关闭看门狗
var		QNV_CTRL_PLAYMUX			=13;//选择到喇叭的语音通道 line1x/pcplay ch0/line2x/pcplay ch1
var		QNV_CTRL_PLAYTOLINE			=14;//播放的语音到line
var		QNV_CTRL_SELECTLINEIN			=15;//选择输入的线路line通道
var		QNV_CTRL_SELECTADCIN			=16;//选择输入的为线路还是MIC语音
var		QNV_CTRL_PHONEPOWER			=17;//打开/关闭给话机供电使能,如果不给话机供电,dophone切换后,话机将不可用,所有对话机的操作都无效
var		QNV_CTRL_RINGPOWER			=18;//内线震铃使能
var		QNV_CTRL_LEDPOWER			=19;//LED指示灯
var		QNV_CTRL_LINEOUT			=20;//线路输出使能
var		QNV_CTRL_SWITCHOUT			=21;//硬件回音抵消
var		QNV_CTRL_UPLOAD				=22;//打开/关闭设备USB数据上传功能,关闭后将接收不到设备语音数据
var		QNV_CTRL_DOWNLOAD			=23;//打开/关闭设备USB数据下载功能,关闭后将不能发送语音/拨号到设备
var		QNV_CTRL_POLARITY			=24;//开关级性反转摘机检测
var		QNV_CTRL_ADBUSY				=25;//是否打开检测忙音叠加时环境(只有在使用两路外线网关时由于同时挂机才会触发忙音被叠加的环境,普通用户不需要使用)
var		QNV_CTRL_RECVCALLIN			=26;//打开/关闭软解码来电
var		QNV_CTRL_READFRAMENUM			=27;//一次请求读取的USB帧数量，越大占用CPU越小，延迟也就越大，一帧为4ms,最大30帧，也就是设置范围为(1-30)
var		QNV_CTRL_DTMFCALLID			=28;//忽略DTMF模式接收来电号码,默认是开启检测的

//以下状态不能设置(set),只能获取(get)
var		QNV_CTRL_PHONE				=30;//电话机摘挂机状态
var		QNV_CTRL_MICIN				=31;//mic插入状态
var		QNV_CTRL_RINGTIMES			=32;//来电响铃的次数
var		QNV_CTRL_RINGSTATE			=33;//来电响铃状态，正在响还是不响
//

//放音控制
//uPlayType
var		QNV_PLAY_FILE_START		       	=1;//开始播放文件
var		QNV_PLAY_FILE_SETCALLBACK		=2;//设置播放文件回调函数
var		QNV_PLAY_FILE_SETVOLUME			=3;//设置播放文件音量
var		QNV_PLAY_FILE_GETVOLUME			=4;//获取播放文件音量
var		QNV_PLAY_FILE_PAUSE			=5;//暂停播放文件
var		QNV_PLAY_FILE_RESUME			=6;//恢复播放文件
var		QNV_PLAY_FILE_ISPAUSE			=7;//检测是否已暂停播放
var		QNV_PLAY_FILE_SETREPEAT			=8;//设置是否循环播放
var		QNV_PLAY_FILE_ISREPEAT			=9;//检测是否在循环播放
var		QNV_PLAY_FILE_SEEKTO			=11;//跳转到某个时间(ms)
var		QNV_PLAY_FILE_SETREPEATTIMEOUT	        =12;//设置循环播放超时次数
var		QNV_PLAY_FILE_GETREPEATTIMEOUT	        =13;//获取循环播放超时次数
var		QNV_PLAY_FILE_SETPLAYTIMEOUT	        =14;//设置播放总共超时时长(ms)
var		QNV_PLAY_FILE_GETPLAYTIMEOUT	        =15;//获取播放总共超时时长
var		QNV_PLAY_FILE_TOTALLEN			=16;//总共时间(ms)
var		QNV_PLAY_FILE_CURSEEK			=17;//当前播放的文件时间位置(ms)
var		QNV_PLAY_FILE_ELAPSE			=18;//总共播放的时间(ms),包括重复的,后退的,不包括暂停的时间
var		QNV_PLAY_FILE_ISPLAY			=19;//该句柄是否在播放
var		QNV_PLAY_FILE_ENABLEAGC			=20;//打开关闭自动增益
var		QNV_PLAY_FILE_ISENABLEAGC		=21;//检测是否打开自动增益
var		QNV_PLAY_FILE_STOP		       	=22;//停止播放指定文件
var		QNV_PLAY_FILE_GETCOUNT			=23;//获取正在文件播放的数量,可以用来检测如果没有了就可以关闭喇叭
var		QNV_PLAY_FILE_STOPALL			=24;//停止播放所有文件
var		QNV_PLAY_FILE_REMOTEBUFFERLEN		=25;//远程播放需要下载的缓冲长度
var		QNV_PLAY_FILE_REMOTEBUFFERSEEK		=26;//远程播放已经下载的缓冲长度
//--------------------------------------------------------

var		QNV_PLAY_BUF_START			=1;//开始缓冲播放
var		QNV_PLAY_BUF_SETCALLBACK		=2;//设置缓冲播放回调函数
var		QNV_PLAY_BUF_SETWAVEFORMAT		=3;//设置缓冲播放语音的格式
var		QNV_PLAY_BUF_WRITEDATA			=4;//写缓冲数据
var		QNV_PLAY_BUF_SETVOLUME			=5;//设置音量
var		QNV_PLAY_BUF_GETVOLUME			=6;//获取音量
var		QNV_PLAY_BUF_SETUSERVALUE		=7;//设置用户自定义数据
var		QNV_PLAY_BUF_GETUSERVALUE		=8;//获取用户自定义数据
var		QNV_PLAY_BUF_ENABLEAGC			=9;//打开关闭自动增益
var		QNV_PLAY_BUF_ISENABLEAGC		=10;//检测是否打开了自动增益
var       	QNV_PLAY_BUF_PAUSE                      =11;//暂停播放文件
var           	QNV_PLAY_BUF_RESUME                     =12;//恢复播放文件
var           	QNV_PLAY_BUF_ISPAUSE                    =13;//检测是否已暂停播放
var           	QNV_PLAY_BUF_STOP                       =14;//停止缓冲播放
var           	QNV_PLAY_BUF_FREESIZE                   =15;//空闲字节
var           	QNV_PLAY_BUF_DATASIZE                   =16;//数据字节
var           	QNV_PLAY_BUF_TOTALSAMPLES               =17;//总共播放的采样数
//设置动态缓冲长度，当缓冲数据播放为空后下次播放前缓冲内必须大于该长度的语音,可用在播放网络数据包，避免网络抖动
var           	QNV_PLAY_BUF_SETJITTERBUFSIZE           =18;
var           	QNV_PLAY_BUF_GETJITTERBUFSIZE           =19;//获取动态缓冲长度
var           	QNV_PLAY_BUF_GETCOUNT                   =20;//获取正在缓冲播放的数量,可以用来检测如果没有了就可以关闭喇叭
var          	QNV_PLAY_BUF_STOPALL                    =21;//停止所有播放
//-------------------------------------------------------

var		QNV_PLAY_MULTIFILE_START		=1;//开始多文件连续播放
var		QNV_PLAY_MULTIFILE_PAUSE		=2;//暂停多文件连续播放
var		QNV_PLAY_MULTIFILE_RESUME		=3;//恢复多文件连续播放
var		QNV_PLAY_MULTIFILE_ISPAUSE		=4;//检测是否暂停了多文件连续播放
var		QNV_PLAY_MULTIFILE_SETVOLUME	        =5;//设置多文件播放音量
var		QNV_PLAY_MULTIFILE_GETVOLUME	        =6;//获取多文件播放音量
var		QNV_PLAY_MULTIFILE_STOP			=7;//停止多文件连续播放
var		QNV_PLAY_MULTIFILE_STOPALL		=8;//停止全部多文件连续播放
//--------------------------------------------------------

var		QNV_PLAY_STRING_INITLIST		=1;//初始化字符播放列表
var		QNV_PLAY_STRING_START			=2;//开始字符播放
var		QNV_PLAY_STRING_PAUSE			=3;//暂停字符播放
var		QNV_PLAY_STRING_RESUME			=4;//恢复字符播放
var		QNV_PLAY_STRING_ISPAUSE			=5;//检测是否暂停了字符播放
var		QNV_PLAY_STRING_SETVOLUME		=6;//设置字符播放音量
var		QNV_PLAY_STRING_GETVOLUME		=7;//获取字符播放音量
var		QNV_PLAY_STRING_STOP			=8;//停止字符播放
var		QNV_PLAY_STRING_STOPALL			=9;//停止全部字符播放
//--------------------------------------------------------

//录音控制
//uRecordType
var		QNV_RECORD_FILE_START			=1;//开始文件录音
var		QNV_RECORD_FILE_PAUSE			=2;//暂停文件录音
var		QNV_RECORD_FILE_RESUME			=3;//恢复文件录音
var		QNV_RECORD_FILE_ISPAUSE			=4;//检测是否暂停文件录音
var		QNV_RECORD_FILE_ELAPSE			=5;//获取已经录音的时间长度,单位(s)
var		QNV_RECORD_FILE_SETVOLUME		=6;//设置文件录音音量
var		QNV_RECORD_FILE_GETVOLUME		=7;//获取文件录音音量
var		QNV_RECORD_FILE_PATH			=8;//获取文件录音的路径
var		QNV_RECORD_FILE_STOP			=9;//停止某个文件录音
var		QNV_RECORD_FILE_STOPALL			=10;//停止全部文件录音
var		QNV_RECORD_FILE_COUNT			=11;//获取正在录音的数量
var		QNV_RECORD_FILE_SETROOT			=20;//设置默认录音目录
var		QNV_RECORD_FILE_GETROOT			=21;//获取默认录音目录

//----------------------------------------------------------

var		QNV_RECORD_BUF_HWND_START		=1;//开始缓冲录音窗口回调
var		QNV_RECORD_BUF_HWND_STOP		=2;//停止某个缓冲录音窗口回调
var		QNV_RECORD_BUF_HWND_STOPALL		=3;//停止全部缓冲录音窗口回调
var		QNV_RECORD_BUF_CALLBACK_START	        =4;//开始缓冲录音回调
var		QNV_RECORD_BUF_CALLBACK_STOP	        =5;//停止某个缓冲录音回调
var		QNV_RECORD_BUF_CALLBACK_STOPALL	        =6;//停止全部缓冲录音回调
var		QNV_RECORD_BUF_SETCBSAMPLES		=7;//设置回调采样数,每秒8K,如果需要20ms回调一次就设置为20*8=160,/默认为20ms回调一次
var		QNV_RECORD_BUF_GETCBSAMPLES		=8;//获取设置的回调采样数
var		QNV_RECORD_BUF_ENABLEECHO		=9;//打开关闭自动增益
var		QNV_RECORD_BUF_ISENABLEECHO		=10;//检测自动增益是否打开
var		QNV_RECORD_BUF_PAUSE			=11;//暂停缓冲录音
var		QNV_RECORD_BUF_ISPAUSE			=12;//检测是否暂停缓冲录音
var		QNV_RECORD_BUF_RESUME			=13;//恢复缓冲录音
var		QNV_RECORD_BUF_SETVOLUME		=14;//设置缓冲录音音量
var		QNV_RECORD_BUF_GETVOLUME		=15;//获取缓冲录音音量
var		QNV_RECORD_BUF_SETWAVEFORMAT	        =16;//设置录音回调的语音编码格式,默认为8K,16位,wav线性
var		QNV_RECORD_BUF_GETWAVEFORMAT	        =17;//获取录音回调的语音编码格式
var		QNV_RECORD_BUF_GETCBMSGID		=100;//查询缓冲录音的窗口回调的消息ID,默认为BRI_RECBUF_MESSAGE
var		QNV_RECORD_BUF_SETCBMSGID		=101;//设置缓冲录音的窗口回调的消息ID,默认为BRI_RECBUF_MESSAGE
//--------------------------------------------------------

//会议控制
//uConferenceType
var		QNV_CONFERENCE_CREATE			=1;//创建会议
var		QNV_CONFERENCE_ADDTOCONF		=2;//增加通道到某个会议
var		QNV_CONFERENCE_GETCONFID		=3;//获取某个通道的会议ID
var		QNV_CONFERENCE_SETSPKVOLUME		=4;//设置会议中某个通道放音音量
var		QNV_CONFERENCE_GETSPKVOLUME		=5;//获取会议中某个通道放音音量
var		QNV_CONFERENCE_SETMICVOLUME		=6;//设置会议中某个通道录音音量
var		QNV_CONFERENCE_GETMICVOLUME		=7;//获取会议中某个通道录音音量
var		QNV_CONFERENCE_PAUSE			=8;//暂停某个会议
var		QNV_CONFERENCE_RESUME			=9;//恢复某个会议
var		QNV_CONFERENCE_ISPAUSE			=10;//检测是否暂停了某个会议
var		QNV_CONFERENCE_ENABLESPK		=11;//打开关闭会议者听功能
var		QNV_CONFERENCE_ISENABLESPK		=12;//检测会议者听功能是否打开
var		QNV_CONFERENCE_ENABLEMIC		=13;//打开关闭会议者说功能
var		QNV_CONFERENCE_ISENABLEMIC		=14;//检测会议者说功能是否打开
var		QNV_CONFERENCE_ENABLEAGC		=15;//打开关闭自动增益
var		QNV_CONFERENCE_ISENABLEAGC		=16;//检测是否打开了自动增益
var		QNV_CONFERENCE_DELETECHANNEL	        =17;//把通道从会议中删除
var		QNV_CONFERENCE_DELETECONF		=18;//删除一个会议
var		QNV_CONFERENCE_DELETEALLCONF	        =19;//删除全部会议
var		QNV_CONFERENCE_GETCONFCOUNT		=20;//获取会议数量
var		QNV_CONFERENCE_SETJITTERBUFSIZE		=21;//设置会议动态缓冲长度
var		QNV_CONFERENCE_GETJITTERBUFSIZE		=22;//获取会议动态缓冲长度

var		QNV_CONFERENCE_RECORD_START		=30;//开始录音
var		QNV_CONFERENCE_RECORD_PAUSE		=31;//暂停录音
var		QNV_CONFERENCE_RECORD_RESUME	        =32;//恢复录音
var		QNV_CONFERENCE_RECORD_ISPAUSE	        =33;//检测是否暂停录音
var		QNV_CONFERENCE_RECORD_FILEPATH	        =34;//获取录音文件路径
var		QNV_CONFERENCE_RECORD_ISSTART		=35;//检测会议是否已经启动了录音
var		QNV_CONFERENCE_RECORD_STOP		=36;//停止指定会议录音
var		QNV_CONFERENCE_RECORD_STOPALL	        =37;//停止全部会议录音
//--------------------------------------------------------

//speech语音识别
var		QNV_SPEECH_CONTENTLIST			=1;//设置识别汉字内容列表
var		QNV_SPEECH_STARTSPEECH			=2;//开始识别
var		QNV_SPEECH_ISSPEECH		       	=3;//检测是否正在识别
var		QNV_SPEECH_STOPSPEECH			=4;//停止识别
var		QNV_SPEECH_GETRESULT			=5;//获取识别后的结果
//------------------------------------------------------------

//传真模块接口
var		QNV_FAX_LOAD			   	=1;//加载启动传真模块
var		QNV_FAX_UNLOAD			  	=2;//卸载传真模块
var		QNV_FAX_STARTSEND		   	=3;//开始发送传真
var		QNV_FAX_STOPSEND		   	=4;//停止发送传真
var		QNV_FAX_STARTRECV		  	=5;//开始接收传真
var		QNV_FAX_STOPRECV		  	=6;//停止接收传真
var		QNV_FAX_STOP			  	=7;//停止全部
var		QNV_FAX_PAUSE			  	=8;//暂停
var		QNV_FAX_RESUME			  	=9;//恢复
var		QNV_FAX_ISPAUSE			  	=10;//是否暂停
var		QNV_FAX_TYPE			   	=11;//传真状态是接受或者发送
var		QNV_FAX_TRANSMITSIZE			=12;//已经发送的图象数据大小
var		QNV_FAX_IMAGESIZE		   	=13;//总共需要发送图象数据大小
//----------------------------------------------------------


//函数general
//uGeneralType
var		QNV_GENERAL_STARTDIAL			=1;//开始拨号
var		QNV_GENERAL_SENDNUMBER			=2;//二次拨号
var		QNV_GENERAL_REDIAL		 	=3;//重拨最后一次呼叫的号码,程序退出后该号码被释放
var		QNV_GENERAL_STOPDIAL			=4;//停止拨号
var		QNV_GENERAL_ISDIALING			=5;//是否在拨号

var		QNV_GENERAL_STARTRING			=10;//phone口震铃
var		QNV_GENERAL_STOPRING			=11;//phone口震铃停止
var		QNV_GENERAL_ISRINGING			=12;//phone口是否在震铃

var		QNV_GENERAL_STARTFLASH			=20;//拍插簧
var		QNV_GENERAL_STOPFLASH			=21;//拍插簧停止
var		QNV_GENERAL_ISFLASHING			=22;//是否正在拍插簧

var		QNV_GENERAL_STARTREFUSE			=30;//拒接当前呼入
var		QNV_GENERAL_STOPREFUSE			=31;//终止拒接操作
var		QNV_GENERAL_ISREFUSEING			=32;//是否正在拒接当前呼入

var		QNV_GENERAL_GETCALLIDTYPE		=50;//获取本次呼入的来电号码类型
var		QNV_GENERAL_GETCALLID			=51;//获取本次呼入的来电号码
var		QNV_GENERAL_GETTELDIALCODE		=52;//获取本次电话机拨出的号码类型,return buf
var		QNV_GENERAL_GETTELDIALCODEEX	        =53;//获取本次电话机拨出的号码类型,outbuf
var		QNV_GENERAL_RESETTELDIALBUF		=54;//清空电话拨的号码缓冲
var		QNV_GENERAL_GETTELDIALLEN		=55;//电话机已拨的号码长度

var		QNV_GENERAL_STARTSHARE			=60;//启动设备共享服务
var		QNV_GENERAL_STOPSHARE			=61;//停止设备共享服务
var		QNV_GENERAL_ISSHARE		 	=62;//是否启用设备共享服务模块

var		QNV_GENERAL_ENABLECALLIN		=70;//禁止/启用外线呼入
var		QNV_GENERAL_ISENABLECALLIN		=71;//外线是否允许呼入
var		QNV_GENERAL_ISLINEHOOK			=72;//外线是否摘机状态(电话机摘机并连着line或者有软摘机都表示摘机状态)
var		QNV_GENERAL_ISLINEFREE			=73;//外线是否空闲(没有摘机并且没有来电表示空闲)


var		QNV_GENERAL_RESETRINGBACK		=80;//复位检测到的回铃,重新启动检测
var		QNV_GENERAL_CHECKCHANNELID		=81;//检测通道ID是否合法
var		QNV_GENERAL_CHECKDIALTONE		=82;//检测拨号音
var		QNV_GENERAL_CHECKSILENCE		=83;//检测线路静音
var		QNV_GENERAL_CHECKVOICE			=84;//检测线路声音
var		QNV_GENERAL_CHECKLINESTATE		=85;//检测线路状态(是否可正常拨号/是否接反)
var		QNV_GENERAL_GETMAXPOWER			=86;//获取当前最大语音幅度

var		QNV_GENERAL_SETUSERVALUE		=90;//用户自定义通道数据,系统退出后自动释放
var		QNV_GENERAL_SETUSERSTRING		=91;//用户自定义通道字符,系统退出后自动释放
var		QNV_GENERAL_GETUSERVALUE		=92;//获取用户自定义通道数据
var		QNV_GENERAL_GETUSERSTRING		=93;//获取用户自定义通道字符

var		QNV_GENERAL_USEREVENT			=99;//发送用户自定义事件
//初始化通道INI文件参数
var		QNV_GENERAL_READPARAM			=100;//读取ini文件进行全部参数初始化
var		QNV_GENERAL_WRITEPARAM			=101;//把参数写入到ini文件
//

//call log
var		QNV_CALLLOG_BEGINTIME			=1;//获取呼叫开始时间
var		QNV_CALLLOG_RINGBACKTIME		=2;//获取回铃时间
var		QNV_CALLLOG_CONNECTEDTIME		=3;//获取接通时间
var		QNV_CALLLOG_ENDTIME		   	=4;//获取结束时间
var		QNV_CALLLOG_CALLTYPE			=5;//获取呼叫类型/呼入/呼出
var		QNV_CALLLOG_CALLRESULT			=6;//获取呼叫结果
var		QNV_CALLLOG_CALLID		        =7;//获取号码
var		QNV_CALLLOG_CALLRECFILE			=8;//获取录音文件路径
var		QNV_CALLLOG_DELRECFILE			=9;//删除录音文件，要删除前必须先停止录音

var		QNV_CALLLOG_RESET			=20;//复位所有状态
var		QNV_CALLLOG_AUTORESET			=21;//自动复位

//工具函数，跟设备无关
//uToolType
var		QNV_TOOL_PSTNEND		 	=1;//检测PSTN号码是否已经结束
var		QNV_TOOL_CODETYPE		 	=2;//判断号码类型(内地手机/固话)
var		QNV_TOOL_LOCATION		 	=3;//获取号码所在地信息
var		QNV_TOOL_DISKFREESPACE			=4;//获取该硬盘剩余空间(M)
var		QNV_TOOL_DISKTOTALSPACE			=5;//获取该硬盘总共空间(M)
var		QNV_TOOL_DISKLIST		 	=6;//获取硬盘列表
var		QNV_TOOL_RESERVID1			=7;//保留
var		QNV_TOOL_RESERVID2			=8;//保留
var		QNV_TOOL_CONVERTFMT	      		=9;//转换语音文件格式
var		QNV_TOOL_SELECTDIRECTORY		=10;//选择目录
var		QNV_TOOL_SELECTFILE			=11;//选择文件
var		QNV_TOOL_CONVERTTOTIFF			=12;//转换图片到传真tiff格式,必须先启动传真模块,支持格式:(*.doc,*.htm,*.html,*.mht,*.jpg,*.pnp.....)
var		QNV_TOOL_APMQUERYSUSPEND		=13;//是否允许PC进入待机/休眠,打开USB设备后才能使用
var		QNV_TOOL_SLEEP				=14;//让调用该方法的线程等待N毫秒
var		QNV_TOOL_SETUSERVALUE			=15;//保存用户自定义信息
var		QNV_TOOL_GETUSERVALUE			=16;//读取用户自定义信息
var		QNV_TOOL_ISFILEEXIST			=17;//检测本地文件是否存在
var		QNV_TOOL_GETUSERVALUEI			=18;//读取用户自定义信息
var		QNV_TOOL_ISFILEEXIST			=20;//检测本地文件是否存在
var		QNV_TOOL_FSKENCODE			=21;//FSK编码
var		QNV_TOOL_WRITELOG			=22;//写文件日志->userlog目录
//------------------------------------------------------

//存储操作
var		QNV_STORAGE_PUBLIC_READ			=1;//读取共享区域数据
var		QNV_STORAGE_PUBLIC_READSTR		=2;//读取共享区域字符串数据,读到'\0'自动结束
var		QNV_STORAGE_PUBLIC_WRITE		=3;//写入共享区域数据
var		QNV_STORAGE_PUBLIC_SETREADPWD		=4;//设置读取共享区域数据的密码
var		QNV_STORAGE_PUBLIC_SETWRITEPWD		=5;//设置写入共享区域数据的密码
var		QNV_STORAGE_PUBLIC_GETSPACESIZE		=6;//获取存储空间长度


//远程操作
//RemoteType
var		QNV_REMOTE_UPLOAD_START 		=1;//上传文件到WEB服务器(http协议)
var		QNV_REMOTE_UPLOAD_DATA 			=2;//上传字符数据到WEB服务器(send/post)(保留)
var		QNV_REMOTE_UPLOAD_STOP 			=3;//上传文件到WEB服务器(http协议)
var		QNV_REMOTE_UPLOAD_LOG 			=4;//重新上传以前没有成功的记录
var		QNV_REMOTE_UPLOAD_TOTALSIZE 		=5;//获取需要上传的总共长度
var		QNV_REMOTE_UPLOAD_TRANSIZE 		=6;//获取已经上传的长度
var		QNV_REMOTE_UPLOAD_CLEARLOG 		=7;//删除所有未成功的日志
var		QNV_REMOTE_UPLOAD_COUNT 		=8;//
var		QNV_REMOTE_UPLOAD_STOPALL 		=9;//

var		QNV_REMOTE_DOWNLOAD_START 		=20;//开始下载远程文件
var		QNV_REMOTE_DOWNLOAD_STOP 		=21;//停止下载远程文件
var		QNV_REMOTE_DOWNLOAD_TOTALSIZE 		=22;//下载的总共长度
var		QNV_REMOTE_DOWNLOAD_TRANSIZE 		=23;//已经下载的长度
var		QNV_REMOTE_DOWNLOAD_COUNT 		=24;//
var		QNV_REMOTE_DOWNLOAD_STOPALL 		=25;//

var		QNV_REMOTE_SETCOOKIE 			=40;//设置HTTP连接的COOKIE

//--------------------------------------------------------

//CC控制
var		QNV_CCCTRL_SETLICENSE			=1;//设置license
var		QNV_CCCTRL_SETSERVER			=2;//设置服务器IP地址
var		QNV_CCCTRL_LOGIN		   	=3;//登陆
var		QNV_CCCTRL_LOGOUT		  	=4;//退出
var		QNV_CCCTRL_ISLOGON		   	=5;//是否登陆成功了
var		QNV_CCCTRL_REGCC		   	=6;//注册CC号码
var		QNV_CCCTRL_FINDSERVER			=7;//自动在内网搜索CC服务器,255.255.255.255表示只广播模式/0.0.0.0只轮寻模式/空表示广播+轮寻模式/其它为指定IP方式

//
//语音
var		QNV_CCCTRL_CALL_START			=1;//呼叫CC
var		QNV_CCCTRL_CALL_VOIP			=2;//VOIP代拨固话
var		QNV_CCCTRL_CALL_STOP			=3;//停止呼叫
var		QNV_CCCTRL_CALL_ACCEPT			=4;//接听来电
var		QNV_CCCTRL_CALL_BUSY			=5;//发送忙提示
var		QNV_CCCTRL_CALL_REFUSE			=6;//拒接
var		QNV_CCCTRL_CALL_STARTPLAYFILE	        =7;//播放文件
var		QNV_CCCTRL_CALL_STOPPLAYFILE	        =8;//停止播放文件
var		QNV_CCCTRL_CALL_STARTRECFILE	        =9;//开始文件录音
var		QNV_CCCTRL_CALL_STOPRECFILE		=10;//停止文件录音
var		QNV_CCCTRL_CALL_HOLD			=11;//保持通话,不影响播放文件
var		QNV_CCCTRL_CALL_UNHOLD			=12;//恢复通话
var		QNV_CCCTRL_CALL_SWITCH			=13;//呼叫转移到其它CC

var		QNV_CCCTRL_CALL_CONFHANDLE		=20;//获取呼叫句柄所在的会议句柄

//
//消息/命令
var		QNV_CCCTRL_MSG_SENDMSG			=1;//发送消息
var		QNV_CCCTRL_MSG_SENDCMD			=2;//发送命令
var		QNV_CCCTRL_MSG_REPLYWEBIM		=3;//回复WEB801消息
var		QNV_CCCTRL_MSG_REPLYWEBCHECK		=4;//应答WEB801在线状态查询
var		QNV_CCCTRL_MSG_QUERYIPINFO		=5;//查询CC的所有IP地址信息
//
//好友
var		QNV_CCCTRL_CONTACT_ADD			=1;//增加好友
var		QNV_CCCTRL_CONTACT_DELETE		=2;//删除好友
var		QNV_CCCTRL_CONTACT_ACCEPT		=3;//接受好友
var		QNV_CCCTRL_CONTACT_REFUSE		=4;//拒绝好友
var		QNV_CCCTRL_CONTACT_GET			=5;//获取好友状态

//好友信息/自己的信息
var		QNV_CCCTRL_CCINFO_OWNERCC	    	=1;//获取本人登陆的CC
var		QNV_CCCTRL_CCINFO_NICK		    	=2;//获取CC的昵称,如果没有输入CC就表示获取本人的昵称

//socket 终端控制
var		QNV_SOCKET_CLIENT_CONNECT			=1;//连接到服务器
var		QNV_SOCKET_CLIENT_DISCONNECT		=2;//断开服务器
var		QNV_SOCKET_CLIENT_STARTRECONNECT	=3;//自动重连服务器
var		QNV_SOCKET_CLIENT_STOPRECONNECT		=4;//停止自动重连服务器
var		QNV_SOCKET_CLIENT_ISCONNECTED		=5;//检测是否已经连接到服务器了
var		QNV_SOCKET_CLIENT_SENDDATA			=6;//发送数据
var		QNV_SOCKET_CLIENT_APPENDDATA		=7;//追加发送数据到队列，如果可以发送就立即发送

//UDP模块
var		QNV_SOCKET_UDP_OPEN					=1;//打开UDP模块
var		QNV_SOCKET_UDP_CLOSE				=2;//关闭UDP模块
var		QNV_SOCKET_UDP_ISOPEN				=3;//是否打开了UDP模块
var		QNV_SOCKET_UDP_SENDDATA				=4;//向目标地址/端口发送数据
//取事件定义
var QNV_EVENT_POP = 1;// 获取后自动删除当前事件,pValue->PBRI_EVENT
var QNV_EVENT_POPEX = 2;// 获取后自动删除当前事件,pValue->字符分隔格式:chid,type,handle,result,data
var QNV_EVENT_TYPE = 3;// 获取事件类型,获取后不会自动删除，获取成功后使用
											// QNV_GENERAL_EVENT_REMOVE删除该事件
var QNV_EVENT_HANDLE = 4;// 获取事件句柄值
var QNV_EVENT_RESULT = 5;// 获取事件数值
var QNV_EVENT_PARAM = 6;// 获取事件保留参数
var QNV_EVENT_DATA = 7;// 获取事件数据
var QNV_EVENT_DATAEX = 8;// 获取事件附加数据
var QNV_EVENT_REMOVE = 20;// 删除最老的事件
var QNV_EVENT_REMOVEALL = 21;// 删除所有事件
var QNV_EVENT_REGWND = 30;// 注册接收消息的窗口句柄
var QNV_EVENT_UNREGWND = 31;// 删除接收消息的窗口句柄
var QNV_EVENT_REGCBFUNC = 32;// 注册事件回调函数
var QNV_EVENT_REGCBFUNCEX = 33;// 注册事件回调函数
var QNV_EVENT_UNREGCBFUNC = 34;// 删除事件回调函数
var QNV_EVENT_GETEVENTMSGID = 100;// 查询窗口回调的消息ID,默认为BRI_EVENT_MESSAGE
var QNV_EVENT_SETEVENTMSGID = 101;// 设置窗口回调的消息ID,默认为BRI_EV
