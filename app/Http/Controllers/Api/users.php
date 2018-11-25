<?php
namespace App\Http\Controllers\api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Mail;

class BASE {


    public static function getImageDir(){

            $server_url = "http://" . $_SERVER['HTTP_HOST'] . "/";
            $profile_image  = "apps/legita/public/uploads/profile_images/";
            return $server_url.$profile_image;

    }

    public static function destinationPath(){

        return "public/uploads/profile_images/";

    }



    public static function deleteImage($image){


        if($image!=="avatar.png"){
            @unlink(self::destinationPath().$image);
            return true;
        }

        return false;
    }
}


class users extends Controller
{


    public function  test(Request $request){

        unlink(BASE::destinationPath()."1525321090.jpg");

    }







    public function update_profile_image(Request $request){
        $result = array();

        $user_id = $request->input("user_id");
        $image = $request->file("image");
        $key = $request->input("key");

        if(empty($key) || $key!=123456){
            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else {




            $ch_user =  DB::table("users")->where([

                ["id","=",$user_id],
                ["status","=","1"]
            ])->count();


            if($ch_user<=0){

                $result["status"] = "0";
                $result["message"] = "رقم مستخدم غير صالح";
                $result["en_message"] = "invalid user id";


            }else{




                //$image_id = null;
                $destinationPath = BASE::destinationPath();
                $final_image = "avatar.png";

                if (empty($image) and !in_array($image->getClientOriginalExtension() , array("png","jpg","jpeg","gif"))) {
                
                    $result["status"] = "0";
                    $result["message"] = "لم تقم باختيار صورة ";
                    $result["en_message"] = "you doesn't choose any image";

                }else{
                    $current_time_stamp = time();


                    $uploaded_image = $current_time_stamp.".".$image->getClientOriginalExtension();

                    //echo $image->getClientOriginalExtension();
                    
                   $image->move($destinationPath,$uploaded_image);

                   $user = DB::table('users')
                   ->where('id', $user_id)
                   ->get();


                   if(!empty($user->profile_image)){
                    BASE::deleteImage($user->profile_image);
                   }
                   
                   

                    $final_image = $uploaded_image;
                    
                    DB::table('users')
                    ->where('id', $user_id)
                    ->update(['profile_image' => $uploaded_image]);


                    $result["status"] = "1";
                    $result["profile_image"] = BASE::getImageDir().$final_image;
                    $result["user_id"] = $user_id;
                    $result["message"] = "تم تحديث الصورة بنجاح";
                    $result["en_message"] = "image updated successfuly";


                }
                   


              
              
            }



        
        }




        return json_encode($result);


    }



    public function  list(){

        $users =  DB::table("users")->where("status","!=", 0)->get()->toArray();


        return $users;
    }


   public function login(Request $request){


       $result = array();

        $email = $request->input("email");
        $password = $request->input("password");
        $token = $request->input("token");
        $key = $request->input("key");

        if(empty($key) || $key!=123456){
            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else {


            if (empty($email) || empty($password) || empty($token)) {
                $result["status"] = "0";
                $result["message"] = "رجاءاً قم بملآ جميع الخانات (email , passowrd)";
                $result["en_message"] = "please fill all fields (email , password)";
            } else {



                if(!filter_var($email,FILTER_VALIDATE_EMAIL)){

                    $result["status"] = "0";
                    $result["message"] = "الايميل المدخل غير صالح ";
                    $result["en_message"] = "in valid email";

                }else{



                    $data = DB::table("users")
                        ->where("email","=", $email)
                        ->where("password", "=",md5($password))
                        ->first();



                    if(empty($data)){

                        $result["status"] = "0";
                        $result["message"] = "البريد الاكتروني او كلمة المرور غير صحيحة";
                        $result["en_message"] = "email or password worng !";
                        return $result;

                    }else{


                        $data = collect($data);

                        if($data['status']==0) // 0 = lock  , 1 = unlock
                        {
                            $result["status"] = "0";
                            $result["message"] = "حسابك محظور حاليا او غير نشط ";
                            $result["en_message"] = "your account had been blocked";

                        }else{
                            $result["status"] = "1";
                            $result["message"] = "تم تسجيل الدخول بنجاح ";
                            $result["en_message"] = "login success";


                            DB::table("users")->where("id","=",$data['id'])->update(["token"=> $token]);
                            $profile_image  =BASE::getImageDir().$data["profile_image"];
                            $user = array(

                                'id' => $data['id'],
                                'image' => $profile_image,
                                'email' => $email,
                                'name'=>   $data['name'],
                                'type'=>   $data['type'],
                                'session' => encrypt(time())


                            );


                            $result['user'] = $user;
                            //$image['path'];



                        }


                    }




                }

            }

        }


        return $result;

   }





   public function update(Request $request){


        $result = array();
        $key = $request->input("key");
        $username = $request->input("username");
        $address = $request->input("address");
        $password = $request->input("password");
        $tel = $request->input("tel");
        $about = $request->input("about");

        $user_id = $request->input("user_id");

        // key checker
        if(empty($key) || $key!=123456 ) {

            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else {



            $user_ch = DB::table("users")->where([
                ["id","=",$user_id],
                ["status","=",1]
                ])->count();


                if($user_ch <=0){

                    $result["status"] = "0";
                    $result["message"] = "هذا المستخدم غير صالح  ";
                    $result["en_message"] = "this user id is in valid";

                }else{


                    $user = DB::table("users")->where([
                        ["id","=",$user_id],
                        ["status","=",1]
                        ])->first();

                    


                        //var_dump($fetch_data->email);
                        //exit();
                    $final_pass = $user->password;
                    $final_address = $user->address;
                    $final_about = $user->about;
                    $final_username = $user->name;
                    $final_tel = $user->tel;


                    if(!empty($password)  and strlen($password)>=8){


                        $final_pass = md5($password);
                    }


                    if(!empty($about)){

                        $final_about = $about;
                    }

                    if(!empty($username)){

                        $final_username = $username;
                    }



                    if(!empty($address)){

                        $final_address = $address;
                    }



                    if(!empty($tel)){

                        $final_tel = $tel;
                    }




                    DB::table("users")->where("id","=",$user_id)->update([

                            'name' => $final_username,
                            'password'=> $final_pass,
                            'tel' => $final_tel,
                            'address'=> $final_address,
                            'about' => $final_about
                    ]);



                    

                    $user = DB::table("users")->where([
                        ["id","=",$user_id],
                        ["status","=",1]
                        ])->first();
                    $result["status"] = "1";
                    $result["message"] = "تم تعديل البيانات ";
                    $result["en_message"] = "information chanaged!";
                    $result['user'] = $user;
                    $result["path"] =  BASE::getImageDir();


                }



        }



    return json_encode($result);

   }






   








   public function  reg(Request $request){

    $result = array();
    $key = $request->input("key");
    $phone = $request->input("phone");


    if(empty($key) || $key!=123456 ) {

        $result["status"] = "0";
        $result["message"] = "فشل التحقق من المرسل ";
        $result["en_message"] = "authucation failer";

    }else {
        

        if(empty($phone)) {

            $result["status"] = "0";
            $result["message"] = "رقم الهاتف فارغ";
            $result["en_message"] = "empty phone";

        }else{


            $user = DB::table("users")->where("tel", "=", $phone)->first();



            if(empty($user)){


             /*   $userid = DB::table("users")->insertGetId(
                    [
                    'tel' => $phone

                    ]
            );*/

          //  $user = DB::table("users")->where("tel", "=", $phone)->first();

                $result["status"] = "1";
                $result["message"] = "تم تسجيل حساب جديد";
                $result["en_message"] = "registrae new account";
                $result['reg_status'] = 1;
                //$result['user_id'] = $userid;
               // $result['user'] = $user;

            }else{

                $result["status"] = "1";
                $result["message"] = "الحساب مسجل ";
                $result["en_message"] = "account registated";
                $result['reg_status'] = 2;
                $result['user'] = $user;
            }

            


        }



    }

    return json_encode($result);

}













    public function add(Request $request){


        $result = array();
        $key = $request->input("key");
        $username = $request->input("username");
       // $email = $request->input("email");
       // $password = $request->input("password");
        $gender = $request->input("gender");
        $latitude = $request->input("latitude");
        $longitude = $request->input("longitude");

       $token = $request->input("token");
        $type = $request->input("type"); // 1= marchtent , 2= normal users
       $tel = $request->input("tel");
        $profile_image = $request->file('profile_image');
    // $profile_image = $request->input('user_id');


        // key checker
        if(empty($key) || $key!=123456 ) {

            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else {


            if (empty($username) ||  empty($token)  || empty($latitude) || empty($longitude) || empty($type) || empty($tel) || empty($gender)) {

                $result["status"] = "0";
                $result["message"] = "رجاءاً قم بملآ جميع الخانات ";
                $result["en_message"] = "please fill all fields ";
            } else {

//!filter_var($email, FILTER_VALIDATE_EMAIL)
                if (1!=1) {

                    $result["status"] = "0";
                    $result["message"] = "الايميل المدخل غير صالح ";
                    $result["en_message"] = "in valid email";
                } else {

                    if (strlen($tel)<=5) {
                      
                        $result["status"] = "0";
                        $result["message"] = "رفم الهاتف المدخل غير صالح ";
                        $result["en_message"] = "in valid phone number";
                    } else {
//strlen($password) <= 6
                        if (1!=1) {


                            $result["status"] = "0";
                            $result["message"] = "كلمة المرور يجب ان لاتقل عن 6 حروف  ";
                            $result["en_message"] = "password shoud be more than 6 char";


                        } else {

                            //$rows = DB::table("users")->where("email", "=", $email)->count();

                            if (1!=1) {

                                $result["status"] = "0";
                                $result["message"] = "هذا الايميل مستخدم من قبل   ";
                                $result["en_message"] = "this is email is already used";


                            } else {

                                /*
                                 *
                                 *  $username = $request->input("username");
                                        $email = $request->input("email");
                                        $password = $request->input("password");
                                        $latitude = $request->input("latitude");
                                        $longitude = $request->input("longitude");



    public function showUploadFile(Request $request){
          $file = $request->file('image');

          //Display File Name
          echo 'File Name: '.$file->getClientOriginalName();
          echo '<br>';

          //Display File Extension
          echo 'File Extension: '.$file->getClientOriginalExtension();
          echo '<br>';

          //Display File Real Path
          echo 'File Real Path: '.$file->getRealPath();
          echo '<br>';

          //Display File Size
          echo 'File Size: '.$file->getSize();
          echo '<br>';

          //Display File Mime Type
          echo 'File Mime Type: '.$file->getMimeType();

          //Move Uploaded File
          $destinationPath = 'uploads';
          $file->move($destinationPath,$file->getClientOriginalName());
       }
                                 * */


                                //encrypt(time())
 /*
                                $image_id = null;
                                $server_url = "http://" . $_SERVER['HTTP_HOST'] . "/";
                                $destinationPath = "apps/legita/public/uploads/profile_images";
                                $uploadIn = "public/uploads/profile_images";
                                $full_path = $server_url.$destinationPath."/avatar.png";
*/
                                


                        $destinationPath = BASE::destinationPath();
                        $final_image = "avatar.png";

                        if (!empty($profile_image) and in_array($profile_image->getClientOriginalExtension() , array("png","jpg","jpeg","gif"))) {

                            $current_time_stamp = time();


                            $uploaded_image = $current_time_stamp.".".$profile_image->getClientOriginalExtension();

                            //echo $image->getClientOriginalExtension();
                            
                            $profile_image->move($destinationPath,$uploaded_image);


                            $final_image = $uploaded_image;
                            


                        }



                                $id = DB::table('users')->insertGetId(
                                    [
                                        //'email' => $email,
                                        'name' => $username,
                                        'tel' => $tel,
                                       // 'password' => md5($password),
                                        'latitude' => $latitude,
                                        'longitude' => $longitude,
                                        'type' => $type,
                                        'profile_image' => $final_image,
                                        'gender' => $gender
                                      //  'token' => $token


                                    ]
                                );




                                $full_path = BASE::getImageDir().$final_image;
                                $result["status"] = "1";
                                $result["message"] = "تم التسجيل بنجاح  ";
                                $result["en_message"] = "registered successfuly";
                               /* $result['user_id'] = $id;
                                $result['user_email'] = $email;
                                $result['user_name'] = $username;
                                $result['user_image'] = $full_path;
                            
*/
                                $user = array(

                                    'id' => $id,
                                    'image' => $full_path,
                                 'email' => "test",
                                    'name'=>   $username,
                                    'type'=>   $type,
                                    'session' => encrypt(time())
    
    
                                );
    
    
                                $result['user'] = $user;




                            }


                        }


                    }


                }


            }
        }


        return $result;



    }



    public function resetPassword(Request $request){


        $result = array();

        $email = $request->input("email");
        $key = $request->input("key");

        if(empty($key) || $key!=123456){
            $result["status"] = false;
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else {
        
            if (empty($email)) {
                $result["status"] = false;
                $result["message"] = "لم تقم بادخال الايميل";
                $result["en_message"] = "please fill email field";
            } else {



                if(!filter_var($email,FILTER_VALIDATE_EMAIL)){

                    $result["status"] = false;
                    $result["message"] = "الايميل المدخل غير صالح ";
                    $result["en_message"] = "in valid email";

                }else{


                        //Mail::to($email)->send("hi");
                        mail($email,"test", " heelo");

                        $data = DB::table("users")->where("email", "=" , $email)->get();


                         if($data->count()>=0){

                                $data = collect($data);






                        }




                }

            }

        
        }
        return $result;

    }
}
