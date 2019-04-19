var command = '';
var servicesStr='';
var servicesIds='';
var moneyTotal=0;
function selectCheck()
    {   moneyTotal=0;
        servicesStr='';
        servicesIds='';
        $('#div_services').find('input[type="checkbox"]:checked').each(function(){
           moneyTotal+=parseInt($(this).val());
           servicesStr+=$(this).attr('data')+'|';
           servicesIds+=$(this).attr('ids')+',';
        });
        $('#money').val(moneyTotal);
        if(servicesIds!='')
        {
             $.ajax({ url: 'ashx/articleClick.ashx',
            type: 'post',
            data: { command: "servicer", servicesIds: servicesIds,companyId: $('#select_company').find("option:selected").val()},
            cache: false,
            error: function() { alert(); },
            success: function(result) {
                var data = eval(result);
                
                    if (data[0].Error == 0) {
                           if(data[0].ResultStr!='')
                           {
                              var myArray=new Array();
                              myArray=data[0].ResultStr.split("|");
                            
                              var sltCity = document.getElementById("select_serviceName");
                              while (sltCity.firstChild) 
                              {
                                  sltCity.removeChild(sltCity.firstChild); 
                               }
                             
                                var sltObj = document.getElementById("select_serviceName"); 
                                var optionObj = document.createElement("option"); 
                                optionObj.value = '0';
                                optionObj.innerHTML = '请选择服务人员';
                                optionObj.selected = true;
                                sltObj.appendChild(optionObj); 
                               
                              for(var i=0;i<myArray.length-1;i++)
                              {
                                 sltObj = document.getElementById("select_serviceName");
                                 optionObj = document.createElement("option"); 
                                 optionObj.value = myArray[i].split(",")[0];
                                 optionObj.innerHTML =myArray[i].split(",")[1];
                                 sltObj.appendChild(optionObj); 
                              }
                               document.getElementById("select_serviceName").options[0].selected = true
                           }
                    }
                    
                }
             });
        }
       
    }
function selectCheckServices()
    {   
        servicesIds='';
        $('#tb_services').find('input[type="checkbox"]:checked').each(function(){
           servicesIds+=$(this).val()+',';
        });       
    }
function isPoneAvailable(str) {
        var myreg=/^[1][1,2,3,4,5,6,7,8,9][0-9]{9}$/;
        if (!myreg.test(str)) {
            return false;
        } else {
            return true;
        }
    }
function isCardNo(card) 
{ 
  var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/; 
  if(reg.test(card) === false) 
  { 
    return false; 
  } 
}
function vipChange()
{

        if($('#select_vip').find("option:selected").val()=='True')
        {
          
             $("#select_grade").attr("disabled",false);
             $("#loginTime").attr("disabled",false);
             $("#stopTime").attr("disabled",false);
        }
        else
        {
            $("#select_grade").attr("disabled",true);
            $("#loginTime").attr("disabled",true);
            $("#stopTime").attr("disabled",true);
        }

 }
    $(document).ready(function() {
        $('#login_add').bind('click', function() {
            AddLogin();
        });
        $('#login_edit').bind('click', function() {
            EditLogin();
        });
        $('#user_add').bind('click', function() {
            AddUser();
        });
        $('#user_edit').bind('click', function() {
            EditUser();
        });
        $('#company_add').bind('click', function() {
            AddCompany();
        });
        $('#company_edit').bind('click', function() {
            EditCompany();
        });
        $('#servicer_add').bind('click', function() {
            AddServicer();
        });
        $('#servicer_edit').bind('click', function() {
            EditServicer();
        });
         $('#services_add').bind('click', function() {
            AddServices();
        });
        $('#services_edit').bind('click', function() {
            EditServices();
        });
        $('#order_add').bind('click', function() {
            AddOrder();
        });
        $('#order_edit').bind('click', function() {
            EditOrder();
        });
        $('#money_add').bind('click', function() {
            AddMoney();
        });
        $('#servicesBase_add').bind('click', function() {
            AddServicesBase();
        });
        $('#servicesBase_edit').bind('click', function() {
            EditServicesBase();
        });
    });
    
function AddLogin() {
        command='addLogin';
        var login_name = $('#login_name').val();
        if (login_name == '') {
            alert('请输入登录账号');
            return;
        }
        var login_pwd = $('#login_pwd').val();
        if (login_pwd == '') {
            alert('请输入登录密码');
            return;
        }
        var login_pwd1 = $('#login_pwd1').val();
        if (login_pwd1 == '') {
            alert('请输入确认密码');
            return;
        }
        if(login_pwd!=login_pwd1)
        {
            alert("两次密码不一致");
            return;
        }
        var name = $('#name').val();
        if (name == '') {
            alert('请输入姓名');
            return;
        }
        var sex = $('#select_sex').val();
        if (sex == '') {
            alert('请选择性别');
            return;
        }
        var mobi = $('#mobi').val();
        if (mobi == '') {
            alert('请输入手机号');
            return;
        }
        if(!isPoneAvailable(mobi))
        {
            alert('请输入正确的手机号');
            return;
        }
        var tel = $('#tel').val();
        var select_type = $('#select_type').val();
        if (select_type == '') {
            alert('请选择员工类型');
            return;
        }
        $.ajax({ url: 'ashx/manage.ashx',
            type: 'post',
            data: { command: command, login_name: login_name, login_pwd: login_pwd, name: name, sex: sex, mobi: mobi, tel: tel, select_type: select_type},
            cache: false,
            error: function() { alert(); },
            success: function(result) {
                var data = eval(result);
                alert(data[0].ResultStr);
                if (data[0].Error == 0) {
                        window.location = window.location;
                }
            }
        });
    }
    
    function EditLogin() {
        command='editLogin';
        var id = $('#Hid').val();
        var login_pwd = $('#login_pwd').val();
        var login_pwd1 = $('#login_pwd1').val();
        
        if(login_pwd!=login_pwd1)
        {
            alert("两次密码不一致");
            return;
        }
        var name = $('#name').val();
        if (name == '') {
            alert('请输入姓名');
            return;
        }
        var sex = $('#select_sex').find("option:selected").val();
        if (sex == '') {
            alert('请选择性别');
            return;
        }
        var mobi = $('#mobi').val();
        if (mobi == '') {
            alert('请输入手机号');
            return;
        }
        if(!isPoneAvailable(mobi))
        {
            alert('请输入正确的手机号');
            return;
        }
        var tel = $('#tel').val();
        var select_type = $('#select_type').find("option:selected").val();
        if (select_type == '') {
            alert('请选择员工类型');
            return;
        }
        var select_company = '0';
        if(select_type=='2')
        {
            var select_company = $('#select_company').find("option:selected").val();
            if (li_comapny == '') {
                alert('请选择服务商');
                return;
            }
        }
        var isEffective = $('#select_isEffective').find("option:selected").val();
        $.ajax({ url: 'ashx/manage.ashx',
            type: 'post',
            data: { command: command,id:id,login_pwd: login_pwd, name: name, sex: sex, mobi: mobi, tel: tel, select_type: select_type,select_company:select_company,isEffective:isEffective},
            cache: false,
            error: function() { alert(); },
            success: function(result) {
                var data = eval(result);
                alert(data[0].ResultStr);
                if (data[0].Error == 0) {
                        window.location = "login_list.aspx";
                }
            }
        });
    }
    
    function deleteLogin(id, check)
    {
        if(confirm('您确定要删除该员工吗？'))
        {
            LoginDel(id, 'deleteLogin', '');
        }
    }  
    function LoginDel(id, command, value)
    {
        $.ajax({url: 'ashx/manage.ashx',  
            type: 'post',  
            data:{id:id, command:command, value:value}, 
            cache: false,
            error: function(){alert();},  
            success: function(result){
                var data = eval(result);
                alert(data[0].ResultStr);
                if(data[0].Error == 0)
                {
                    window.location = window.location;
                }
            }  
        });
    }
    
    
    function AddUser() {
        command='addUser';
        var user_no = $('#user_no').val();
        var name = $('#name').val();
        if (name == '') {
            alert('请输入姓名');
            return;
        }
        var sex = $('#select_sex').val();
        if (sex == '') {
            alert('请选择性别');
            return;
        }
        var sfz = $('#sfz').val();
        if (sfz == '') {
            alert('请输入身份证号');
            return;
        }
        if(isCardNo(sfz))
        {
            alert('请输入正确的身份证号');
            return;
        }
        var mobi = $('#mobi').val();
        if (mobi == '') {
            alert('请输入手机号');
            return;
        }
        if(!isPoneAvailable(mobi))
        {
            alert('请输入正确的手机号');
            return;
        }
        var contactName = $('#contactName').val();
        if (contactName == '') {
            alert('请输入联系人姓名');
            return;
        }
        var tontactTel1 = $('#tontactTel1').val();
        if (tontactTel1 == '') {
            alert('请输入联系人手机号');
            return;
        }
        if(!isPoneAvailable(mobi))
        {
            alert('请输入正确联系人手机号');
            return;
        }
        var tontactTel2 = $('#tontactTel2').val();

        var birthday = $('#birthday').val();
        if (birthday == '') {
            alert('请输入出生年月');
            return;
        }

        var select_bloodType = $('#select_bloodType').val();
        var nation = $('#nation').val();
        var select_marriage = $('#select_marriage').val();
        var companyName = $('#companyName').val();
        var profession = $('#profession').val();
        var address = $('#address').val();
        
        var select_vip = $('#select_vip').val();
        if (select_vip == '0') {
            alert('请选择是否会员');
            return;
        }
        var select_grade = $('#select_grade').val();
        var loginTime = $('#loginTime').val();
        var stopTime = $('#stopTime').val();
        if (stopTime == '') {
            alert('请输入到期时间');
            return;
        }
        var imei = $('#imei').val();
        $.ajax({ url: 'ashx/manage.ashx',
            type: 'post',
            data: { command: command,user_no:user_no, name: name, sex: sex,sfz:sfz, mobi: mobi,contactName:contactName,tontactTel1:tontactTel1,tontactTel2:tontactTel2, birthday: birthday, bloodType: select_bloodType,nation:nation,marriage:select_marriage,companyName:companyName,profession:profession,address:address,vip:select_vip,grade:select_grade,loginTime:loginTime,stopTime:stopTime,imei:imei},
            cache: false,
            error: function() { alert(); },
            success: function(result) {
                var data = eval(result);
                alert(data[0].ResultStr);
                if (data[0].Error == 0) {
                        window.location = window.location;
                }
            }
        });
    }
    
    function EditUser() {
        command='editUser';
        var id = $('#Hid').val();
        var user_no = $('#user_no').val();
        var name = $('#name').val();
        if (name == '') {
            alert('请输入姓名');
            return;
        }
        var sex = $('#select_sex').val();
        if (sex == '') {
            alert('请选择性别');
            return;
        }
        var sfz = $('#sfz').val();
        if (sfz == '') {
            alert('请输入身份证号');
            return;
        }
        if(isCardNo(sfz))
        {
            alert('请输入正确的身份证号');
            return;
        }
        var mobi = $('#mobi').val();
        if (mobi == '') {
            alert('请输入手机号');
            return;
        }
        if(!isPoneAvailable(mobi))
        {
            alert('请输入正确的手机号');
            return;
        }
        var contactName = $('#contactName').val();
        if (contactName == '') {
            alert('请输入联系人姓名');
            return;
        }
        var tontactTel1 = $('#tontactTel1').val();
        if (tontactTel1 == '') {
            alert('请输入联系人手机号');
            return;
        }
        if(!isPoneAvailable(mobi))
        {
            alert('请输入正确联系人手机号');
            return;
        }
        var tontactTel2 = $('#tontactTel2').val();

        var birthday = $('#birthday').val();
        if (birthday == '') {
            alert('请输入出生年月');
            return;
        }

        var select_bloodType = $('#select_bloodType').val();
        var nation = $('#nation').val();
        var select_marriage = $('#select_marriage').val();
        var companyName = $('#companyName').val();
        var profession = $('#profession').val();
        var address = $('#address').val();
        
        var select_vip = $('#select_vip').val();
        if (select_vip == '') {
            alert('请选择是否会员');
            return;
        }
        var select_grade = $('#select_grade').val();
        
        var isEffective = $('#select_isEffective').find("option:selected").val();
        var stopTime = $('#stopTime').val();
        if (stopTime == '') {
            alert('请输入到期时间');
            return;
        }
        var imei = $('#imei').val();
         
        $.ajax({ url: 'ashx/manage.ashx',
            type: 'post',
            data: { command: command,id:id,user_no:user_no, name: name, sex: sex,sfz:sfz, mobi: mobi,contactName:contactName,tontactTel1:tontactTel1,tontactTel2:tontactTel2, birthday: birthday, bloodType: select_bloodType,nation:nation,marriage:select_marriage,companyName:companyName,profession:profession,address:address,vip:select_vip,grade:select_grade,isEffective:isEffective,stopTime:stopTime,imei:imei},
            cache: false,
            error: function() { alert(); },
            success: function(result) {
                var data = eval(result);
                alert(data[0].ResultStr);
                if (data[0].Error == 0) {
                        window.location = "user_list.aspx";
                }
            }
        });
    }
    
    
    function deleteUser(id, check)
    {
        if(confirm('您确定要删除该员工吗？'))
        {
            userDel(id, 'deleteUser', '');
        }
    }  
    function userDel(id, command, value)
    {
        $.ajax({url: 'ashx/manage.ashx',  
            type: 'post',  
            data:{id:id, command:command, value:value}, 
            cache: false,
            error: function(){alert();},  
            success: function(result){
                var data = eval(result);
                alert(data[0].ResultStr);
                if(data[0].Error == 0)
                {
                    window.location = window.location;
                }
            }  
        });
    }
    
     function AddCompany() {
        command='addCompany';
       
        var name = $('#name').val();
        if (name == '') {
            alert('请输入服务商名称');
            return;
        }
        var no = $('#no').val();
        if (no == '') {
            alert('请输入营业执照号');
            return;
        }
        var fr_name = $('#fr_name').val();
        if (fr_name == '') {
            alert('请输入法人姓名');
            return;
        }
        var mobi = $('#mobi').val();
        if (mobi == '') {
            alert('请输入手机号');
            return;
        }
        if(!isPoneAvailable(mobi))
        {
            alert('请输入正确的手机号');
            return;
        }
        var tel = $('#tel').val();
        var address = $('#address').val();
        if (address == '') {
            alert('请输入服务商地址');
            return;
        }
        var stopTime = $('#stopTime').val();
        $.ajax({ url: 'ashx/manage.ashx',
            type: 'post',
            data: {command: command, name: name, no: no,fr_name:fr_name, mobi: mobi, tel: tel,address:address, stopTime: stopTime},
            cache: false,
            error: function() { alert(); },
            success: function(result) {
                var data = eval(result);
                alert(data[0].ResultStr);
                if (data[0].Error == 0) {
                        window.location = window.location;
                }
            }
        });
    }
    
    function EditCompany() {
        command='editCompany';
        var id = $('#Hid').val();
       
        var name = $('#name').val();
        if (name == '') {
            alert('请输入服务商名称');
            return;
        }
        var no = $('#no').val();
        if (no == '') {
            alert('请输入营业执照号');
            return;
        }
        var fr_name = $('#fr_name').val();
        if (fr_name == '') {
            alert('请输入法人姓名');
            return;
        }
        var mobi = $('#mobi').val();
        if (mobi == '') {
            alert('请输入手机号');
            return;
        }
        if(!isPoneAvailable(mobi))
        {
            alert('请输入正确的手机号');
            return;
        }
        var tel = $('#tel').val();
        var address = $('#address').val();
        if (address == '') {
            alert('请输入服务商地址');
            return;
        }
        var loginTime = $('#loginTime').val();
        var stopTime = $('#stopTime').val();
      
        var isEffective = $('#select_isEffective').find("option:selected").val();
        $.ajax({ url: 'ashx/manage.ashx',
            type: 'post',
            data: { command: command,id:id,name: name, no: no,fr_name:fr_name, mobi: mobi, tel: tel, address: address,loginTime:loginTime,stopTime:stopTime,isEffective:isEffective},
            cache: false,
            error: function() { alert(); },
            success: function(result) {
                var data = eval(result);
                alert(data[0].ResultStr);
                if (data[0].Error == 0) {
                        window.location ="company_list.aspx";
                }
            }
        });
    }
    
    function deleteCompany(id, check)
    {
        if(confirm('您确定要删除该服务商吗？服务商下的服务人员及服务项目将一并删除！'))
        {
            CompanyDel(id, 'deleteCompany', '');
        }
    }  
    function CompanyDel(id, command, value)
    {
        $.ajax({url: 'ashx/manage.ashx',  
            type: 'post',  
            data:{id:id, command:command, value:value}, 
            cache: false,
            error: function(){alert();},  
            success: function(result){
                var data = eval(result);
                alert(data[0].ResultStr);
                if(data[0].Error == 0)
                {
                    window.location = window.location;
                }
            }  
        });
    }
    
    function AddServicer() {
        command='addServicer';
        var no = $('#no').val();
        if (no == '') {
            alert('请输入服务人员编号');
            return;
        }
        var name = $('#name').val();
        var companyName = $('#companyName').val();
        if (name == '') {
            alert('请输入姓名');
            return;
        }
        var sex = $('#select_sex').find("option:selected").val();
        if (sex == '') {
            alert('请选择性别');
            return;
        }
        var sfz = $('#sfz').val();
        if (sfz == '') {
            alert('请输入身份证号');
            return;
        }
        var mobi = $('#mobi').val();
        if (mobi == '') {
            alert('请输入手机号');
            return;
        }
        if(!isPoneAvailable(mobi))
        {
            alert('请输入正确的手机号');
            return;
        }
        var nation = $('#nation').val();
        var education = $('#education').val();
        var height = $('#height').val();
        var weight = $('#weight').val();
        var workSituation = $('#workSituation').val();
        var physicalExamination = $('#physicalExamination').val();
        var education=$('#select_education').find("option:selected").val();
        
        var birthday = $('#birthday').val();
        var workStartTime = $('#workStartTime').val();
        var workStopTime = $('#workStopTime').val();
        var physicalExamTime = $('#physicalExamTime').val();
        var physicalExamStopTime = $('#physicalExamStopTime').val();
        var companyId = $('#HcompanyId').val();
        var address = $('#address').val();
        if (address == '') {
            alert('请输入家庭住址');
            return;
        }
        if(servicesIds=='')
        {
            alert('请选择服务项目!');
            return;
        }
        $.ajax({ url: 'ashx/manage.ashx',
            type: 'post',
            data: {command: command,  no: no,name: name,companyName:companyName,sex:sex, sfz:sfz,birthday:birthday,mobi: mobi, address:address,nation:nation, education: education,height:height,weight:weight,workSituation:workSituation,physicalExamination:physicalExamination,workStartTime:workStartTime,workStopTime:workStopTime,physicalExamTime:physicalExamTime,physicalExamStopTime:physicalExamStopTime,companyId:companyId,servicesIds:servicesIds},
            cache: false,
            error: function() { alert(); },
            success: function(result) {
                var data = eval(result);
                alert(data[0].ResultStr);
                if (data[0].Error == 0) {
                        window.location = window.location;
                }
            }
        });
    }
    
    function EditServicer() {
        command='editServicer';
        var id = $('#Hid').val();
        var no = $('#no').val();
        if (no == '') {
            alert('请输入服务人员编号');
            return;
        }
        var name = $('#name').val();
        var companyName = $('#companyName').val();
        if (name == '') {
            alert('请输入姓名');
            return;
        }
        var sex = $('#select_sex').find("option:selected").val();
        if (sex == '') {
            alert('请选择性别');
            return;
        }
        var sfz = $('#sfz').val();
        if (sfz == '') {
            alert('请输入身份证号');
            return;
        }
        var mobi = $('#mobi').val();
        if (mobi == '') {
            alert('请输入手机号');
            return;
        }
        if(!isPoneAvailable(mobi))
        {
            alert('请输入正确的手机号');
            return;
        }
        var nation = $('#nation').val();
        var education = $('#education').val();
        var height = $('#height').val();
        var weight = $('#weight').val();
        var workSituation = $('#workSituation').val();
        var physicalExamination = $('#physicalExamination').val();
        var education=$('#select_education').find("option:selected").val();
        
        var birthday = $('#birthday').val();
        var workStartTime = $('#workStartTime').val();
        var workStopTime = $('#workStopTime').val();
        var physicalExamTime = $('#physicalExamTime').val();
        var physicalExamStopTime = $('#physicalExamStopTime').val();
        var companyId = $('#HcompanyId').val();
        var address = $('#address').val();
        if (address == '') {
            alert('请输入家庭住址');
            return;
        }
        var jiFen = $('#jiFen').val();
        var isEffective = $('#select_isEffective').find("option:selected").val();
        servicesIds='';
        $('#div_services').find('input[type="checkbox"]:checked').each(function(){
           servicesIds+=$(this).attr('ids')+',';
        });
        if(servicesIds=='')
        {
            alert('请输选择服务项目');
            return;
        }
        $.ajax({ url: 'ashx/manage.ashx',
            type: 'post',
            data: {command: command,id:id, no: no,name: name,companyName:companyName,sex:sex, sfz:sfz,birthday:birthday,mobi: mobi, address:address,nation:nation, education: education,height:height,weight:weight,workSituation:workSituation,physicalExamination:physicalExamination,workStartTime:workStartTime,workStopTime:workStopTime,physicalExamTime:physicalExamTime,physicalExamStopTime:physicalExamStopTime,companyId:companyId,jiFen:jiFen,isEffective:isEffective,servicesIds:servicesIds},
            cache: false,
            error: function() { alert(); },
            success: function(result) {
                var data = eval(result);
                alert(data[0].ResultStr);
                if (data[0].Error == 0) {
                        window.location ="servicer_list.aspx";
                }
            }
        });
    }
    
    function deleteServicer(id, check)
    {
        if(confirm('您确定要删除该服务人员吗？'))
        {
            ServicerDel(id, 'deleteServicer', '');
        }
    }  
    function ServicerDel(id, command, value)
    {
        $.ajax({url: 'ashx/manage.ashx',  
            type: 'post',  
            data:{id:id, command:command, value:value}, 
            cache: false,
            error: function(){alert();},  
            success: function(result){
                var data = eval(result);
                alert(data[0].ResultStr);
                if(data[0].Error == 0)
                {
                    window.location = window.location;
                }
            }  
        });
    }
    
    
    function AddServices() {
        command='addServices';
      

        var companyId = $('#select_company').find("option:selected").val();
        var companyName = $('#select_company').find("option:selected").text();
        if (companyId == '0') {
            alert('请选择服务商');
            return;
        }
        if (servicesIds == '') {
            alert('请选择服务项目');
            return;
        }

        $.ajax({ url: 'ashx/manage.ashx',
            type: 'post',
            data: { command: command,companyId:companyId,companyName:companyName,servicesIds:servicesIds},
            cache: false,
            error: function() { alert(); },
            success: function(result) {
                var data = eval(result);
                alert(data[0].ResultStr);
//                if (data[0].Error == 0) {
//                        window.location = window.location;
//                }
            }
        });
    }
    
    function EditServices() {
        command='editServices';
        var id = $('#Hid').val();
        var companyId = $('#select_company').find("option:selected").val();
        var companyName = $('#select_company').find("option:selected").text();
        if (companyId == '0') {
            alert('请选择服务商');
            return;
        }
        var serviceName = $('#serviceName').val();
        if (serviceName == '') {
            alert('请输入项目名称');
            return;
        }
        var money = $('#money').val();
        if (money == '0') {
            alert('请输入项目金额');
            return;
        }

        
         var isEffective = $('#select_isEffective').find("option:selected").val();
        
         
        $.ajax({ url: 'ashx/manage.ashx',
            type: 'post',
            data: { command: command,id:id,companyId:companyId,companyName:companyName,serviceName:serviceName,money:money,isEffective:isEffective},
            cache: false,
            error: function() { alert(); },
            success: function(result) {
                var data = eval(result);
                alert(data[0].ResultStr);
                if (data[0].Error == 0) {
                        window.location = "services_list.aspx";
                }
            }
        });
    }
    
    
    function deleteServices(id, check)
    {
        if(confirm('您确定要删除该服务项目吗？'))
        {
            servicesDel(id, 'deleteServices', '');
        }
    }  
    function servicesDel(id, command, value)
    {
        $.ajax({url: 'ashx/manage.ashx',  
            type: 'post',  
            data:{id:id, command:command, value:value}, 
            cache: false,
            error: function(){alert();},  
            success: function(result){
                var data = eval(result);
                alert(data[0].ResultStr);
                if(data[0].Error == 0)
                {
                    window.location = window.location;
                }
            }  
        });
    }
    
    function AddOrder() {
        command='addOrder';
        var order_no = $('#order_no').val();
        var userId = $('#userId').val();
        if (userId == '') {
            alert('请输入会员编号');
            return;
        }
        userId = $('#HuserId').val();
        var userName = $('#userName').val();
        var userTel = $('#userTel').val();
        var userAddress = $('#userAddress').val();
        var payType = $('#select_payType').find("option:selected").val();
        if (payType == '') {
            alert('请选择支付方式');
            return;
        }
        var companyId = $('#select_company').find("option:selected").val();
        var companyName = $('#select_company').find("option:selected").text();
        if (companyId == '0') {
            alert('请选择服务商');
            return;
        }
        if(servicesIds=='')
        {
            alert('请选择服务项目');
            return;
        }
        var serviceID = $('#select_serviceName').find("option:selected").val();
        if (serviceID == '0') {
            alert('请选择服务人员姓名');
            return;
        }
        var serviceName = $('#select_serviceName').find("option:selected").text();
        var loginId = $('#HloginId').val();
        var loginName = $('#loginName').val();
        var state = $('#select_state').val();
        if (state == '') {
            alert('请选择订单状态');
            return;
        }
        if (servicesStr == '') {
            alert('请选择服务项目');
            return;
        }
        var services=servicesStr;
        var money=moneyTotal;
        var startTime= $('#startTime').val();
        var stopTime= $('#stopTime').val();
        var Remarks=$('#Remarks').val();
        $.ajax({ url: 'ashx/manage.ashx',
            type: 'post',
            data: { command: command,order_no:order_no,userId:userId,userName:userName,userTel:userTel,companyId:companyId,companyName:companyName,payType:payType,userAddress:userAddress,serviceID:serviceID,serviceName:serviceName,loginId:loginId,loginName:loginName,state:state,servicesIds:servicesIds,services:services,money:money,startTime:startTime,stopTime:stopTime,Remarks:Remarks},
            cache: false,
            error: function() { alert(); },
            success: function(result) {
                var data = eval(result);
                alert(data[0].ResultStr);
                if (data[0].Error == 0) {
                        window.location = window.location;
                }
            }
        });
    }
    
    function EditOrder() {
        command='editOrder';
        var id = $('#Hid').val();
        var userTel = $('#userTel').val();
        var userAddress = $('#userAddress').val();
        var payType = $('#select_payType').find("option:selected").val();
        if (payType == '') {
            alert('请选择支付方式');
            return;
        }
        var companyId = $('#select_company').find("option:selected").val();
        var companyName = $('#select_company').find("option:selected").text();
        if (companyId == '0') {
            alert('请选择服务商');
            return;
        }
        var serviceID = $('#select_serviceName').find("option:selected").val();
        if (serviceID == '0') {
            alert('请选择服务人员姓名');
            return;
        }
        var serviceName = $('#select_serviceName').find("option:selected").text();
        var state = $('#select_state').find("option:selected").val();
        if (state == '') {
            alert('请选择订单状态');
            return;
        }
        var services=servicesStr;
        if (services == '') {
            services="aa"
        }
        var money=$('#money').val();
        var startTime= $('#startTime').val();
        var stopTime= $('#stopTime').val();
        
         
        $.ajax({ url: 'ashx/manage.ashx',
            type: 'post',
            data: { command: command,id:id,userTel:userTel,userAddress:userAddress,payType:payType,companyId:companyId,companyName:companyName,serviceID:serviceID,serviceName:serviceName,state:state,services:services,money:money,startTime:startTime,stopTime:stopTime},
            cache: false,
            error: function() { alert(); },
            success: function(result) {
                var data = eval(result);
                alert(data[0].ResultStr);
                if (data[0].Error == 0) {
                        window.location = "order_list.aspx";
                }
            }
        });
    }
    
    
    function deleteOrder(id, check)
    {
        if(confirm('您确定要删除该员工吗？'))
        {
            OrderDel(id, 'deleteOrder', '');
        }
    }  
    function OrderDel(id, command, value)
    {
        $.ajax({url: 'ashx/manage.ashx',  
            type: 'post',  
            data:{id:id, command:command, value:value}, 
            cache: false,
            error: function(){alert();},  
            success: function(result){
                var data = eval(result);
                alert(data[0].ResultStr);
                if(data[0].Error == 0)
                {
                    window.location = window.location;
                }
            }  
        });
    }
    
    
    function AddMoney() {
        command='addMoney';
        var userName = $('#userName').val();
        if (userName == '') {
            alert('请输入正确会员编号');
            return;
        }
        
        var userNo = $('#userNo').val();
        var userId = $('#HuserId').val();
        var userTel = $('#userTel').val();
        var type = $('#select_type').val();
        if (type == '') {
            alert('请选择充/退值选项');
            return;
        }
        var userMoney = $('#userMoney').val();
        if (userMoney == '') {
            alert('请输入金额');
            return;
        }
        var addName = $('#HaddName').val();
        $.ajax({ url: 'ashx/manage.ashx',
            type: 'post',
            data: { command: command, userId: userId, userName: userName,userTel:userTel, userNo: userNo, type: type, userMoney: userMoney,addName:addName},
            cache: false,
            error: function() { alert(); },
            success: function(result) {
                var data = eval(result);
                alert(data[0].ResultStr);
                if (data[0].Error == 0) {
                        window.location = window.location;
                }
            }
        });
    }
    
    
     function AddServicesBase() {
        command='addServicesBase';
      

        var type = $('#select_type').find("option:selected").val();
        if (type == '0') {
            alert('请选择服务项目类型');
            return;
        }
        var name = $('#name').val();
        if (name == '') {
            alert('请输入项目名称');
            return;
        }
        var price = $('#price').val();
        if (price == '') {
            alert('请输入项目金额');
            return;
        }
        var unit = $('#select_unit').find("option:selected").val();
        if (unit == '') {
            alert('请选择单位');
            return;
        }
        var remarks = $('#remarks').val();
        $.ajax({ url: 'ashx/manage.ashx',
            type: 'post',
            data: { command: command,type:type,name:name,price:price,unit:unit,remarks:remarks},
            cache: false,
            error: function() { alert(); },
            success: function(result) {
                var data = eval(result);
                alert(data[0].ResultStr);
//                if (data[0].Error == 0) {
//                        window.location = window.location;
//                }
            }
        });
    }
    
    function EditServicesBase() {
        command='editServicesBase';
        var id = $('#Hid').val();
        var type = $('#select_type').find("option:selected").val();
        if (type == '0') {
            alert('请选择服务项目类型');
            return;
        }
        var name = $('#name').val();
        if (name == '') {
            alert('请输入项目名称');
            return;
        }
        var price = $('#price').val();
        if (price == '') {
            alert('请输入项目金额');
            return;
        }
        var unit = $('#select_unit').find("option:selected").val();
        if (unit == '') {
            alert('请选择单位');
            return;
        }
        var remarks = $('#remarks').val();

        
        
         
        $.ajax({ url: 'ashx/manage.ashx',
            type: 'post',
            data: { command: command,id:id,type:type,name:name,price:price,unit:unit,remarks:remarks},
            cache: false,
            error: function() { alert(); },
            success: function(result) {
                var data = eval(result);
                alert(data[0].ResultStr);
                if (data[0].Error == 0) {
                        window.location = "servicesBase_list.aspx";
                }
            }
        });
    }
    
    
    function deleteServicesBase(id, check)
    {
        if(confirm('您确定要删除该服务项目吗？'))
        {
            servicesBaseDel(id, 'deleteServicesBase', '');
        }
    }  
    function servicesBaseDel(id, command, value)
    {
        $.ajax({url: 'ashx/manage.ashx',  
            type: 'post',  
            data:{id:id, command:command, value:value}, 
            cache: false,
            error: function(){alert();},  
            success: function(result){
                var data = eval(result);
                alert(data[0].ResultStr);
                if(data[0].Error == 0)
                {
                    window.location = window.location;
                }
            }  
        });
    }