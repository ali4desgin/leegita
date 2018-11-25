@extends("BackEnd.layout.master")

@section("title")
Edit Category | Legita Admin Panel
@endsection
@section("description")
        Edit Category | Legita Admin Panel
@endsection



@section("content")


<form role="form" action="{{ url('admin/category/edit') }}/{{ $category->id }}" method="POST" enctype='multipart/form-data'>

<input type="hidden" name="_token" value="{{ csrf_token() }}">


    <div class="form-group">
        <label>Arabic Title</label>
        <input class="form-control" type="text" placeholder="add arabic title for the category" name="title"  value='{{ $category->title }}' required>
    </div>
    <div class="form-group">
        <label>Arabic Description</label>
        <textarea class="form-control" placeholder="add arabic description for the category" name="description" required>{{ $category->description }}</textarea>
    </div>
    <div class="form-group">
        <label>English Title</label>
        <input class="form-control"  type="text" placeholder="add english title for the category" name="en_title" value='{{ $category->en_title }}' required>
    </div>

    <div class="form-group">
        <label>English Description</label>
        <textarea class="form-control" placeholder="add english description for the category" name="en_description" required>{{ $category->en_description }}</textarea>
    </div>


    <div class="form-group">
    
        <img id="preview" src="{{ $image_url }}{{ $category->image }}" style="height:200px" class="img-thumbnail"/>
    </div>
        <div class="form-group">
        <label>Category Image</label>
        <input class="form-control" type="file" id="image" name="image">
    </div>
    <button type="submit" class="btn btn-default">Edit Button</button>
    <a href="{{ url('admin/categories') }}" type="reset" class="btn btn-primary">Cancel Button</a>

</form>


@endsection