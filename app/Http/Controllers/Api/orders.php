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


            if ( empty($category_id) || empty($subcategory_id) || empty($item_id) || empty($user_id) || empty($merchant_id)) {
                $result["status"] = "0";
                $result["message"] = "لم تقم بادخال جميع الحقول المطلوبة";
                $result["en_message"] = "all filed are required";
            } else {

                if(!is_numeric($category_id) 
                    || !is_numeric($subcategory_id)
                    || !is_numeric($item_id)
                    || !is_numeric($user_id)
                    || !is_numeric($merchant_id)
                ){

                    $result["status"] = "0";
                    $result["message"] = "القيم غير صحيحة";
                    $result["en_message"] = "filed are invalid";



                }else{



                    $ch_user =  DB::table("users")->where([

                        ["id","=",$user_id],
                        ["status","=","1"]
                    ])->count();


                    $ch_merchant =  DB::table("users")->where([

                        ["id","=",$merchant_id],
                        ["status","=","1"],
                        ["type","=","1"]
                    ])->count();


                    $ch_item =  DB::table("items")->where([

                        ["id","=",$item_id],
                        ["status","=","1"]
                    ])->count();



                    if($ch_user<=0 || $ch_merchant<=0 || $ch_item<=0){
                        $result["status"] = "0";
                        $result["message"] = "القيم غير صحيحة";
                        $result["en_message"] = "filed are invalid";

                    }else{


                        // create order

                        $id = DB::table('orders')->insertGetId(
                            [
                                'category_id' => $category_id,
                                'subcategory_id' => $subcategory_id,
                                'user_id' => $user_id,
                                'merchant_id' =>$merchant_id,
                                'item_id' => $item_id,
                                'comment' => $comment

                            ]
                        );



                        $merchant =  DB::table("users")->where([

                            ["id","=",$merchant_id],
                            ["status","=","1"],
                            ["type","=","1"]
                        ])->first();


                        $result["status"] = "1";
                        $result["message"] = "تم انشاء الطلب بنجاح";
                        $result["en_message"] = "order successufly";
                        $result['order_id'] = $id;


                        // make sms notification
                       Notification::send($merchant->token);

                    }






                    
                }

            }

        }


        return json_encode($result);




    }




    public function myorder(Request $request){


        $result = array();

        $user_id = $request->input("user_id");
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
                $result["message"] = "رقم المستخدم غير صحيح";
                $result["en_message"] = "invalid user id";
            }else{

               $orders =  DB::table("orders")->where("user_id","=",$user_id)->get()->toArray();


               $total = [] ;


              //return $orders;
               
               foreach(collect($orders) as $order){
                
                $category_id = $order->category_id;
                $subcategory_id = $order->subcategory_id;
                $item_id = $order->item_id;
               

                $category =  DB::table("categories")->where("id","=",$category_id)->first();
                $subcategory =  DB::table("subcategories")->where("id","=",$subcategory_id)->first();
                $item =  DB::table("items")->where("id","=",$item_id)->first();
               

                if(!empty($category) && !empty($subcategory) && !empty($item)  ){

                    $category_title =  $category->title;
                    $subcategory_title =  $subcategory->title;
                    $item_title =  $item->title;
                    
    
                        $all = [] ;
                        $all['category_title'] = $category_title;
                        $all['subcategory_title'] = $subcategory_title;
                        $all['status'] = $order->status;
                        $all['comment'] = $order->comment;
                        $all['item_title'] = $item_title;
                        
                        $all['created_date'] = $order->created_date;
    
                        $total[]  = $all;
                        //return  $all;
                   }
                  
                    


                }



                if(empty($total)) {
                    $result["status"] = "0";
                    $result["message"] = "لا توجد طلبات ";
                    $result["en_message"] = "there is no any order";
                   
                }else{

                    $result["status"] = "1";
                    $result["message"] = "قائمة طلبات";
                    $result["en_message"] = "my orders list";
                    $result["orders"] = $total;
                }

                    
               

            }


        }


        return json_encode($result);
    }



   




    public function requests(Request $request){


        $result = array();

        $merchant_id = $request->input("merchant_id");
        $key = $request->input("key");

        if(empty($key) || $key!=123456){
            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else {


            $ch_user =  DB::table("users")->where([

                ["id","=",$merchant_id],
                ["status","=","1"]
            ])->count();

            if($ch_user<=0){


                $result["status"] = "0";
                $result["message"] = "رقم المستخدم غير صحيح";
                $result["en_message"] = "invalid user id";
            }else{

               $orders =  DB::table("orders")->where("merchant_id","=",$merchant_id)->get()->toArray();


               $total = [] ;


              //return $orders;
               
               foreach(collect($orders) as $order){
                
                $category_id = $order->category_id;
                $subcategory_id = $order->subcategory_id;
                $item_id = $order->item_id;
                $user_id = $order->user_id;

                $category =  DB::table("categories")->where("id","=",$category_id)->first();
                $subcategory =  DB::table("subcategories")->where("id","=",$subcategory_id)->first();
                $item =  DB::table("items")->where("id","=",$item_id)->first();

                $user =  DB::table("users")->where("id","=",$user_id)->first();

                if(!empty($category) && !empty($subcategory) && !empty($item) && !empty($user) ){

                    $category_title =  $category->title;
                    $subcategory_title =  $subcategory->title;
                    $item_title =  $item->title;
                    $username =  $user->name;
    
                        $all = [] ;
                        $all['id'] = $order->id;
                        $all['category_title'] = $category_title;
                        $all['subcategory_title'] = $subcategory_title;
                        $all['status'] = $order->status;
                        $all['comment'] = $order->comment;
                        $all['item_title'] = $item_title;
                        $all['user_id'] = $user->id;
                        $all['user_name'] = $user->name;
                        $all['user_phone'] = $user->tel;
                        $all['user_email'] = $user->email;
                        $all['created_date'] = $order->created_date;
    
                        $total[]  = $all;
                        //return  $all;
                   }
                  
                    


                }



                if(empty($total)) {
                    $result["status"] = "0";
                    $result["message"] = "لا توجد طلبات ";
                    $result["en_message"] = "there is no any order";
                   
                }else{

                    $result["status"] = "1";
                    $result["message"] = "قائمة طلبات";
                    $result["en_message"] = "my orders list";
                    $result["orders"] = $total;
                }

                    
               

            }


        }


        return json_encode($result);
    }






    public function chanage_status(Request $request){


        $result = array();

        $order_id = $request->input("order_id");
        $status = $request->input("status");
        $key = $request->input("key");

        if(empty($key) || $key!=123456){
            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else {



            DB::table("orders")->where("id","=",$order_id)->update(["status" => $status ]);
            $result["status"] = "1";
            $result["message"] = "تم تغير الحالة  ";
            $result["en_message"] = "status changed";

        }


        return json_encode($result);


    }




}



class Notification {


   public static function sendMessageone($title,$message,$id,$data){

	
		$content = array(
			"en" => $message
		);
		$heading = array(
			"en" => $title
		);
		$fields = array(
			'app_id' => "e7438d18-3c78-4bda-a427-9c643ce30b31",
			'include_player_ids' => array($id),
			'data' => array("foo" => $data),
			'large_icon' =>"ic_launcher_round.png",
			'contents' => $content,
             'headings' => $heading
		);
	
		
		$fields = json_encode($fields);
    	print("\nJSON sent:\n");
    	print($fields);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
												   'Authorization: Basic MTk1ZmU5NDEtZjBiZC00MjJmLWE1MTYtYzMxNWI1NmIxZDlm'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response;
	}











    public static   function send($token){
    #API access key from Google API's Console
    define( 'API_ACCESS_KEY', 'AIzaSyClkUYoWqm2cqYC5mUo5hzsNSrIVie3RYY' );
    
    #prep the bundle
     $msg = array
          (
        'body' 	=> 'Body  Of Notification',
        'title'	=> 'Title Of Notification',
                 'icon'	=> 'myicon',/*Default Icon*/
                  'sound' => 'mySound'/*Default sound*/
          );
    $fields = array
            (
                'to'		=>$token,
                'notification'	=> $msg
            );
    
    
    $headers = array
            (
                'Authorization: key=' . API_ACCESS_KEY,
                'Content-Type: application/json'
            );
    #Send Reponse To FireBase Server	
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
    #Echo Result Of FireBase Server
    
    
    
    }



















    public static function sendMessage($title,$message,$data){
		$content = array(
			"en" => $message
		);
		$heading = array(
			"en" => $title
		);
		$fields = array(
			'app_id' => "e7438d18-3c78-4bda-a427-9c643ce30b31",
			'included_segments' => array('All'),
			'data' => array("foo" => $data),
			'large_icon' =>"ic_launcher_round.png",
			'contents' => $content,
			'headings' => $heading
		);
	
		$fields = json_encode($fields);
	
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
			'Authorization: Basic MTk1ZmU5NDEtZjBiZC00MjJmLWE1MTYtYzMxNWI1NmIxZDlm'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	
		$response = curl_exec($ch);
		curl_close($ch);
		$return= $response;
		$return = json_decode( $return);
	
	
		return  $return->recipients;
	
	
	}
}