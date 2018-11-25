@extends("BackEnd.layout.master")

@section("title")
    Dashboard | Legita Admin Panel
@endsection
@section("description")
        Dashboard | Legita Admin Panel
@endsection



@section("content")

                <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-red set-icon">
                    <i class="fa fa-bars"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text">{{  $subcategories }} Subcategory</p>
                    <p class="text-muted">all subcategory by users </p>
                </div>
             </div>
		     </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-green set-icon">
                    <i class="fa fa-users"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text">{{ $users }} User</p>
                    <p class="text-muted">All merchant and customers </p>
                </div>
             </div>
		     </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-blue set-icon">
                    <i class="fa fa-circle"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text">{{  $items }} item</p>
                    <p class="text-muted">Total Items Added by Merchents </p>
                </div>
             </div>
		     </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-brown set-icon">
                    <i class="fa fa-bell-o"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text">{{ $orders }} Order</p>
                    <p class="text-muted">All Orders By Customers </p>
                </div>
             </div>
		     </div>
			</div>
@endsection