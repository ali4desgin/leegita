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



class subcategories extends Controller
{
 
    

    public function index($category_id){

        $subcategories = DB::table("subcategories")->where('category_id', "=",$category_id)->orderBy("id","desc")->get()->toArray();

        return view("BackEnd.subcategories", compact("subcategories","category_id"));

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





    public function delete($category_id,$subcategory_id){

        $subcategory = DB::table("subcategories")->where("id","=",$subcategory_id)->first();


        if(!empty($subcategory)){

            if($subcategory->image!="category.png"){

                @unlink(BASE::destinationPath()."/".$subcategory->image);
            }
             

           DB::table("subcategories")->where("id","=",$subcategory_id)->delete();
           
        }



        return redirect("admin/subcategories/".$category_id);
        

    }


    public function active($category_id,$subcategory_id){

        $category = DB::table("subcategories")->where("id","=",$subcategory_id)->update(['status' => 1]);




        return redirect("admin/subcategories/".$category_id);
        

    }


    public function block($category_id,$subcategory_id){

        $category = DB::table("subcategories")->where("id","=",$subcategory_id)->update(['status' => 0]);




        return redirect("admin/subcategories/".$category_id);

    }
}
