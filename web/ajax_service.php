<?php
session_start();

include_once "db.php";

set_error_handler(function($errno, $errstr, $errfile, $errline, array $errcontext) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }

    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});


/*register_shutdown_function('fatalErrorShutdownHandler');

function fatalErrorShutdownHandler()
{
  $last_error = error_get_last();
  if ($last_error['type'] === E_ERROR) {
    // fatal error	
    throw new ErrorException($last_error['message'],0,$last_error['type'],$last_error['file'], $last_error['line']);
  }
}*/

$str_action_param = "";

if (isset($_REQUEST['action_param']))
{
	if (empty($_REQUEST['action_param'])){}
	else
	{
		$str_action_param = $_REQUEST['action_param'];
		
		switch ($str_action_param)
		{
			case "login_check":
				if (isset($_REQUEST["username"]) && !(empty($_REQUEST["username"])) && isset($_REQUEST["userpass"]) && !(empty($_REQUEST["userpass"])))
				{
					$username = $_REQUEST["username"];
					$userpass = $_REQUEST["userpass"];
					$objInfo = new ajax_action();
					header('Content-Type: application/json');
					echo $objInfo->login_check($username,$userpass);
				}
				else
					echo null;
			break;
			//Functions for Course tab starts
			case "fetch_course_master":	
				$objInfo = new ajax_action();
				header('Content-Type: application/json');
				echo $objInfo->fetch_course_master();	
			break;
			case "insert_course":
				if (isset($_REQUEST["txtCourseName"]) && !(empty($_REQUEST["txtCourseName"])) && isset($_REQUEST["txtCourseDuration"]) && !(empty($_REQUEST["txtCourseDuration"])))
				{
					$txtCourseName = $_REQUEST["txtCourseName"];
					$txtCourseDuration = $_REQUEST["txtCourseDuration"];
					
					$objInfo = new ajax_action();
					header('Content-Type: application/json');
					echo $objInfo->insert_course($txtCourseName,$txtCourseDuration);
				}
				else
					echo null;
			break;
			case "update_course":
				if (isset($_REQUEST["txtCourseName"]) && !(empty($_REQUEST["txtCourseName"])) && isset($_REQUEST["course_id"]) && !(empty($_REQUEST["course_id"])) && isset($_REQUEST["txtCourseDuration"]) && !(empty($_REQUEST["txtCourseDuration"])))
				{
					$txtCourseName = $_REQUEST["txtCourseName"];
					$course_id = $_REQUEST["course_id"];
					$txtCourseDuration = $_REQUEST["txtCourseDuration"];
					
					
					$objInfo = new ajax_action();
					header('Content-Type: application/json');
					echo $objInfo->update_course($txtCourseName,$course_id,$txtCourseDuration);
				}
				else
					echo null;
			break;		
			case "delete_course":
				if (isset($_REQUEST["course_id"]) && !(empty($_REQUEST["course_id"])))
				{					
					$course_id = $_REQUEST["course_id"];
					$objInfo = new ajax_action();
					header('Content-Type: application/json');
					echo $objInfo->delete_course($course_id);
				}
				else
					echo null;
			break;
			case "fetch_course_detail":
				if (isset($_REQUEST["course_id"]) && !(empty($_REQUEST["course_id"])))
				{					
					$course_id = $_REQUEST["course_id"];
					$objInfo = new ajax_action();
					header('Content-Type: application/json');
					echo $objInfo->fetch_course_detail($course_id);
				}
				else
					echo null;
			break;
			//Functions for Course tab ends			
			//Functions for Student tab starts
			case "fetch_student_master":	
				$objInfo = new ajax_action();
				header('Content-Type: application/json');
				echo $objInfo->fetch_student_master();	
			break;
			case "insert_student":
				if (isset($_REQUEST["txtStudentFName"]) && !(empty($_REQUEST["txtStudentFName"])) && isset($_REQUEST["txtStudentLName"]) && !(empty($_REQUEST["txtStudentLName"])))
				{
					$txtStudentFName = $_REQUEST["txtStudentFName"];
					$txtStudentLName = $_REQUEST["txtStudentLName"];
					$txtStudentMobile = $_REQUEST["txtStudentMobile"];
					
					$objInfo = new ajax_action();
					header('Content-Type: application/json');
					echo $objInfo->insert_student($txtStudentFName,$txtStudentLName,$txtStudentMobile);
				}
				else
					echo null;
			break;
			case "fetch_student_detail":
				if (isset($_REQUEST["student_id"]) && !(empty($_REQUEST["student_id"])))
				{					
					$student_id = $_REQUEST["student_id"];
					$objInfo = new ajax_action();
					header('Content-Type: application/json');
					echo $objInfo->fetch_student_detail($student_id);
				}
				else
					echo null;
			break;
			case "printBarcode":
				if (isset($_REQUEST["student_id"]) && !(empty($_REQUEST["student_id"])))
				{					
					$student_id = $_REQUEST["student_id"];
					$objInfo = new ajax_action();
					header('Content-Type: application/json');
					echo $objInfo->printBarcode($student_id);
				}
				else
					echo null;
			break;			
			case "update_student":
				if (isset($_REQUEST["txtStudentFName"]) && !(empty($_REQUEST["txtStudentFName"])) && isset($_REQUEST["txtStudentLName"]) && !(empty($_REQUEST["txtStudentLName"])) && isset($_REQUEST["txtStudentMobile"]) && !(empty($_REQUEST["txtStudentMobile"])) && isset($_REQUEST["student_id"]) && !(empty($_REQUEST["student_id"])) )
				{
					$txtStudentFName = $_REQUEST["txtStudentFName"];
					$student_id = $_REQUEST["student_id"];
					$txtStudentLName = $_REQUEST["txtStudentLName"];
					$txtStudentMobile = $_REQUEST["txtStudentMobile"];
					
					
					$objInfo = new ajax_action();
					header('Content-Type: application/json');
					echo $objInfo->update_student($txtStudentFName,$txtStudentLName,$txtStudentMobile,$student_id);
				}
				else
					echo null;
			break;
			case "delete_student":
				if (isset($_REQUEST["student_id"]) && !(empty($_REQUEST["student_id"])))
				{					
					$student_id = $_REQUEST["student_id"];
					$objInfo = new ajax_action();
					header('Content-Type: application/json');
					echo $objInfo->delete_student($student_id);
				}
				else
					echo null;
			break;
			//Functions for Student tab ends
			//Functions for Assign tab starts
			case "fetch_assign_master":	
				$objInfo = new ajax_action();
				header('Content-Type: application/json');
				echo $objInfo->fetch_assign_master();	
			break;
			case "insert_map":
				if (isset($_REQUEST["course_id"]) && !(empty($_REQUEST["course_id"])) && isset($_REQUEST["student_id"]) && !(empty($_REQUEST["student_id"])))
				{
					$course_id = $_REQUEST["course_id"];
					$student_id = $_REQUEST["student_id"];
					
					
					$objInfo = new ajax_action();
					header('Content-Type: application/json');
					echo $objInfo->insert_map($course_id,$student_id);
				}
				else
					echo null;
			break;
			case "delete_mapping":
				if (isset($_REQUEST["map_id"]) && !(empty($_REQUEST["map_id"])))
				{					
					$map_id = $_REQUEST["map_id"];
					$objInfo = new ajax_action();
					header('Content-Type: application/json');
					echo $objInfo->delete_mapping($map_id);
				}
				else
					echo null;
			break;
			case "complete_course":
				if (isset($_REQUEST["map_id"]) && isset($_REQUEST["course_status"]))
				{					
					$map_id = $_REQUEST["map_id"];
					$course_status = $_REQUEST["course_status"];
					
					$objInfo = new ajax_action();
					header('Content-Type: application/json');
					echo $objInfo->complete_course($map_id,$course_status);
				}
				else
					echo null;
			break;
			//Functions for Assign tab ends
			case "matchQR":
				if (isset($_REQUEST["txtQRCode"]) && !(empty($_REQUEST["txtQRCode"])))
				{					
					$txtQRCode = $_REQUEST["txtQRCode"];
					$objInfo = new ajax_action();
					header('Content-Type: application/json');
					echo $objInfo->matchQR($txtQRCode);
				}
				else
					echo null;
			break;
			case "markAttendance":
				if (isset($_REQUEST["map_id"]) && !(empty($_REQUEST["map_id"])))
				{					
					$map_id = $_REQUEST["map_id"];
					$objInfo = new ajax_action();
					header('Content-Type: application/json');
					echo $objInfo->markAttendance($map_id);
				}
				else
					echo null;
			break;
			/*
			case "activate_deactivate_user":
				if (isset($_REQUEST["course_id"]) && !(empty($_REQUEST["course_id"])) && isset($_REQUEST["action"]) && !(empty($_REQUEST["action"])))
				{					
					$course_id = $_REQUEST["course_id"];
					$action = $_REQUEST["action"];
					$objInfo = new ajax_action();
					header('Content-Type: application/json');
					echo $objInfo->activate_deactivate_user($course_id,$action);
				}
				else
					echo null;
			break;
			*/
			default:
				echo null;
				break;
		}
	}
}

class ajax_action
{
	function utf8ize($d)
    {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = $this->utf8ize($v);
            }
        } else if (is_string ($d)) {
            return utf8_encode($d);
        }
        return $d;
    }
	
	function login_check($username,$userpass)
    {
        global $conn;

		$isActive=1;
		
		/*** prepare the SQL statement ***/
        $stmt = $conn->prepare('SELECT * FROM admin_master WHERE user_name=:user_name AND user_pass = md5(:user_pass) AND isActive=:isActive ');
		/*** bind the paramaters ***/
		$stmt->bindParam(':user_name', $username, PDO::PARAM_STR);
		$stmt->bindParam(':user_pass', $userpass, PDO::PARAM_INT);
		$stmt->bindParam(':isActive', $isActive, PDO::PARAM_INT);

		$stmt->execute();

		/*** fetch the results ***/
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

        $row_cnt = $stmt->rowCount();

		$arr_res_json = array();
		
		
		if($row_cnt>0){
			//update the last login time in database
			$stmt_updt = $conn->prepare('UPDATE admin_master SET last_login=now() WHERE admin_id=:admin_id');
			$admin_id = $row["admin_id"];
			
			$stmt_updt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
			$stmt_updt->execute();			
			
			$_SESSION['admin_id'] = $admin_id;
			
			$arr_res_json["login_check"] = "success";
			//array_push($arr_res_json,"success");
		}else{
			$arr_res_json["login_check"] = "error";
			//array_push($arr_res_json,"error");
		}
		
		/*** close the database connection ***/
		$conn=null;
		
		//return json_encode($this->utf8ize($arr_res_json));
		return json_encode($arr_res_json);

    }
	
	//Functions for Course tab starts
	function fetch_course_master()
    {
        global $conn;
		$arr_res = array();

		try
		{
			$sql = "SELECT * FROM course_master ORDER BY course_id ASC";
			if($stmt = $conn->query($sql))
			{}
			else
				throw new Exception("DB Exception");

			$row_cnt = $stmt->rowCount();

			if ($row_cnt > 0)
			{
				/*** fetch the results ***/
				$arr_res = $stmt->fetchAll();
			}else{
				$arr_res = null;
			}
			//return json_encode($this->utf8ize(null));
			
			/*** close the database connection ***/
			$conn=null;			
			return json_encode($arr_res);
		}
		catch(PDOException $e)
		{
			$conn=null;			
			return json_encode($this->utf8ize(null));
		}
		catch(Exception $e) {
		  return json_encode($this->utf8ize(null));
		}
    }
	
	function insert_course($txtCourseName,$txtCourseDuration)
    {
        global $conn;
		$arr_res_json = array();
		
		try
		{
			//check to avoid duplicate entry
			$stmt_exists = $conn->prepare("SELECT * FROM course_master WHERE course_name=:txtCourseName");
			$stmt_exists->bindParam(':txtCourseName', $txtCourseName, PDO::PARAM_STR);
			$stmt_exists->execute();
			
			$row_cnt_exists = $stmt_exists->rowCount();
			
			//check to avoid duplicate entry
			if($row_cnt_exists==0)
			{
				if($stmt = $conn->prepare('INSERT INTO course_master (course_name,duration) VALUES (:txtCourseName,:txtCourseDuration) '))
				{}	
				else{
					throw new ErrorException("DB operation error");
				}
				
				$stmt->bindParam(':txtCourseName', $txtCourseName, PDO::PARAM_STR);
				$stmt->bindParam(':txtCourseDuration', $txtCourseDuration, PDO::PARAM_INT);
				
				$stmt->execute();
				
				if ($conn->lastInsertId() > 0) {
					$arr_res_json["add_course"] = "success";
				} else {
					$arr_res_json["add_course"] = "error";
				}
						
			}
			else		
			{
				$arr_res_json["add_course"] = "already";
			}
		}
		catch(PDOException $e)
		{
			$arr_res_json["add_course"] = "error";
		}
		catch(Exception $e) {
			$arr_res_json["add_course"] = "error";
		}
		
		$conn=null;	
		//return json_encode($this->utf8ize($arr_res_json));
		return json_encode($arr_res_json);
        
    }
	
	function fetch_course_detail($course_id)
	{
		global $conn;
		$arr_res_json = array();

        $stmt = $conn->prepare("SELECT * FROM course_master WHERE course_id=:course_id");
        $stmt->bindParam(':course_id', $course_id);
		$stmt->execute();

		$row_cnt = $stmt->rowCount();
		
		if($row_cnt>0)
		{
			$arr_res_json =  $stmt->fetch(PDO::FETCH_ASSOC);
		}else{
			$arr_res_json["action_error"] = "error";
		}
		
		$conn=null;
		
		//return json_encode($this->utf8ize($arr_res_json));
		return json_encode($arr_res_json);
		
	}
	
	function update_course($txtCourseName,$course_id,$txtCourseDuration)
	{
		global $conn;
		$arr_res_json = array();
		
		try
		{
			//check to avoid duplicate entry
			$stmt_exists = $conn->prepare("SELECT * FROM course_master WHERE course_name=:txtCourseName");
			$stmt_exists->bindParam(':txtCourseName', $txtCourseName);
			$stmt_exists->execute();
			
			$arr_res_exists = $stmt_exists->fetch(PDO::FETCH_ASSOC);
			
			$row_cnt_exists = $stmt_exists->rowCount();
			
			if($row_cnt_exists==0 || $arr_res_exists["course_id"]==$course_id)
			{
				$stmt = $conn->prepare('UPDATE course_master SET course_name=:txtCourseName,duration=:txtCourseDuration WHERE course_id=:course_id');		
				$stmt->bindParam(':txtCourseName', $txtCourseName);
				$stmt->bindParam(':txtCourseDuration', $txtCourseDuration);
				$stmt->bindParam(':course_id', $course_id);
				

				$stmt->execute();

				if ($stmt->rowCount() >= 0) {	
					$arr_res_json["add_course"] = "success";						
				} else {
					$arr_res_json["add_course"] = "error";
				}
				
				
			}
			else		
			{
				$arr_res_json["add_course"] = "already";
			}

		}
		catch(PDOException $e)
		{
			$arr_res_json["add_course"] = "error";
		}
		catch(Exception $e) {
			$arr_res_json["add_course"] = "error";
		}
		
		$conn=null;	
		
		//return json_encode($this->utf8ize($arr_res_json));
		return json_encode($arr_res_json);
		
	}
	
	function delete_course($course_id)
	{
		global $conn;
		try
		{
			$stmt = $conn->prepare('DELETE FROM course_master WHERE course_id=:course_id');		
			$stmt->bindParam(':course_id', $course_id);
			$stmt->execute();
			
			$arr_res_json = array();

			if ($stmt->rowCount() > 0) {
				$arr_res_json["delete_course"] = "success";
			} else {
				$arr_res_json["delete_course"] = "error";
			}
		}
		catch(PDOException $e)
		{
			$arr_res_json["delete_course"] = "error";
		}
		catch(Exception $e) {
			$arr_res_json["delete_course"] = "error";
		}
		
		
		$conn=null;	
		
		//return json_encode($this->utf8ize($arr_res_json));
		return json_encode($arr_res_json);
		
	}
	//Functions for Course tab ends
	
	//Functions for Student tab starts
	function fetch_student_master()
    {
        global $conn;

		try
		{
			$sql = "SELECT * FROM student_master ORDER BY student_id ASC";
			if($stmt = $conn->query($sql))
			{}
			else
				throw new Exception("DB Exception");
			
			$row_cnt = $stmt->rowCount();

			$arr_res = array();

			if ($row_cnt > 0)
			{
				$arr_res = $stmt->fetchAll();
				//return json_encode($this->utf8ize($arr_res));
			}
			else{
				$arr_res = null;
			}
			
			$conn=null;	
			return json_encode($arr_res);
			//return json_encode($this->utf8ize(null));
		}
		catch(PDOException $e)
		{
			$conn=null;			
			return json_encode($this->utf8ize(null));
		}
		catch(Exception $e) {
		  return json_encode($this->utf8ize(null));
		}
    }
	
	function insert_student($txtStudentFName,$txtStudentLName,$txtStudentMobile)
    {
        global $conn;
		try
		{
			//check to avoid duplicate entry
			$stmt_exists = $conn->prepare("SELECT * FROM student_master WHERE first_name=:txtStudentFName AND last_name=:txtStudentLName
										  AND mobile_no=:txtStudentMobile");
			$stmt_exists->bindParam(':txtStudentFName', $txtStudentFName);
			$stmt_exists->bindParam(':txtStudentLName', $txtStudentLName);
			$stmt_exists->bindParam(':txtStudentMobile', $txtStudentMobile);
			$stmt_exists->execute();
						
			$row_cnt_exists = $stmt_exists->rowCount();
			//check to avoid duplicate entry
			
			$arr_res_json = array();
			
			if($row_cnt_exists==0)
			{				
				if($stmt = $conn->prepare('INSERT INTO student_master (first_name,last_name,mobile_no) VALUES (:txtStudentFName,:txtStudentLName,:txtStudentMobile) '))
				{}	
				else{
					throw new ErrorException("DB operation error");
				}
				
				$stmt->bindParam(':txtStudentFName', $txtStudentFName);
				$stmt->bindParam(':txtStudentLName', $txtStudentLName);
				$stmt->bindParam(':txtStudentMobile', $txtStudentMobile);
				
				$stmt->execute();
				
				$inserted_id = $conn->lastInsertId();
				
				if ($inserted_id > 0) {
					
					//Create qr file
					date_default_timezone_set('Asia/Kolkata');
					$qr_filename = date('dmYhisa', time()).".png";								
					$qr_data = $txtStudentFName.",".$txtStudentLName.",".$txtStudentMobile;
					
					//then update
					if($stmt_updt_code = $conn->prepare('UPDATE student_master SET qr_data=:qr_data,file_name=:qr_filename
					WHERE student_id=:inserted_id')) // or die($conn->error);	
					{}
					else
						throw new ErrorException("DB operation error");
					
					$stmt_updt_code->bindParam(':qr_data', $qr_data);
					$stmt_updt_code->bindParam(':qr_filename', $qr_filename);
					$stmt_updt_code->bindParam(':inserted_id', $inserted_id);
					$stmt_updt_code->execute();

					if ($stmt_updt_code->rowCount() >= 0)
					{
						include_once ("phpqrcode/qrlib.php");
						require_once 'phpqrcode/qrconfig.php';

						if (!file_exists('qr_files')) {
							mkdir('qr_files', 0777, true);
						}				
						
						$qr_filepath = 'qr_files/'.$qr_filename;
						
						if (file_exists($qr_filepath))
						{
							//delete it
							unlink($qr_filepath);
						}
						
						QRcode::png($qr_data,$qr_filepath, 'L', 8, 2);
						$arr_res_json["add_student"] = "success";
					}
					else {
						$arr_res_json["add_student"] = "error";
					}	
					
				} else {
					$arr_res_json["add_student"] = "error";
				}	
			}
			else		
			{
				$arr_res_json["add_student"] = "already";
			}
		}
		catch(Exception $e) {
		  $arr_res_json["add_student"] = "error";
		}
		catch(PDOException $e) {
		  $arr_res_json["add_student"] = "error";
		}		
		catch (ErrorException $e) {
			$arr_res_json["add_student"] = "error";
			//restore_error_handler();//restore the previous error handler later
		}
				
		$conn=null;
		//return json_encode($this->utf8ize($arr_res_json));
		return json_encode($arr_res_json);
        
    }
	
	function fetch_student_detail($student_id)
	{
		global $conn;

        $stmt = $conn->prepare("SELECT * FROM student_master WHERE student_id=:student_id");
		$stmt->bindParam(':student_id', $student_id);
		$stmt->execute();

		$row_cnt = $stmt->rowCount();
		
		$arr_res_json = array();
		
		if($row_cnt>0)
		{
			$arr_res_json =  $stmt->fetch(PDO::FETCH_ASSOC);
		}else{
			$arr_res_json["action_error"] = "error";
		}
		
		$conn=null;
		
		//return json_encode($this->utf8ize($arr_res_json));
		return json_encode($arr_res_json);
		
	}
	
	function update_student($txtStudentFName,$txtStudentLName,$txtStudentMobile,$student_id)
	{
		global $conn;
		$arr_res_json = array();
		
		try
		{
			//check to avoid duplicate entry
			$stmt_exists = $conn->prepare("SELECT * FROM student_master WHERE first_name=:txtStudentFName AND last_name=:txtStudentLName 
			AND mobile_no=:txtStudentMobile");			
			$stmt_exists->bindParam(':txtStudentFName', $txtStudentFName);
			$stmt_exists->bindParam(':txtStudentLName', $txtStudentLName);
			$stmt_exists->bindParam(':txtStudentMobile', $txtStudentMobile);
			$stmt_exists->execute();
			
			$arr_res_exists = $stmt_exists->fetch(PDO::FETCH_ASSOC);
			
			$row_cnt_exists = $stmt_exists->rowCount();
			
			if($row_cnt_exists==0 || $arr_res_exists["student_id"]==$student_id)
			{
				$stmt = $conn->prepare('UPDATE student_master SET first_name=:txtStudentFName,last_name=:txtStudentLName,mobile_no=:txtStudentMobile
				WHERE student_id=:student_id');
				$stmt->bindParam(':txtStudentFName', $txtStudentFName);
				$stmt->bindParam(':txtStudentLName', $txtStudentLName);
				$stmt->bindParam(':txtStudentMobile', $txtStudentMobile);				
				$stmt->bindParam(':student_id', $student_id);				
				

				$stmt->execute();

				if ($stmt->rowCount() >= 0) {

					//Generate QR and update the same in database
					$stmt_qr = $conn->prepare("SELECT * FROM student_master WHERE student_id=:student_id");
					$stmt_qr->bindParam(':student_id', $student_id);

					$stmt_qr->execute();
					
					$row_cnt_qr = $stmt_qr->rowCount();

					if($row_cnt_qr>0)
					{
						$arr_res_json_qr = $stmt_qr->fetch(PDO::FETCH_ASSOC);
						
						date_default_timezone_set('Asia/Kolkata');
						$qr_filename = date('dmYhisa', time()).".png";
						
						$qr_data = $arr_res_json_qr["first_name"].",".$arr_res_json_qr["last_name"].",".$arr_res_json_qr["mobile_no"];					
						$stmt_updt_code = $conn->prepare('UPDATE student_master SET qr_data=:qr_data,file_name=:qr_filename WHERE student_id=:student_id');	
						$stmt_updt_code->bindParam(':qr_data', $qr_data);
						$stmt_updt_code->bindParam(':qr_filename', $qr_filename);
						$stmt_updt_code->bindParam(':student_id', $student_id);
						
						$stmt_updt_code->execute();
						
						if ($stmt_updt_code->rowCount() >= 0){
							include_once ("phpqrcode/qrlib.php");
							require_once 'phpqrcode/qrconfig.php';

							if (!file_exists('qr_files')) {
								mkdir('qr_files', 0777, true);
							}
							
							
							
							$qr_filepath = 'qr_files/'.$qr_filename;
							
							if (file_exists($qr_filepath))
							{
								//delete it
								unlink($qr_filepath);
							}
							
							if($arr_res_json_qr["file_name"]!="")
							{	
								$del_file = 'qr_files/'.$arr_res_json_qr["file_name"];
								
								//DELETE PREVIOUS FILE
								if (file_exists($del_file))
								{
									//delete it
									unlink($del_file);
								}
							}
							
							QRcode::png($qr_data,$qr_filepath, 'L', 8, 2);
							
							$arr_res_json["add_student"] = "success";
						}
						else {
							$arr_res_json["add_student"] = "error";
						}
						
					}
					else {
						$arr_res_json["add_student"] = "error";
					}
				
											
				} else {
					$arr_res_json["add_student"] = "error";
				}
				
			}
			else		
			{
				$arr_res_json["add_student"] = "already";
			}

		}
		catch(Exception $e) {
		  $arr_res_json["add_student"] = "error";
		}
		catch (ErrorException $e) {
			$arr_res_json["add_student"] = "error";
			//restore_error_handler();//restore the previous error handler later
		}
		
		$conn=null;
		
		//return json_encode($this->utf8ize($arr_res_json));
		return json_encode($arr_res_json);
		
	}
	
	function delete_student($student_id)
	{
		global $conn;
		
		$stmt_qr = $conn->prepare("SELECT * FROM student_master WHERE student_id=:student_id");
		$stmt_qr->bindParam(':student_id', $student_id);
		$stmt_qr->execute();

		$row_cnt_qr = $stmt_qr->rowCount();

		$arr_res_json_qr = array();
		
		if($row_cnt_qr>0)
		{
			$arr_res_json_qr = $stmt_qr->fetch(PDO::FETCH_ASSOC);
			if($arr_res_json_qr["file_name"]!="")
			{	
				$del_file = 'qr_files/'.$arr_res_json_qr["file_name"];
				
				//DELETE PREVIOUS FILE
				if (file_exists($del_file))
				{
					//delete it
					unlink($del_file);
				}
			}
		}

		
		//Delete their attendance
		$stmt_del_attendance = $conn->prepare('DELETE FROM student_attendance s WHERE s.map_id IN (SELECT c.map_id FROM course_student_map c WHERE c.student_id=:student_id)');	
		$stmt_del_attendance->bindParam(':student_id',$student_id);
		$stmt_del_attendance->execute();
		
		//Delete their course mapping as well
		$stmt_del_map = $conn->prepare('DELETE FROM course_student_map WHERE student_id=:student_id');	
		$stmt_del_map->bindParam(':student_id',$student_id);
		$stmt_del_map->execute();
		
		//Finally delete their master record
        $stmt = $conn->prepare('DELETE FROM student_master WHERE student_id=:student_id');		
		$stmt->bindParam(':student_id', $student_id);
		$stmt->execute();
		
		$arr_res_json = array();

		if ($stmt->rowCount() > 0) {		
			$arr_res_json["delete_student"] = "success";
		} else {
			$arr_res_json["delete_student"] = "error";
		}		
		
		$conn=null;
		
		//return json_encode($this->utf8ize($arr_res_json));
		return json_encode($arr_res_json);
		
	}
	
	
	//Functions for Student tab ends
	
	//Functions for Assign tab starts
	function fetch_assign_master()
    {
        global $conn;

        $sql = "SELECT m.*, c.course_name, CONCAT(s.first_name,' ',s.last_name) AS student_name
				FROM `course_student_map` m
				JOIN course_master c ON c.course_id=m.course_id
				JOIN student_master s ON s.student_id=m.student_id
				ORDER BY map_id ASC";

        if($stmt = $conn->query($sql))
		{}
		else
			throw new Exception("DB Exception");
		
		$row_cnt = $stmt->rowCount();


        $arr_res = array();
		
		if ($row_cnt > 0)
		{
			$arr_res = $stmt->fetchAll();
			//return json_encode($this->utf8ize($arr_res));
		}
		else{
			$arr_res = null;
		}
		
		$conn=null;	
		return json_encode($arr_res);
    }	
	
	function insert_map($course_id,$student_id)
    {
        global $conn;
		try
		{
			//check to avoid duplicate entry
			$stmt_exists = $conn->prepare("SELECT * FROM course_student_map WHERE student_id=:student_id AND course_complete=0");
			$stmt_exists->bindParam(':student_id', $student_id);	
			$stmt_exists->execute();
			
			$row_cnt_exists = $stmt_exists->rowCount();
			//check to avoid duplicate entry
			
			$arr_res_json = array();
			
			if($row_cnt_exists==0)
			{
				if($stmt = $conn->prepare('INSERT INTO course_student_map (course_id,student_id) VALUES (:course_id,:student_id) '))
				{}	
				else{
					throw new ErrorException("DB operation error");
				}
				
				$stmt->bindParam(':course_id', $course_id);	
				$stmt->bindParam(':student_id', $student_id);	
				

				$stmt->execute();

				if ($stmt->rowCount() > 0) {
					$arr_res_json["assign"] = "success";
				} else {
					$arr_res_json["assign"] = "error";
				}		
						
			}
			else		
			{
				$arr_res_json["assign"] = "already";
			}
		}
		catch(Exception $e) {
		  $arr_res_json["assign"] = "error";
		}
		catch (ErrorException $e) {
			$arr_res_json["assign"] = "error";
			//restore_error_handler();//restore the previous error handler later
		}
		
		$conn=null;
		//return json_encode($this->utf8ize($arr_res_json));
		return json_encode($arr_res_json);
        
    }
		
	function delete_mapping($map_id)
	{
		global $conn;
		
        $stmt = $conn->prepare('DELETE FROM course_student_map WHERE map_id=:map_id');	
		$stmt->bindParam(':map_id',$map_id);

		$stmt->execute();
		
		$arr_res_json = array();

		if ($stmt->rowCount() > 0) {
			$arr_res_json["delete_mapping"] = "success";
		} else {
			$arr_res_json["delete_mapping"] = "error";
		}
		
		
		$conn=null;
		
		//return json_encode($this->utf8ize($arr_res_json));
		return json_encode($arr_res_json);
		
	}
	
	function complete_course($map_id,$course_status)
	{
		global $conn;
		$updt_course_status = 0;
		
		if($course_status==0)
			$updt_course_status=1;
		
		$stmt = $conn->prepare('UPDATE course_student_map SET course_complete=:updt_course_status WHERE map_id=:map_id');
		$stmt->bindParam(':updt_course_status',$updt_course_status);		
		$stmt->bindParam(':map_id',$map_id);		
		
		$stmt->execute();

		if ($stmt->rowCount() >= 0) {							
			$arr_res_json["course_complete"] = "success";						
		} else {
			$arr_res_json["course_complete"] = "error";
		}		
		
		$conn=null;
		
		//return json_encode($this->utf8ize($arr_res_json));
		return json_encode($arr_res_json);
		
	}
	
	//Functions for Assign tab ends
	
	
	
	function matchQR($txtQRCode)
	{
		global $conn;

        $stmt = $conn->prepare("Select s.*,m.* FROM student_master s
								JOIN course_student_map m ON m.student_id=s.student_id AND m.course_complete=0
								WHERE s.qr_data=:txtQRCode AND s.isActive=1");
		$stmt->bindParam(':txtQRCode',$txtQRCode);

		$stmt->execute();

        $row_cnt = $stmt->rowCount();

		$arr_res = array();
		$arr_res_json = array();
		
		if($row_cnt>0)
		{
			$arr_res = $stmt->fetch(PDO::FETCH_ASSOC);
			$map_id = $arr_res["map_id"];
			
			$func_res = $this->markAttendance($map_id);
			$arr_res_json["action_attendance"] = $func_res;
			
		}else{
			$arr_res_json["action_attendance"] = "no_record";
		}
		
		$conn=null;
		
		//return json_encode($this->utf8ize($arr_res_json));
		return json_encode($arr_res_json);
	}
	
	function markAttendance($map_id)
	{
		global $conn;

        $stmt = $conn->prepare("SELECT * FROM student_attendance WHERE map_id=:map_id");
		$stmt->bindParam(':map_id',$map_id);

		$stmt->execute();

        $row_cnt = $stmt->rowCount();

		$arr_res_updt = array();
		//$arr_res_json = array();
		
		$attendance_result = "";
		
		if($row_cnt==0)
		{
			//Insert the record
			$stmt_insrt = $conn->prepare('INSERT INTO student_attendance (map_id,days_present,date_updated) VALUES (:map_id,1,now())');
			$stmt_insrt->bindParam(':map_id',$map_id);			
			

			$stmt_insrt->execute();

			if ($stmt_insrt->rowCount() >= 0) {							
				//$arr_res_json["action_attendance"] = "success";	
				$attendance_result = "success";				
			} else {
				//$arr_res_json["action_attendance"] = "error";
				$attendance_result = "error";				
			}
			
		}
		else{
			//update the record
			$arr_res_updt = $stmt->fetch(PDO::FETCH_ASSOC);
			
			$timestamp = strtotime($arr_res_updt['date_updated']);
			
			$last_date_updated = date('Y-m-d', $timestamp);
			
			date_default_timezone_set('Asia/Kolkata');
			$currDateTime = date('Y-m-d H:i:s');
			$currTimeStamp = strtotime($currDateTime);
			$currDate = date('Y-m-d',$currTimeStamp);
			
			//echo $last_date_updated ."!=". $currDate;
			//exit;
			
			if(strtotime($last_date_updated)!= strtotime($currDate))
			{
				$attendance_id = $arr_res_updt["attendance_id"];
				
				//Update the attendance count
				$stmt_updt = $conn->prepare('UPDATE student_attendance SET days_present=days_present+1,date_updated="'.$currDate.'" WHERE attendance_id=:attendance_id');		
				$stmt_updt->bindParam(':attendance_id',$attendance_id);

				$stmt_updt->execute();

				if ($stmt_updt->rowCount() >= 0) {							
					//$arr_res_json["action_attendance"] = "success";						
					$attendance_result = "success";
				} else {
					//$arr_res_json["action_attendance"] = "error";
					$attendance_result = "error";
				}
			}
			else
			{
				//$arr_res_json["action_attendance"] = "already";
				$attendance_result = "already";
			}
		}
		
		$conn=null;
		
		//return json_encode($this->utf8ize($arr_res_json));
		//return json_encode($arr_res_json);
		return $attendance_result;
	}
	
	
	function printBarcode($student_id)
	{
		global $conn;

        $stmt = $conn->prepare("SELECT * FROM student_master WHERE student_id=:student_id");
		$stmt->bindParam(':student_id', $student_id);
		$stmt->execute();

		$row_cnt = $stmt->rowCount();
		
		$arr_res = array();
		$arr_res_json = array();
		
		if($row_cnt>0)
		{			
			$arr_res =  $stmt->fetch(PDO::FETCH_ASSOC);
			$qr_file = "qr_files/".$arr_res["file_name"];
		
			/*
			$filecontents = file_get_contents($qr_file);
			print $filecontents;
			*/
			
			/*print file_get_contents($qr_file);
			print "<script>window.print()</script>";*/
			
			$arr_res_json["print_code"] = $qr_file;
		}else{
			$arr_res_json["print_code"] = "error";
		}
		
		$conn=null;
		return json_encode($arr_res_json);
	}
	
	/*
	function activate_deactivate_user($course_id,$action)
	{
		global $conn;
		$actionStatus = 0;
		
		if(strtolower($action) == "deactivate")
			$actionStatus = 0;
		else
			$actionStatus = 1;
		
		//check to avoid duplicate entry
		$stmt_updt = $conn->prepare("UPDATE user_master SET isActive=? WHERE course_id=?");
        $stmt_updt->bind_param('ii',$actionStatus,$course_id);

		$stmt_updt->execute();
		
		$arr_res_json = array();
		
		if ($stmt_updt->affected_rows >= 0)
		{
			$arr_res_json["action_record"] = "success";
		}
		else		
		{
			$arr_res_json["action_record"] = "already";
		}

		mysqli_close($conn);
		
		//return json_encode($this->utf8ize($arr_res_json));
		return json_encode($arr_res_json);
	}
	*/
}

?>