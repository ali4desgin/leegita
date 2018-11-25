<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BASE {


    public static function getImageDir(){

            $server_url = "http://" . $_SERVER['HTTP_HOST'] . "/";
            $categories_images  = "apps/legita/public/uploads/categories_images/";
            return $server_url.$categories_images;

    }

    public static function destinationPath(){

        return "public/uploads/categories_images";

    }

}
class categories extends Controller
{
    //


    public function categories( Request $request){
            

           
            $key  = $request->input("key");
           if($key!=null && $key == "123456"){
                $categories = DB::table("categories")->where("status", "=",  1)->orderBy("id","desc")->get()->toArray();

               






               $total = [] ;


/**
 * 
 * 
 * {"status":"1","message":"\u0642\u0627\u0626\u0645\u0629 \u0627\u0644\u0627\u0635\u0646\u0627\u0641  ","en_message":"categories list","category_image_url":"http:\/\/13.59.32.107\/apps\/legita\/public\/uploads\/categories_images\/","categories":[{"id":9,"title":"\u0645\u0637\u0627\u0639\u0645 ","en_title":"fff","description":"\u0645\u0622\u0643\u0648\u0644\u0627\u062a \u0648\u062c\u0645\u064a\u0639 \u0645\u0627 \u062a\u0634\u062a\u0647\u064a \u0627\u0644\u0646\u0641\u0633 \u0647\u0646\u0627 ","en_description":"cccc","status":1,"image":"1526786412.png","created_date":"2018-05-20 03:20:12","updated_date":"2018-05-20 03:20:12"},{"id":3,"title":"xxxxxxxxxxx","en_title":"category 3","description":"\u0628\u0639\u0636 \u0627\u0644\u0648\u0635\u0641 \u0627\u0644\u063a\u064a\u0631 \u0645\u0637\u0648\u0644 \u0644\u0647\u0630\u0627 \u0627\u0644\u0635\u0646\u0641","en_description":"some text about this categorysssdsdsd","status":1,"image":"1526569438.png","created_date":"2018-05-07 13:56:04","updated_date":"2018-05-18 19:03:48"}]}
 * 
 * 
 * 
 * {"status":"1","message":"\u0642\u0627\u0626\u0645\u0629 \u0627\u0644\u0627\u0635\u0646\u0627\u0641  ","en_message":"categories list","categories":[{"id":9,"title":"\u0645\u0637\u0627\u0639\u0645 ","en_title":"fff","description":"\u0645\u0622\u0643\u0648\u0644\u0627\u062a \u0648\u062c\u0645\u064a\u0639 \u0645\u0627 \u062a\u0634\u062a\u0647\u064a \u0627\u0644\u0646\u0641\u0633 \u0647\u0646\u0627 ","en_description":"cccc","status":1,"image":"http:\/\/13.59.32.107\/apps\/legita\/public\/uploads\/categories_images\/1526786412.png","updated_date":"2018-05-20 03:20:12","created_date":"2018-05-20 03:20:12"},{"id":3,"title":"xxxxxxxxxxx","en_title":"category 3","description":"\u0628\u0639\u0636 \u0627\u0644\u0648\u0635\u0641 \u0627\u0644\u063a\u064a\u0631 \u0645\u0637\u0648\u0644 \u0644\u0647\u0630\u0627 \u0627\u0644\u0635\u0646\u0641","en_description":"some text about this categorysssdsdsd","status":1,"image":"http:\/\/13.59.32.107\/apps\/legita\/public\/uploads\/categories_images\/1526569438.png","updated_date":"2018-05-18 19:03:48","created_date":"2018-05-07 13:56:04"}]}
 */
              //return $orders;
               
               foreach(collect($categories) as $category){
              
                        $all = [] ;
                        $all['id'] = $category->id;
                        $all['title'] = $category->title;
                        $all['en_title'] = $category->en_title;
                        $all['description'] = $category->description;
                        $all['en_description'] = $category->en_description;
                        $all['status'] = $category->status;
                        $all['image'] =BASE::getImageDir() .  $category->image;
                        $all['updated_date'] = $category->updated_date;
                        $all['created_date'] = $category->created_date;
    
                        $total[]  = $all;
                  
                }





                if(!empty($total)) {

                    //$result["category_image_url"] = BASE::getImageDir();

                    $result["status"] = "1";
                    $result["message"] = "قائمة الاصناف  ";
                    $result["en_message"] = "categories list";
                    $result["categories"] = $total;
                }else{
                //$result["category_image_url"] = BASE::getImageDir();

                $result["status"] = "0";
                $result["message"] = "قائمة الاصناف فارغة";
                $result["en_message"] = "categories list empty";

                }
                






            }else{

              $result["status"] = "0";
             $result["message"] = "فشل التحقق من المرسل ";
               $result["en_message"] = "authucation failer";
           }

            
            return json_encode($result);
    }



   
}
