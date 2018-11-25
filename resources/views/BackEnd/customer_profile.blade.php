@extends("BackEnd.layout.master")

@section("title")
{{ $customer->name }} profile | Legita Admin Panel
@endsection
@section("description")
{{ $customer->id }} - {{ $customer->name }}  | Legita Admin Panel
@endsection



@section("content")

<div class="row">
    <div class="col-sm-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <img src="{{ $image_url }}/{{ $customer->profile_image  }}" style="height:200px" class="img-thumbnail img-responsive center-block"/>
            </div>
            <div class="panel-body profile_details">
                <span>{{ $customer->name }}</span>
                <span>{{ $customer->email }}</span>
                <span>{{ $customer->tel }}</span>
                <span>{{ $customer->address }}</span>
                <span>{{ $customer->created_date }}</span>
                <span>
                @if($customer->status == 1)
                    <a href="{{  url('admin/customer/block') }}/{{ $customer->id }}" class="confirm btn btn-sm btn-warning"><i class="fa fa-circle-o"></i> Block</a>
                @else
                    <a href="{{  url('admin/customer/active') }}/{{ $customer->id }}" class="confirm btn btn-sm btn-success"><i class="fa fa-circle"></i> Activitate</a>
                @endif
                
                <a href="{{  url('admin/customer/edit') }}/{{ $customer->id }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>
                                                <a href="{{  url('admin/customer/delete') }}/{{ $customer->id }}" class="confirmProccess btn btn-sm btn-danger"><i class="fa fa-close"></i> Delete</a>
                </span>
            </div>
            <div class="panel-footer">
            <span>{{ $customer->about }}</span>
            </div>
        </div>
    </div>

    <div class="col-sm-9">



<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#home">Orders</a></li>
  <li><a data-toggle="tab" href="#menu1">Activities</a></li>
</ul>

<div class="tab-content">
  <div id="home" class="tab-pane fade in active">
    <h3>HOME</h3>
        @if(!empty($orders))

                <div class="row">
                @foreach($orders as $order)

                    <?php


                        $merchant = DB::table("users")->where("id","=",$order->merchant_id)->first();
                        $subcategory = DB::table("subcategories")->where("id","=",$order->subcategory_id)->first();
                        $category = DB::table("categories")->where("id","=",$order->category_id)->first();
                        $item = DB::table("items")->where("id","=",$order->item_id)->first();

                        if(empty($category)){
                            $category_title = "Known";
                        }else{
                            $category_title = $category->title;

                        }



                

                        if(empty($subcategory)){
                            $subcategory_title = "Known";
                        }else{
                            $subcategory_title = $subcategory->title;

                        }


                        if(empty($item)){
                            $item_title = "Known";
                        }else{
                            $item_title = $item->title;

                        }

                    ?>
                   <div class="col-sm-4">
                   
                        <div class="panel panel-default">
                            <div class="panel-heading">
                               {{ $category_title }} - {{ $subcategory_title }} -  {{ $item_title }}
                            </div>
                            <div class="panel-body">
                            </div>
                        </div>
                   </div>


                @endforeach
                </div>  

        @else

            <div class="alert alert-warning text-center">There is no any order for this customer yet </div>

        @endif
  </div>
  <div id="menu1" class="tab-pane fade">
    <h3>Menu 1</h3>
    <p>Some content in menu 1.</p>
  </div>
 
</div>
  
    </div>

</div>

@endsection