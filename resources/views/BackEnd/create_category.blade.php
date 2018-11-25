@extends("BackEnd.layout.master")

@section("title")
Add Category | Legita Admin Panel
@endsection
@section("description")
        Add Category | Legita Admin Panel
@endsection



@section("content")


<form role="form" action="{{ url('admin/category/add') }}" method="POST" enctype='multipart/form-data'>

<input type="hidden" name="_token" value="{{ csrf_token() }}">


    <div class="form-group">
        <label>Arabic Title</label>
        <input class="form-control" type="text" placeholder="add arabic title for the category" name="title" required>
    </div>
    <div class="form-group">
        <label>Arabic Description</label>
        <textarea class="form-control" placeholder="add arabic description for the category" name="description" required></textarea>
    </div>
    <div class="form-group">
        <label>English Title</label>
        <input class="form-control"  type="text" placeholder="add english title for the category" name="en_title" required>
    </div>

    <div class="form-group">
        <label>English Description</label>
        <textarea class="form-control" placeholder="add english description for the category" name="en_description" required></textarea>
    </div>


        <div class="form-group">
        <label>Category Image</label>
        <input class="form-control" type="file" name="image">
    </div>
    <button type="submit" class="btn btn-default">Submit Button</button>
    <button type="reset" class="btn btn-primary">Reset Button</button>

</form>


@endsection