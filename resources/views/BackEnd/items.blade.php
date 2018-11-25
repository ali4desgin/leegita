@extends("BackEnd.layout.master")

@section("title")
Subcategories | Legita Admin Panel
@endsection
@section("description")
<h3></h3>
<p></p>
@endsection



@section("content")

 @if(!empty($items))
       
 <div class="row">

 @foreach($items as $item )
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="{{ $path }}{{ $item->image }} " alt="{{ $item->title }}" class="img-responsive" >
      <div class="caption">
        <h3>{{ $item->title }}</h3>
        <p>{{ $item->description }}</p>
        <p><a href="{{ url('orders/item/'.$item->id) }}" class="btn btn-primary" role="button">Orders</a> </p>
      </div>
    </div>
  </div>
  @endforeach
</div>

       

       

 @endif


@endsection