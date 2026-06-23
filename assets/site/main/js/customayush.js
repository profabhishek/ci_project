var text_max = 500;
var checklist = [];
var applicant_checklist = ["1","2","5","6","9"];
var applicant_check = [];
var mission_check = [];
var mission_checklist = ["3","4","8","10","11"];
var Codes = [];
var idleTime = 0;
var universityLetterId = "";
var universityId = 0;
var universityOption = 0;
var courseList = [];

var balanceSheet = [{
	firstQuarter : {
		openingBalance : 0,
		fundReceived : 0,
		totalFund : 0,
		fundUtilize : 0,
		fundBalance : 0
	},
	secondQuarter : {
		openingBalance : 0,
		fundReceived : 0,
		totalFund : 0,
		fundUtilize : 0,
		fundBalance : 0
	},
	thirdQuarter : {
		openingBalance : 0,
		fundReceived : 0,
		totalFund : 0,
		fundUtilize : 0,
		fundBalance : 0
	},
	fourthQuarter : {
		openingBalance : 0,
		fundReceived : 0,
		totalFund : 0,
		fundUtilize : 0,
		fundBalance : 0
	}
}];
function getCurrentQuarter()
{
	var years = getCurrentFiscalYear();
	var yearsAr = years.split('-');
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();
	if(dd<10) {
	    dd='0'+dd
	} 
	if(mm<10) {
	    mm='0'+mm
	} 
	today = dd+'/'+mm+'/'+yyyy;

	var darray = today.split('/');
  	var month = darray[1];
  	var quarter;var returnmonth =0;
	if (yyyy == yearsAr[1] && month < 4)
	  quarter = 04;
	else if (yyyy == yearsAr[0] && month < 7 && month >= 4)
	  quarter = 01;
	else if (yyyy == yearsAr[0] && month < 10 && month >= 7)
	 quarter = 02;
	else if (yyyy == yearsAr[0] && month < 13 && month >= 10)
	  quarter = 03;
	  
	  return quarter;
}
function getCurrentFiscalYear() {
    //get current date
    var today = new Date();
    
    //get current month
    var curMonth = today.getMonth();
    
    var fiscalYr = "";
    if (curMonth > 3) { //
        var nextYr1 = (today.getFullYear() + 1).toString();
        fiscalYr = today.getFullYear().toString() + "-" + nextYr1;
    } else {
        var nextYr2 = today.getFullYear().toString();
        fiscalYr = (today.getFullYear() - 1).toString() + "-" + nextYr2;
    }
    
    return fiscalYr;
 }
var years = getCurrentFiscalYear();
	var yearsAr = years.split('-');
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();
	if(dd<10) {
	    dd='0'+dd
	} 
	if(mm<10) {
	    mm='0'+mm
	} 
	today = dd+'/'+mm+'/'+yyyy;

	var darray = today.split('/');
  	var month = darray[1];
  	var quarter;var returnmonth =0;
	if (yyyy == yearsAr[1] && month < 4)
	  quarter = 04;
	else if (yyyy == yearsAr[0] && month < 7 && month >= 4)
	  quarter = 01;
	else if (yyyy == yearsAr[0] && month < 10 && month >= 7)
	 quarter = 02;
	else if (yyyy == yearsAr[0] && month < 13 && month >= 10)
	  quarter = 03;



$(document).ready(function () {
		$("input[name$='optradio']").click(function() {
        var is_app = $(this).val();
		if(is_app == 1)
		{
		$("#app_div").show();
        $('#year').attr("required",true);
		}
		else
		{
		$("#app_div").hide();
		$('#year').attr("required",false);
		}
    }); 
	$('#password').keyup(function() {
    var pswd = $(this).val();
    if ( pswd.length < 8 ) {
    $('#length').removeClass('valid').addClass('invalid');
	} else {
	    $('#length').removeClass('invalid').addClass('valid');
	}
	if ( pswd.match(/[A-z]/) ) {
    $('#letter').removeClass('invalid').addClass('valid');
	} else {
	    $('#letter').removeClass('valid').addClass('invalid');
	}

	//validate capital letter
	if ( pswd.match(/[A-Z]/) ) {
	    $('#capital').removeClass('invalid').addClass('valid');
	} else {
	    $('#capital').removeClass('valid').addClass('invalid');
	}
	//validate number
	if ( pswd.match(/\d/) ) {
	    $('#number').removeClass('invalid').addClass('valid');
	} else {
	    $('#number').removeClass('valid').addClass('invalid');
	}
	if ( pswd.match(/[!@#$%^&*()_]/) ) {
	    $('#specChar').removeClass('invalid').addClass('valid');
	} else {
	    $('#specChar').removeClass('valid').addClass('invalid');
	}
	
	}).focus(function() {
	    $('#pswd_info').show();
	}).blur(function() {
	    $('#pswd_info').hide();
	});	
	
	$('#newpassword').keyup(function() {
		var pswd = $(this).val();
    if ( pswd.length < 8 ) {
    $('#length').removeClass('valid').addClass('invalid');
	} else {
	    $('#length').removeClass('invalid').addClass('valid');
	}
	if ( pswd.match(/[A-z]/) ) {
    $('#letter').removeClass('invalid').addClass('valid');
	} else {
	    $('#letter').removeClass('valid').addClass('invalid');
	}

	//validate capital letter
	if ( pswd.match(/[A-Z]/) ) {
	    $('#capital').removeClass('invalid').addClass('valid');
	} else {
	    $('#capital').removeClass('valid').addClass('invalid');
	}
	//validate number
	if ( pswd.match(/\d/) ) {
	    $('#number').removeClass('invalid').addClass('valid');
	} else {
	    $('#number').removeClass('valid').addClass('invalid');
	}
	if ( pswd.match(/[!@#$%^&*()_]/) ) {
	    $('#specChar').removeClass('invalid').addClass('valid');
	} else {
	    $('#specChar').removeClass('valid').addClass('invalid');
	}
	
	}).focus(function() {
	    $('#pswd_info').show();
	}).blur(function() {
	    $('#pswd_info').hide();
	});	
	
	/* Block Special Character */
	$('#captchatext,#userCaptcha').keyup(function(e){
		 var str = $(this).val();
	    var regex=/[^a-zA-Z0-9]/gi;
	    $(this).val(str.replace(regex ,""));	
	});
	$('#student_name').keyup(function(e){
		 var str = $(this).val();
	    var regex=/[^a-zA-Z ]/gi;
	    $(this).val(str.replace(regex ,""));	
	});
	
	
	$('textarea').keyup(function(e){
		blockSpecialChar(e);	
	});
	
		
	$(".btn-pref .btn").click(function () {
    $(".btn-pref .btn").removeClass("bg-green").addClass("btn-default");
    // $(".tab").addClass("active"); // instead of this do the below 
    $(this).removeClass("btn-default").addClass("bg-green");   
	});	
	
	
	
		
	window.setTimeout(function() {
	    $(".alert").fadeTo(500, 0).slideUp(500, function(){
	       // $(this).remove(); 
	    });
	}, 6000);
    //Increment the idle time counter every minute.
    var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

    //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
        idleTime = 0;
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });
});
function updateId(id,uniid,opt)
{
	universityLetterId = id;
	universityId = uniid;
	universityOption = opt;
}
function blockSpecialChar(e){
	var k;
	document.all ? k = e.keyCode : k = e.which;
	return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
}
function timerIncrement() {
    idleTime = idleTime + 1;   
    if (idleTime > 25) { // 20 minutes          
        if(isLogin == 'true')
        {
        	$.ajax({
		    type: "POST",
		    url: redirectLink,	 
		    dataType:'json',		    
		    success: function (data) {
		    	
		    }
		   }); 	
		   if(!$("body").hasClass("modal-open"))
			{
				  BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Session Out" ,message: "You have been logged out due to inactivity. Please login again."  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();location.reload();}}]});
			}
		 
		}
    }
}

$(function() {
            $( "#datepicker-13" ).datepicker();
            $( "#datepicker-13" ).datepicker("show");
			
			
			
			$( "#datepicker-14" ).datepicker();
            $( "#datepicker-14" ).datepicker("show");
         });


function showduration(id,ctype)
{
	var valueFY = $('#aca_year').val();
	var FY_array = valueFY.split('-');
	$("#date_from").datepicker("destroy");
	$('#date_from').datepicker({
	    changeMonth: true,
	    changeYear: true,
	    showButtonPanel: false,
	    dateFormat: 'm/yy',
	    maxDate: new Date(FY_array[1],5,30),
	    minDate: new Date(FY_array[0],6,01)
	});
	$("#date_from").datepicker("refresh");
	
	$("#date_to").datepicker("destroy");
	$('#date_to').datepicker({
	    changeMonth: true,
	    changeYear: true,
	    showButtonPanel: false,
	    dateFormat: 'm/yy',
	   maxDate: new Date(FY_array[1],5,30),
	    minDate: new Date(FY_array[0],6,01)
	});
	$("#date_to").datepicker("refresh");
	
}
function orderOptgroups() {
    $("select optgroup:eq(0)").each(function() {
        var $select = $(this);
        var $groups = $select.find("optgroup");
        $groups.remove();
        $groups = $groups.sort(function(g1, g2) {
            return g1.label.localeCompare(g2.label);      
        });      
        $select.append($groups);
        $groups.each(function() {
            var $group = $(this);
            var options = $group.find("option");
            options.remove();
            options = options.sort(function(a, b) {
                return a.innerHTML.localeCompare(b.innerHTML);
            });
            $group.append(options);
        });
    });
}
function showReport(appno)
{
	var fy = "";
	if($('#fy_year').val()!="")
	{
		fy = $('#fy_year').val();
		location.href = baseURL + "regional/expenditureReportofStudent/" + appno + "/" + fy;
	}
	else
	{
		BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error" ,message: "Select Financial Year First!"  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]}); 
	}
}
function showOtherCity(id)
{
	var ctyval = $('#' + id).val();
	if(ctyval==7)
	{
		$('.ctyother').addClass("in");
	}
	else
	{
		$('.ctyother').removeClass("in");
	}
}
function getQuarter(d) {
  var darray = d.split('/');
  var month = darray[1];
  var quarter;var returnmonth =0;
	if (month < 4)
	  returnmonth = 03;
	else if (month < 7 && month >= 4)
	  returnmonth = 06;
	else if (month < 10 && month >= 7)
	 returnmonth = 09;
	else if (month < 13 && month >= 10)
	  returnmonth = 12;
	  
	return returnmonth; 
}
function getdt(m)
{
	if(m == 0 || m == 2 || m == 4 || m == 6 || m ==  7 || m == 9 || m == 11)
		return 31;
	else if(m == 3 || m == 5 || m == 8 || m ==  10)	
		return 30;
	else if(m == 1)	
		return 28;	
}
$(function(){	
	
	
	
	$('#aca_year').change(function(){
		
		var valueFY = $('#aca_year').val();
		var FY_array = valueFY.split('-');
		$("#date_from").datepicker("destroy");
		$('#date_from').datepicker({
		    changeMonth: true,
		    changeYear: true,
		    showButtonPanel: false,
		    dateFormat: 'm/yy',
		    maxDate: new Date(FY_array[1],05,30),
		    minDate: new Date(FY_array[0],6,01)
		});
		$("#date_from").datepicker("refresh");
		
		$("#date_to").datepicker("destroy");
		$('#date_to').datepicker({
		    changeMonth: true,
		    changeYear: true,
		    showButtonPanel: false,
		    dateFormat: 'm/yy',
		    maxDate: new Date(FY_array[1],05,30),
		    minDate: new Date(FY_array[0],06,01)
		});
		$("#date_to").datepicker("refresh");
		
	});	

	
	$('.FY_DATEPICKER').change(function(){
		//alert('ok');
		var valueFY = $(this).val();
		var FY_array = valueFY.split('-');
		$('.fy').text(valueFY);
		$(".fyDatepicker").datepicker("destroy");
		$('.fyDatepicker').datepicker({
		    changeMonth: true,
		    changeYear: true,
		    showButtonPanel: false,
		    dateFormat: 'd/m/yy',
		    maxDate: new Date(FY_array[1],2,31),
		    minDate: new Date(FY_array[0],3,01),
		    onSelect: function(value, date) { 
            	var id = $(this).attr("id");
            	var quarter =0;var start =0; var endm =0; var dd =31;
            	switch(id)
            	{
					case "nd_from_date":					
					var vsls = value.split('/');
					quarter = getQuarter(value);					
					start = parseInt(parseInt(vsls[1])-1);
					endm = parseInt(parseInt(quarter)-1);					
					dd = 31;
					dd = getdt(endm);
					$("#nd_to_date").datepicker("destroy");
					$('#nd_to_date').datepicker({
					    changeMonth: true,
					    changeYear: true,
					    dateFormat: 'd/m/yy',
					    showButtonPanel: false,
					    maxDate: new Date(vsls[2],endm,dd),
					    minDate: new Date(vsls[2],start,01)
		    		});
		    		$("#nd_to_date").datepicker("refresh");
					break;
					case "op_from_date":					
					var vsls = value.split('/');
					quarter = getQuarter(value);					
					start = parseInt(parseInt(vsls[1])-1);
					endm = parseInt(parseInt(quarter)-1);					
					dd = 31;
					dd = getdt(endm);
					$("#op_to_date").datepicker("destroy");
					$('#op_to_date').datepicker({
					    changeMonth: true,
					    changeYear: true,
					    dateFormat: 'd/m/yy',
					    showButtonPanel: false,
					    maxDate: new Date(vsls[2],endm,dd),
					    minDate: new Date(vsls[2],start,01)
		    		});
		    		$("#op_to_date").datepicker("refresh");
					break;
					/*case "adv_stipend_from_date":					
					var vsls = value.split('/');
					quarter = getQuarter(value);					
					start = parseInt(parseInt(vsls[1])-1);
					endm = parseInt(parseInt(quarter)-1);					
					dd = 31;
					dd = getdt(endm);
					$("#adv_stipend_to_date").datepicker("destroy");
					$('#adv_stipend_to_date').datepicker({
					    changeMonth: true,
					    changeYear: true,
					     dateFormat: 'd/m/yy',
					    showButtonPanel: false,
					    maxDate: new Date(vsls[2],endm,dd),
					    minDate: new Date(vsls[2],start,01)
		    		});
		    		$("#adv_stipend_to_date").datepicker("refresh");
					break;*/
					case "stipend_from_date":					
					var vsls = value.split('/');
					quarter = getQuarter(value);					
					start = parseInt(parseInt(vsls[1])-1);
					endm = parseInt(parseInt(quarter)-1);					
					dd = 31;
					dd = getdt(endm);
					$("#stipend_to_date").datepicker("destroy");
					$('#stipend_to_date').datepicker({
					    changeMonth: true,
					    changeYear: true,
					    showButtonPanel: false,
					     dateFormat: 'd/m/yy',
					    maxDate: new Date(vsls[2],endm,dd),
					    minDate: new Date(vsls[2],start,01)
		    		});
		    		$("#stipend_to_date").datepicker("refresh");
					break;
					case "hra_from_date":					
					var vsls = value.split('/');
					quarter = getQuarter(value);					
					start = parseInt(parseInt(vsls[1])-1);
					endm = parseInt(parseInt(quarter)-1);					
					dd = 31;
					dd = getdt(endm);
					$("#hra_to_date").datepicker("destroy");
					$('#hra_to_date').datepicker({
					    changeMonth: true,
					    changeYear: true,
					    showButtonPanel: false,
					     dateFormat: 'd/m/yy',
					    maxDate: new Date(vsls[2],endm,dd),
					    minDate: new Date(vsls[2],start,01)
		    		});
		    		$("#hra_to_date").datepicker("refresh");
					break;
					case "st_from_date":					
					var vsls = value.split('/');
					quarter = getQuarter(value);					
					start = parseInt(parseInt(vsls[1])-1);
					endm = parseInt(parseInt(quarter)-1);					
					dd = 31;
					dd = getdt(endm);
					$("#st_to_date").datepicker("destroy");
					$('#st_to_date').datepicker({
					    changeMonth: true,
					    changeYear: true,
					    showButtonPanel: false,
					     dateFormat: 'd/m/yy',
					    maxDate: new Date(vsls[2],endm,dd),
					    minDate: new Date(vsls[2],start,01)
		    		});
		    		$("#st_to_date").datepicker("refresh");
					break;
					case "hos_from":					
					var vsls = value.split('/');
					quarter = getQuarter(value);					
					start = parseInt(parseInt(vsls[1])-1);
					endm = parseInt(parseInt(quarter)-1);					
					dd = 31;
					dd = getdt(endm);
					$("#hos_to").datepicker("destroy");
					$('#hos_to').datepicker({
					    changeMonth: true,
					    changeYear: true,
					     dateFormat: 'd/m/yy',
					    showButtonPanel: false,
					    maxDate: new Date(vsls[2],endm,dd),
					    minDate: new Date(vsls[2],start,01)
		    		});
		    		$("#hos_to").datepicker("refresh");
					break;
					case "ebc_from_date":					
					var vsls = value.split('/');
					quarter = getQuarter(value);					
					start = parseInt(parseInt(vsls[1])-1);
					endm = parseInt(parseInt(quarter)-1);					
					dd = 31;
					dd = getdt(endm);
					$("#ebc_to_date").datepicker("destroy");
					$('#ebc_to_date').datepicker({
					    changeMonth: true,
					    changeYear: true,
					     dateFormat: 'd/m/yy',
					    showButtonPanel: false,
					    maxDate: new Date(vsls[2],endm,dd),
					    minDate: new Date(vsls[2],start,01)
		    		});
		    		$("#ebc_to_date").datepicker("refresh");
					break;
					case "camps_from_date":					
					var vsls = value.split('/');
					quarter = getQuarter(value);					
					start = parseInt(parseInt(vsls[1])-1);
					endm = parseInt(parseInt(quarter)-1);					
					dd = 31;
					dd = getdt(endm);
					$("#camps_to_date").datepicker("destroy");
					$('#camps_to_date').datepicker({
					    changeMonth: true,
					    changeYear: true,
					     dateFormat: 'd/m/yy',
					    showButtonPanel: false,
					    maxDate: new Date(vsls[2],endm,dd),
					    minDate: new Date(vsls[2],start,01)
		    		});
		    		$("#camps_to_date").datepicker("refresh");
					break;
					case "isa_from_date":					
					var vsls = value.split('/');
					quarter = getQuarter(value);					
					start = parseInt(parseInt(vsls[1])-1);
					endm = parseInt(parseInt(quarter)-1);					
					dd = 31;
					dd = getdt(endm);
					$("#isa_to_date").datepicker("destroy");
					$('#isa_to_date').datepicker({
					    changeMonth: true,
					    changeYear: true,
					     dateFormat: 'd/m/yy',
					    showButtonPanel: false,
					    maxDate: new Date(vsls[2],endm,dd),
					    minDate: new Date(vsls[2],start,01)
		    		});
		    		$("#isa_to_date").datepicker("refresh");
					break;
					case "sump_from_date":					
					var vsls = value.split('/');
					quarter = getQuarter(value);					
					start = parseInt(parseInt(vsls[1])-1);
					endm = parseInt(parseInt(quarter)-1);					
					dd = 31;
					dd = getdt(endm);
					$("#sump_to_date").datepicker("destroy");
					$('#sump_to_date').datepicker({
					    changeMonth: true,
					    changeYear: true,
					     dateFormat: 'd/m/yy',
					    showButtonPanel: false,
					    maxDate: new Date(vsls[2],endm,dd),
					    minDate: new Date(vsls[2],start,01)
		    		});
		    		$("#sump_to_date").datepicker("refresh");
					break;
					case "ef_from_date":					
					var vsls = value.split('/');
					quarter = getQuarter(value);					
					start = parseInt(parseInt(vsls[1])-1);
					endm = parseInt(parseInt(quarter)-1);					
					dd = 31;
					dd = getdt(endm);
					$("#ef_to_date").datepicker("destroy");
					$('#ef_to_date').datepicker({
					    changeMonth: true,
					    changeYear: true,
					     dateFormat: 'd/m/yy',
					    showButtonPanel: false,
					    maxDate: new Date(vsls[2],endm,dd),
					    minDate: new Date(vsls[2],start,01)
		    		});
		    		$("#ef_to_date").datepicker("refresh");
					break;
					case "sd_from_date":					
					var vsls = value.split('/');
					quarter = getQuarter(value);					
					start = parseInt(parseInt(vsls[1])-1);
					endm = parseInt(parseInt(quarter)-1);					
					dd = 31;
					dd = getdt(endm);
					$("#sd_to_date").datepicker("destroy");
					$('#sd_to_date').datepicker({
					    changeMonth: true,
					    changeYear: true,
					     dateFormat: 'd/m/yy',
					    showButtonPanel: false,
					    maxDate: new Date(vsls[2],endm,dd),
					    minDate: new Date(vsls[2],start,01)
		    		});
		    		$("#sd_to_date").datepicker("refresh");
					break;
					case "ded_from":					
					var vsls = value.split('/');
					quarter = getQuarter(value);					
					start = parseInt(parseInt(vsls[1])-1);
					endm = parseInt(parseInt(quarter)-1);					
					dd = 31;
					dd = getdt(endm);
					$("#ded_to").datepicker("destroy");
					$('#ded_to').datepicker({
					    changeMonth: true,
					    changeYear: true,
					     dateFormat: 'd/m/yy',
					    showButtonPanel: false,
					    maxDate: new Date(vsls[2],endm,dd),
					    minDate: new Date(vsls[2],start,01)
		    		});
		    		$("#ded_to").datepicker("refresh");
					break;
					
				}    
            } 
		});
		 $( ".fyDatepicker" ).datepicker("refresh");
	});

	/*
	foreach($stateuniversities as $univercity)
	{											
		if(array_key_exists($univercity['state_id'],$statewiseUniversites))
		{													
			array_push($statewiseUniversites[$univercity['state_id']],$univercity);
		}
	}	 
	foreach($statewiseUniversites as $key=>$univercity1)
	{
		if(sizeof($univercity1)>0)
		{
			$statenames = $this->common_model->getStateById($key);
			echo '<optgroup label="&nbsp;&nbsp;&nbsp;'.$statenames[0]['name'].'">';
			foreach($univercity1 as $uni_choice)
			{
				if(!empty($applicaitonStepOne))
			  	{											  		
					if($applicaitonStepOne[0]['universty_choice'] == $uni_choice['id'])
					{
						echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
					}
					else
					{														
						echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
					}
				}
				else
				{
					echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
				}	
			}
			echo '</optgroup>';			
		}	
	}
*/

if(typeof stateuniversities != 'undefined')
{
	for(var i=0; i<stateuniversities.length;i++)
	{
		if(statesarray.hasOwnProperty(stateuniversities[i].state_id))
		{
			//statesarray[stateuniversities[i].state_id].push(stateuniversities[i]);
		}
	}	
}
$('#course_types').change(function(){
		
		
	
	$("#universty_choice").html("<option value=''>-- Select --</option>");
	$("#universty_choice_two").html("<option value=''>-- Select --</option>");
	$("#universty_choice_three").html("<option value=''>-- Select --</option>");	
	$("#universty_choice_fourth").html("<option value=''>-- Select --</option>");
	
	$('.unidiv1 .course_option_name > #course_option_name').val("");
	$('.unidiv2 .course_option_name_two > #course_option_name_two').val("");
	$('.unidiv3 .course_option_name_three > #course_option_name_three').val("");
	$('.unidiv3 .course_option_name_fourth > #course_option_name_fourth').val("");
		
	var programme=$('#programmeayush').val();
	var courseType = $(this).val();
	//console.log(courset);
	if(courseType == 1)
	{
		var agrihtml = "";
		for(var j=0; j<Object.keys(ayush).length;j++)
		{
			agrihtml += "<option value='"+ ayush[j].id +"'>" + ayush[j].uni + "</option>";
		}
	
		$("#universty_choice_fourth").html(agrihtml);
		//$("#course_fourth").val(courset);
	}
	else if(courseType == 2)
	{
		var icarhtml = "";
		for(var j=0; j<Object.keys(icar).length;j++)
		{
			icarhtml += "<option value='"+ icar[j].id +"'>" + icar[j].uni + "</option>";
		}
		$("#universty_choice").html(icarhtml);
		$("#universty_choice_two").html(icarhtml);
		$("#universty_choice_three").html(icarhtml);	
		
	}
	
	$('.course_option_name').addClass("fade in");	
		var frmdata = new FormData();		
		frmdata.append('programme', programme);	
		frmdata.append('course_type', courseType);		
		frmdata.append(csrfName, csrfHash);	
		$.ajax({
		    type: "POST",
		    url: baseURL +'applicant/getCourseByPrgramme',	   
		    data: frmdata,
		    dataType:'json',
		    processData: false,
	   		contentType: false,
		    success: function (data) {
		    	csrfName = data.csrfName;
				csrfHash = data.csrfHash;
				var htm = "<option value=''>Select Course</option>";
				courseList = [];
		    	if(data.status == true)
	    		{	
	    			courseList = data.data;
					if(data.data.length > 0)
					{
						for(var i=0; i<data.data.length; i++)
						{
							htm += "<option value='"+ data.data[i].id +"'>" + data.data[i].title + "</option>";
						}
						
					}
					$("#course").html(htm);
					$("#course_two").html(htm);
					$("#course_three").html(htm);
					$("#course_fourth").html(htm);
					//$("#course_fourth").prop('readonly','true');
	    	 		$("#programme").val(programme);
	    	 		
	    	 		/* Bind Universities */
	    	 		stateuniversities = [];	
	    	 		centralUniversities = [];    	 		
	    	 		stateuniversities = data.stateUniversities;	 
	    	 		centralUniversities = data.centralUniversities;	 
	    	 	for (var member in statesarray) 
	    	 		statesarray[member]=[];  
	    	 			 		
	    	 	if(typeof stateuniversities != 'undefined')
				{
					for(var i=0; i<stateuniversities.length;i++)
					{
						if(statesarray.hasOwnProperty(stateuniversities[i].state_id))
						{							
							
							statesarray[stateuniversities[i].state_id].push(stateuniversities[i]);
						}
					}	
				}	
	    	 	if(courseType == 3 || courseType == 4 )
				{
			
			var stateuniHtml = "";var centralUniHtml = "";var NITHtml ="";
			stateuniHtml +=" <optgroup label='State Universities'>";
			centralUniHtml +="<optgroup label='Central Universities'>";
			NITHtml +="<optgroup label='National Institute of Technology (NIT)'>";
			for(var j=1; j<=Object.keys(statesarray).length;j++)
			{			
				if(statesarray[j].length > 0)
				{									
					stateuniHtml +="<optgroup label='"+statesarray[j][0].name+"'>";
					for(var k=0; k<statesarray[j].length;k++)
					{
						stateuniHtml += "<option value='"+ statesarray[j][k].id +"'>" + statesarray[j][k].uni + "</option>";
					}
					stateuniHtml +="</optgroup>";
				}
			}	
			stateuniHtml +=" </optgroup>";
			for(var j=0; j<centralUniversities.length;j++)
			{
				centralUniHtml += "<option value='"+ centralUniversities[j].id +"'>" + centralUniversities[j].uni + "</option>";
			}
			centralUniHtml +="</optgroup>";
			for(var k=0; k<nits.length;k++)
			{
				NITHtml += "<option value='"+ nits[k].id +"'>" + nits[k].uni + "</option>";
			}
			NITHtml +="</optgroup>";
			$("#universty_choice").html("<option value=''>-- Select --</option>" + stateuniHtml + centralUniHtml);
		}	
	else if(courseType == 6 || courseType == 7 || courseType == 8 || courseType == 9 || courseType == 10 )
	{
		var stateuniHtml = "";var centralUniHtml = "";var fashion = "";
		stateuniHtml +=" <optgroup label='State Universities'>";
		centralUniHtml +="<optgroup label='Central Universities'>";
		fashion += "<optgroup label='National Institute of Fashion Technology'>";
		for(var key in statesarray)
		{			
			if(statesarray[key].length > 0)
			{									
				stateuniHtml +="<optgroup label='"+statesarray[key][0].name+"' class='stt'>";
				for(var key1 in statesarray[key])
				{
					stateuniHtml += "<option value='"+ statesarray[key][key1].id +"'>" + statesarray[key][key1].uni + "</option>";
				}
				
				stateuniHtml +="</optgroup>";
			}
		}	
		stateuniHtml +=" </optgroup>";
		for(var j=0; j<centralUniversities.length;j++)
		{
			centralUniHtml += "<option value='"+ centralUniversities[j].id +"'>" + centralUniversities[j].uni + "</option>";
		}
		centralUniHtml +="</optgroup>";
		
		
		$('.course_option_name').addClass("fade in");	
		if(courseType == 8)
		{
			for(var j=0; j<niftList.length;j++)
			{
				fashion += "<option value='"+ niftList[j].id +"'>" + niftList[j].uni + "</option>";
			}
			fashion +="</optgroup>";
			$("#universty_choice").html("<option value=''>-- Select --</option>" + stateuniHtml + centralUniHtml + fashion);
		}
		else
		{
			$("#universty_choice").html("<option value=''>-- Select --</option>" + stateuniHtml + centralUniHtml);
		}
		
		 orderOptgroups();		
	}
	else if(courseType == 5)
	{
		var stateuniHtml = "";var NITHtml ="";var centralUniHtml = "";
		stateuniHtml +=" <optgroup label='State Universities'>";
		NITHtml +="<optgroup label='National Institute of Technology (NIT)'>";
		centralUniHtml +="<optgroup label='Central Universities'>";
		for(var j=1; j<=Object.keys(statesarray).length;j++)
		{			
			if(statesarray[j].length > 0)
			{									
				stateuniHtml +="<optgroup label='"+statesarray[j][0].name+"'>";
				for(var k=0; k<statesarray[j].length;k++)
				{
					stateuniHtml += "<option value='"+ statesarray[j][k].id +"'>" + statesarray[j][k].uni + "</option>";
				}
				stateuniHtml +="</optgroup>";
			}
		}	
		stateuniHtml +=" </optgroup>";
		
		for(var j=0; j<centralUniversities.length;j++)
			{
				centralUniHtml += "<option value='"+ centralUniversities[j].id +"'>" + centralUniversities[j].uni + "</option>";
			}
			centralUniHtml +="</optgroup>";
		for(var l=0; l<nits.length;l++)
		{
			NITHtml += "<option value='"+ nits[l].id +"'>" + nits[l].uni + "</option>";
		}
		NITHtml +="</optgroup>";
		$("#universty_choice").html("<option value=''>-- Select --</option>" + stateuniHtml + centralUniHtml + NITHtml);
	}	
	    	 		
	    	 		
	    	 		
				}
				else if(data.status == false)
				{
					$("#course").html(htm);
					$("#course_two").html(htm);
					$("#course_three").html(htm);
	    	 		$("#programme").val(programme);
	    	 		
	    	 		/* Bind Universities */
	    	 		stateuniversities = [];	
	    	 		centralUniversities = [];    	 		
	    	 		stateuniversities = data.stateUniversities;	 
	    	 		centralUniversities = data.centralUniversities;	 
	    	 	for (var member in statesarray) 
	    	 		statesarray[member]=[];  
	    	 			 		
	    	 	if(typeof stateuniversities != 'undefined')
				{
					for(var i=0; i<stateuniversities.length;i++)
					{
						if(statesarray.hasOwnProperty(stateuniversities[i].state_id))
						{							
							
							statesarray[stateuniversities[i].state_id].push(stateuniversities[i]);
						}
					}	
				}	
	    	 	if(courseType == 3 || courseType == 4)
				{
			
			var stateuniHtml = "";var centralUniHtml = "";var NITHtml ="";
			stateuniHtml +=" <optgroup label='State Universities'>";
			centralUniHtml +="<optgroup label='Central Universities'>";
			NITHtml +="<optgroup label='National Institute of Technology (NIT)'>";
			for(var j=1; j<=Object.keys(statesarray).length;j++)
			{			
				if(statesarray[j].length > 0)
				{									
					stateuniHtml +="<optgroup label='"+statesarray[j][0].name+"'>";
					for(var k=0; k<statesarray[j].length;k++)
					{
						stateuniHtml += "<option value='"+ statesarray[j][k].id +"'>" + statesarray[j][k].uni + "</option>";
					}
					stateuniHtml +="</optgroup>";
				}
			}	
			stateuniHtml +=" </optgroup>";
			for(var j=0; j<centralUniversities.length;j++)
			{
				centralUniHtml += "<option value='"+ centralUniversities[j].id +"'>" + centralUniversities[j].uni + "</option>";
			}
			centralUniHtml +="</optgroup>";
			for(var k=0; k<nits.length;k++)
			{
				NITHtml += "<option value='"+ nits[k].id +"'>" + nits[k].uni + "</option>";
			}
			NITHtml +="</optgroup>";
			$("#universty_choice").html("<option value=''>-- Select --</option>" + stateuniHtml + centralUniHtml + NITHtml);
		}	
	else if(courseType == 6 || courseType == 7 || courseType == 8 || courseType == 9 || courseType == 10)
	{
		var stateuniHtml = "";var centralUniHtml = "";var fashion = "";
		stateuniHtml +=" <optgroup label='State Universities'>";
		centralUniHtml +="<optgroup label='Central Universities'>";
		fashion += "<optgroup label='National Institute of Fashion and Technology'>";
		for(var key in statesarray)
		{			
			if(statesarray[key].length > 0)
			{									
				stateuniHtml +="<optgroup label='"+statesarray[key][0].name+"' class='stt'>";
				for(var key1 in statesarray[key])
				{
					stateuniHtml += "<option value='"+ statesarray[key][key1].id +"'>" + statesarray[key][key1].uni + "</option>";
				}
				
				stateuniHtml +="</optgroup>";
			}
		}	
		stateuniHtml +=" </optgroup>";
		for(var j=0; j<centralUniversities.length;j++)
		{
			centralUniHtml += "<option value='"+ centralUniversities[j].id +"'>" + centralUniversities[j].uni + "</option>";
		}
		centralUniHtml +="</optgroup>";
		
		
		$('.course_option_name').addClass("fade in");	
		if(courseType == 8)
		{
			for(var j=0; j<niftList.length;j++)
			{
				fashion += "<option value='"+ niftList[j].id +"'>" + niftList[j].uni + "</option>";
			}
			fashion +="</optgroup>";
			$("#universty_choice").html("<option value=''>-- Select --</option>" + stateuniHtml + centralUniHtml + fashion);
		}
		else
		{
			$("#universty_choice").html("<option value=''>-- Select --</option>" + stateuniHtml + centralUniHtml);
		}
		
		 orderOptgroups();		
	}
	else if(courseType == 5)
	{
		var stateuniHtml = "";var NITHtml ="";
		centralUniHtml +="<optgroup label='Central Universities'>";
		stateuniHtml +=" <optgroup label='State Universities'>";
		NITHtml +="<optgroup label='National Institute of Technology (NIT)'>";
		
		for(var j=1; j<=Object.keys(statesarray).length;j++)
		{			
			if(statesarray[j].length > 0)
			{									
				stateuniHtml +="<optgroup label='"+statesarray[j][0].name+"'>";
				for(var k=0; k<statesarray[j].length;k++)
				{
					stateuniHtml += "<option value='"+ statesarray[j][k].id +"'>" + statesarray[j][k].uni + "</option>";
				}
				stateuniHtml +="</optgroup>";
			}
		}	
		stateuniHtml +=" </optgroup>";
		for(var j=0; j<centralUniversities.length;j++)
			{
				centralUniHtml += "<option value='"+ centralUniversities[j].id +"'>" + centralUniversities[j].uni + "</option>";
			}
			centralUniHtml +="</optgroup>";
		for(var l=0; l<nits.length;l++)
		{
			NITHtml += "<option value='"+ nits[l].id +"'>" + nits[l].uni + "</option>";
		}
		NITHtml +="</optgroup>";
		$("#universty_choice").html("<option value=''>-- Select --</option>" + stateuniHtml +centralUniHtml+ NITHtml);
	}	
	    	 		
	    	 		
				}		    	     	
		      },
		      error: function(jqXHR, text, error){
		                
		      }
		   });
});

$('#course_type').change(function(){
		
	$("#universty_choice").html("<option value=''>-- Select --</option>");
	$("#universty_choice_two").html("<option value=''>-- Select --</option>");
	$("#universty_choice_three").html("<option value=''>-- Select --</option>");	
	
	$('.unidiv1 .course_option_name > #course_option_name').val("");
	$('.unidiv2 .course_option_name_two > #course_option_name_two').val("");
	$('.unidiv3 .course_option_name_three > #course_option_name_three').val("");
		
	var programme=$('#programme').val();
	var courseType = $(this).val();
	if(courseType == 1)
	{
		var agrihtml = "";
		for(var j=0; j<Object.keys(ayushU).length;j++)
		{
			agrihtml += "<option value='"+ ayushU[j].id +"'>" + ayushU[j].uni + "</option>";
		}
		$("#universty_choice").html(agrihtml);		
		$("#universty_choice_two").html(agrihtml);
		$("#universty_choice_three").html(agrihtml);	
	}
	if(courseType == 2)
	{
		var icarhtml = "";
		for(var j=0; j<Object.keys(icar).length;j++)
		{
			icarhtml += "<option value='"+ icar[j].id +"'>" + icar[j].uni + "</option>";
		}
		$("#universty_choice").html(icarhtml);
		$("#universty_choice_two").html(icarhtml);
		$("#universty_choice_three").html(icarhtml);	
		
	}
	
	$('.course_option_name').addClass("fade in");	
		var frmdata = new FormData();		
		frmdata.append('programme', programme);	
		frmdata.append('course_type', courseType);		
		frmdata.append(csrfName, csrfHash);	
		$.ajax({
		    type: "POST",
		    url: baseURL +'applicant/getCourseByPrgramme',	   
		    data: frmdata,
		    dataType:'json',
		    processData: false,
	   		contentType: false,
		    success: function (data) {
		    	csrfName = data.csrfName;
				csrfHash = data.csrfHash;
				var htm = "<option value=''>Select Course</option>";
				courseList = [];
		    	if(data.status == true)
	    		{	
	    			courseList = data.data;
					if(data.data.length > 0)
					{
						for(var i=0; i<data.data.length; i++)
						{
							htm += "<option value='"+ data.data[i].id +"'>" + data.data[i].title + "</option>";
						}
					}
					$("#course").html(htm);
					$("#course_two").html(htm);
					$("#course_three").html(htm);
	    	 		$("#programme").val(programme);
	    	 		
	    	 		/* Bind Universities */
	    	 		stateuniversities = [];	
	    	 		centralUniversities = [];    	 		
	    	 		stateuniversities = data.stateUniversities;	 
	    	 		centralUniversities = data.centralUniversities;	 
	    	 	for (var member in statesarray) 
	    	 		statesarray[member]=[];  
	    	 			 		
	    	 	if(typeof stateuniversities != 'undefined')
				{
					for(var i=0; i<stateuniversities.length;i++)
					{
						if(statesarray.hasOwnProperty(stateuniversities[i].state_id))
						{							
							
							statesarray[stateuniversities[i].state_id].push(stateuniversities[i]);
						}
					}	
				}	
	    	 	if(courseType == 3 || courseType == 4 )
				{
			
			var stateuniHtml = "";var centralUniHtml = "";var NITHtml ="";
			stateuniHtml +=" <optgroup label='State Universities'>";
			centralUniHtml +="<optgroup label='Central Universities'>";
			NITHtml +="<optgroup label='National Institute of Technology (NIT)'>";
			for(var j=1; j<=Object.keys(statesarray).length;j++)
			{			
				if(statesarray[j].length > 0)
				{									
					stateuniHtml +="<optgroup label='"+statesarray[j][0].name+"'>";
					for(var k=0; k<statesarray[j].length;k++)
					{
						stateuniHtml += "<option value='"+ statesarray[j][k].id +"'>" + statesarray[j][k].uni + "</option>";
					}
					stateuniHtml +="</optgroup>";
				}
			}	
			stateuniHtml +=" </optgroup>";
			for(var j=0; j<centralUniversities.length;j++)
			{
				centralUniHtml += "<option value='"+ centralUniversities[j].id +"'>" + centralUniversities[j].uni + "</option>";
			}
			centralUniHtml +="</optgroup>";
			for(var k=0; k<nits.length;k++)
			{
				NITHtml += "<option value='"+ nits[k].id +"'>" + nits[k].uni + "</option>";
			}
			NITHtml +="</optgroup>";
			$("#universty_choice").html("<option value=''>-- Select --</option>" + stateuniHtml + centralUniHtml);
		}	
	else if(courseType == 6 || courseType == 7 || courseType == 8 || courseType == 9 || courseType == 10 )
	{
		var stateuniHtml = "";var centralUniHtml = "";var fashion = "";
		stateuniHtml +=" <optgroup label='State Universities'>";
		centralUniHtml +="<optgroup label='Central Universities'>";
		fashion += "<optgroup label='National Institute of Fashion Technology'>";
		for(var key in statesarray)
		{			
			if(statesarray[key].length > 0)
			{									
				stateuniHtml +="<optgroup label='"+statesarray[key][0].name+"' class='stt'>";
				for(var key1 in statesarray[key])
				{
					stateuniHtml += "<option value='"+ statesarray[key][key1].id +"'>" + statesarray[key][key1].uni + "</option>";
				}
				
				stateuniHtml +="</optgroup>";
			}
		}	
		stateuniHtml +=" </optgroup>";
		for(var j=0; j<centralUniversities.length;j++)
		{
			centralUniHtml += "<option value='"+ centralUniversities[j].id +"'>" + centralUniversities[j].uni + "</option>";
		}
		centralUniHtml +="</optgroup>";
		
		
		$('.course_option_name').addClass("fade in");	
		if(courseType == 8)
		{
			for(var j=0; j<niftList.length;j++)
			{
				fashion += "<option value='"+ niftList[j].id +"'>" + niftList[j].uni + "</option>";
			}
			fashion +="</optgroup>";
			$("#universty_choice").html("<option value=''>-- Select --</option>" + stateuniHtml + centralUniHtml + fashion);
		}
		else
		{
			$("#universty_choice").html("<option value=''>-- Select --</option>" + stateuniHtml + centralUniHtml);
		}
		
		 orderOptgroups();		
	}
	else if(courseType == 5)
	{
		var stateuniHtml = "";var NITHtml ="";var centralUniHtml = "";
		stateuniHtml +=" <optgroup label='State Universities'>";
		NITHtml +="<optgroup label='National Institute of Technology (NIT)'>";
		centralUniHtml +="<optgroup label='Central Universities'>";
		for(var j=1; j<=Object.keys(statesarray).length;j++)
		{			
			if(statesarray[j].length > 0)
			{									
				stateuniHtml +="<optgroup label='"+statesarray[j][0].name+"'>";
				for(var k=0; k<statesarray[j].length;k++)
				{
					stateuniHtml += "<option value='"+ statesarray[j][k].id +"'>" + statesarray[j][k].uni + "</option>";
				}
				stateuniHtml +="</optgroup>";
			}
		}	
		stateuniHtml +=" </optgroup>";
		
		for(var j=0; j<centralUniversities.length;j++)
			{
				centralUniHtml += "<option value='"+ centralUniversities[j].id +"'>" + centralUniversities[j].uni + "</option>";
			}
			centralUniHtml +="</optgroup>";
		for(var l=0; l<nits.length;l++)
		{
			NITHtml += "<option value='"+ nits[l].id +"'>" + nits[l].uni + "</option>";
		}
		NITHtml +="</optgroup>";
		$("#universty_choice").html("<option value=''>-- Select --</option>" + stateuniHtml + centralUniHtml + NITHtml);
	}	
	    	 		
	    	 		
	    	 		
				}
				else if(data.status == false)
				{
					$("#course").html(htm);
					$("#course_two").html(htm);
					$("#course_three").html(htm);
	    	 		$("#programme").val(programme);
	    	 		
	    	 		/* Bind Universities */
	    	 		stateuniversities = [];	
	    	 		centralUniversities = [];    	 		
	    	 		stateuniversities = data.stateUniversities;	 
	    	 		centralUniversities = data.centralUniversities;	 
	    	 	for (var member in statesarray) 
	    	 		statesarray[member]=[];  
	    	 			 		
	    	 	if(typeof stateuniversities != 'undefined')
				{
					for(var i=0; i<stateuniversities.length;i++)
					{
						if(statesarray.hasOwnProperty(stateuniversities[i].state_id))
						{							
							
							statesarray[stateuniversities[i].state_id].push(stateuniversities[i]);
						}
					}	
				}	
	    	 	if(courseType == 3 || courseType == 4)
				{
			
			var stateuniHtml = "";var centralUniHtml = "";var NITHtml ="";
			stateuniHtml +=" <optgroup label='State Universities'>";
			centralUniHtml +="<optgroup label='Central Universities'>";
			NITHtml +="<optgroup label='National Institute of Technology (NIT)'>";
			for(var j=1; j<=Object.keys(statesarray).length;j++)
			{			
				if(statesarray[j].length > 0)
				{									
					stateuniHtml +="<optgroup label='"+statesarray[j][0].name+"'>";
					for(var k=0; k<statesarray[j].length;k++)
					{
						stateuniHtml += "<option value='"+ statesarray[j][k].id +"'>" + statesarray[j][k].uni + "</option>";
					}
					stateuniHtml +="</optgroup>";
				}
			}	
			stateuniHtml +=" </optgroup>";
			for(var j=0; j<centralUniversities.length;j++)
			{
				centralUniHtml += "<option value='"+ centralUniversities[j].id +"'>" + centralUniversities[j].uni + "</option>";
			}
			centralUniHtml +="</optgroup>";
			for(var k=0; k<nits.length;k++)
			{
				NITHtml += "<option value='"+ nits[k].id +"'>" + nits[k].uni + "</option>";
			}
			NITHtml +="</optgroup>";
			$("#universty_choice").html("<option value=''>-- Select --</option>" + stateuniHtml + centralUniHtml + NITHtml);
		}	
	else if(courseType == 6 || courseType == 7 || courseType == 8 || courseType == 9 || courseType == 10)
	{
		var stateuniHtml = "";var centralUniHtml = "";var fashion = "";
		stateuniHtml +=" <optgroup label='State Universities'>";
		centralUniHtml +="<optgroup label='Central Universities'>";
		fashion += "<optgroup label='National Institute of Fashion and Technology'>";
		for(var key in statesarray)
		{			
			if(statesarray[key].length > 0)
			{									
				stateuniHtml +="<optgroup label='"+statesarray[key][0].name+"' class='stt'>";
				for(var key1 in statesarray[key])
				{
					stateuniHtml += "<option value='"+ statesarray[key][key1].id +"'>" + statesarray[key][key1].uni + "</option>";
				}
				
				stateuniHtml +="</optgroup>";
			}
		}	
		stateuniHtml +=" </optgroup>";
		for(var j=0; j<centralUniversities.length;j++)
		{
			centralUniHtml += "<option value='"+ centralUniversities[j].id +"'>" + centralUniversities[j].uni + "</option>";
		}
		centralUniHtml +="</optgroup>";
		
		
		$('.course_option_name').addClass("fade in");	
		if(courseType == 8)
		{
			for(var j=0; j<niftList.length;j++)
			{
				fashion += "<option value='"+ niftList[j].id +"'>" + niftList[j].uni + "</option>";
			}
			fashion +="</optgroup>";
			$("#universty_choice").html("<option value=''>-- Select --</option>" + stateuniHtml + centralUniHtml + fashion);
		}
		else
		{
			$("#universty_choice").html("<option value=''>-- Select --</option>" + stateuniHtml + centralUniHtml);
		}
		
		 orderOptgroups();		
	}
	else if(courseType == 5)
	{
		var stateuniHtml = "";var NITHtml ="";
		centralUniHtml +="<optgroup label='Central Universities'>";
		stateuniHtml +=" <optgroup label='State Universities'>";
		NITHtml +="<optgroup label='National Institute of Technology (NIT)'>";
		
		for(var j=1; j<=Object.keys(statesarray).length;j++)
		{			
			if(statesarray[j].length > 0)
			{									
				stateuniHtml +="<optgroup label='"+statesarray[j][0].name+"'>";
				for(var k=0; k<statesarray[j].length;k++)
				{
					stateuniHtml += "<option value='"+ statesarray[j][k].id +"'>" + statesarray[j][k].uni + "</option>";
				}
				stateuniHtml +="</optgroup>";
			}
		}	
		stateuniHtml +=" </optgroup>";
		for(var j=0; j<centralUniversities.length;j++)
			{
				centralUniHtml += "<option value='"+ centralUniversities[j].id +"'>" + centralUniversities[j].uni + "</option>";
			}
			centralUniHtml +="</optgroup>";
		for(var l=0; l<nits.length;l++)
		{
			NITHtml += "<option value='"+ nits[l].id +"'>" + nits[l].uni + "</option>";
		}
		NITHtml +="</optgroup>";
		$("#universty_choice").html("<option value=''>-- Select --</option>" + stateuniHtml +centralUniHtml+ NITHtml);
	}	
	    	 		
	    	 		
				}		    	     	
		      },
		      error: function(jqXHR, text, error){
		                
		      }
		   });
});



	$('form').attr('autocomplete', 'off');

	$('#course').change(function(){
		var progrm = $('#programme').val();	
		var courseval = $(this).val();
		var courseStream = 0;		
		
		for(var keys in courseList)
		{
		   if(courseval == courseList[keys].id)
		   {
		     courseStream = courseList[keys].has_stream;
		   }
		}
		
		if(courseStream > 0)
		{
			$('.unidiv1 .course_option_name').removeAttr("style");
			$('.unidiv1 .course_option_name').addClass("fade in");	
		}
		else
		{			
			$('.unidiv1 .course_option_name > #course_option_name').val("");
			$('.unidiv1 .course_option_name').attr("style","display:none;");
			$('.unidiv1 .course_option_name').removeClass("fade");
			$('.unidiv1 .course_option_name').removeClass("in");
			$('.unidiv1 .course_option_name').addClass("fade");				
		}		
		
	});
	
	$('#course_two').change(function(){
		var progrm = $('#programme').val();	
		var courseval = $(this).val();
		var courseStream = 0;		
		
		for(var keys in courseList)
		{
		   if(courseval == courseList[keys].id)
		   {
		     courseStream = courseList[keys].has_stream;
		   }
		}
		
		if(courseStream > 0)
		{
			$('.unidiv2 .course_option_name_two').removeAttr("style");
			$('.unidiv2 .course_option_name_two').addClass("fade in");	
		}
		else
		{			
			$('.unidiv2 .course_option_name_two > #course_option_name_two').val("");
			$('.unidiv2 .course_option_name_two').attr("style","display:none;");
			$('.unidiv2 .course_option_name_two').removeClass("fade");
			$('.unidiv2 .course_option_name_two').removeClass("in");
			$('.unidiv2 .course_option_name_two').addClass("fade");				
		}		
		
	});
	$('#course_three').change(function(){
		var progrm = $('#programme').val();	
		var courseval = $(this).val();
		var courseStream = 0;		
		
		for(var keys in courseList)
		{
		   if(courseval == courseList[keys].id)
		   {
		     courseStream = courseList[keys].has_stream;
		   }
		}
		
		if(courseStream > 0)
		{
			$('.unidiv3 .course_option_name_three').removeAttr("style");
			$('.unidiv3 .course_option_name_three').addClass("fade in");	
		}
		else
		{			
			$('.unidiv3 .course_option_name_three > #course_option_name_three').val("");
			$('.unidiv3 .course_option_name_three').attr("style","display:none;");
			$('.unidiv3 .course_option_name_three').removeClass("fade");
			$('.unidiv3 .course_option_name_three').removeClass("in");
			$('.unidiv3 .course_option_name_three').addClass("fade");				
		}		
		
	});
	/* Mobile Number Validation */
	$('#mobile_no').on('blur',function() {
		var val = $('#mobile_no').val();
		var len = val.length;
		if(len < 10)
		{
			//alert("Please Enter 10 Digit Mobile Number Only.");
			//var val = $('#mobile_no').val('');
		}
	});
	$('.numverval').keydown(function (e) {
		if (e.shiftKey || e.ctrlKey || e.altKey) 
		{
			e.preventDefault();
		} 
		else 
		{
			var key = e.keyCode;
			if (!((key == 9) || (key == 8) || (key == 46) || (key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) 
			{
				e.preventDefault();
			}
		}
	});
	
	
	/*GMAT Score*/
	
	$('.universty_choice_cl').change(function() {
		var valm =   $('#course_type').val();
		var val = $('#universty_choice').val();	
		var val_two = $('#universty_choice_two').val();
		var val_three = $('#universty_choice_three').val();
		//console.log(valm);
		//console.log('One-'+val);
		//console.log('Two-'+val_two);
		//console.log('Three'+val_three);
		if( (val_three == 189 && valm == 6 ) ||  ( val_three == 176 && valm == 6 ) || ( val_three == 205 && valm == 6 )  || (valm == 6 && val_two == 189) ||  ( valm == 6 && val_two == 176) || (valm == 6 && val_two == 205) || (valm == 6 && val == 189) ||  (valm == 6 && val == 176 ) || (valm == 6 && val == 205 ))
		{
			$('.gmat').removeAttr("style");
			$('#gmat_score').attr("required","true");
		}
		else{
			
			$('.gmat').attr("style","display:none;");
			$('#gmat_score').removeAttr("required");
		}
	});


	$('.course').change(function(){	

	//var universty_choice_two = $('#universty_choice_two').val();
    var programme=$('#programmeayush').val();
	var courseType = $('#course_types').val();
	var course = $('#course').val();
	//alert(programme);
	//alert(courseType);
	//alert(course);
	if(courseType == 1)
	{
		//alert('ayush');
			if(programme == 1 || programme == 2  || programme == 8)
			{
				
				//if(courseTypeList.length > 0)
				//{
					$.ajax({
					type: "POST",
					url: baseURL +'applicant/getAyushUniversityByCourse',	   
					data: {"programme":programme,"courseType":courseType,"course":course},
						success: function (data) {
						//$('#course_type').html(data);
						$("#universty_choice").html(data);
						$("#course_fourth").val(course);
						$("#course_fourth").prop('disabled','true');
						}
					})
				
			}
	}


});

$("input[name = step-one-application]").on("click" ,function(){
//alert('ok');
$("#course_fourth").removeAttr('disabled','false');

})

$('.course_two').change(function(){	

	var university =$('#universty_choice').val();
	var university_two =$('#universty_choice_three').val();
	
    var programme=$('#programmeayush').val();
	var courseType = $('#course_types').val();
	var course = $('#course_two').val();
	
	if(courseType == 1)
	{
		//alert('ayush');
			if(programme == 1 || programme == 2  || programme == 8)
			{
				
				//if(courseTypeList.length > 0)
				//{
					$.ajax({
					type: "POST",
					url: baseURL +'applicant/getAyushUniversityByCourse',	   
					data: {"programme":programme,"courseType":courseType,"course":course},
						success: function (data) {
						//$('#course_type').html(data);
						$("#universty_choice_two").html(data);
						
					var htmlFirst = $('#universty_choice_two').html();
					$('#universty_choice_two').html(htmlFirst);
					$('#universty_choice_two option[value="'+university+'"]').remove();
						 
						}
					})
					
				
			}
	}
	
	


});

 $('.course_three').change(function(){	

	var university =$('#universty_choice').val();
	//alert(university);
	var university_two =$('#universty_choice_two').val();
	//alert(university_two);
	//var university_three =$('#universty_choice_three').val();
	
	//alert(university_three);
    var programme=$('#programmeayush').val();
	var courseType = $('#course_types').val();
	var course_two = $('#course_three').val();
	//alert(programme);
	//alert(courseType);
	//alert(course);
	if(courseType == 1)
	{
		//alert('ayush');
			if(programme == 1 || programme == 2  || programme == 8)
			{
				
				//if(courseTypeList.length > 0)
				//{
					$.ajax({
					type: "POST",
					url: baseURL +'applicant/getAyushUniversityByCourse',	   
					data: {"programme":programme,"courseType":courseType,"course":course_two},
						success: function (data) {
						//$('#course_type').html(data);
						$("#universty_choice_three").html(data);
						
					var htmlFirst = $('#universty_choice_three').html();
					$('#universty_choice_three').html(htmlFirst);
					$('#universty_choice_three option[value="'+university_two+'"]').remove();
						$('#universty_choice_three option[value="'+university+'"]').remove()
						}
					})
				
			}
	}


}); 
	$('#programme2').change(function(){
		
		var programme1 = $('#programme2').val();
		var frmdata = new FormData();		
		frmdata.append('programme', programme1);		
		//frmdata.append(csrfName, csrfHash);	
		$.ajax({
		    type: "POST",
		    url: baseURL +'regional/getCourseByPrgramme',	   
		    data: frmdata,
		    dataType:'json',
		    processData: false,
	   		contentType: false,
		    success: function (data) {
		    //	csrfName = data.csrfName;
				//csrfHash = data.csrfHash;
				var htm = "<option value=''>Select Course</option>";				
		    	if(data.status == true)
	    		{	    		
					
					if(data.data.length > 0)
					{
						for(var i=0; i<data.data.length; i++)
						{
							htm += "<option value='"+ data.data[i].id +"'>" + data.data[i].title + "</option>";
						}
					}
					$("#course2").html(htm);
	    	 		$("#programme2").val(programme1);
	    	 		var fy = "<option value=''>Academic Year</option>";
	    	 		if(data.fy.length > 0)
					{
						for(var i=0; i<data.fy.length; i++)
						{
							fy += "<option value='"+ data.fy[i] +"'>" + data.fy[i] + "</option>";
						}
					}
					var fyras = "<option value=''>Year</option>";
	    	 		if(data.fyrs.length > 0)
					{
						for(var i=0; i<data.fyrs.length; i++)
						{
							fyras += "<option value='"+ data.fyrs[i] +"'>" + data.fyrs[i] + "</option>";
						}
					}
				}
				else if(data.status == false)
				{
					$("#course2").html(htm);
				}		    	     	
		      },
		      error: function(jqXHR, text, error){
		                
		      }
		   });
		
	});	
	
	/* For Mission */
	$('#programmes_mission').change(function(){
		
		var programme1 = $('#programmes_mission').val();
		var frmdata = new FormData();		
		frmdata.append('programme', programme1);		
		//frmdata.append(csrfName, csrfHash);	
		$.ajax({
		    type: "POST",
		    url: baseURL +'mission/getCourseByPrgrammeold',	   
		    data: frmdata,
		    dataType:'json',
		    processData: false,
	   		contentType: false,
		    success: function (data) {
		    //	csrfName = data.csrfName;
				//csrfHash = data.csrfHash;
				var htm = "<option value=''>Select Course</option>";				
		    	if(data.status == true)
	    		{	    
					if(data.data.length > 0)
					{
						for(var i=0; i<data.data.length; i++)
						{
							htm += "<option value='"+ data.data[i].id +"'>" + data.data[i].title + "</option>";
						}
					}
					$("#courses_mission").html(htm);
	    	 		$("#programmes_mission").val(programme1);
				}
				else if(data.status == false)
				{
					$("#courses_mission").html(htm);
				}		    	     	
		      },
		      error: function(jqXHR, text, error){
		                
		      }
		   });
		
	});	
	
	/* For Headquarter */
	
		$('#programmes').change(function(){
		
		var programme1 = $('#programmes').val();
		var frmdata = new FormData();		
		frmdata.append('programme', programme1);		
		//frmdata.append(csrfName, csrfHash);	
		$.ajax({
		    type: "POST",
		    url: baseURL +'headquarter/getCourseByPrgrammeold',	   
		    data: frmdata,
		    dataType:'json',
		    processData: false,
	   		contentType: false,
		    success: function (data) {
		    //	csrfName = data.csrfName;
				//csrfHash = data.csrfHash;
				var htm = "<option value=''>Select Course</option>";				
		    	if(data.status == true)
	    		{	    		
					
					if(data.data.length > 0)
					{
						for(var i=0; i<data.data.length; i++)
						{
							htm += "<option value='"+ data.data[i].id +"'>" + data.data[i].title + "</option>";
						}
					}
					$("#courses").html(htm);
	    	 		$("#programmes").val(programme1);
				}
				else if(data.status == false)
				{
					$("#courses").html(htm);
				}		    	     	
		      },
		      error: function(jqXHR, text, error){
		                
		      }
		   });
		
	});	
	
		/* For Regional */
	
		$('#programmero').change(function(){
		
		var programme1 = $('#programmero').val();
		//alert(programme1);
		var frmdata = new FormData();		
		frmdata.append('programme', programme1);		
		//frmdata.append(csrfName, csrfHash);	
		$.ajax({
		    type: "POST",
		    url: baseURL +'regional/getCourseByPrgrammeold',	   
		    data: frmdata,
		    dataType:'json',
		    processData: false,
	   		contentType: false,
		    success: function (data) {
		    //	csrfName = data.csrfName;
				//csrfHash = data.csrfHash;
				var htm = "<option value=''>Select Course</option>";				
		    	if(data.status == true)
	    		{	    		
					
					if(data.data.length > 0)
					{
						for(var i=0; i<data.data.length; i++)
						{
							htm += "<option value='"+ data.data[i].id +"'>" + data.data[i].title + "</option>";
						}
					}
					$("#courses").html(htm);
	    	 		$("#programmero").val(programme1);
				}
				else if(data.status == false)
				{
					$("#courses").html(htm);
				}		    	     	
		      },
		      error: function(jqXHR, text, error){
		                
		      }
		   });
		
	});	
	
			/* For Regional Arrival Page*/
	
		$('#programmeroarrival').change(function(){
		
		var programme1 = $('#programmeroarrival').val();
		//alert(programme1);
		var frmdata = new FormData();		
		frmdata.append('programme', programme1);		
		//frmdata.append(csrfName, csrfHash);	
		$.ajax({
		    type: "POST",
		    url: baseURL +'regional/getCourseByPrgrammeold',	   
		    data: frmdata,
		    dataType:'json',
		    processData: false,
	   		contentType: false,
		    success: function (data) {
		    //	csrfName = data.csrfName;
				//csrfHash = data.csrfHash;
				var htm = "<option value=''>Select Course</option>";				
		    	if(data.status == true)
	    		{	    		
					
					if(data.data.length > 0)
					{
						for(var i=0; i<data.data.length; i++)
						{
							htm += "<option value='"+ data.data[i].title +"'>" + data.data[i].title + "</option>";
						}
					}
					$("#courses").html(htm);
	    	 		$("#programmero").val(programme1);
				}
				else if(data.status == false)
				{
					$("#courses").html(htm);
				}		    	     	
		      },
		      error: function(jqXHR, text, error){
		                
		      }
		   });
		
	});	
	
	
	/*$('#programme1').change(function(){
		
		var programme1 = $('#programme1').val();
		var frmdata = new FormData();		
		frmdata.append('programme', programme1);		
		//frmdata.append(csrfName, csrfHash);	
		$.ajax({
		    type: "POST",
		    url: baseURL +'regional/getCourseByPrgrammeold',	   
		    data: frmdata,
		    dataType:'json',
		    processData: false,
	   		contentType: false,
		    success: function (data) {
		    //	csrfName = data.csrfName;
				//csrfHash = data.csrfHash;
				var htm = "<option value=''>Select Course</option>";				
		    	if(data.status == true)
	    		{	    		
					
					if(data.data.length > 0)
					{
						for(var i=0; i<data.data.length; i++)
						{
							htm += "<option value='"+ data.data[i].id +"'>" + data.data[i].title + "</option>";
						}
					}
					$("#course1").html(htm);
	    	 		$("#programme1").val(programme1);
	    	 		var fy = "<option value=''>Academic Year</option>";
	    	 		if(data.fy.length > 0)
					{
						for(var i=0; i<data.fy.length; i++)
						{
							fy += "<option value='"+ data.fy[i] +"'>" + data.fy[i] + "</option>";
						}
					}
					var fyras = "<option value=''>Year</option>";
	    	 		if(data.fyrs.length > 0)
					{
						for(var i=0; i<data.fyrs.length; i++)
						{
							fyras += "<option value='"+ data.fyrs[i] +"'>" + data.fyrs[i] + "</option>";
						}
					}					
					$("#aca_year").html(fy);
					$("#course_duration_from").html(fyras);
					$("#course_duration_to").html(fyras);
				}
				else if(data.status == false)
				{
					$("#course1").html(htm);
				}		    	     	
		      },
		      error: function(jqXHR, text, error){
		                
		      }
		   });
		
	});	*/
	/*Get Courses */
	
	//Ayush
	
	$('#programmeayush').change(function(){
		
		$('.cours_subject').removeAttr("style");
		$('.cours_subject').attr("style","display:none;");
		
		$('#course_types').val("");
		$('.course_option_name').hide();
		$('#course').html("<option value=''>Select Course</option>");
		$('#course_two').html("<option value=''>Select Course</option>");
		$('#course_three').html("<option value=''>Select Course</option>");
		var programme = $('#programmeayush').val();	
		//alert(programme);
		if(programme != 1 && programme != 2 && programme != 5 && programme != 6 && programme != 9 && programme != 8)
		{
			$('.unidiv1 > .course_wish_study').css({"display":"none"});
			$('.unidiv2 > .course_wish_study').css({"display":"none"});
			$('.unidiv3 > .course_wish_study').css({"display":"none"});
			
			$('.unidiv1 > .course_option_name').css({"display":"none"});
			$('.unidiv2 > .course_option_name').css({"display":"none"});
			$('.unidiv3 > .course_option_name').css({"display":"none"});
			
			$('.unidiv1,.unidiv2,.unidiv3').removeClass("col-md-12");
			$('.unidiv1,.unidiv2,.unidiv3').addClass("col-md-4");
			
			$('.unidiv').removeClass("col-md-4");
			$('.unidiv').addClass("col-md-12");	
			if(programme == 3 || programme == 4)
			{
				if(courseTypeList.length > 0)
				{
					var ctypeHtml = "";
					ctypeHtml +="<option value='0'>Course Type</option>";
					for(var i=2; i<courseTypeList.length; i++)
					{
						ctypeHtml +="<option value='" + courseTypeList[i].id + "'>" + courseTypeList[i].course_type + "</option>";
					}
				}
				$('#course_types').html(ctypeHtml);
			}
			if(programme == 3 || programme == 4)
			{
				$('.course_type').removeClass("fade");
				$('.course_type').addClass("fade in");
				$('.course_type').css({"display":"Block"});
			}
			else
			{
				$('.course_type').removeClass("fade in");
				$('.course_type').addClass("fade");
				$('.course_type').css({"display":"none"});
			}
			
			$('.course_option_name,.course_option_name_two,.course_option_name_three').css({"display":"none"});
			$('#course_subject').val("");
			
			if(programme == 3 || programme == 4 || programme == 8)
			{
				$('.cours_subject').removeAttr("style");
				$('.cours_subject').attr("style","display:block;");
			}
			else
			{
				$('.cours_subject').removeAttr("style");
				$('.cours_subject').attr("style","display:none;");
			}
		}	
		else
		{
			$('.unidiv1 > .course_wish_study').css({"display":"block"});
			$('.unidiv2 > .course_wish_study').css({"display":"block"});
			$('.unidiv3 > .course_wish_study').css({"display":"block"});
			
			$('.unidiv1 > .course_wish_study').addClass("in");
			$('.unidiv2 > .course_wish_study').addClass("in");
			$('.unidiv3 > .course_wish_study').addClass("in");
			
			$('.unidiv1 > .course_option_name').css({"display":"none"});
			$('.unidiv2 > .course_option_name').css({"display":"none"});
			$('.unidiv3 > .course_option_name').css({"display":"none"});
			
			$('.unidiv1,.unidiv2,.unidiv3').removeClass("col-md-4");
			$('.unidiv1,.unidiv2,.unidiv3').addClass("col-md-12");
			
			if(programme != 5 && programme != 6)
			{
				$('.course_type').removeClass("fade");
				$('.course_type').addClass("fade in");
				$('.course_type').removeAttr("style");
			}
			else
			{
				$('.course_type').removeClass("fade in");
				$('.course_type').addClass("fade");	
			}	
			$('.unidiv').removeClass("col-md-12");
			$('.unidiv').addClass("col-md-12");
			
			$('.course_option_name,.course_option_name_two,.course_option_name_three').css({"display":"none"});
			
			if(programme == 1 || programme == 2 || programme == 3 || programme == 4)
			{
				
				
				if(courseTypeList.length > 0)
				{
					$.ajax({
					type: "POST",
					url: baseURL +'applicant/getCourseType',	   
					data: {"programme":programme},
						success: function (data) {
						$('#course_types').html(data);
						
						}
					})
				}
				
				//$('#course_type').html(ctypeHtml);
			}
			if(programme == 9)
			{
				
				if(courseTypeList.length > 0)
				{
					var ctypeHtml = "";
					ctypeHtml +="<option value='0'>Course Type</option>";
					for(var i=8; i<courseTypeList.length; i++)
					{
						ctypeHtml +="<option value='" + courseTypeList[i].id + "'>" + courseTypeList[i].course_type + "</option>";
					}
				}
				$('#course_type').html(ctypeHtml);
			}
		}
		
		$("#universty_choice").html("<option value=''>-- Select --</option>");
		$("#universty_choice_two").html("<option value=''>-- Select --</option>");
		$("#universty_choice_three").html("<option value=''>-- Select --</option>");
		$("#universty_choice_fourth").html("<option value=''>-- Select --</option>");
		
		if(programme == 5 || programme == 6 || programme == 7)
		{
			var stateuniHtml = "";
			stateuniHtml +=" <optgroup label='ICCR Gurus'>";			
			for(var i=0; i<yogas.length;i++)
			{				
				stateuniHtml += "<option value='"+ yogas[i].id +"'>" + yogas[i].uni + "  ("+ yogas[i].subject +")" + "</option>";
			}
			stateuniHtml +=" </optgroup>";			
			$("#universty_choice").html("<option value=''>-- Select --</option>" + stateuniHtml);
		}
		/* if(programme == 8 )
		{
			
			var agrihtml = "";
			for(var j=0; j<Object.keys(ayushU).length;j++)
			{
				agrihtml += "<option value='"+ ayushU[j].id +"'>" + ayushU[j].uni + "</option>";
			}
			$("#universty_choice").html(agrihtml);
			$("#universty_choice_two").html(agrihtml);
			$("#universty_choice_three").html(agrihtml);
		} */
		
		
		if(programme == 5 || programme == 6)
		{
			var courseType = 0;
			var frmdata = new FormData();		
			frmdata.append('programme', programme);	
			frmdata.append('course_type', courseType);		
			frmdata.append(csrfName, csrfHash);	
			$.ajax({
			    type: "POST",
			    url: baseURL +'applicant/getCourseByPrgramme',	   
			    data: frmdata,
			    dataType:'json',
			    processData: false,
		   		contentType: false,
			    success: function (data) {
			    	csrfName = data.csrfName;
					csrfHash = data.csrfHash;
					var htm = "<option value=''>Select Course</option>";
					courseList = [];
			    	if(data.status == true)
		    		{	
		    			courseList = data.data;
						if(data.data.length > 0)
						{
							for(var i=0; i<data.data.length; i++)
							{
								htm += "<option value='"+ data.data[i].id +"'>" + data.data[i].title + "</option>";
							}
						}
						$("#course").html(htm);
						$("#course_two").html(htm);
						$("#course_three").html(htm);
		    	 		$("#programme").val(programme);
					}
					else if(data.status == false)
					{
						$("#course").html(htm);
						$("#course_two").html(htm);
						$("#course_three").html(htm);
		    	 		$("#programme").val(programme);
					}		    	     	
			      },
			      error: function(jqXHR, text, error){
			                
			      }
			   });	
		}
	});
	
	
	
	$('#programme').change(function(){
		
		$('.cours_subject').removeAttr("style");
		$('.cours_subject').attr("style","display:none;");
		
		$('#course_type').val("");
		$('.course_option_name').hide();
		$('#course').html("<option value=''>Select Course</option>");
		$('#course_two').html("<option value=''>Select Course</option>");
		$('#course_three').html("<option value=''>Select Course</option>");
		var programme = $('#programme').val();	
		if(programme != 1 && programme != 2 && programme != 5 && programme != 6 && programme != 9)
		{
			$('.unidiv1 > .course_wish_study').css({"display":"none"});
			$('.unidiv2 > .course_wish_study').css({"display":"none"});
			$('.unidiv3 > .course_wish_study').css({"display":"none"});
			
			$('.unidiv1 > .course_option_name').css({"display":"none"});
			$('.unidiv2 > .course_option_name').css({"display":"none"});
			$('.unidiv3 > .course_option_name').css({"display":"none"});
			
			$('.unidiv1,.unidiv2,.unidiv3').removeClass("col-md-12");
			$('.unidiv1,.unidiv2,.unidiv3').addClass("col-md-4");
			
			$('.unidiv').removeClass("col-md-4");
			$('.unidiv').addClass("col-md-12");	
			if(programme == 3 || programme == 4)
			{
				if(courseTypeList.length > 0)
				{
					var ctypeHtml = "";
					ctypeHtml +="<option value='0'>Course Type</option>";
					for(var i=1; i<courseTypeList.length; i++)
					{
						ctypeHtml +="<option value='" + courseTypeList[i].id + "'>" + courseTypeList[i].course_type + "</option>";
					}
				}
				$('#course_type').html(ctypeHtml);
			}
			if(programme == 3 || programme == 4)
			{
				$('.course_type').removeClass("fade");
				$('.course_type').addClass("fade in");
				$('.course_type').css({"display":"Block"});
			}
			else
			{
				$('.course_type').removeClass("fade in");
				$('.course_type').addClass("fade");
				$('.course_type').css({"display":"none"});
			}
			
			$('.course_option_name,.course_option_name_two,.course_option_name_three').css({"display":"none"});
			$('#course_subject').val("");
			
			if(programme == 3 || programme == 4 || programme == 8)
			{
				$('.cours_subject').removeAttr("style");
				$('.cours_subject').attr("style","display:block;");
			}
			else
			{
				$('.cours_subject').removeAttr("style");
				$('.cours_subject').attr("style","display:none;");
			}
		}	
		else
		{
			$('.unidiv1 > .course_wish_study').css({"display":"block"});
			$('.unidiv2 > .course_wish_study').css({"display":"block"});
			$('.unidiv3 > .course_wish_study').css({"display":"block"});
			
			$('.unidiv1 > .course_wish_study').addClass("in");
			$('.unidiv2 > .course_wish_study').addClass("in");
			$('.unidiv3 > .course_wish_study').addClass("in");
			
			$('.unidiv1 > .course_option_name').css({"display":"none"});
			$('.unidiv2 > .course_option_name').css({"display":"none"});
			$('.unidiv3 > .course_option_name').css({"display":"none"});
			
			$('.unidiv1,.unidiv2,.unidiv3').removeClass("col-md-4");
			$('.unidiv1,.unidiv2,.unidiv3').addClass("col-md-12");
			
			if(programme != 5 && programme != 6)
			{
				$('.course_type').removeClass("fade");
				$('.course_type').addClass("fade in");
				$('.course_type').removeAttr("style");
			}
			else
			{
				$('.course_type').removeClass("fade in");
				$('.course_type').addClass("fade");	
			}	
			$('.unidiv').removeClass("col-md-12");
			$('.unidiv').addClass("col-md-4");
			
			$('.course_option_name,.course_option_name_two,.course_option_name_three').css({"display":"none"});
			
			if(programme == 1 || programme == 2 || programme == 3 || programme == 4)
			{
				
				
				if(courseTypeList.length > 0)
				{
					$.ajax({
					type: "POST",
					url: baseURL +'applicant/getCourseType',	   
					data: {"programme":programme},
						success: function (data) {
						$('#course_type').html(data);
						
						}
					})
				}
				
				//$('#course_type').html(ctypeHtml);
			}
			if(programme == 9)
			{
				
				if(courseTypeList.length > 0)
				{
					var ctypeHtml = "";
					ctypeHtml +="<option value='0'>Course Type</option>";
					for(var i=8; i<courseTypeList.length; i++)
					{
						ctypeHtml +="<option value='" + courseTypeList[i].id + "'>" + courseTypeList[i].course_type + "</option>";
					}
				}
				$('#course_type').html(ctypeHtml);
			}
		}
		
		$("#universty_choice").html("<option value=''>-- Select --</option>");
		$("#universty_choice_two").html("<option value=''>-- Select --</option>");
		$("#universty_choice_three").html("<option value=''>-- Select --</option>");
		
		
		if(programme == 5 || programme == 6 || programme == 7)
		{
			var stateuniHtml = "";
			stateuniHtml +=" <optgroup label='ICCR Gurus'>";			
			for(var i=0; i<yogas.length;i++)
			{				
				stateuniHtml += "<option value='"+ yogas[i].id +"'>" + yogas[i].uni + "  ("+ yogas[i].subject +")" + "</option>";
			}
			stateuniHtml +=" </optgroup>";			
			$("#universty_choice").html("<option value=''>-- Select --</option>" + stateuniHtml);
		}
		if(programme == 8 )
		{
			
			var agrihtml = "";
			for(var j=0; j<Object.keys(ayushU).length;j++)
			{
				agrihtml += "<option value='"+ ayushU[j].id +"'>" + ayushU[j].uni + "</option>";
			}
			$("#universty_choice").html(agrihtml);
			$("#universty_choice_two").html(agrihtml);
			$("#universty_choice_three").html(agrihtml);
		}
		
		
		if(programme == 5 || programme == 6)
		{
			var courseType = 0;
			var frmdata = new FormData();		
			frmdata.append('programme', programme);	
			frmdata.append('course_type', courseType);		
			frmdata.append(csrfName, csrfHash);	
			$.ajax({
			    type: "POST",
			    url: baseURL +'applicant/getCourseByPrgramme',	   
			    data: frmdata,
			    dataType:'json',
			    processData: false,
		   		contentType: false,
			    success: function (data) {
			    	csrfName = data.csrfName;
					csrfHash = data.csrfHash;
					var htm = "<option value=''>Select Course</option>";
					courseList = [];
			    	if(data.status == true)
		    		{	
		    			courseList = data.data;
						if(data.data.length > 0)
						{
							for(var i=0; i<data.data.length; i++)
							{
								htm += "<option value='"+ data.data[i].id +"'>" + data.data[i].title + "</option>";
							}
						}
						$("#course").html(htm);
						$("#course_two").html(htm);
						$("#course_three").html(htm);
		    	 		$("#programme").val(programme);
					}
					else if(data.status == false)
					{
						$("#course").html(htm);
						$("#course_two").html(htm);
						$("#course_three").html(htm);
		    	 		$("#programme").val(programme);
					}		    	     	
			      },
			      error: function(jqXHR, text, error){
			                
			      }
			   });	
		}
	});



		$('#schemes_selection').hide();
		$('#process_selection').hide();
	$('.checklistdiv li input[type=checkbox]').change(function(){			
		if($(this).is(':checked') == true)
		{
			if($(this).val() == 1 || $(this).val() == 2 || $(this).val() == 5 || $(this).val() == 6 || $(this).val() == 9)
			{
				applicant_check.push($(this).val());
			}
			if($(this).val() == 3 || $(this).val() == 4 || $(this).val() == 8 || $(this).val() == 10 || $(this).val() == 11)
			{
				mission_check.push($(this).val());
			}	
			checklist.push($(this).val());
		}
		else if($(this).is(':checked') == false)
		{
			checklist.splice(checklist.indexOf($(this).val()), 1);
		}
		var lent = $('.checklistdiv li').size();//applicant_checklist.length + mission_checklist.length;		
		if(checklist.length == lent)
		{
			$('#schemes_selection').show();			
		}
		else
		{
			$('#schemes_selection').hide();
		}
	});
	
	$('#form-process-application').submit(function(){
		var  formID = $(this).attr('id');
		$(this).attr( "enctype", "multipart/form-data");
		//var datafiles = null;
		var datafiles = new FormData();
		$.each($('#signature')[0].files, function(i, file) {
		    datafiles.append('signature', file);
		});	
		var formDetails = $('#'+formID);
		var process = $(".process-submit").val();
		var appno = $('#applicaiton_number').val();
		var schlr = $('#schloarship_name').val();
		var marks = $('#testmarks').val();
		 $('<input />').attr('type', 'hidden')
          .attr('name', "appid")
          .attr('value', appno)
          .appendTo('#form-process-application');
          $('<input />').attr('type', 'hidden')
          .attr('name', "type")
          .attr('value', process)
          .appendTo('#form-process-application');
          var other_data = $('#form-process-application').serializeArray();
           $.each(other_data,function(key,input){
		        datafiles.append(input.name,input.value);
		    });
		   $.ajax({
		    type: "POST",
		    url: baseURL +'mission/applicaitonProcess',
		    cache: false,
		    contentType: false,
		    processData: false,
		    data: datafiles,
		    dataType:"json",
		    success: function (data) {	
		    console.log(data);
		       if(data.status == true)
		       {
		       		if(data.message == "Rejected")
		       		{
						BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Success" ,message: "Application "+appno+ " Rejected.!"  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close(); location.href = baseURL + "mission/dashboard";}}]}); 
					}
					else if(data.message == "Approved")
					{
						BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Application "+data.ref+ " Recommended by Mission!"  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close(); location.href = baseURL + "mission/dashboard";}}]}); 
					}
					else if(data.message == "PENDING")
					{
						BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Application "+appno+ " pending due to some checklist points are missing.!"  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close(); location.href = baseURL + "mission/dashboard";}}]}); 
					}
			   		
			   }
			   if(data.status == false)
		       {
			   		BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Application "+data.ref+ " Submitted Successfully!"  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close(); location.href = baseURL + "mission/dashboard";}}]}); 
			   }
		       
		      },
		        error: function(jqXHR, text, error){
		               
		      }
		   });	
	     return false;
	});	
	$('.is_iccr_scholarship_avail_before').change(function(){
		var is_Indian = $(this).val();
		switch(is_Indian)
		{
			case "1":			
			$('.iccr_scholar').removeClass("fade");
			$('.iccr_scholar').addClass("fade in");
			break;
			case "2":			
			$('.iccr_scholar').removeClass("fade in");
			$('.iccr_scholar').addClass("fade");
			break;
		}
	});
	$('.is_international_lic').change(function(){
		var is_Indian = $(this).val();
		switch(is_Indian)
		{
			case "1":			
			$('.licence_div').removeClass("fade");
			$('.licence_div').addClass("fade in");
			break;
			case "2":			
			$('.licence_div').removeClass("fade in");
			$('.licence_div').addClass("fade");
			break;
		}
	});
	$('.currently_non_nri_val').change(function(){
		var is_Indian = $(this).val();
		switch(is_Indian)
		{
			case "1":			
			$('.is_indian_address').removeClass("fade");
			$('.is_indian_address').addClass("fade in");
			break;
			case "2":			
			$('.is_indian_address').removeClass("fade in");
			$('.is_indian_address').addClass("fade");
			break;
		}
	});
	$('.is_knwldge').change(function(){
		var is_Know = $(this).val();
		$('#knowledge_english_written').prop("checked",false);
		$('#knowledge_english_spoken').prop("checked",false);
		switch(is_Know)
		{
			case "1":			
			$('.knwledge_eng').removeClass("fade");
			$('.knwledge_eng').addClass("fade in");
			break;
			case "2":			
			$('.knwledge_eng').removeClass("fade in");
			$('.knwledge_eng').addClass("fade");
			break;
		}
	});
	$("#frm_download").submit(function(){
	var ht = $(".detailpagepdf").prop("outerHTML");
	alert(ht);
	$('<input />').attr('type', 'hidden')
          .attr('name', "myHTML")
          .attr('value', ht)
          .appendTo('#frm_download');
      return true;
   }); 
	$("#frm_details_ngo").parent("div").addClass("pdfdiv");
		$("#frm_details_ngo").submit(function(){
			var ht = $(".detailpagepdf").prop("outerHTML");
		
			$('<input />').attr('type', 'hidden')
		          .attr('name', "myHTML")
		          .attr('value', ht)
		          .appendTo('#frm_details_ngo');
		          console.log($("#frm_details_ngo"));
		      return true;
		});
		$("#frm_details_ngo_one").submit(function(){
			var ht = $(".detailpagepdfone").prop("outerHTML");
		
			$('<input />').attr('type', 'hidden')
		          .attr('name', "myHTML")
		          .attr('value', ht)
		          .appendTo('#frm_details_ngo_one');
		          console.log($("#frm_details_ngo_one"));
		      return true;
		});

	
	var step = getParameterByName("step");
	if(step != "undefined" && step != "")
	{
		
	}
	
	$("body").on("contextmenu",function(e){
		BootstrapDialog.show({type: BootstrapDialog.TYPE_WARNING ,title: "Warning" ,message: "Mouse Right Click Not Working!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]}); 
        return false;
    });
	/* $("#reg").click(function(e){
		BootstrapDialog.show({type: BootstrapDialog.TYPE_WARNING ,title: "Warning" ,message: "Sorry! last date of application is over" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]}); 
        return false;
    }); */
    $('body').bind('cut copy paste', function (e) {
       // e.preventDefault();
    });
      $('.datepicker_visa_issuedate').datepicker({
		changeMonth: true,
		//minDate:"+0M + 0D",
		//maxDate:"+0M +0D",
		changeYear: true,
		yearRange: "-0:+5",
		dateFormat: 'dd-mm-yy'
	});
	  $('.datepicker_joining_date').datepicker({
		changeMonth: true,
		//minDate:"+0M + 0D",
		//maxDate:"+0M +0D",
		changeYear: true,
		yearRange: "-10:+10",
		dateFormat: 'dd-mm-yy'
	});
     $('.datepicker_passport_issuedate').datepicker({
		changeMonth: false,
		minDate:"+0M + 0D",
		//maxDate:"+0M +0D",
		changeYear: true,
		yearRange: "-0:+30",
		dateFormat: 'dd-mm-yy'
	});
    $('.datepicker_arrival').datepicker({
		changeMonth: false,
		minDate:"-5M + 0D",
		//maxDate:"+0M +0D",
		changeYear: true,
		yearRange: "-0:+5",
		dateFormat: 'dd/mm/yy'
	});
	 $('.datepicker_checklist').datepicker({
		changeMonth: false,
		minDate:"+0M + 0D",
		//maxDate:"+0M +0D",
		changeYear: false,
		yearRange: "-0:+0",
		dateFormat: 'dd/mm/yy'
	});
    
    $( ".datepicker_register" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "-60:-13",
		dateFormat: 'dd/mm/yy'
	});
	$( ".datepicker_visato" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "-10:+10",
		dateFormat: 'dd-mm-yy'
	});
	$( ".datepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "-100:+0",
		dateFormat: 'dd-mm-yy'
	});
	$('#chars_left_message').html(text_max + ' remaining');
		$('#postal_address').keyup(function() {
	  	var text_length = jQuery('#postal_address').val().length;
	  	var text_remaining = text_max - text_length;
	 	$('#chars_left_message').html(text_remaining + ' remaining');
	});
	$('.my_course_choice').on('change', function(){
	    $('.my_course_choice').not(this).prop('checked', false); 
	});
	
	/* Uploading */
	
	Dropzone.autoDiscover = false;
	
	Dropzone.options.universtiyLetter = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);
			var url      = window.location.href; 
			var n = url.lastIndexOf("/");
			var pathtoredirect= url.substring(n);
			
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Letter Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();window.location.reload();}}]});
				$('#universtiyLetterdiv').modal('hide');
				this.removeFile(file);
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Error in uploading..!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
			}
	    },
	    sending: function(file, xhr, formData){
           formData.append("application_no", universityLetterId);
           formData.append("uniId", universityId);
           formData.append("opt", universityOption);
        },      
	   // params: {'application_no':universityLetterId,'uniId':universityId,'opt':universityOption},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles: "image/*, .pdf",
	    maxFilesize:5,
	    parallelUploads:1
	}
	Dropzone.options.UploadUnderTaking = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);
			var url      = window.location.href; 
			var n = url.lastIndexOf("/");
			var pathtoredirect= url.substring(n);
			
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Signature Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
				var thml = '<a target="_blank" href="'+jsresp.file_path+'" target="_blank" title="Click to View Signature"><img  style="border:1px solid #cecece;padding:2px;width:50px;max-height:40px;" class="pull-right" src="'+jsresp.file_path+'"/></a>';
				
				$('.signaturediv_img').nextAll().remove();
				$('.signaturediv_img').after(thml);
				$('.signaturediv_img').text('Re-Upload Signature');
				$('#signature').modal('hide');
				this.removeFile(file);
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Error in uploading..!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
			}
	    },
	    sending: function(file, xhr, formData){
           formData.append("csrf_test_name", csrf_test_name);
        },      
	    params: {'csrf_test_name':csrf_test_name},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles: "image/*, .pdf",
	    maxFilesize:5,
	    parallelUploads:1
	}
	Dropzone.options.signatureUpload = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);
			var url      = window.location.href; 
			var n = url.lastIndexOf("/");
			var pathtoredirect= url.substring(n);
			
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Signature Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
				var thml = '<a target="_blank" href="'+jsresp.file_path+'" target="_blank" title="Click to View Signature"><img id="signatureImageImg" name="signatureImageImg"  style="border:1px solid #cecece;padding:2px;width:50px;max-height:40px;" class="pull-right" src="'+jsresp.file_path+'"/></a>';
				
				$('.signaturediv_img').nextAll().remove();
				$('.signaturediv_img').after(thml);
				$('.signaturediv_img').text('Re-Upload Signature');
				$('#signature').modal('hide');
				this.removeFile(file);
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: jsresp.message ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
			}
	    },
	    sending: function(file, xhr, formData){
           formData.append("csrf_test_name", csrf_test_name);
        },      
	    params: {'csrf_test_name':csrf_test_name},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles: "image/*",
	    maxFilesize:5,
	    parallelUploads:1
	}
	Dropzone.options.profilePic = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);
			var url      = window.location.href; 
			var n = url.lastIndexOf("/");
			var pathtoredirect= url.substring(n);
			
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Profile Pic Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
				$("#profil_image_div").attr("src",jsresp.file_path);
				$('#profileUploadsPic').modal('hide');
				this.removeFile(file);
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: jsresp.message ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
			}
	    },
	    sending: function(file, xhr, formData){
           formData.append("csrf_test_name", csrf_test_name);
        },      
	    params: {'csrf_test_name':csrf_test_name},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles: "image/*",
	    maxFilesize:5,
	    parallelUploads:1
	}	
	Dropzone.options.translationUpload = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Translation Document Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close(); location.href = location.href;}}]});
				
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: jsresp.message ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();  location.href = location.href;}}]});
			}
	    },
	    params: {'csrf_test_name':csrf_test_name},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles: "image/*, .pdf",
	    maxFilesize:5,
	    parallelUploads:1
	}
	Dropzone.options.licenceUpload = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Licence Document Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close(); location.href = location.href;}}]});
				
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: jsresp.message ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();  location.href = location.href;}}]});
			}
	    },
	    params: {'csrf_test_name':csrf_test_name},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles: "image/*, .pdf",
	    maxFilesize:5,
	    parallelUploads:1
	}
	Dropzone.options.schoolLiving = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "School Living Document Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close(); location.href = location.href;}}]});
				
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: jsresp.message ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();  location.href = location.href;}}]});
			}
	    },
	    params: {'csrf_test_name':csrf_test_name},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles:"image/*,.pdf",
	    maxFilesize:5,
	    parallelUploads:1
	}
	
	Dropzone.options.underGraduate = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);
			
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Under Graduate Document Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();location.href = location.href;}}]});				
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: jsresp.message ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
			}
	    },
	    params: {'csrf_test_name':csrf_test_name},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles: "image/*,.pdf",
	    maxFilesize:5,
	    parallelUploads:1
	}
	
	Dropzone.options.postGraduate = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);		
			
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Post Graduate Document Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();location.href = location.href;}}]});
				
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Error in uploading..!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
			}
	    },
	    params: {'csrf_test_name':csrf_test_name},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles: "image/*,.pdf",
	    maxFilesize:5,
	    parallelUploads:1
	}
	
	Dropzone.options.phd = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);			
			
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Phd Document Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();location.href = location.href;}}]});
				
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Error in uploading..!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();location.href = location.href;}}]});
			}
	    },
	    params: {'csrf_test_name':csrf_test_name},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles: "image/*,.pdf",
	    maxFilesize:5,
	    parallelUploads:1
	}
	
	Dropzone.options.panCard = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);
			
			
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "PAN Card Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();location.href = location.href;}}]});
				
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Error in uploading..!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
			}
	    },
	    params: {'csrf_test_name':csrf_test_name},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles: "image/*,.pdf",
	    maxFilesize:5,
	    parallelUploads:1
	}
	
	Dropzone.options.idProof = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);			
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "ID Proof Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();location.href = location.href;}}]});
				
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Error in uploading..!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
			}
	    },
	    params: {'csrf_test_name':csrf_test_name},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles: "image/*,.pdf",
	    maxFilesize:5,
	    parallelUploads:1
	}
	
	Dropzone.options.addressProof = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);			
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Address Proof Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();location.href = location.href;}}]});
				
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Error in uploading..!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
			}
	    },
	    params: {'csrf_test_name':csrf_test_name},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles: "image/*,.pdf",
	    maxFilesize:5,
	    parallelUploads:1
	}
	
	Dropzone.options.physicalFitness = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);			
			
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Physical Fitness Document Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();
				location.href = location.href;
				}}]});
				
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Error in uploading..!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
			}
	    },
	    params: {'csrf_test_name':csrf_test_name},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles: "image/*,.pdf",
	    maxFilesize:5,
	    parallelUploads:1
	}
	Dropzone.options.gmatScore = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);			
			
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Gmat Score Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();
				location.href = location.href;
				}}]});
				
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Error in uploading..!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
			}
	    },
	    params: {'csrf_test_name':csrf_test_name},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles: "image/*,.pdf",
	    maxFilesize:5,
	    parallelUploads:1
	}
	Dropzone.options.mphil = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);			
			
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Mphil Document Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();
				location.href = location.href;
				}}]});
				
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message:jsresp.message  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
			}
	    },
	    params: {'csrf_test_name':csrf_test_name},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles: "image/*,.pdf",
	    maxFilesize:5,
	    parallelUploads:1
	}
	
	Dropzone.options.passport = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);			
			
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Passport Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();
				location.href = location.href;
				}}]});
				
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: jsresp.message ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
			}
	    },
	    params: {'csrf_test_name':csrf_test_name},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles: "image/*,.pdf",
	    maxFilesize:5,
	    parallelUploads:1
	}
		
			Dropzone.options.phdResearch = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Phd Reseach Paper Document Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close(); location.href = location.href;}}]});
				
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: jsresp.message ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();  location.href = location.href;}}]});
			}
	    },
	    params: {'csrf_test_name':csrf_test_name},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles:"image/*,.pdf",
	    maxFilesize:5,
	    parallelUploads:1
	}
	
	
		Dropzone.options.otherDoc = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Other Document Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close(); location.href = location.href;}}]});
				
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: jsresp.message ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();  location.href = location.href;}}]});
			}
	    },
	    params: {'csrf_test_name':csrf_test_name},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles:"image/*,.pdf",
	    maxFilesize:5,
	    parallelUploads:1
	}
		Dropzone.options.expDivId = {	  
	    success: function(file, response){
			var jsresp = JSON.parse(response);
	        if(jsresp.status == true){
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Expenditure Document Uploaded Successfully!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close(); location.href = location.href;}}]});
				
			}
			else if(jsresp.status == false)
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: jsresp.message ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();  location.href = location.href;}}]});
			}
	    },
	    params: {'csrf_test_name':csrf_test_name},
	    dictDefaultMessage:"Click / Drop here to upload files",
	    addRemoveLinks: true,
	    dictRemoveFile:"Remove",
	    maxFiles:1,
        acceptedFiles:"image/*,.pdf",
	    maxFilesize:5,
	    parallelUploads:1
	}
	$(function() {
	  /* Upload Profile Pic */
		$('#profilePic').dropzone({ url: baseURL + "applicant/uploadProfilePic",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});	
		
		$('#schoolLiving').dropzone({ url: baseURL + "applicant/uploadSchoolLeaving",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});	
		
		$('#underGraduate').dropzone({ url: baseURL + "applicant/uploadUnderGraduate",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});	
		
		$('#postGraduate').dropzone({ url: baseURL + "applicant/uploadPostGraduate",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});	
		
		$('#phd').dropzone({ url: baseURL + "applicant/uploadPhd",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});	
		
		$('#panCard').dropzone({ url: baseURL + "applicant/uploadPanCard",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});	
		
		$('#idProof').dropzone({ url: baseURL + "applicant/uploadIdProof",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});	
		
		$('#addressProof').dropzone({ url: baseURL + "applicant/uploadAddressProof",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});	
		
		$('#physicalFitness').dropzone({ url: baseURL + "applicant/uploadPhysicalFitness",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});	
		
		$('#gmatScore').dropzone({ url: baseURL + "applicant/uploadGmatScore",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});
		
		$('#mphil').dropzone({ url: baseURL + "applicant/uploadMphil",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});	
		
		$('#passport').dropzone({ url: baseURL + "applicant/uploadPassport",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});	
		$('#licenceUpload').dropzone({ url: baseURL + "applicant/uploadLicence",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});
		$('#translationUpload').dropzone({ url: baseURL + "applicant/uploadTranslation",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});
		
		$('#signatureUpload').dropzone({ url: baseURL + "applicant/uploadSignature",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});
		$('#UploadUnderTaking').dropzone({ url: baseURL + "mission/UploadUnderTaking",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});
		$('#universtiyLetter').dropzone({ url: baseURL + "regional/universtiyLetter",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});
		
		$('#phdResearch').dropzone({ url: baseURL + "applicant/uploadPhdResearchPaper",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});
		
		$('#otherDoc').dropzone({ url: baseURL + "applicant/uploadOtherDocs",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});
		
		$('#expDivId').dropzone({url: baseURL + "regional/uploadExpenditure",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});	
		
		
	});
	
	
	var applicationStep = getParameterByName("step");	
	if(applicationStep != null && applicationStep != "" && applicationStep > 0)
	{
		switch(applicationStep)
		{
			case "1":
			$("#home").show();
			$("#step1").removeClass("fade");
			$("#step1").removeClass("fade");
			$("#step1").removeClass("fade");
			break;
			case '2':
			$("#step1").removeClass("fade");
			$("#step1").addClass("fade in active");
			$("#home").removeClass("fade in active");
			$("#step2").removeClass("fade in active");
			$("#step3").removeClass("fade in active");
			break;
			case "3":
			$("#step2").removeClass("fade");
			$("#step2").addClass("fade in active");
			$("#home").removeClass("fade in active");
			$("#step1").removeClass("fade in active");
			$("#step3").removeClass("fade in active");
			break;
			case "4":
			$("#step3").removeClass("fade");
			$("#step3").addClass("fade in active");
			$("#home").removeClass("fade in active");
			$("#step1").removeClass("fade in active");
			$("#step2").removeClass("fade in active");
			break;
		}
		
	}	
});
$(document).ready(function() {
    $('.customTable').DataTable();   
});
$(function(){
	
	$('#mission_made_through').change(function(){
		var mmthrough = $(this).val();
		if(mmthrough > 0)
		{
			$.ajax({
		    type: "POST",
		    url: baseURL +'applicant/getMissionsByCountry',
		    data: {'countryId' : mmthrough},
		    dataType:'json',
		    success: function (data) {	
		    var htm = "<option value=''>-- Select --</option>";
		    	if(data.status == true)
		    	{
					//alert("h1");
		    		for(var i=0; i<data.jsondata.length; i++)
		    		{
						htm += "<option value='" + data.jsondata[i].id + "'>" + data.jsondata[i].mission_type + " " + data.jsondata[i].mission_name + "</option>";
					}
					$('.mission_list').removeClass("fade");
					$('.mission_list').addClass("fade in");
				}
				else if(data.status == false)
		    	{
		    		$('.mission_list').removeClass("fade in");
					$('.mission_list').addClass("fade");
					//alert("hi");
				}
				
				$('#application_through').html(htm);
		      },
		      error: function(jqXHR, text, error){		             
		      }
		   });
		}
		else
		{
			
		}
	});
	
	
		$('#mission_made_through_alumini').change(function(){
		var mmthrough = $(this).val();
		if(mmthrough > 0)
		{
			$.ajax({
		    type: "POST",
		    url: baseURL +'home/getMissionsByCountry',
		    data: {'countryId' : mmthrough},
		    dataType:'json',
		    success: function (data) {	
		    var htm = "<option value=''>-- Select --</option>";
		    	if(data.status == true)
		    	{
					//alert("h1");
		    		for(var i=0; i<data.jsondata.length; i++)
		    		{
						htm += "<option value='" + data.jsondata[i].id + "'>" + data.jsondata[i].mission_type + " " + data.jsondata[i].mission_name + "</option>";
					}
					$('.mission_list').removeClass("fade");
					$('.mission_list').addClass("fade in");
				}
				else if(data.status == false)
		    	{
		    		$('.mission_list').removeClass("fade in");
					$('.mission_list').addClass("fade");
					//alert("hi");
				}
				
				$('#application_through').html(htm);
		      },
		      error: function(jqXHR, text, error){		             
		      }
		   });
		}
		else
		{
			
		}
	});
	
/*$("#form-one-application").submit(function(){   
var  formID = $(this).attr('id');
var formDetails = $('#'+formID);
	
		$.ajax({
	    type: "POST",
	    url: baseURL +'applicant/applicationStepOne',
	    data: formDetails.serialize(),
	    dataType:'json',
	    success: function (data) {	
	    	if(data.status == true)
	    	{
	    		BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: data.message ,buttons: [{label: 'OK',action: function(dialogItself) {
	    			dialogItself.close();
	    			$("#step1").removeClass("fade");
					$("#step1").addClass("fade in active");
					$("#home").removeClass("fade in active");
					$("#step2").removeClass("fade in active");
					$("#step3").removeClass("fade in active");
					$("#form-one-application input[type=hidden]").val(data.csrf);
					$("#form-two-application input[type=hidden]").val(data.csrf);
					$("#form-three-application input[type=hidden]").val(data.csrf);
					
					window.history.pushState({}, "Indian Council for Cultural Relations",  baseURL + "applicant/application/education") ;
	    			}}]});
			}
			else
			{
				$("#form-one-application input[type=hidden]").val(data.csrf);
			}
	      },
	      error: function(jqXHR, text, error){
	            BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: data.message ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});    
	      }
	   });
	
    return false;
  });*/
/*$("#form-two-application").submit(function(){   
var  formID = $(this).attr('id');
var formDetails = $('#'+formID);
	
		$.ajax({
	    type: "POST",
	    url: baseURL +'applicant/applicationStepTwo',
	    data: formDetails.serialize(),
	    dataType:'json',
	    success: function (data) {	
	    	if(data.status == true)
	    	{
	    		var appno = getParameterByName("appno");
	    		location.href = baseURL + "applicant/applicant_education_info/" + appno;
			}
			else
			{
				$("#form-two-application input[type=hidden]").val(data.csrf);
			}
	      },
	      error: function(jqXHR, text, error){
	                
	      }
	   });
	
    return false;
  });*/
 /* $("#form-three-application").submit(function(){   
var  formID = $(this).attr('id');

var formDetails = $('#'+formID);
	
		$.ajax({
	    type: "POST",
	    url: baseURL +'applicant/applicationStepThree',
	    data: formDetails.serialize(),
	    dataType:'json',
	    success: function (data) {	
	    	if(data.status == true)
	    	{
	    		BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: data.message ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
	    		$("#step3").removeClass("fade");
				$("#step3").addClass("fade in active");
				$("#home").removeClass("fade in active");
				$("#step1").removeClass("fade in active");
				$("#step2").removeClass("fade in active");
				$("#form-one-application input[type=hidden]").val(data.csrf);
				$("#form-two-application input[type=hidden]").val(data.csrf);
				$("#form-three-application input[type=hidden]").val(data.csrf);
				
			}
	      },
	      error: function(jqXHR, text, error){
	                
	      }
	   });
	
    return false;
  });*/
}); 
function refresh_login()
{
	$("#username").val("");
	$("#pass").val("");
	$("#captchatext").val("");
}
function validateFieldsOtherInfo()
{	
	if($("#signatureImageImg").length <= 0)
	{
		$('.signaturediv_img').css("border","1px solid red");
		return false;
	}
	return true;
}
function validateFieldsPersonalInfo()
{	
	var pics = $("#profil_image_div").attr("src").split('/');
	if(pics[pics.length-1] == "default_avatar.png")
	{
		$("#profil_image_div").attr("style","border:1px solid red");
		//$('body').scrollTop(200);
		
		$('body,html').animate({ scrollTop: 200 }, 500, function() {  
		});
				
		return false;
	}
	return true;
}
function hold_application(appid)
{
	$.ajax({
	    type: "POST",
	    url: baseURL +'mission/holdApplication',	   
	    data:{'appno':appid},
	    dataType:'json',	   
	    success: function (data) {
	    	csrfName = data.csrfName;
			csrfHash = data.csrfHash;
			var htm = "<option value=''>Select Course</option>";
	    	if(data.status == true)
    		{	    		
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Application " + appid + " is now on hold!" ,buttons: [{label: 'Ok',action: function(dialogItself) {location.href = baseURL + "mission/dashboard";}}]});				
			}					    	     	
	      },
	      error: function(jqXHR, text, error){
	               BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Success" ,message: "Some Error Occured While Updating!" ,buttons: [{label: 'Ok',action: function(dialogItself) {dialogItself.close();}}]});	 
	      }
	   });
}
function isInArray(value, array) {
  return array.indexOf(value) > -1;
}
function containsAll(check, arr){ 
  var found = true;
	for (var i = 0; i < check.length; i++) {		
	    if (arr.indexOf(check[i]) == -1) {
	        found = false;
	        break;
	    }
	}
  return found;
}
function showprocess(acton)
{
	//alert('ok');
	var chklist = $('#checklist_10').val();
	var boxes = $('input[name=checklist_10]:checked');
	console.log(boxes.length);

    //if (boxes.length == 0) {
        //BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Warning" ,message: "Please Check the point no 6 (Marks of English test conducted by Mission/Post and Certificate of proficiency in English to be uploaded. Answer sheets to be sent to ICCR by post) if you are processing the application!" ,buttons: [{label: 'Ok',action: function(dialogItself) {dialogItself.close();}}]});	
    //} 
	switch(acton)
	{
		case "reject":
		$('#schemes_selection').hide();
		$('#process_selection').show();
		$('.process-submit').val("Reject Application")
		break;
		case "process":
		$('#schemes_selection').hide();
		$('#process_selection').hide();
		if($('#testmarks').val() == "")
		{
			BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Warning" ,message: "Test Marks Not Valid!" ,buttons: [{label: 'Ok',action: function(dialogItself) {dialogItself.close();}}]});						
		}
		else if($('#testmarks').val() != "")
		{
			if(false == containsAll(applicant_check,checklist) || false == containsAll(mission_check,checklist))
			{				
										
				$('#schemes_selection').hide();
				$('#schloarship_name').removeAttr("required");
				$('#process_selection').show();				
			}
			else
			{
				
				$('#schemes_selection').show();
				$('#schloarship_name').attr("required","true");
				$('#process_selection').show();
			}			
			$('.process-submit').val("Submit Application");
		}		
		break;
	}
}
function forwardtouniversity(appid)
{
	BootstrapDialog.show({type: BootstrapDialog.TYPE_WARNING ,title: "Warning" ,message: "Are you sure you want to Forward!!" ,buttons: [{label: 'Ok',action: function(dialogItself) {dialogItself.close();location.href= baseURL + "regional/forwardtouniversity/" + appid;}},{label: 'Cancel',action: function(dialogItself) {dialogItself.close();}}]}); 
}
function showForwardRegional()
{
	$('.forwarddiv_regional').removeClass("fade");
	$('.forwarddiv_regional').addClass("fade in");
}
function forwardtoMission(appid)
{
	BootstrapDialog.show({type: BootstrapDialog.TYPE_WARNING ,title: "Warning" ,message: "Are you sure you want to Forward!!" ,buttons: [{label: 'Ok',action: function(dialogItself) {dialogItself.close();location.href = baseURL + "headquarter/forwardtoMission/" + appid;}},{label: 'Cancel',action: function(dialogItself) {dialogItself.close();}}]}); 
}
function confirmtoRegionforTravelPlan(appid)
{
	BootstrapDialog.show({type: BootstrapDialog.TYPE_WARNING ,title: "Warning" ,message: "Are you sure you want to Confirm!!" ,buttons: [{label: 'Ok',action: function(dialogItself) {dialogItself.close();location.href = baseURL + "mission/confirmregionforTravel/" + appid;}},{label: 'Cancel',action: function(dialogItself) {dialogItself.close();}}]}); 
}
function confirmtoHqrsofAcceptance(appid)
{
	BootstrapDialog.show({type: BootstrapDialog.TYPE_WARNING ,title: "Warning" ,message: "Are you sure you want to Confirm to Hqrs!!" ,buttons: [{label: 'Ok',action: function(dialogItself) {dialogItself.close();location.href = baseURL + "mission/confirmtomissionofuseracceptance/" + appid;}},{label: 'Cancel',action: function(dialogItself) {dialogItself.close();}}]}); 
}
function candidateacceptance(acton,appid)
{
	switch(acton)
	{
		case "Reject":
		BootstrapDialog.show({type: BootstrapDialog.TYPE_WARNING ,title: "Warning" ,message: "Are you sure you scholar want to Reject.!!" ,buttons: [{label: 'Ok',action: function(dialogItself) {dialogItself.close();location.href= baseURL + "mission/rejection/" + appid;}},{label: 'Cancel',action: function(dialogItself) {dialogItself.close();}}]}); 
		break;
		case "Accept":
		BootstrapDialog.show({type: BootstrapDialog.TYPE_WARNING ,title: "Warning" ,message: "Are you sure you scholar accepted!" ,buttons: [{label: 'Ok',action: function(dialogItself) {dialogItself.close();location.href= baseURL + "mission/acceptance/" + appid;}},{label: 'Cancel',action: function(dialogItself) {dialogItself.close();}}]}); 
		break;
	}
}
function applicaiton_process(acton,appid)
{	
	switch(acton)
	{
		case "Rejected":
		BootstrapDialog.show({type: BootstrapDialog.TYPE_WARNING ,title: "Warning" ,message: "Are you sure you want to rejected!!" ,buttons: [{label: 'Ok',action: function(dialogItself) {dialogItself.close();location.href= baseURL + "mission/rejected/" + appid;}},{label: 'Cancel',action: function(dialogItself) {dialogItself.close();}}]}); 
		break;
		case "Process":
		BootstrapDialog.show({type: BootstrapDialog.TYPE_WARNING ,title: "Warning" ,message: "Are you sure you want to proceed!!" ,buttons: [{label: 'Ok',action: function(dialogItself) {dialogItself.close();location.href= baseURL + "mission/process/" + appid;}},{label: 'Cancel',action: function(dialogItself) {dialogItself.close();}}]}); 
		break;
	}
	
}
function applicaiton_process_pending(acton,appid)
{	
	BootstrapDialog.show({type: BootstrapDialog.TYPE_WARNING ,title: "Warning" ,message: "Are you sure you want to proceed!!" ,buttons: [{label: 'Ok',action: function(dialogItself) {dialogItself.close();location.href= baseURL + "mission/pending_process/" + appid;}},{label: 'Cancel',action: function(dialogItself) {dialogItself.close();}}]}); 
}




function applicaiton_process_by_university(acton,appid)
{	
	switch(acton)
	{
		case "Rejected":
		BootstrapDialog.show({type: BootstrapDialog.TYPE_WARNING ,title: "Warning" ,message: "Are you sure you want to rejected!!" ,buttons: [{label: 'Ok',action: function(dialogItself) {dialogItself.close();location.href= baseURL + "university/rejected/" + appid;}},{label: 'Cancel',action: function(dialogItself) {dialogItself.close();}}]}); 
		break;
		case "Process":
		BootstrapDialog.show({type: BootstrapDialog.TYPE_WARNING ,title: "Warning" ,message: "Are you sure you want to proceed!!" ,buttons: [{label: 'Ok',action: function(dialogItself) {dialogItself.close();location.href= baseURL + "university/process/" + appid;}},{label: 'Cancel',action: function(dialogItself) {dialogItself.close();}}]}); 
		break;
	}
	
}

function applicaiton_process_pending_by_university(acton,appid)
{	
	BootstrapDialog.show({type: BootstrapDialog.TYPE_WARNING ,title: "Warning" ,message: "Are you sure you want to proceed!!" ,buttons: [{label: 'Ok',action: function(dialogItself) {dialogItself.close();location.href= baseURL + "university/pending_process/" + appid;}},{label: 'Cancel',action: function(dialogItself) {dialogItself.close();}}]}); 
}

  $('#university_course_type').change(function(){	
alert('ok');
	var university_pg =$('#programme_university').val()
	var university_course_type =$('#university_course_type').val()
	//alert(university_pg);
			if(university_pg == 1 || university_pg == 2  || university_pg == 8)
			{
				
					$.ajax({
					type: "POST",
					url: baseURL +'university/getUniversityCourseProgramme',	   
					data: {"university_pg":university_pg,"university_course_type":university_course_type},
						success: function (data) {
						$("#university_courses").html(data);
						}
					})
			}
});


	$('#university_courses').change(function(){	

    var programme=$('#programme_university').val();
	var courseType = $('#university_course_type').val();
	var course = $('#university_courses').val();
	if(courseType == 1 || courseType == 3 || courseType == 4 || courseType == 5)
	{
			if(programme == 1 || programme == 2  || programme == 3 || programme == 4 || programme == 8)
			{
					$.ajax({
					type: "POST",
					url: baseURL +'university/getUniversityStreamByCourseProgrammeCoureseType',	   
					data: {"programme":programme,"courseType":courseType,"course":course},
						success: function (data) {
							//$('.modal-body').html(data);
						  // Display Modal
						  //$('#empModal').modal('show'); 
						$("#university_stream").html(data);
						
						}
					})
				
			}
			
	}
	

});


	$('#university_stream').change(function(){	

    var programme=$('#programme_university').val();
	var courseType = $('#university_course_type').val();
	var course = $('#university_course').val();
	var stream = $('#university_stream').val();
			if(programme == 1 || programme == 2  || programme == 3 || programme == 4 || programme == 8)
			{
					$.ajax({
					type: "POST",
					url: baseURL +'university/getUniversityStreamById',	 
					dataType:'json',
					data: {"programme":programme,"courseType":courseType,"course":course,"stream":stream},
						success: function (data) {
							//console.log(data);
						if(data.status == true)
		    		{	
		    			//courseList = data.data;
						
							
						htm1 = data.data[0].no_of_seat;
							
						
						$("#seats").val(htm1);
						
					}
					else
					{
						$("#seats").val('');
					}
						
						}
					})
			}
			
});
function showSecondForm()
{
	$("#step1").removeClass("fade");
	$("#step1").addClass("fade in active");
	$("#home").removeClass("fade in active");
	$("#step2").removeClass("fade in active");
	window.history.pushState({}, "Indian Council for Cultural Relations",  baseURL + "applicant/application/education") ;
}
function showFirstForm()
{
	$("#home").removeClass("fade");
	$("#home").addClass("fade in active");
	$("#step1").removeClass("fade in active");
	$("#step2").removeClass("fade in active");
	window.history.pushState({}, "Indian Council for Cultural Relations",  baseURL + "applicant/application/personal") ;
}
function showThirdForm()
{
	$("#step2").removeClass("fade");
	$("#step2").addClass("fade in active");
	$("#home").removeClass("fade in active");
	$("#step1").removeClass("fade in active");
}
function getCode(id)
{
	var schemeId = $("#" +  id).val();
	var code = Codes[schemeId];
	$('#code').val(code);
}
function getParameterByName(name, url) {
    if (!url) {
      url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
function getCourses(id)
{
	var programme = $('#programme').val();
	var frmdata = new FormData();		
		frmdata.append('programme', programme);		
		frmdata.append(csrfName, csrfHash);	
	$.ajax({
	    type: "POST",
	    url: baseURL +'applicant/getCourseByPrgramme',	   
	    data: frmdata,
	    dataType:'json',
	    processData: false,
   		contentType: false,
	    success: function (data) {
	    	csrfName = data.csrfName;
			csrfHash = data.csrfHash;
			var htm = "<option value=''>Select Course</option>";
	    	if(data.status == true)
    		{	    		
				
				if(data.data.length > 0)
				{
					for(var i=0; i<data.data.length; i++)
					{
						htm += "<option value='"+ data.data[i].id +"'>" + data.data[i].title + "</option>";
					}
				}
				$("#course").html(htm);
    	 		$("#programme").val(programme);
			}
			else if(data.status == false)
			{
				$("#course").html(htm);
			}		    	     	
	      },
	      error: function(jqXHR, text, error){
	                
	      }
	   });
	
}
// vipin change
function selectAyushUniversityChoice(id)
{
	//alert(id);
	var programme = $('#programmeayush').val();
	var course_types = $('#course_types').val();
	var course = $('#course').val();
	var datas = id.split('/');
	var uni_id = datas[0];
	var schemid_one = datas[1];
	var schemid_two = datas[2];
	//alert(uni_id);
	//alert(schemid_one);
	//alert(schemid_two);
	
	  // AJAX request
   $.ajax({
    url: baseURL +'applicant/selectedAyushSchemeUniversityData',
    type: 'post',
    data: {uni_id:uni_id,programme: programme,course_types:course_types,course:course},
    success: function(response){ 
      // Add response in Modal body
      $('.modal-body').html(response);

      // Display Modal
      $('#empModal').modal('show'); 
	  
	  var htmlFirst = $('#universty_choice').html();
	$('#universty_choice_two').html(htmlFirst);
	$('#universty_choice_two option[value="'+id+'"]').remove();
	$("#course_two").val("");
	//$('#universty_choice_two').val("");
    }
  });
	
	
	
}
function selectAyushUniversityChoice_third(uni_id)
{
	var programme = $('#programmeayush').val();
	var course_types = $('#course_types').val();
	var course = $('#course_two').val();
	var uni_id_two = $('#universty_choice_two').val();
	//alert(uni_id);
	//alert(uni_id_two);
	$.ajax({
    url: baseURL +'applicant/selectedAyushSchemeUniversityData',
    type: 'post',
    data: {uni_id:uni_id,programme: programme,course_types:course_types,course:course},
    success: function(response){ 
      // Add response in Modal body
      $('.modal-body').html(response);

      // Display Modal
      $('#empModal').modal('show'); 
	  
	var htmlFirst = $('#universty_choice_two').html();
	$('#universty_choice_three').html(htmlFirst);
	$('#universty_choice_three option[value="'+uni_id+'"]').remove();
	$('#universty_choice_three option[value="'+uni_id_two+'"]').remove();
	$("#course_three").val("");
    }
  });
	
}

function selectAyushUniversity_thirdpop(uni_id)
{
	var programme = $('#programmeayush').val();
	var course_types = $('#course_types').val();
	var course = $('#course_three').val();
	var uni_id_two = $('#universty_choice_three').val();
	$.ajax({
    url: baseURL +'applicant/selectedAyushSchemeUniversityData',
    type: 'post',
     data: {uni_id:uni_id,programme: programme,course_types:course_types,course:course},
    success: function(response){ 
      // Add response in Modal body
      $('.modal-body').html(response);

      // Display Modal
      $('#empModal').modal('show'); 
	  
	var htmlFirst = $('#universty_choice_three').html();
	//$('#universty_choice_three').html(htmlFirst);
	//$('#universty_choice_three option[value="'+uni_id+'"]').remove();
	//$('#universty_choice_three option[value="'+uni_id_two+'"]').remove();
    }
  });
	
}
function selectUniversityChoice(id)
{
	var htmlFirst = $('#universty_choice').html();
	$('#universty_choice_two').html(htmlFirst);
	$('#universty_choice_two option[value="'+id+'"]').remove();
}
function selectUniversityChoice_third(id)
{
	var htmlFirst = $('#universty_choice_two').html();
	$('#universty_choice_three').html(htmlFirst);
	$('#universty_choice_three option[value="'+id+'"]').remove();
}
function selectedUnvercity(id)
{
	var univercity=$('#universty_choice').val();
	var frmdata = new FormData();		
		frmdata.append('university', univercity);
		frmdata.append('university1', 0);
		frmdata.append(csrfName, csrfHash);	
	$.ajax({
	    type: "POST",
	    url: baseURL +'applicant/selectedUnvercity',	   
	    data: frmdata,
	    dataType:'json',
	    processData: false,
   		contentType: false,
	    success: function (data) {
	    	csrfName = data.csrfName;
			csrfHash = data.csrfHash;
			var htm = "<option value=''>Select</option>";
	    	if(data.status == true)
    		{ 
				if(data.data.length > 0)
				{
					for(var i=0; i<data.data.length; i++)
					{
						htm += "<option value='"+ data.data[i].id +"'>" + data.data[i].name + "</option>";
					}
				}
				$("#universty_choice_two").html(htm);
    	 		$("#selectedunivercityone").val(id);
			}
			else if(data.status == false)
			{
				$("#universty_choice_two").html(htm);
			}		    	     	
	      },
	      error: function(jqXHR, text, error){
	                
	      }
	   });
}
function selectedUnvercityOne(id)
{	
	var univercity=$('#universty_choice').val();
	var univercity1=$('#universty_choice_two').val();
	var frmdata = new FormData();		
		frmdata.append('university', univercity);
		frmdata.append('university1', univercity1);
		frmdata.append(csrfName, csrfHash);
	$.ajax({
    	type: "post",
	    url: baseURL +'applicant/selectedUnvercity',	    
	    data: frmdata,
	    dataType:'json',
	    processData: false,
		contentType: false,
	    success: function (data) {		   
			csrfName = data.csrfName;
			csrfHash = data.csrfHash;
			if(data.status == true)
			{
					var htm = "<option value=''>Select</option>";
					if(data.data.length > 0)
					{
						for(var i=0; i<data.data.length; i++)
						{
							htm += "<option value='"+ data.data[i].id +"'>" + data.data[i].name + "</option>";
						}
					}
					$("#universty_choice_three").html(htm);
		 			$("#universty_choice_two").val(id);
			}
      },
      error: function(jqXHR, text, error){
                console.log(jqXHR,text,error);
      }
   });
}

function showStipendMode(id)
{
	var stpvalue = $('#' + id).val();	
	if(stpvalue == 2 || stpvalue == 3 || stpvalue == 4 || stpvalue == 5)
	{
		$('.' + id).addClass("in");
	}
	else if(stpvalue <= 1)
	{
		$('.' + id).removeClass("in");
	}
}

function getMissonById(id)
{
	
	$.ajax({
	    type: "POST",
	    url: baseURL +'regional/getMissionsByCountry',	   
	    data: {'countryId':id},
	    dataType:'json',
	    success: function (data) {
			
			var htm = "<option value=''>Select</option>";
	    	if(data.status == true)
    		{	    		
				
				if(data.jsondata.length > 0)
				{
					for(var i=0; i<data.jsondata.length; i++)
					{
					htm += "<option value='" + data.jsondata[i].id + "'>" + data.jsondata[i].mission_type + " " + data.jsondata[i].mission_name + "</option>";
						
					}
				}
				
				
				$("#mission_made_through").html(htm);
			}
			else if(data.status == false)
			{
				$("#mission_made_through").html(htm);
			}		    	     	
	      },
	      error: function(jqXHR, text, error){
	                
	      }
	   });
	
}

function getAluminiMissonById(id)
{
	
	$.ajax({
	    type: "POST",
	    url: baseURL +'home/getMissionsByCountry',	   
	    data: {'countryId':id},
	    dataType:'json',
	    success: function (data) {
			
			var htm = "<option value=''>Select</option>";
	    	if(data.status == true)
    		{	    		
				
				if(data.jsondata.length > 0)
				{
					for(var i=0; i<data.jsondata.length; i++)
					{
					htm += "<option value='" + data.jsondata[i].id + "'>" + data.jsondata[i].mission_type + " " + data.jsondata[i].mission_name + "</option>";
						
					}
				}
				
				
				$("#mission_made_through_alumini").html(htm);
			}
			else if(data.status == false)
			{
				$("#mission_made_through_alumini").html(htm);
			}		    	     	
	      },
	      error: function(jqXHR, text, error){
	                
	      }
	   });
	
}

/* For Regional */
	
		$('#programmes').change(function(){
		
		var programme1 = $('#programmes').val();
		var frmdata = new FormData();		
		frmdata.append('programme', programme1);		
		//frmdata.append(csrfName, csrfHash);	
		$.ajax({
		    type: "POST",
		    url: baseURL +'regional/getCourseByPrgrammeold',	   
		    data: frmdata,
		    dataType:'json',
		    processData: false,
	   		contentType: false,
		    success: function (data) {
		    //	csrfName = data.csrfName;
				//csrfHash = data.csrfHash;
				var htm = "<option value=''>Select Course</option>";				
		    	if(data.status == true)
	    		{	    		
					
					if(data.data.length > 0)
					{
						for(var i=0; i<data.data.length; i++)
						{
							htm += "<option value='"+ data.data[i].id +"'>" + data.data[i].title + "</option>";
						}
					}
					$("#courses").html(htm);
	    	 		$("#programmes").val(programme1);
				}
				else if(data.status == false)
				{
					$("#courses").html(htm);
				}		    	     	
		      },
		      error: function(jqXHR, text, error){
		                
		      }
		   });
		
	});	
	
	
	//SUPER ADMIN
	
	/* For Headquarter */
	
		$('#programmes').change(function(){
		
		var programme1 = $('#programmes').val();
		var frmdata = new FormData();		
		frmdata.append('programme', programme1);		
		//frmdata.append(csrfName, csrfHash);	
		$.ajax({
		    type: "POST",
		    url: baseURL +'admin/getCourseByPrgrammeold',	   
		    data: frmdata,
		    dataType:'json',
		    processData: false,
	   		contentType: false,
		    success: function (data) {
		    //	csrfName = data.csrfName;
				//csrfHash = data.csrfHash;
				var htm = "<option value=''>Select Course</option>";				
		    	if(data.status == true)
	    		{	    		
					
					if(data.data.length > 0)
					{
						for(var i=0; i<data.data.length; i++)
						{
							htm += "<option value='"+ data.data[i].id +"'>" + data.data[i].title + "</option>";
						}
					}
					$("#courses").html(htm);
	    	 		$("#programmes").val(programme1);
				}
				else if(data.status == false)
				{
					$("#courses").html(htm);
				}		    	     	
		      },
		      error: function(jqXHR, text, error){
		                
		      }
		   });
		
	});
	
	
		function regdemo(){
	bootbox.prompt({
    title: "Are you applying for PHD Courses under all ICCR Scholarship Schemes or applying courses under Ayush Scholarship Scheme (UG/PG/PHD in ayuerveda,Yoga,Unani,Siddha and Homoeopathy) for academic session 2020-2021.Please note last date for submitting applications under Ayush Scholarship Scheme is 31 July 2020.",
 
    callback: function (result) {
		
			location.href = baseURL + "home/register";
			
		
		
        
    }
	
});
		};
		
		
		function reg(){
		bootbox.alert("are you applying for Ph.D Courses under all ICCR Scholarship Schemes or applying for courses under Ayush Scholarship Scheme (UG/PG/Ph.D in Ayuerveda,Yoga,Unani,Siddha and Homoeopathy) for academic session 2020-2021.Please note that last date for submitting applications under Ayush Scholarship Scheme has been extended till 30th September 2020. Applications for Ph.D courses under all other schemes of ICCR Scholarship has been extended till 30 September 2020.", function(){ 
		location.href = baseURL + "home/register";
    console.log('This was logged in the callback!'); 
});
		
		}
			function validateDob()
{
	var year = $("#applicant_year").val();
	var month = $("#applicant_month").val();
	var date = $("#applicant_date").val();
	$.ajax({
	    type: "POST",
	    url: baseURL +'home/getDob',	   
	    data: {'year':year,'month':month,'date':date},
	    dataType:'json',
	    success: function (data) {
	    	if(data.status == true)
    		{	    		
				//document.getElementById("submit").disabled = false;
				$(':input[type="submit"]').prop('disabled', false);
				
			}
			else
			{
				BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error" ,message: "Age should be greater then or equal to 18 years on 1st July of the academic year"  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();location.reload();}}]}); 
			//document.getElementById("submit").disabled = true;
			$(':input[type="submit"]').prop('disabled', true);
       //alert("Input Error - Age should be greater then or equal to 18");
			} 		    	     	
	      },
	      error: function(jqXHR, text, error){
	                
	      }
	   });
	   
	   
	   
	
}
	
	