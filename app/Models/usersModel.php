<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\CommonModal;

class UsersModel extends Model

{
    protected $table = 'user_registration';
    protected $primaryKey = 'userId';
    protected $allowedFields = ['userName', 'userEmail', 'userPassword'];
    protected $beforeInsert = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['userPassword'])) {
            $data['data']['userPassword'] = password_hash($data['data']['userPassword'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    public function checkUserValuesForLogin($userid, $password)
    {
        $whereCondition = array(
            'userEmail' => $userid,
            'userPassword' => $password,
        );
        $builder = $this->db->table('user_registration');
        $builder->select('userName,userEmail,userPassword,userId');
        $builder->where($whereCondition);
        return $builder->get()->getRow();
    }
} 


// {

//     public function __construct()
//     {
//         parent::__construct();
//         $this->db = \Config\Database::connect();
//         $session = \Config\Services::session();
//     }


//     function checkPasswordData($pEmail)
//     {
//         return $this->db->table('user_registration')->where('userEmail', $pEmail)->get()->getRow();
//     }

//     function generatePasswordResetToken($userId)
//     {
//         $tokenOtp = mt_rand(1000, 9999);
//         $tokenArray = array(
//             'userId' => $userId,
//             'token_no' => md5(rand()),
//             'token_otp' => $tokenOtp,
//             'token_time' => date('Y-m-d H:i:s'),
//         );
//         $this->db->table('forgot_pass_token')->insert($tokenArray);
//         $tokenId = $this->db->insertID();
//         return $this->db->table('forgot_pass_token')->where('token_id ', $tokenId)->get()->getRow();
//     }
//     function getValidUserDataForToken($tokenno, $userid)
//     {
//         return $this->db->table('forgot_pass_token as a, user_registration as b')
//             ->where('a.userId =b.userId')
//             ->where('a.token_no', $tokenno)
//             ->where('b.userRefId', $userid)
//             ->get()->getRow();
//     }



//     public function checkUserValidityData($userId, $hashTag)
//     {
//         $userIdValue = convert_uudecode($userId);
//         $whereCondition = array(
//             'userId ' => $userIdValue,
//             'randomHashTag' => $hashTag,
//             'user_status' => 1,
//         );
//         $builder = $this->db->table('user_registration as user_registration');
//         $builder->select('user_registration.userId,user_registration.userName,user_registration.userRefId,user_registration.randomHashTag');
//         $builder->where($whereCondition);
//         return $builder->get()->getRow();
//     }
// }


