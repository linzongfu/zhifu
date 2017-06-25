<?php
//        dd(Request::get('password'));
//        dd(Request::has('age'));
//        dd(Request::all());

namespace App;

use Illuminate\Database\Eloquent\Model;
use  Request;
use  Hash;


class User extends Model
{
    /*注册api*/
    public  function  signup(){
         $has_username_and_password=$this->has_username_and_password();
        if(!$this->has_username_and_password())
            return ['status'=>0,'msg'=>'用户名和密码皆不可为空'];
        $username=$has_username_and_password[0];
        $password=$has_username_and_password[1];
        /*检查用户名是否存在*/
        $user_exists=$this
            ->where('username',$username)
            ->exists();
        if($user_exists)
            return ['status'=>0,'msg'=>'用户名已存在'];




        /*加密密码*/
        $hash_password=Hash::make($password);

        /*存入数据库*/
        $user=$this;
        $user->password=$hash_password;
        $user->username=$username;
        if($user->save()){
            return ['status'=>1,'id'=>$user->id];
        }else
            return ['status'=>2,'msg'=>插入石板];
        return 1;
    }
    /*登陆api*/
    public function login(){
        /*检查用户名和密码是否存在*/
        $has_username_and_password=$this->has_username_and_password();

        if(!$has_username_and_password)
            return ['status'=>0,'msg'=>'用户名和密码不可为空存在'];
        $username=$has_username_and_password[0];
        $password=$has_username_and_password[1];

        /*检查用户是否存在*/
        $user=$this->where('username',$username)->first();
        if(!$user){
            return ['status'=>0,'msg'=>'用户名不存在'];
        }

        /*检查密码是否正确*/
        $hashed_password=$user->password;
        if(!Hash::check($password,$hashed_password))
            return ['status'=>0,'msg'=>'密码有误'];
       /*将用户信息写入session*/
        session()->put('username',$user->username);
        session()->put('user_id',$user->id);
        return ['status'=>1,'id'=>$user->id];
    }

    public  function  has_username_and_password(){
        /*检查用户名密码是否为空*/
        $username=rq('username');
        $password=rq('password');
        if( $username&&$password)
            return [$username,$password];
        return false;

    }
    /*登出api*/
    public function  logout(){
        //session()->flush();
        session()->forget('username');
        session()->forget('user_id');

        //dd(session()->all());
        return ['status'=>1];
        /*session还可以二级嵌套,或者更高*/
        //session()->set('person.name','xiaoming');
       // session()->set('person.friend.hanmeimei.age','20');
    }
    /*检测用户是否登陆*/
    public  function is_logged_in()
    {
        return  session('user_id')?:false;
    }
}
