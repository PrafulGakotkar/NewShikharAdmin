<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Dashboard extends BaseController
{
    public function index()
    {
        return view('home/index');
    }
    public function dashboard()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/');
        }


        return view('home/dashboard');
    }


    public function registerView()
    {
        return view('home/registerView');
    }

    public function register()

    {

        // $userModel = new UsersModel();

        // $name= $this->request->getPost('username');
        // $email= $this->request->getPost('email');
        // $password= $this->request->getPost('password');

        // $data = ['userName'=>$name,'userEmail'=>$email,'userPassword'=>$password];
        // // userId	userRefId	userName	userMobile	userEmail	userDOB	userGender	userPassword	userRole	

        // $r = $userModel->insert($data);

        // if($r){
        //     echo "user reg Success";
        // }else{
        //     echo "user reg fail";
        // }

        // helper(['form']);
        print_r($this->request->getMethod());

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'username' => 'required|min_length[3]',
                'email'    => 'required|valid_email|is_unique[user_registration.userEmail]',
                'password' => 'required|min_length[6]'
            ];

            if ($this->validate($rules)) {
                $userModel = new UsersModel();
                $userModel->insert([
                    'userName' => $this->request->getPost('username'),
                    'userEmail' => $this->request->getPost('email'),
                    'userPassword' => $this->request->getPost('password')
                ]);

                return redirect()->to('/');
            } else {
                return view('home/registerView', ['validation' => $this->validator]);
            }
        }

        return view('home/registerView');
    }

    // public function login()
    // {
    //     // Post Value
    //     $userid = $this->request->getPost('userId');
    //     $password = $this->request->getPost('password');
    //     $remember = $this->request->getGetPost('remember'); //maybe sntax error
    //     $session = \Config\Services::session();
    //     if (isset($_SESSION['login_attempt'])) {
    //         $cnt_login_attempt = $_SESSION['login_attempt'];
    //     } else {
    //         $cnt_login_attempt = 0;
    //     }
    //     if ($cnt_login_attempt < 3) {
    //         $cnt_login_attempt_new = $cnt_login_attempt + 1;
    //         $session->setTempdata('login_attempt', $cnt_login_attempt_new, 360);
    //         // check weather user has entered correct values or not
    //         $LoginModel = new UsersModel(); // here model is intialized
    //         $outputValue = $LoginModel->getRowTableData($table = 'user_registration', ['userEmail' => $userid, 'userPassword' => md5($password)]);
    //         // if value is correct then redirect to dashborad
    //         if (!empty($outputValue)) {
    //             $idRef = $outputValue->userId ;
    //             // if Remember is ellected then set cookies for 6 months
    //             if ($remember == 1) {
    //                 $time = time() + (86400 * 30 * 12);
    //             } else { // else set cookies for 6 hrs
    //                 $time = time() + (21600);
    //             }
    //             $userId  = $outputValue->userId ;
    //             $userRefId = $outputValue->userRefId	;
    //             $randomHashTag = $outputValue->randomHashTag;
    //             //set login cookies 
    //             // set email id	
    //             $encodeUserId = convert_uuencode($userId );
    //             $sessionData = [
    //                 'userId'  => $encodeUserId,
    //                 'hashTag'     => $randomHashTag,
    //                 'logged_in' => true,
    //             ];

    //             $session->set($sessionData);
    //             $data = array(
    //                 'status' => 1,
    //                 'msg' => 'Login Success',
    //                 'redirect' => 'dashboard',
    //             );
    //         } else { // else value is wrong then resend login page and flash the msg that credentials not matching
    //             $data = array(
    //                 'status' => 2,
    //                 'msg' => 'Invalid User Name or Password. Failed Attempt : ' . $cnt_login_attempt_new . ', Allowed: 3',
    //                 'redirect' => '',
    //             );
    //         }
    //     } else {
    //         $data = array(
    //             'status' => 3,
    //             'msg' => 'You crossed limit of max three(3) attempt at a time, please try after 6 mins.',
    //             'redirect' => '',
    //         );
    //     }
    //     echo json_encode($data);
    // }
    public function login()
    {
        // print_r($this->request->getMethod());

        // $userModel = new UsersModel();

        // $email = $this->request->getPost('email');
        // $password = $this->request->getPost('password');
        // print_r($email);
        // print_r($password);

        // $result =  $userModel->where('userEmail', $email)->first();
        // print_r($result);

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'email'    => 'required|valid_email',
                'password' => 'required'
            ];

            if ($this->validate($rules)) {
                $userModel = new UsersModel();
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');

                // Fetch user by email
                $user = $userModel->where('userEmail', $email)->first();

                // Check if user exists and verify the password
                if ($user && password_verify($password, $user['userPassword'])) {
                    // Set session or handle login logic
                    $session = session();
                    $session->set([
                        'id' => $user['userId'],
                        'username' => $user['userName'],
                        'isLoggedIn' => true
                    ]);

                    return redirect()->to('/dashboard');
                } else {
                    // Invalid login credentials
                    print_r('Invalid email or password.');
                    session()->setFlashdata('error', 'Invalid email or password.');
                    return redirect()->back()->withInput();
                }
            } else {
                print_r('Invalid email or password.');
                return view('home/index', ['error' => 'Invalid login credentials']);
            }
        }
    }

    public function logout()
    {
        // Destroy the session
        session()->destroy();

        // Remove session cookies
        if (isset($_COOKIE['session_name'])) {
            unset($_COOKIE['session_name']);
            setcookie('session_name', '', time() - 3600, '/'); // Expire the cookie
        }

        // Redirect to home page
        return redirect()->to('/');
    }
}
