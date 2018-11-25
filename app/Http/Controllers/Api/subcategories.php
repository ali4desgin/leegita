<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BASE {


    public static function getImageDir(){

            $server_url = "http://" . $_SERVER['HTTP_HOST'] . "/";
            $subcategory_image  = "apps/legita/public/uploads/subcategories_images/";
            return $server_url.$subcategory_image;

    }

    public static function destinationPath(){

        return "public/uploads/subcategories_images";

    }


    public static function getItemImageDir(){

        $server_url = "http://" . $_SERVER['HTTP_HOST'] . "/";
        $subcategory_image  = "apps/legita/public/uploads/items_images/";
        return $server_url.$subcategory_image;

}

public static function ItemdestinationPath(){

    return "public/uploads/items_images";

}

}
class subcategories extends Controller
{
    




    public function add(Request $request){

        //caption all the inputs
        $key  = $request->input("key");
        $category_id  = $request->input("category_id");
        $subcategory_title  = $request->input("subcategory_title");
        $subcategory_description  = $request->input("subcategory_description");
        $merchant_id  = $request->input("merchant_id");
       
        $image  = $request->file("image");


        if(empty($key) || $key!=123456){
            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else { 



            if ( empty($category_id) || empty($subcategory_title) || empty($subcategory_description) ||  empty($merchant_id)) {
                $result["status"] = "0";
                $result["message"] = "لم تقم بادخال جميع الحقول المطلوبة";
                $result["en_message"] = "all filed are required";
            } else {

                if(!is_numeric($category_id) 
                    || !is_numeric($merchant_id)
                ){

                    $result["status"] = "0";
                    $result["message"] = " القيم غير صحيحة";
                    $result["en_message"] = "category or merchent are invalid";



                }else{


                    $ch_merchant =  DB::table("users")->where("id","=",$merchant_id)->count();


                    $ch_category =  DB::table("categories")->where([

                        ["id","=",$category_id],
                        ["status","=","1"]
                    ])->count();

                
                    if($ch_merchant<=0 || $ch_category<=0){
                        $result["status"] = "0";
                        $result["message"] = " القيم غير صحيحة";
                        $result["en_message"] = "kerche  are invalid";

                    }else{


                         

                        //$image_id = null;
                        $destinationPath = BASE::destinationPath();
                        $final_image = "category.png";

                        if (!empty($image) and in_array($image->getClientOriginalExtension() , array("png","jpg","jpeg","gif"))) {

                            $current_time_stamp = time();


                            $uploaded_image = $current_time_stamp.".".$image->getClientOriginalExtension();

                            //echo $image->getClientOriginalExtension();
                            
                           $image->move($destinationPath,$uploaded_image);


                            $final_image = $uploaded_image;
                            


                        }

        
                       // echo $final_image;

                       


                        $id = DB::table('subcategories')->insertGetId(
                            [
                                'category_id' => $category_id,
                                'title' => $subcategory_title,
                                'description' => $subcategory_description,
                                'merchant_id' => $merchant_id,
                                'image' => $final_image,
                                'status' => 1

                            ]
                        );


                          $result["status"] = "1";
                        $result["message"] = "تم انشاء الطلب بنجاح";
                        $result["en_message"] = "order successufly";
                        $result['subcategory_id'] = $id;

                    }






                    
                }

            }




            


        }


        return json_encode($result);

    }





    public function additem(Request $request){

        //caption all the inputs
        $key  = $request->input("key");
        $subcategory_id  = $request->input("subcategory_id");
        $item_title  = $request->input("item_title");
        $item_description  = $request->input("item_description");
        $item_price  = $request->input("item_price");
        $merchant_id  = $request->input("merchant_id");
        $image  = $request->file("image");
        $token  = $request->input("token");


        if(empty($key) || $key!=123456){
            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else { 



            if ( empty($subcategory_id) || empty($item_title) || empty($item_price) || empty($item_description) ||  empty($merchant_id)) {
                $result["status"] = "0";
                $result["message"] = "لم تقم بادخال جميع الحقول المطلوبة";
                $result["en_message"] = "all filed are required";
            } else {

                if(!is_numeric($subcategory_id) 
                    || !is_numeric($merchant_id)
                ){

                    $result["status"] = "0";
                    $result["message"] = " القيم غير صحيحة";
                    $result["en_message"] = "filed are invalid";



                }else{


                    $ch_merchant =  DB::table("users")->where([

                        ["id","=",$merchant_id],
                        ["status","=","1"],
                        ["type","=","1"]
                    ])->count();


                    $ch_subcategory =  DB::table("subcategories")->where([

                        ["id","=",$subcategory_id],
                        ["status","=","1"]
                    ])->count();

                
                    if($ch_merchant<=0 || $ch_subcategory<=0){
                        $result["status"] = "0";
                        $result["message"] = " القيم غير صحيحة";
                        $result["en_message"] = "filed are invalid";

                    }else{


              
                        DB::table("users")->where("id","=",$merchant_id)->update(['token' => $token]);;

                        //$image_id = null;
                        $destinationPath = BASE::ItemdestinationPath();
                        $final_image = "item.png";

                        if (!empty($image) and in_array($image->getClientOriginalExtension() , array("png","jpg","jpeg","gif"))) {

                            $current_time_stamp = time();


                            $uploaded_image = $current_time_stamp.".".$image->getClientOriginalExtension();

                            //echo $image->getClientOriginalExtension();
                            
                           $image->move($destinationPath,$uploaded_image);


                            $final_image = $uploaded_image;
                            


                        }

        
                       // echo $final_image;




                       

                        $id = DB::table('items')->insertGetId(
                            [
                                'subcategory_id' => $subcategory_id,
                                'title' => $item_title,
                                'description' => $item_description,
                                'merchant_id' => $merchant_id,
                                'price'=>$item_price,
                                'currency'=>"SDG",
                                'image'=>$final_image,
                                'status' => 1

                            ]
                        );


                          $result["status"] = "1";
                        $result["message"] = "تم انشاء الطلب بنجاح";
                        $result["en_message"] = "order successufly";
                        $result['item_id'] = $id;
                        $result['image'] = Base::getItemImageDir().$final_image;

                    }






                    
                }

            }




            


        }


        return json_encode($result);

    }





    public function subcategories( Request $request){
            

        $result = [];
           
        $key  = $request->input("key");
        $category_id  = $request->input("category_id");

        if(empty($key) || $key!=123456){
            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else { 


            if(empty($category_id)){

                $result["status"] = "0";
                $result["message"] = "رقم الصنف الرئيسي فارغ";
                $result["en_message"] = " category id can't be empty";

            }else{

                $rows = DB::table("categories")->where("id", "=", $category_id)->count();

                if ($rows <= 0) {

                    $result["status"] = "0";
                    $result["message"] = "رقم الصنف غير صالح ";
                    $result["en_message"] = "category id is not valid";


                } else{

                    $subcategories_list = DB::table("subcategories")->where([
                        ['category_id', '=', $category_id],
                        ['status', '=', 1],
                    ]
                    )->orderBy("id","desc")->get()->toArray();


                    $total = [];

                    foreach(collect($subcategories_list) as $sub){
              
                        $all = [] ;
                        $all['id'] = $sub->id;
                        $all['category_id'] = $sub->category_id;
                        $all['title'] = $sub->title;
                        $all['description'] = $sub->description;
                        $all['merchant_id'] = $sub->merchant_id;
                        $all['status'] = $sub->status;
                        $all['image'] =BASE::getImageDir() .  $sub->image;
                        $all['updated_date'] = $sub->updated_date;
                        $all['created_date'] = $sub->created_date;
    
                        $total[]  = $all;
                  
                }


                    $result["status"] = "1";
                    $result["message"] = "قائمة الاصناف الفرعية";
                    $result["en_message"] = "subcategories list";
                    $result["subcategory_image_url"] = BASE::getImageDir();
                    $result["subcategories"] = $total;
                }

            }


        }


        return json_encode($result);
    }








    public function mysubcategories(Request $request){


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
                ["status","=","1"],
                ['type',"=","1"]
            ])->count();

            if($ch_user<=0){


                $result["status"] = "0";
                $result["message"] = "رقم المستخدم غير صحيح";
                $result["en_message"] = "invalid user id";
            }else{

               $subcategories_list =  DB::table("subcategories")->where("merchant_id","=",$merchant_id)->orderBy("id","desc")->get()->toArray();






               if (empty($subcategories_list)) {

                $result["status"] = "0";
                $result["message"] = "رقم الصنف غير صالح ";
                $result["en_message"] = "category id is not valid";


            } else{

               


                $total = [];

                foreach(collect($subcategories_list) as $sub){
          

                    $category =  DB::table("categories")->where("id","=",$sub->category_id)->first();

                    if(empty($category)){
                        $category_title = "unknow";
                        $category_description = "unknow";
                    }else{

                        $category_title = $category->title;
                        $category_description = $category->description;
                    }
                    $all = [] ;
                    $all['id'] = $sub->id;
                    $all['category_id'] = $sub->category_id;
                    $all['category_title'] = $category_title ;
                    $all['category_description'] = $category_description;
                    $all['title'] = $sub->title;
                    $all['description'] = $sub->description;
                    $all['merchant_id'] = $sub->merchant_id;
                    $all['status'] = $sub->status;
                    $all['image'] =BASE::getImageDir() .  $sub->image;
                    $all['updated_date'] = $sub->updated_date;
                    $all['created_date'] = $sub->created_date;

                    $total[]  = $all;
              
            }


                $result["status"] = "1";
                $result["message"] = "قائمة الاصناف الفرعية";
                $result["en_message"] = "subcategories list";
                $result["subcategories"] = $total;
            }




            
            }


        }


        return json_encode($result);
    }







    public function get_subcategory_details(Request $request){




        $result = [];
        $user_id = $request->input("user_id");
        $subcategory_id = $request->input("subcategory_id");
        $key = $request->input("key");

        if(empty($key) || $key!=123456){
            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else { 


            if(empty($subcategory_id)){

                $result["status"] = "0";
                $result["message"] = "رقم الصنف الرئيسي فارغ";
                $result["en_message"] = " subcategory id can't be empty";

            }else{

                $rows = DB::table("subcategories")->where("id", "=", $subcategory_id)->count();

                if ($rows <= 0) {

                    $result["status"] = "0";
                    $result["message"] = "رقم الصنف الفرع  غير صالح ";
                    $result["en_message"] = "subcategory id is not valid";


                } else{


                    $details = DB::table("subcategories")->where("id", "=", $subcategory_id)->first();

                    if($details->merchant_id ==  $user_id ) {
                        $items_list = DB::table("items")->where([
                            ['subcategory_id', '=', $subcategory_id]
                        ]
                        )->get()->toArray();

                    }else{

                        $items_list = DB::table("items")->where([
                            ['subcategory_id', '=', $subcategory_id],
                            ['status', '=', 1],
                        ]
                        )->get()->toArray();
                    }
                    

                    

                    $result["status"] = "1";
                    $result["message"] = "تفاصيل الصنف الفدعي المنتجات";
                    $result["en_message"] = "subcategory details and items  list";

                    //$result['details'] = $details;
                    $result['category_id'] = $details->category_id;
                  $result['subcategory_id'] = $details->id;
                    $result['image'] =Base::getImageDir(). $details->image;
                    $result['merchant_id'] = $details->merchant_id;
                    $result['title'] = $details->title;
                    $result['description'] = $details->description;



                    $total = [];

/*
  {
        "id": 4,
        "subcategory_id": 3,
        "title": "shavhbdhdhdhjd",
        "description": "aaaaaaaaaaaa",
        "price": "3323",
        "currency": "SDG",
        "status": 1,
        "image": "",
        "created_date": "2018-05-12 18:58:38",
        "updated_date": "2018-05-12 19:20:32",
        "merchant_id": 0
    },
    */
                    foreach($items_list as $item){
                        $signal = [] ;

                        $signal['id'] =  $item->id;
                        $signal['subcategory_id'] =  $item->subcategory_id;
                        $signal['title'] =  $item->title;
                        $signal['description'] =  $item->description;
                        $signal['price'] =  $item->price;
                        $signal['currency'] =  $item->currency;
                        $signal['status'] =  $item->status;
                        $signal['image'] =  BASE::getItemImageDir().$item->image;
                        $signal['updated_date'] =  $item->updated_date;
                        $signal['created_date'] =  $item->created_date;
                        $signal['merchant_id'] =  $item->merchant_id;
                        $total[] = $signal;
                    }


                    //return $total;
                    //$items_list
                    $result["items"] = $total;
                }

            }


        }


        return json_encode($result);


    }





    
    public function active(Request $request){

        $result = [];
        $subcategory_id = $request->input("subcategory_id");
        $key = $request->input("key");

        if(empty($key) || $key!=123456){
            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else { 

            $num = DB::table("subcategories")->where("id", "=", $subcategory_id)->count();

            if($num >= 1){

                 DB::table("subcategories")->where("id","=",$subcategory_id)->update(['status' => 1]);
                $result["status"] = "1";
                $result["message"] = "تم اظهار الصنف بنجاح";
                $result["en_message"] = "subcategory successfuly activiated";
            }else{


                $result["status"] = "0";
                $result["message"] = "الصنف الفرعي غير متاح";
                $result["en_message"] = "invalid subcategory id";
            }



        }



        



        return $result;
        
        

    }


    public function block(Request $request){


        $result = [];
        $subcategory_id = $request->input("subcategory_id");
        $key = $request->input("key");

        if(empty($key) || $key!=123456){
            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else { 

            $num = DB::table("subcategories")->where("id", "=", $subcategory_id)->count();

            if($num >= 1){

                 DB::table("subcategories")->where("id","=",$subcategory_id)->update(['status' => 0]);
                $result["status"] = "1";
                $result["message"] = "تم اخفاء الصنف بنجاح";
                $result["en_message"] = "subcategory successfuly blocked";
            }else{


                $result["status"] = "0";
                $result["message"] = "الصنف الفرعي غير متاح";
                $result["en_message"] = "invalid subcategory id";
            }



        }



        



        return $result;
        

    }



    
    public function delete(Request $request){

        $result = [];
        $subcategory_id = $request->input("subcategory_id");
        $key = $request->input("key");

        if(empty($key) || $key!=123456){
            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else { 

            $num = DB::table("subcategories")->where("id", "=", $subcategory_id)->count();

            if($num >= 1){

                $subcategory = DB::table("subcategories")->where("id","=",$subcategory_id)->first();


                if($subcategory->image!="category.png"){

                    @unlink(BASE::destinationPath()."/".$subcategory->image);
                }
                 
    
               DB::table("subcategories")->where("id","=",$subcategory_id)->delete();


                $result["status"] = "1";
                $result["message"] = "تم حذف الصنف الفرعي";
                $result["en_message"] = "subcategory successfuly deleted";
            }else{


                $result["status"] = "0";
                $result["message"] = "الصنف الفرعي غير متاح";
                $result["en_message"] = "invalid subcategory id";
            }



        }



        



        return $result;
        
        

    }





    public function update(Request $request){



        $result = [];
        $subcategory_id = $request->input("subcategory_id");
        $title = $request->input("title");
        $description = $request->input("description");
        //$image = $request->file("image");
        $key = $request->input("key");

        if(empty($key) || $key!=123456){
            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else { 

            $subcategory_ch = DB::table("subcategories")->where("id","=",$subcategory_id)->count();


            if($subcategory_ch>=1){



                $subcategory = DB::table("subcategories")->where("id","=",$subcategory_id)->first();
                $final_title = $subcategory->title;
                $final_description = $subcategory->description;
               // $final_image = $subcategory->image;

                if(!empty($title)){


                    $final_title = $title;
                }




                if(!empty($description)){

                    $final_description = $description;
                }


                DB::table("subcategories")->where("id","=",$subcategory_id)->update([

                    'title' => $final_title,
                    'description'=> $final_description
            ]);


            $result["status"] = "1";
            $result["message"] = "تم تعديل البيانات ";
            $result["en_message"] = "information chanaged!";





            }else{

                $result["status"] = "0";
                $result["message"] = "الصنف الفرعي غير متاح";
                $result["en_message"] = "invalid subcategory id";
            }



        }

        return $result;
        
    }









    
    public function activeitem(Request $request){

        $result = [];
        $item_id = $request->input("item_id");
        $key = $request->input("key");

        if(empty($key) || $key!=123456){
            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else { 

            $num = DB::table("items")->where("id", "=", $item_id)->count();

            if($num >= 1){

                 DB::table("items")->where("id","=",$item_id)->update(['status' => 1]);
                $result["status"] = "1";
                $result["message"] = "تم اظهار العنصر بنجاح";
                $result["en_message"] = "item successfuly activiated";
            }else{


                $result["status"] = "0";
                $result["message"] = "الصنف  العنصر غير متاح";
                $result["en_message"] = "invalid item id";
            }



        }



        



        return $result;
        
        

    }


    public function blockitem(Request $request){


        $result = [];
        $item_id = $request->input("item_id");
        $key = $request->input("key");

        if(empty($key) || $key!=123456){
            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else { 

            $num = DB::table("items")->where("id", "=", $item_id)->count();

            if($num >= 1){

                 DB::table("items")->where("id","=",$item_id)->update(['status' => 0]);
                $result["status"] = "1";
                $result["message"] = "تم اخفاء العنصر بنجاح";
                $result["en_message"] = "item successfuly blocked";
            }else{


                $result["status"] = "0";
                $result["message"] = "الصنف العنصر غير متاح";
                $result["en_message"] = "invalid item id";
            }



        }



        



        return $result;
        

    }



    
    public function deleteitem(Request $request){

        $result = [];
        $item_id = $request->input("item_id");
        $key = $request->input("key");

        if(empty($key) || $key!=123456){
            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else { 

            $num = DB::table("items")->where("id", "=", $item_id)->count();

            if($num >= 1){

                $item = DB::table("items")->where("id","=",$item_id)->first();


                if($item->image!="item.png"){

                    @unlink(BASE::ItemdestinationPath()."/".$item->image);
                }
                 
    
               DB::table("items")->where("id","=",$item_id)->delete();


                $result["status"] = "1";
                $result["message"] = "تم حذف العنصر ";
                $result["en_message"] = "item successfuly deleted";
            }else{


                $result["status"] = "0";
                $result["message"] = "العنصر   غير متاح";
                $result["en_message"] = "invalid item id";
            }



        }



        



        return $result;
        
        

    }





    public function updateitem(Request $request){



        $result = [];
        $item_id = $request->input("item_id");
        $title = $request->input("title");
        $description = $request->input("description");
        $price = $request->input("price");
        //$image = $request->file("image");
        $key = $request->input("key");

        if(empty($key) || $key!=123456){
            $result["status"] = "0";
            $result["message"] = "فشل التحقق من المرسل ";
            $result["en_message"] = "authucation failer";

        }else { 

            $item_ch = DB::table("items")->where("id","=",$item_id)->count();


            if($item_ch>=1){



                $item = DB::table("items")->where("id","=",$item_id)->first();
                $final_title = $item->title;
                $final_description = $item->description;
                $final_price = $item->price;
               // $final_image = $subcategory->image;

                if(!empty($title)){


                    $final_title = $title;
                }




                if(!empty($description)){

                    $final_description = $description;
                }


                if(!empty($price)){

                    $final_price = $price;
                }

                DB::table("items")->where("id","=",$item_id)->update([

                    'title' => $final_title,
                    'description'=> $final_description,
                    'price'=>$final_price
            ]);


            $result["status"] = "1";
            $result["message"] = "تم تعديل البيانات ";
            $result["en_message"] = "information chanaged!";





            }else{

                $result["status"] = "0";
                $result["message"] = "الصنف الفرعي غير متاح";
                $result["en_message"] = "invalid subcategory id";
            }



        }

        return $result;
        


    }


}
