<?php
session_start();

header('Content-Type: application/json');

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['studentid']) && !empty($_POST['studentid'])) {
        $studentid = $_POST['studentid'];

        // Validate the student ID format
        if (!preg_match('/^\d{4}-\d{4}$/', $studentid)) {
            $response['status'] = 'error';
            $response['message'] = 'Alumni ID must be in the format 1234-5678';
            echo json_encode($response);
            exit;
        }

        // Validate the year in the student ID
        $currentYear = date('Y');
        $idYear = substr($studentid, 0, 4);
        if ($currentYear - $idYear < 4) {
            $response['status'] = 'error';
            $response['message'] = 'Alumni ID year must be at least 4 years ago';
            echo json_encode($response);
            exit;
        }

        // Assign form data to variables
        $firstname = $_POST['firstname'] ?? '';
        $lastname = $_POST['lastname'] ?? '';
        $middlename = $_POST['middlename'] ?? '';
        $auxiliaryname = $_POST['auxiliaryname'] ?? '';
        $birthdate = $_POST['birthdate'] ?? '';
        $civilstatus = $_POST['civilstatus'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $addressline1 = $_POST['addressline1'] ?? '';
        $city = $_POST['city'] ?? '';
        $state = $_POST['state'] ?? '';
        $zipcode = $_POST['zipcode'] ?? '';
        $contactnumber = $_POST['contactnumber'] ?? '';
        $email = $_POST['email'] ?? '';
        $course = $_POST['course'] ?? '';
        $batch = $_POST['batch'] ?? '';

        require_once 'includes/firebaseRDB.php';
        require_once 'includes/config.php';
        $firebase = new firebaseRDB($databaseURL);

        // Check if student ID or email already exists
        $table = 'alumni';
        $result = $firebase->retrieve($table);
        $result = json_decode($result, true);
        
        $isStudentIdExists = false;
        $isEmailExists = false;
        
        if ($result) {
            foreach ($result as $record) {
                if (isset($record['studentid']) && $record['studentid'] === $studentid) {
                    $isStudentIdExists = true;
                }
                if (isset($record['email']) && $record['email'] === $email) {
                    $isEmailExists = true;
                }
            }
        }

        if ($isStudentIdExists) {
            $response['status'] = 'error';
            $response['message'] = 'Alumni ID already exists. It cannot be reused.';
            echo json_encode($response);
            exit;
        }

        if ($isEmailExists) {
            $response['status'] = 'error';
            $response['message'] = 'Email already exists. Please use a different email.';
            echo json_encode($response);
            exit;
        }

        // Prepare alumni data
        $alumniData = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'middlename' => $middlename,
            'auxiliaryname' => $auxiliaryname,
            'birthdate' => $birthdate,
            'civilstatus' => $civilstatus,
            'gender' => $gender,
            'addressline1' => $addressline1,
            'city' => $city,
            'state' => $state,
            'zipcode' => $zipcode,
            'contactnumber' => $contactnumber,
            'email' => $email,
            'course' => $course,
            'batch' => $batch,
            'studentid' => $studentid,
            'forms_completed' => false
        );

        // Add alumni data
        $result = $firebase->insert($table, $alumniData);

        // Check result
        if ($result === null) {
            $response['status'] = 'error';
            $response['message'] = 'Failed to add alumni data to Firebase.';
            error_log('Firebase error: Failed to insert alumni data.');
        } else {
            $response['status'] = 'success';
            $response['message'] = 'Alumni data added successfully!';
        }

        echo json_encode($response);
        exit;
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Alumni ID is required.';
        echo json_encode($response);
        exit;
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
    exit;
}
?>