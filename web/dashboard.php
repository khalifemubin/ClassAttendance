<?php
	session_start();
	
	if(!(isset($_SESSION["admin_id"])))
	{
		header("Location: index.php"); /* Redirect browser */
		exit();
	}
	
	header('Content-type: text/html; charset=UTF-8');
?>
<!doctype html>
<html lang="en">
<meta charset="utf-8" />
<head>  
  <title>Attendance :: Administration Page - Welcome</title>
  <link rel="stylesheet" href="jquery-ui/jquery-ui.css">
  <script src="js/jquery-1.10.2.js"></script>
  <script src="jquery-ui/jquery-ui.js"></script>
  
  <!--Loader Source (http://demos.mimiz.fr/jquery/loader) -->
  <script src="js/jquery.loader.js"></script>
  <link href="css/jquery.loader.css" rel="stylesheet" />
  
  <link rel="stylesheet" href="css/dashboard.css">
  <script>
	var dbCourseRecords = "";
	var dbStudentRecords = "";
	var dbAssignRecords = "";
	
	String.prototype.fulltrim=function(){return this.replace(/(?:(?:^|\n)\s+|\s+(?:$|\n))/g,'').replace(/\s+/g,' ');}
	
	function chkLogout()
	{
	  window.location.replace("logout.php");
	}
	
	$(function() {
		$( "#tabs" ).tabs();
		
		$.ajaxSetup({
			beforeSend: function(jqXHR, settings) {
				$.loader({
					className:"blue-with-image",
					content:''
				});
			},			
			complete(jqXHR,settings) {
				$.loader('close');
			}
			
		});
		
		
		
		var regexIP = new RegExp(/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/g);
		var regxWhole = new RegExp(/^\d+$/);
		var regexMAC = new RegExp(/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/);
		
		$(".div_add_edit").hide();

		$("#frm_add_edit_course").submit(function(e){
			e.preventDefault();
			
			var txtCourseName = $("#txtCourseName").val();
			var txtCourseDuration = $("#txtCourseDuration").val();
			
			//Begin validation
			if(txtCourseName.fulltrim()==""){
				$("#divCourseErrMsg").html("Please enter valid Course Name").show();
				return true;
			}	
			else if(regxWhole.test(txtCourseDuration)==false)
			{
				$("#divCourseErrMsg").html("Please enter valid number of days for Course Duration.").show();
				return false;
			}			
			else{
				$("#divCourseErrMsg").html("");
				$("#divCourseErrMsg").hide();				
				
				var strAjaxUrl = "";
				
				if($("#hidEditCourseId").val()=="")
					strAjaxUrl = "action_param=insert_course&txtCourseName="+encodeURIComponent($("#txtCourseName").val())+"&txtCourseDuration="+txtCourseDuration;
				else
					strAjaxUrl = "action_param=update_course&txtCourseName="+encodeURIComponent($("#txtCourseName").val())+"&txtCourseDuration="+txtCourseDuration+"&course_id="+$("#hidEditCourseId").val();						
			
				$.ajax({
					url: 'ajax_service.php',
					data: strAjaxUrl,
					success: addEditCourseMasterCallBack	
				});
			
			}
			
			
		});

		$("#frm_add_edit_student").submit(function(e){
			e.preventDefault();
			
			var txtStudentFName = $("#txtStudentFName").val();
			var txtStudentLName = $("#txtStudentLName").val();
			var txtStudentMobile = $("#txtStudentMobile").val();
			
			//Begin validation
			if(txtStudentFName.fulltrim()==""){
				$("#divStudentErrMsg").html("Please enter valid First Name").show();
				return true;
			}
			else if(txtStudentLName.fulltrim()==""){
				$("#divStudentErrMsg").html("Please enter valid Last Name").show();
				return true;
			}	
			else if(regxWhole.test(txtStudentMobile)==false)
			{
				$("#divStudentErrMsg").html("Please enter valid mobile number.").show();
				return false;
			}			
			else{
				$("#divStudentErrMsg").html("");
				$("#divStudentErrMsg").hide();				
				
				var strAjaxUrl = "";
				
				if($("#hidEditStudentId").val()=="")
					strAjaxUrl = "action_param=insert_student&txtStudentFName="+encodeURIComponent($("#txtStudentFName").val())+"&txtStudentLName="+encodeURIComponent($("#txtStudentLName").val())+"&txtStudentMobile="+encodeURIComponent($("#txtStudentMobile").val());
				else
					strAjaxUrl = "action_param=update_student&txtStudentFName="+encodeURIComponent($("#txtStudentFName").val())+"&txtStudentLName="+encodeURIComponent($("#txtStudentLName").val())+"&txtStudentMobile="+encodeURIComponent($("#txtStudentMobile").val())+"&student_id="+$("#hidEditStudentId").val();						
			
				$.ajax({
					url: 'ajax_service.php',
					data: strAjaxUrl,
					success: addEditStudentMasterCallBack	
				});
			
			}
			
			
		});

		$("#frm_assign").submit(function(e){
			e.preventDefault();
			
			var selCourseAssign = $("#selCourseAssign").val();
			var selStudentAssign = $("#selStudentAssign").val();
						
			//Begin validation
			if(selCourseAssign=="" || regxWhole.test(selCourseAssign)==false){
				$("#divAssignErrMsg").html("Please select Course").show();
				return true;
			}
			else if(selStudentAssign=="" || regxWhole.test(selStudentAssign)==false){
				$("#divAssignErrMsg").html("Please selct Student").show();
				return true;
			}			
			else{
				$("#divAssignErrMsg").html("");
				$("#divAssignErrMsg").hide();				
				
				var strAjaxUrl = "";
				
				//if($("#hidEditAssignId").val()=="")
					strAjaxUrl = "action_param=insert_map&course_id="+selCourseAssign+"&student_id="+selStudentAssign;
				/*else
					strAjaxUrl = "action_param=update_map&map_id="+$("#hidEditAssignId").val()+"&course_id="+selCourseAssign+"&student_id="+selStudentAssign;*/						
			
				$.ajax({
					url: 'ajax_service.php',
					data: strAjaxUrl,
					success: assignCourseStudentMasterCallBack
				});
			
			}
			
			
		});

		
		
		fetchCourseMasterData();
		
		fetchStudentMasterData();
		
		fetchMappingData();

	});

	//functions for Course tab starts
	function addEditCourseMasterCallBack(ajaxResponse)
	{		
		var result = ajaxResponse["add_course"];

		if(result.toLowerCase().fulltrim() == "success"){
			alert("Information saved successfully!");		
		}
		else if(result.toLowerCase().fulltrim() == "already"){
			alert("Course Name already exists");
		}
		else{
			alert("Error occured while saving Course, please try again later");
		}
		
		$("#divCourseErrMsg").html("");
		$("#divCourseErrMsg").hide();
		$("#add_edit_course").hide();
		
		fetchCourseMasterData();
	}
  
	function fetchCourseMasterData()
	{
		$(".appendedCourseMasterRow").html("");		
		$("#divAddEditCourseLink").show();
		$(".editCourseMasterInfo").val("");

		  //get content from database
		$.ajax({
			url: 'ajax_service.php',
			data: "action_param=fetch_course_master",
			success: fetch_course_masterCallBack
		});
	}

	function fetch_course_masterCallBack(data)
	{
		dbCourseRecords = data;
		
		if(data==null || data=="")
		{		  
			$("#no_course_records").show();
			$("#course_records").hide();
		}
		else{
			$("#no_course_records").hide();
			$("#course_records").show();

			var strElement = "";
			var selCourseAssign = "<option value=''>Select</option>";
			
			//console.log(Object.keys(data).length);
			
			for(i=0;i<data.length;i++)
			{
				strStatus = "";
				strActivation = "";
				
				strElement += "<div class='Row appendedCourseMasterRow'><div class='Cell'><p>"+(i+1)+"</p></div><div class='Cell'><p>"+data[i].course_name+"</p></div><div class='Cell'><p>"+data[i].duration+" days</p></div>";
								
				strElement += "<div class='Cell'><p>";
				strElement += "<a href='javascript:;' onclick=editCourseRecord("+data[i].course_id+")>Edit</a>";
				strElement += "&nbsp;|&nbsp;<a href='javascript:;' onclick=deleteCourseRecord("+data[i].course_id+")>Delete</a>";
				strElement += "</p>";
				strElement += "</div></div>";
				
				selCourseAssign+="<option value='"+data[i].course_id+"'>"+data[i].course_name+"</option>";
			}
			
			$("#tblCourseMasterHeading").after(strElement);
			$("#selCourseAssign").html(selCourseAssign);
		  
		}
	}

	function add_course()
	{
	  $("#add_edit_course").show();
	  $("#no_course_records").hide();
	  $("#divAddEditCourseLink").hide();
	  $("#course_records").hide();
	  $(".spnCourseAction").html("Add");
	}
	
	function cancelCourseAction()
	{
	  $("#divCourseErrMsg").html("");
	  $("#divCourseErrMsg").hide();
	  $("#add_edit_course").hide();	  
	  $("#divAddEditCourseLink").show();
	  
	  $(".editCourseMasterInfo").val("");
	  	  
	  //show-hide depending on db records
	  if(dbCourseRecords == null || dbCourseRecords=="")
	  {
		$("#no_course_records").show();
		$("#course_records").hide();
	  }
	  else{
		  $("#no_course_records").hide();
		  $("#course_records").show();
	  }
	  
	}

	function editCourseRecord(course_id)
	{
		$("#add_edit_course").show();
		$("#no_course_records").hide();	
		$("#divAddEditCourseLink").show();		
		$("#course_records").hide();

		//fetch the record to update from database
		$.ajax({
			url: 'ajax_service.php',
			data: "action_param=fetch_course_detail&course_id="+course_id,
			success: editCourseCallBack
		});
	}
	
	function editCourseCallBack(data)
	{
		if(data["action_error"] == undefined)
		{
			$("#hidEditCourseId").val(data.course_id);
			$("#txtCourseName").val(data.course_name);
			$("#txtCourseDuration").val(data.duration);			
		}
		else{
			alert("Error Occured while trying to fetch data for update. Please try again later");
			cancelCourseAction();
		}
	}
  
	function deleteCourseRecord(course_id)
	{		
		var confirmDelete = confirm("Are you sure, you want to delete this course?");
		if (confirmDelete == true)
		{
			$.ajax({
				url: 'ajax_service.php',
				data: "action_param=delete_course&course_id="+course_id,
				success: deleteCourseCallBack
			});
		}
	}
	
	function deleteCourseCallBack(ajaxResponse)
	{
		var result = ajaxResponse["delete_course"];

		if(result.toLowerCase().fulltrim() == "success")
			alert("Course deleted successfully");
		else
			alert("Error occured. Please try again later");
		
		fetchCourseMasterData();
	}	
	//functions for Course tab ends
	
	//functions for Student tab starts
	function fetchStudentMasterData()
	{
		$(".appendedStudentMasterRow").html("");		
		$("#divAddEditStudentLink").show();
		$(".editStudentMasterInfo").val("");

		  //get content from database
		$.ajax({
			url: 'ajax_service.php',
			data: "action_param=fetch_student_master",
			success: fetch_student_masterCallBack
		});
	}

	function fetch_student_masterCallBack(data)
	{
		dbStudentRecords = data;
		
		if(data==null || data =="")
		{		  
			$("#no_student_records").show();
			$("#student_records").hide();
		}
		else{
			$("#no_student_records").hide();
			$("#student_records").show();

			var strElement = "";
			var selStudentAssign="<option value=''>Select</option>";
			
			for(i=0;i<data.length;i++)
			{
				strStatus = "";
				strActivation = "";
				
				strElement += "<div class='Row appendedStudentMasterRow'><div class='Cell'><p>"+(i+1)+"</p></div><div class='Cell'><p>"+data[i].first_name+"</p></div><div class='Cell'><p>"+data[i].last_name+"</p></div><div class='Cell'><p>"+data[i].mobile_no+"</p></div>";
								
				strElement += "<div class='Cell'><p>";
				strElement += "<a href='javascript:;' onclick=editStudentRecord("+data[i].student_id+")>Edit</a>";
				strElement += "&nbsp;|&nbsp;<a href='javascript:;' onclick=deleteStudentRecord("+data[i].student_id+")>Delete</a>";
				strElement += "&nbsp;|&nbsp;<a href='javascript:;' onclick=printBarcode("+data[i].student_id+")>Print Barcode</a>";
				strElement += "</p>";
				strElement += "</div></div>";	

				selStudentAssign+= "<option value='"+data[i].student_id+"'>"+data[i].first_name+" "+data[i].last_name+"</option>";
			}
			
			$("#tblStudentMasterHeading").after(strElement);
			$("#selStudentAssign").html(selStudentAssign);
		  
		}
	}

	function addEditStudentMasterCallBack(ajaxResponse)
	{		
		var result = ajaxResponse["add_student"];

		if(result.toLowerCase().fulltrim() == "success"){
			alert("Information saved successfully!");		
		}
		else if(result.toLowerCase().fulltrim() == "already"){
			alert("Duplicate data. Information already exists");
		}
		else{
			alert("Error occured while saving Student, please try again later");
		}
		
		$("#divStudentErrMsg").html("");
		$("#divStudentErrMsg").hide();
		$("#add_edit_student").hide();
		
		fetchStudentMasterData();
	}
  
	function add_student()
	{
	  $("#add_edit_student").show();
	  $("#no_student_records").hide();
	  $("#divAddEditStudentLink").hide();
	  $("#student_records").hide();
	  $(".spnStudentAction").html("Add");
	}
	
	function cancelStudentAction()
	{
	  $("#divStudentErrMsg").html("");
	  $("#divStudentErrMsg").hide();
	  $("#add_edit_student").hide();	  
	  $("#divAddEditStudentLink").show();
	  
	  $(".editStudentMasterInfo").val("");
	  	  
	  //show-hide depending on db records
	  if(dbStudentRecords == null || dbStudentRecords == "")
	  {
		$("#no_student_records").show();
		$("#student_records").hide();
	  }
	  else{
		  $("#no_student_records").hide();
		  $("#student_records").show();
	  }
	  
	}

	function editStudentRecord(student_id)
	{
		$("#add_edit_student").show();
		$("#no_student_records").hide();	
		$("#divAddEditStudentLink").show();		
		$("#student_records").hide();
		$(".spnStudentAction").html("Update");

		//fetch the record to update from database
		$.ajax({
			url: 'ajax_service.php',
			data: "action_param=fetch_student_detail&student_id="+student_id,
			success: editStudentCallBack
		});
	}
	
	function editStudentCallBack(data)
	{
		if(data["action_error"] == undefined)
		{
			$("#hidEditStudentId").val(data.student_id);
			$("#txtStudentFName").val(data.first_name);
			$("#txtStudentLName").val(data.last_name);			
			$("#txtStudentMobile").val(data.mobile_no);			
		}
		else{
			alert("Error Occured while trying to fetch data for update. Please try again later");
			cancelStudentAction();
		}
	}
  
	function deleteStudentRecord(student_id)
	{		
		var confirmDelete = confirm("Are you sure, you want to delete this student?");
		if (confirmDelete == true)
		{
			$.ajax({
				url: 'ajax_service.php',
				data: "action_param=delete_student&student_id="+student_id,
				success: deleteStudentCallBack
			});
		}
	}
	
	function deleteStudentCallBack(ajaxResponse)
	{
		var result = ajaxResponse["delete_student"];

		if(result.toLowerCase().fulltrim() == "success")
			alert("Student deleted successfully");
		else
			alert("Error occured. Please try again later");
		
		fetchStudentMasterData();
	}	
	
	function printBarcode(student_id)
	{		
		var confirmDelete = confirm("Are you sure, you want to print barcode for this student?");
		if (confirmDelete == true)
		{
			$.ajax({
				url: 'ajax_service.php',
				data: "action_param=printBarcode&student_id="+student_id,
				success: printBarcodeCallBack
			});
		}
	}
	
	function printBarcodeCallBack(ajaxResponse)
	{
		var result = ajaxResponse["print_code"];
		if(result!=undefined){
			if(result.toLowerCase().fulltrim() == "error")
				alert("Error occured. Please try again later");
			else{				
				var w = window.open(result);
				w.print();
			}
		}
	}	
	
	
	//functions for Student tab ends
	
	//functions for Mapping tab starts
	function fetchMappingData()
	{
		$(".appendedAssignMasterRow").html("");		
		$("#divAddEditAssignLink").show();
		$(".editAssignMasterInfo").val("");

		  //get content from database
		$.ajax({
			url: 'ajax_service.php',
			data: "action_param=fetch_assign_master",
			success: fetch_assign_masterCallBack
		});
	}

	function fetch_assign_masterCallBack(data)
	{
		dbAssignRecords = data;
		
		if(data==null || data=="")
		{		  
			$("#no_assign_records").show();
			$("#assign_records").hide();
		}
		else{
			$("#no_assign_records").hide();
			$("#assign_records").show();

			var strElement = "";
			var strCourseAction = "";
		
			
			for(i=0;i<data.length;i++)
			{
				strStatus = "";
				strActivation = "";
				
				strElement += "<div class='Row appendedAssignMasterRow'><div class='Cell'><p>"+(i+1)+"</p></div><div class='Cell'><p>"+data[i].course_name+"</p></div><div class='Cell'><p>"+data[i].student_name+"</p></div>";
				
				if(data[i].course_complete==0)
					strCourseAction ="In Progress";
				else
					strCourseAction ="Complete";
								
				strElement += "<div class='Cell'><p>"+strCourseAction+"</p></div>";
				
				strElement += "<div class='Cell'><p>";
				//strElement += "<a href='javascript:;' onclick=editAssignRecord("+data[i].map_id+")>Edit</a>";
				strElement += "<a href='javascript:;' onclick=deleteAssignRecord("+data[i].map_id+")>Delete</a>";
				strElement += "&nbsp;|&nbsp;<a href='javascript:;' onclick=completeStudentCourse("+data[i].map_id+","+data[i].course_complete+") >Change Status</a>";
				strElement += "</p>";
				strElement += "</div></div>";				
			}
			
			$("#tblAssignMasterHeading").after(strElement);
		  
		}
	}

	function add_assign()
	{
	  $("#add_edit_assign").show();
	  $("#no_assign_records").hide();
	  $("#divAddEditAssignLink").hide();
	  $("#assign_records").hide();	  
	}
	
	function cancelAssignAction()
	{
	  $("#divAssignErrMsg").html("");
	  $("#divAssignErrMsg").hide();
	  $("#add_edit_assign").hide();	  
	  $("#divAddEditAssignLink").show();
	  
	  $(".editAssignMasterInfo").val("");
	  	  
	  //show-hide depending on db records
	  if(dbAssignRecords == null || dbAssignRecords == "")
	  {
		$("#no_assign_records").show();
		$("#assign_records").hide();
	  }
	  else{
		  $("#no_assign_records").hide();
		  $("#assign_records").show();
	  }
	  
	}

	function assignCourseStudentMasterCallBack(ajaxResponse)
	{		
		var result = ajaxResponse["assign"];

		if(result.toLowerCase().fulltrim() == "success"){
			alert("Information saved successfully!");		
		}
		else if(result.toLowerCase().fulltrim() == "already"){
			alert("Student's Course is in Progress");
		}
		else{
			alert("Error occured while saving Student, please try again later");
		}
		
		$("#divAssignErrMsg").html("");
		$("#divAssignErrMsg").hide();
		$("#add_edit_assign").hide();
		
		fetchMappingData();
	}
  
	/*
	function editAssignRecord(map_id)
	{
		$("#add_edit_assign").show();
		$("#no_assign_records").hide();	
		$("#divAddEditAssignLink").show();		
		$("#assign_records").hide();

		//fetch the record to update from database
		$.ajax({
			url: 'ajax_service.php',
			data: "action_param=fetch_mapping_detail&map_id="+map_id,
			success: editAssignCallBack
		});
	}
	
	function editAssignCallBack(data)
	{
		if(data["action_error"] == undefined)
		{
			$("#hidEditAssignId").val(data.map_id);
			$("#selCourseAssign").val(data.course_id);
			$("#selStudentAssign").val(data.student_id);					
		}
		else{
			alert("Error Occured while trying to fetch data for update. Please try again later");
			cancelStudentAction();
		}
	}
	*/
	
	function deleteAssignRecord(map_id)
	{		
		var confirmDelete = confirm("Are you sure, you want to delete this Mapping?");
		if (confirmDelete == true)
		{
			$.ajax({
				url: 'ajax_service.php',
				data: "action_param=delete_mapping&map_id="+map_id,
				success: deleteAssignCallBack
			});
		}
	}
	
	function deleteAssignCallBack(ajaxResponse)
	{
		var result = ajaxResponse["delete_mapping"];

		if(result.toLowerCase().fulltrim() == "success")
			alert("Mapping deleted successfully");
		else
			alert("Error occured. Please try again later");
		
		fetchMappingData();
	}	
	
	function completeStudentCourse(map_id,course_status)
	{
		var strCourseAction = "";
		if(course_status==0)
			strCourseAction ="Complete";
		else
			strCourseAction ="In Progress";
		
		var confirmComplete = confirm("Are you sure, you want to mark the Course as '"+strCourseAction+"' for this Student?");
		if (confirmComplete == true)
		{
			$.ajax({
				url: 'ajax_service.php',
				data: "action_param=complete_course&map_id="+map_id+"&course_status="+course_status,
				success: completeStudentCourseCallBack
			});
		}
	}
	
	function completeStudentCourseCallBack(ajaxResponse)
	{
		var result = ajaxResponse["course_complete"];

		if(result.toLowerCase().fulltrim() == "success")
			alert("Course status changed for the selected student");
		else
			alert("Error occured. Please try again later");
		
		fetchMappingData();
	}	
	
	//functions for Mapping tab ends
  
  
  </script>
</head>
<body>

<h1 id="dashboard_title">Attendance :: Administration</h1> 

<div class="parentForDivRightAlign">
    <div class="divLeftOfRight">
		&nbsp;
	 </div>
	 <div class="divRightOfRight">
		<a href="javascript:;" onclick="chkLogout();">Logout</a>
	 </div>
</div> 

<div class="divClr">&nbsp;</div>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Course Master</a></li>
		<li><a href="#tabs-2">Student Master</a></li>
		<li><a href="#tabs-3">Course-Student Mapping</a></li>
		<li><a href="#tabs-4">Attendance Report</a></li>
	</ul>
	
	<div id="tabs-1">
		
		<div id="no_course_records" class="no_records_found">
			<p>No records found.</p>
		</div>

		<div id="divAddEditCourseLink">Click <a href="javascript:;"onclick="add_course();">here</a> to add a Course</div>

		<div id="course_records" class="Table course_master_tbl">
			<div class="Title">
				<p>Courses</p>
			</div>
			<div id="tblCourseMasterHeading" class="Heading">
				<div class="Cell">
					<p>Sr. No.</p>
				</div>
				<div class="Cell">
					<p>Course Name</p>
				</div>
				<div class="Cell">
					<p>Course Duration (in days)</p>
				</div>			
				<div class="Cell">
					<p>Action</p>
				</div>
			</div>									
		</div>

		<div class="divError" id="divCourseErrMsg"></div>

		<div id="add_edit_course" class="Table div_add_edit">	
			<form id="frm_add_edit_course">
				<input type="hidden" id="hidEditCourseId" value="" class="editCourseMasterInfo"/>
				<div class="Title">
					<p><span class="spnCourseAction">Add</span> Course</p>
				</div>
				<div class="Row">
					<div class="Cell largeLbl">
						<p>Course Name</p>
					</div>
					<div class="Cell largeInput">
						<input type="text" id="txtCourseName" class="editCourseMasterInfo" />
					</div>
				</div>				
				<div class="Row">
					<div class="Cell largeLbl">
						<p>Course Durartion (in days)</p>
					</div>
					<div class="Cell largeInput">
						<input type="text" id="txtCourseDuration" class="editCourseMasterInfo" />
					</div>
				</div>
				<div class="divClr">&nbsp;</div>
				<div style="margin-left:35%;">
					<button id="btnAddEditCourse" type="submit"><span class="spnCourseAction">Add</span></button>&nbsp;&nbsp;&nbsp;
				
					<button type="button" onclick="cancelCourseAction();">Cancel</button>
				
				</div>	
			</form>
		</div>	
			
	</div>

	<div id="tabs-2">
		<div id="no_student_records" class="no_records_found">
			<p>No records found.</p>
		</div>

		<div id="divAddEditStudentLink">Click <a href="javascript:;"onclick="add_student();">here</a> to add a Student</div>
		
		<div id="student_records" class="Table student_master_tbl">
			<div class="Title">
				<p>Students</p>
			</div>
			<div id="tblStudentMasterHeading" class="Heading">
				<div class="Cell">
					<p>Sr. No.</p>
				</div>
				<div class="Cell">
					<p>First Name</p>
				</div>
				<div class="Cell">
					<p>Last Name</p>
				</div>		
				<div class="Cell">
					<p>Mobile</p>
				</div>			
				<div class="Cell">
					<p>Action</p>
				</div>
			</div>									
		</div>
		
		<div class="divError" id="divStudentErrMsg"></div>
				
		<div id="add_edit_student" class="Table div_add_edit">	
			<form id="frm_add_edit_student">
				<input type="hidden" id="hidEditStudentId" value="" class="editStudentMasterInfo"/>
				<div class="Title">
					<p><span class="spnStudentAction">Add</span> Student</p>
				</div>
				<div class="Row">
					<div class="Cell largeLbl">
						<p>First Name</p>
					</div>
					<div class="Cell largeInput">
						<input type="text" id="txtStudentFName" class="editStudentMasterInfo" />
					</div>
				</div>	
				<div class="Row">
					<div class="Cell largeLbl">
						<p>Last Name</p>
					</div>
					<div class="Cell largeInput">
						<input type="text" id="txtStudentLName" class="editStudentMasterInfo" />
					</div>
				</div>	
				<div class="Row">
					<div class="Cell largeLbl">
						<p>Mobile</p>
					</div>
					<div class="Cell largeInput">
						(+91)<input type="text" id="txtStudentMobile" class="editStudentMasterInfo" />
					</div>
				</div>
				<div class="divClr">&nbsp;</div>
				<div style="margin-left:35%;">
					<button id="btnAddEditStudent" type="submit"><span class="spnStudentAction">Add</span></button>&nbsp;&nbsp;&nbsp;
				
					<button type="button" onclick="cancelStudentAction();">Cancel</button>
				
				</div>	
			</form>
		</div>	
		
	</div>
	
	<div id="tabs-3">
		<div id="no_assign_records" class="no_records_found">
			<p>No records found.</p>
		</div>

		<div id="divAddEditAssignLink">Click <a href="javascript:;"onclick="add_assign();">here</a> to assign Student to Course</div>
		
		<div id="assign_records" class="Table assign_master_tbl">
			<div class="Title">
				<p>Assign Course to Student</p>
			</div>
			<div id="tblAssignMasterHeading" class="Heading">
				<div class="Cell">
					<p>Sr. No.</p>
				</div>
				<div class="Cell">
					<p>Course</p>
				</div>
				<div class="Cell">
					<p>Student Name</p>
				</div>
				<div class="Cell">
					<p>Status</p>
				</div>				
				<div class="Cell">
					<p>Action</p>
				</div>
			</div>									
		</div>
		
		<div class="divError" id="divAssignErrMsg"></div>
				
		<div id="add_edit_assign" class="Table div_add_edit">	
			<form id="frm_assign">
				<input type="hidden" id="hidEditAssignId" value="" class="editAssignMasterInfo"/>
				<div class="Title">
					<p>Assign</p>
				</div>
				<div class="Row">
					<div class="Cell largeLbl">
						<p>Course</p>
					</div>
					<div class="Cell largeInput">
						<select id="selCourseAssign" class="editAssignMasterInfo" >
							<option value="">Select</option>
						</select>
					</div>
				</div>	
				<div class="Row">
					<div class="Cell largeLbl">
						<p>Student</p>
					</div>
					<div class="Cell largeInput">
						<select id="selStudentAssign" class="editAssignMasterInfo" >
							<option value="">Select</option>
						</select>
					</div>
				</div>	
				<div class="divClr">&nbsp;</div>
				<div style="margin-left:35%;">
					<button id="btnAssignAssign" type="submit">Assign</button>&nbsp;&nbsp;&nbsp;
				
					<button type="button" onclick="cancelAssignAction();">Cancel</button>
				
				</div>	
			</form>
		</div>	
		
		
	</div>
	
	<div id="tabs-4">
		<strong>Coming Soon</strong>
	</div>
	
</div>
	 
 
</body>
</html>