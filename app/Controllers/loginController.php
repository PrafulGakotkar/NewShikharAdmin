<?php

namespace App\Controllers;

use App\Models\UsersModel;

class loginController extends BaseController
{


    public function loginPage()
    {
        error_reporting(0);
        // check did login to this device or not
        // if logged in then redirec to dashboard _HEID
        $userId = $_COOKIE['_HEID'];
        if (!empty($userId)) {
            $checkValidUser = $this->checkUserValidity();
            if (!empty($checkValidUser)) {
                return redirect()->to(base_url('dashboard'));
            } else {
                return view('loginPageView');
            }
        } else { //else if not login then view login page
            return view('loginPageView');
        }
    }
    // request of user to login with credentials
    public function loginme()
    {
        // Post Value
        $userid = $this->request->getPost('userid');
        $password = (string)$this->request->getPost('password');
        // $remember = $this->request->getGetPost('remember');
        // $role = $this->request->getGetPost('role');
        $session = \Config\Services::session();
        if (isset($_SESSION['login_attempt'])) {
            $cnt_login_attempt = $_SESSION['login_attempt'];
        } else {
            $cnt_login_attempt = 0;
        }
        if ($cnt_login_attempt < 3) {
            $cnt_login_attempt_new = $cnt_login_attempt + 1;
            $session->setTempdata('login_attempt', $cnt_login_attempt_new, 360);
            // check weather user has entered correct values or not
            $loginModel = new UsersModel(); // here model is intialized
            $outputValue = $loginModel->checkUserValuesForLogin($userid, md5($password));
            // if value is correct then redirect to dashborad
            if (!empty($outputValue)) {
                // If not empty then record login session 
                //get IP of user
                $clientIP = $_SERVER['REMOTE_ADDR'];
                if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }
                // generate session id
                $today = date('YmdHi');
                $startDate = date('YmdHi', strtotime('2016-03-14 09:06:00'));
                $range = $today - $startDate;
                $sessionId = rand(0, $range);

                $idRef = $outputValue->userId;
                $loggedTable = 'user_logged_sessions';

                // if Remember is ellected then set cookies for 6 months
                if ($remember == 1) {
                    $time = time() + (86400 * 30 * 12);
                } else { // else set cookies for 6 hrs
                    $time = time() + (21600);
                }
                $loggedSessionData = array(
                    'loggedUserId' => $idRef,
                    'loggedDateTime' => date('Y-m-d H:i:s'),
                    'loogedSeesionId' => $sessionId,
                    'loogedIp' => $clientIP,
                    'loggedStatus' => 1,
                    'sessionExpiry' => date("Y-m-d H:i:s", $time),
                );
                $loginModel->saveTableData($loggedSessionData, $loggedTable);
                $backEnd_role = $outputValue->userRole;

                $userRefId = $outputValue->userRefId;
                $randSecTag = $outputValue->randSecTag;
                $randomHashTag = $outputValue->randomHashTag;
                //set login cookies 
                // set email id	
                $encodeUserId = convert_uuencode($userRefId);
                // setcookie('_HEID', $encodeUserId, $time, "/");
                setcookie('_HEID', $encodeUserId, ['expires' => $time, 'path' => '/', 'httponly' => true, 'samesite' => 'Strict']);
                // set email id	
                // setcookie('hashTag', $randomHashTag, $time, "/");
                setcookie('hashTag', $randomHashTag, ['expires' => $time, 'path' => '/', 'httponly' => true, 'samesite' => 'Strict']);
                // set email id	
                // setcookie('secCheck', $randSecTag, $time, "/");
                setcookie('secCheck', $randSecTag, ['expires' => $time, 'path' => '/', 'httponly' => true, 'samesite' => 'Strict']);
                // set Session Cookies
                setcookie('sessionId', $sessionId, ['expires' => $time, 'path' => '/', 'httponly' => true, 'samesite' => 'Strict']);

                $data = array(
                    'status' => 1,
                    'msg' => 'Login Success',
                    'redirect' => 'dashboard',
                );
            } else { // else value is wrong then resend login page and flash the msg that credentials not matching
                $data = array(
                    'status' => 2,
                    'msg' => 'Invalid User Name or Password. Failed Attempt : ' . $cnt_login_attempt_new . ', Allowed: 3',
                    'redirect' => '',
                );
            }
        } else {
            $data = array(
                'status' => 3,
                'msg' => 'You crossed limit of max three(3) attempt at a time, please try after 6 mins.',
                'redirect' => '',
            );
        }
        echo json_encode($data);
    }
}
