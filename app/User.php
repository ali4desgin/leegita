<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $table = 'user';

    public static function user_detail($usr_id = null){
        // echo $usr_id; die;
    
        if(!is_numeric($usr_id)) {
            $user_id = explode(',', $usr_id);

            for ($i=0; $i <2 ; $i++) { 
            
            $user[] = User::where('id',$user_id[$i])
                            ->where('is_deleted','0')
                            ->first();
            }
            // echo "<pre>"; print_r($user); die;
        } else {
            $user = User::where('id',$usr_id)
                        ->where('is_deleted','0')
                        ->first();
            // echo "<pre>"; print_r($user); die;
        }
        return $user;
    }
        
        

    public static function get_user_detail($user_id = null){
        // echo $user_name;die;
        $user = User::where('id',$user_id)
                    ->where('is_deleted','0')
                    ->first();
        return $user;
    }
    public function profilePics() {
        return $this->hasMany('App\ProfilePics','user_id','id');
    }

    public function aboutMe() {
        return $this->hasOne('App\AboutMe','user_id','id');
    }

    public function country() {
        return $this->hasOne('App\Country','id','country_id');
    }

    public function residence_detail() {
        return $this->hasOne('App\Residence','id','residence');
    }
    public function cover_images(){
        return $this->hasMany('App\ProfilePics','user_id','id')->orderBy('id','desc');
    }

    public function chatSender() {
        return $this->hasMany('App\ChatRoom', 'sender_id','id')->orderBy('id','desc');
    }
    public function chatReceiver() {
        return $this->hasMany('App\ChatRoom', 'receiver_id','id')->orderBy('id','desc');
    }

    public static function send_mail($user_id = null){

        $user          = User::where('id',$user_id)->first();
        // echo "<pre>"; print_r($user); die;
        if(!empty($user)){
            $company_name  = 'HiLike';
            $email         = $user->email;
            $name          = $user->name;
            $locked        = 'Locked';
            if($user->status == '1'){
                $locked = 'Unlocked';
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) 
            {   
                Mail::send('emails.locked_template', ['name'=>$name,'locked'=>$locked], function($message) use ($email,$company_name)
                {
                    $message->to($email,$company_name)->subject('HiLike');
                });
                return true;
            } 
        }
        return false;
    }
    public static function notification_send_mail($eng_msg = null, $arabic_msg = null){

        $user = User::where('status','1')
                    ->where('is_deleted','0')
                    ->get();
        $company_name  = 'HiLike';
        if(!empty($user)){
            foreach ($user as $key => $value) {

                if($value->language == 'english'){
                    $name  = $value->name;
                    $msg   = $eng_msg;
                    $email = $value->email;
                    $subject = 'Admin Notification';
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) 
                    {   
                        Mail::send('emails.notification_template', ['name'=>$name,'msg'=>$msg,'subject'=>$subject], function($message) use ($email,$company_name)
                        {
                            $message->to($email,$company_name)->subject('HiLike');
                        });
                        
                    } 
                }else{
                    $name  = $value->name;
                    $msg   = $arabic_msg;
                    $email = $value->email;
                    $subject = 'إشعار المشرف';
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) 
                    {   
                        Mail::send('emails.notification_template', ['name'=>$name,'msg'=>$msg,'subject'=>$subject], function($message) use ($email,$company_name)
                        {
                            $message->to($email,$company_name)->subject('HiLike');
                        });
                    } 

                }
            }
            return true;
        }
        return false;
    }

    public static function payment_send_mail($user_id = null){
        $user = User::select('w.transaction_id as order_id','user.name','user.email','user.user_type','w.expiry','w.amount','w.upgrade_datetime as start_time')
                    ->where('user.id',$user_id)
                    ->join('wallets as w','w.user_id','user.id')
                    ->first();
        if(!empty($user)){
            $email      = $user->email;
            $name       = $user->name;
            $membership = $user->user_type;
            $order_id   = $user->order_id;
            $day_count  = $user->expiry;
            $amount     = $user->amount;
            $start_time = $user->start_time;
            $company_name = 'HiLike';
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) 
            {   
                Mail::send('emails.payment_template', ['name'=>$name,'email'=>$email,'membership'=>$membership,'order_id'=>$order_id,'day_count'=> $day_count,'amount'=> $amount,'start_time'=>$start_time], function($message) use ($email,$company_name)
                {
                    $message->to($email,$company_name)->subject('HiLike');
                });
                return true;
            } 
        }
        return false;

    }
}
