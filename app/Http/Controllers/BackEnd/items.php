<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class BASE {


    public static function getImageDir(){

            $server_url = "http://" . $_SERVER['HTTP_HOST'] . "/";
            $subcategory_image  = "apps/legita/public/uploads/items_images/";
            return $server_url.$subcategory_image;

    }

    public static function destinationPath(){

        return "public/uploads/items_images";

    }

}


class items extends Controller
{
 
    

    public function index($category_id,$subcategory_id){


        $subcategory  =  DB::table("subcategories")->where('id','=',$subcategory_id)->get();


        $path = BASE::getImageDir();
        $subcategory = $subcategory[0];
        if(empty($subcategory )){


            return redirect("admin/subcategories");
        }

        $mechent  =  DB::table("users")->where('id','=',$subcategory_id)->get();

        $items =  DB::table("items")->where('subcategory_id','=',$subcategory_id)->get()->toArray();



        return view("BackEnd.items", compact("subcategory","items","path"));

    }

}