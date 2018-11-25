<?php

namespace App\Http\Controllers\api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Mail;




class orders extends Controller
{



    public function new(Request $request){


        $result = array();

        $category_id = $request->input("category_id");
        $subcategory_id = $request->input("subcategory_id");
        $item_id = $request->input("item_id");
        $user_id = $request->input("user_id");
        $merchant_id = $request->input("merchant_id");
        $comment = $request->input("comment");
        $key = $request->input("key");

        if(empty($key) || $key!=123456){
            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else {


            if (empty($category_id) || empty($category_id) || empty($ubcategory_id) || empty($item_id) || empty($user_id) || empty($merchant_id)) {
                $result["status"] = "0";
                $result["message"] = "لم تقم بادخال جميع الحقول المطلوبة";
                $result["en_message"] = "all filed are required";
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

                            $image = "";


                            if($data["profile_image"]!=null){

                                $image = DB::table("images")->where("id","=",3)->select("path")->get()->first();
                                $image = collect($image);

                                $image = $image['path'];
                            }else{

                                $server_url = "http://" . $_SERVER['HTTP_HOST'] . "/";
                                $destinationPath = "apps/legita/public/uploads/profile_images";
                                $full_path = $server_url.$destinationPath."/avatar.png";
                                $image = $full_path;
                            }


                            $user = array(

                                'id' => $data['id'],
                                'image' => $image,
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

    public function  test(Request $request){


        $result['files'] = $_FILES;
        $result['posts'] = $_POST;
        $result['gets'] = $_GET;



        //$users = array("total", $request->input());
        return $result;

    }


    public function  list(){

        $users =  DB::table("users")->where("status","!=", 0)->get()->toArray();


        return $users;
    }


   public function login(Request $request){


       $result = array();

        $email = $request->input("email");
        $password = $request->input("password");
        $key = $request->input("key");

        if(empty($key) || $key!=123456){
            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else {


            if (empty($email) || empty($password)) {
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

                            $image = "";


                            if($data["profile_image"]!=null){

                                $image = DB::table("images")->where("id","=",3)->select("path")->get()->first();
                                $image = collect($image);

                                $image = $image['path'];
                            }else{

                                $server_url = "http://" . $_SERVER['HTTP_HOST'] . "/";
                                $destinationPath = "apps/legita/public/uploads/profile_images";
                                $full_path = $server_url.$destinationPath."/avatar.png";
                                $image = $full_path;
                            }


                            $user = array(

                                'id' => $data['id'],
                                'image' => $image,
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




    public function add(Request $request){


        $result = array();
        $key = $request->input("key");
        $username = $request->input("username");
        $email = $request->input("email");
        $password = $request->input("password");
        $gender = $request->input("gender");
        $latitude = $request->input("latitude");
        $longitude = $request->input("longitude");
        $type = $request->input("type"); // 1= marchtent , 2= normal users
        $tel = $request->input("tel");
        $profile_image = $request->file('profile_image');



        // key checker
        if(empty($key) || $key!=123456 ) {

            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else {


            if (empty($username) || empty($password) || empty($email) || empty($latitude) || empty($longitude) || empty($type) || empty($tel) || empty($gender)) {

                $result["status"] = "0";
                $result["message"] = "رجاءاً قم بملآ جميع الخانات (username , email , password , latitude , longitude , type , tel , profile as image , )";
                $result["en_message"] = "please fill all fields (username , email , password , latitude , longitude , type , tel , profile as image , gender)";
            } else {


                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    $result["status"] = "0";
                    $result["message"] = "الايميل المدخل غير صالح ";
                    $result["en_message"] = "in valid email";
                } else {

                    if (strlen($tel)<=5) {
                      
                        $result["status"] = "0";
                        $result["message"] = "رفم الهاتف المدخل غير صالح ";
                        $result["en_message"] = "in valid phone number";
                    } else {

                        if (strlen($password) <= 6) {


                            $result["status"] = "0";
                            $result["message"] = "كلمة المرور يجب ان لاتقل عن 6 حروف  ";
                            $result["en_message"] = "password shoud be more than 6 char";


                        } else {

                            $rows = DB::table("users")->where("email", "=", $email)->count();

                            if ($rows >= 1) {

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
 
                                $image_id = null;
                                $server_url = "http://" . $_SERVER['HTTP_HOST'] . "/";
                                $destinationPath = "apps/legita/public/uploads/profile_images";
                                $uploadIn = "public/uploads/profile_images";
                                $full_path = $server_url.$destinationPath."/avatar.png";

                                if (!empty($profile_image)) {

                                    $current_time_stamp = time();



                                    $title = $profile_image->getClientOriginalName();
                                    $size = $profile_image->getSize();
                                    $extension = $profile_image->getClientOriginalExtension();

                                    $final_name = $current_time_stamp . "." . $extension;
                                    $full_path = $server_url . $destinationPath . "/" . $final_name;

                                    if($profile_image->move($uploadIn, $final_name)){


                                        $full_path = $server_url . $destinationPath . "/" . $final_name;
                                    }
                                    //return $profile_image->move($uploadIn, $final_name);




                                    $image_id = $id = DB::table('images')->insertGetId(
                                        [
                                            'path' => $full_path,
                                            'type' => 0,
                                            'name' => $title,
                                            'size' => $size,
                                            'status' => 1,
                                            'type' => $type


                                        ]
                                    );


                                    //return $full_path;

                                }

                                $id = DB::table('users')->insertGetId(
                                    [
                                        'email' => $email,
                                        'name' => $username,
                                        'tel' => $tel,
                                        'password' => md5($password),
                                        'latitude' => $latitude,
                                        'longitude' => $longitude,
                                        'type' => $type,
                                        'profile_image' => $image_id,
                                        'gender' => $gender


                                    ]
                                );



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
                                    'email' => $email,
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
