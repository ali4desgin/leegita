<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class adminController extends Controller
{
    

    public function login(Request $request){


        $error= [] ;
        if($request->method() == "POST") {



            $email = $request->input("email");
            $password = $request->input("pass");

            $check =  DB::table("users")->where([

                ["email","=",$email],
                ["password","=",md5($password)],
                ["status","=","1"],
                ["type","=","0"]
            ])->count();

            if( $check <= 1 ){

                $admin =  DB::table("users")->where([

                    ["email","=",$email],
                    ["password","=",md5($password)],
                    ["status","=","1"],
                    ["type","=","0"]
                ])->first();


                $mytime = \Carbon\Carbon::now();
               
                $request->session()->put("admin_id", $admin->id);
                $request->session()->put("last_access", $mytime->toDateTimeString());
                $request->session()->put("admin_logged",1);

                return redirect("admin/dashboard");

            }else{


                $error[] = "Data";

            }
        }

      
        return view("BackEnd.login",$error);
    }



    public function logout(Request $request){


        $request->session()->forget("admin_id");
         $request->session()->put("admin_logged",0);
        return redirect("admin/login");


    }

    public function dashboard(){

        $subcategories = DB::table("subcategories")->count();
        $users = DB::table("users")->count();
        $items = DB::table("items")->count();
        $orders = DB::table("orders")->count();
       // $data['total_categories'] = $total_categories;

        return view("BackEnd.dashboard", compact("users","subcategories", "items", "orders"));
    }

}
