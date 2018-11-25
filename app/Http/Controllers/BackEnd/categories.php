<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class BASE {


    public static function getImageDir(){

            $server_url = "http://" . $_SERVER['HTTP_HOST'] . "/";
            $subcategory_image  = "apps/legita/public/uploads/categories_images/";
            return $server_url.$subcategory_image;

    }

    public static function destinationPath(){

        return "public/uploads/categories_images";

    }

}



class categories extends Controller
{
 
    

    public function index(){

        $categories = DB::table("categories")->orderBy("id","desc")->get()->toArray();

        return view("BackEnd.categories", compact("categories"));

    }


    public function add(Request $request){



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
                


            }




            $id = DB::table('categories')->insertGetId(
                [
                    'title' => $title,
                    'description' => $description,
                    'en_title' => $en_title,
                    'en_description' => $en_description,
                    'image' => $final_image,
                    'status' => 1

                ]
            );

            return redirect("admin/categories");





        }


        return view("BackEnd.create_category");
    }

    








    public function edit($category_id,Request $request){


        $category = DB::table("categories")->where("id","=",$category_id)->first();



        if(empty($category)){

            return redirect("admin/categories");

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

        return view("BackEnd.edit_category", compact("category","image_url"));
    }





    public function delete($category_id){

        $category = DB::table("categories")->where("id","=",$category_id)->first();


        if(!empty($category)){

            if($category->image!="category.png"){

                @unlink(BASE::destinationPath()."/".$category->image);
            }
             

           DB::table("categories")->where("id","=",$category_id)->delete();
           
        }



        return redirect("admin/categories");
        

    }


    public function active($category_id){

        $category = DB::table("categories")->where("id","=",$category_id)->update(['status' => 1]);




        return redirect("admin/categories");
        

    }


    public function block($category_id){

        $category = DB::table("categories")->where("id","=",$category_id)->update(['status' => 0]);




        return redirect("admin/categories");
        

    }
}
