<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /*创建问题*/
    public function add(){
        /*检查用户是否登陆*/
     if(!user_ins()->is_logged_in())
         return ['status'=>0,'msg'=>'login request'];
        /*检查是否存在标题*/
     if(!rq('title'))
         return ['status'=>0,'msg'=>'requird title'];

     $this->title=rq('title');
     $this->user_id=session('user_id');

     /*如果存在描述 就添加描述*/
     if(rq('desc'))
         $this->desc=rq('desc');
     /*保存*/
     return $this->save()?
         ['status'=>1,'id'=>$this->id]:
         ['status'=>0,'msg'=>'db insert failed'];
    }s
    public function change(){
        /*检查用户是否登陆*/
        if(!user_ins()->is_logged_in())
            return ['status'=>0,'msg'=>'login request'];

        /*用户id必须存在*/
        if(!rq('id'))
            return ['status'=>0,'msg'=>'login request'];
    }
}
