<?php 
 
// Load the database configuration file 
include_once 'dbConfig.php'; 
 
// Include PhpSpreadsheet library autoloader 
require_once 'vendor/autoload.php'; 
use PhpOffice\PhpSpreadsheet\Reader\Xlsx; 
 
if(isset($_POST['importSubmit'])){ 
     
    // Allowed mime types 
    $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
     
    // Validate whether selected file is a Excel file 
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $excelMimes)){ 
         
        // If the file is uploaded 
        if(is_uploaded_file($_FILES['file']['tmp_name'])){ 
            $reader = new Xlsx(); 
            $spreadsheet = $reader->load($_FILES['file']['tmp_name']); 
            $worksheet = $spreadsheet->getActiveSheet();  
            $worksheet_arr = $worksheet->toArray(); 
 
            // Remove header row 
            unset($worksheet_arr[0]); 
 
            foreach($worksheet_arr as $row){ 
                $s_id = $row[0]; 
                $reg_no = $row[1]; 
                $s_name = $row[2]; 
                $s_dept = $row[3]; 
                $s_email = $row[4]; 
 
                // Check whether member already exists in the database with the same email 
                $prevQuery = "SELECT s_id FROM student_detail WHERE s_email = '".$s_email."'"; 
                $prevResult = $db->query($prevQuery); 
                 
                if($prevResult->num_rows > 0){ 
                    // Update member data in the database 
                    $db->query("UPDATE student_detail SET s_id = '".$s_id."', reg_no = '".$reg_no."', s_name = '".$s_name."', s_dept = '".$s_dept."', s_email = '".$s_email."', modified = NOW() WHERE s_email = '".$s_email."'"); 
                }else{ 
                    // Insert member data in the database 
                    $db->query("INSERT INTO student_detail (s_id, reg_no, s_name, s_dept, s_email, created, modified) VALUES ('".$s_id."', '".$reg_no."', '".$s_name."', '".$s_dept."', '".$s_email."', NOW(), NOW())"); 
                } 
            } 
             
            $qstring = '?status=succ'; 
        }else{ 
            $qstring = '?status=err'; 
        } 
    }else{ 
        $qstring = '?status=invalid_file'; 
    } 
} 
 
// Redirect to the listing page 
header("Location: index.php".$qstring); 
 
?>
