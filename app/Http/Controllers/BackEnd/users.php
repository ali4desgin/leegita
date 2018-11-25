<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class BASE {


    public static function getImageDir(){

            $server_url = "http://" . $_SERVER['HTTP_HOST'] . "/";
            $subcategory_image  = "apps/legita/public/uploads/profile_images/";
            return $server_url.$subcategory_image;

    }

    public static function destinationPath(){

        return "public/uploads/profile_images";

    }

}



class users extends Controller
{
 
    

    public function customers(){

        $customers = DB::table("users")->where('type', "=",2)->orderBy("id","desc")->get()->toArray();

        return view("BackEnd.customers", compact("customers"));

    }



    public function profile($customer_id){
        $customer = DB::table("users")->where([
            ['id', "=",$customer_id]
        ])->first();


        $orders = DB::table("orders")->where("user_id","=",$customer_id)->get()->toArray();


        /*
        ,
            ['type', "=",2]
        */

        $image_url = BASE::getImageDir();


        if(empty($customer)){

            return redirect("admin/customers");
        }
        return view("BackEnd.customer_profile", compact("customer","orders","image_url"));


    }
    



    public function edit($customer_id,Request $request){


        $customer = DB::table("users")->where("id","=",$customer_id)->first();

        

        if(empty($customer)){

            return redirect("admin/users");

        }

        if($request->method()=="POST"){

            $title  = $request->input("title");
            $description  = $request->input("description");
            $en_title  = $request->input("en_title");
            $en_description  = $request->input("en_description");
            $image  = $request->file("image");


            //$image_id = null;
            $destinationPath = BASE::destinationPath();
            $final_image = "category.png";

            if (!empty($image) and in_array($image->getClientOriginalExtension() , array("png","jpg","jpeg","gif"))) {

                $current_time_stamp = time();


                $uploaded_image = $current_time_stamp.".".$image->getClientOriginalExtension();

                //echo $image->getClientOriginalExtension();
                
               $image->move($destinationPath,$uploaded_image);


                $final_image = $uploaded_image;
                
                if($category->image!="category.png"){

                    @unlink(BASE::destinationPath()."/".$category->image);
                }

                $id = DB::table('categories')->where("id","=",$category_id)->update(
                    ["image"=> $final_image ]);

            }




            $id = DB::table('categories')->where("id","=",$category_id)->update(
                [
                    'title' => $title,
                    'description' => $description,
                    'en_title' => $en_title,
                    'en_description' => $en_description,
                    'image' => $final_image

                ]
            );

            return redirect("admin/categories");





        }


       

        $image_url = BASE::getImageDir();

        return view("BackEnd.edit_customer", compact("customer","image_url"));
    }





    public function delete($customer_id){

        $customer = DB::table("users")->where("id","=",$customer_id)->first();


        if(!empty($customer)){

            if($customer->profile_image!="avatar.png"){

                @unlink(BASE::destinationPath()."/".$customer->profile_image);
            }
             

           DB::table("users")->where("id","=",$customer_id)->delete();
           
        }



        return redirect("admin/customers");
        

    }


    public function active($customer_id){

        $category = DB::table("users")->where("id","=",$customer_id)->update(['status' => 1]);




        return redirect("admin/customers");
        

    }


    public function block($customer_id){

        $category = DB::table("users")->where("id","=",$customer_id)->update(['status' => 0]);




        return redirect("admin/customers");
        

    }
}
