@extends("BackEnd.layout.master")

@section("title")
Categories | Legita Admin Panel
@endsection
@section("description")
        Categories | Legita Admin Panel
@endsection



@section("content")

    @if(!empty($categories))
        <p>
            <a href="{{ url('admin/category/add') }}" class="btn  btn-default"><i class="fa fa-plus"></i> Create Category </a>
        </p>
        <div class="row">

        @foreach($categories as $category )
                <div class="col-md-4 col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        {{  $category->en_title }} -  {{  $category->title }}
                        </div>
                        <div class="panel-body">
                            <p><img src="{{ url('public/uploads/categories_images') }}/{{ $category->image   }}" class="img-circle img-thumbnail center-block" style="    height: 174px;"/></p>
                            <p> {{  $category->en_description }} <br/> {{  $category->description }}</p>
                        </div>
                        <div class="panel-footer"> <a href="{{ url('admin/category/edit')}}/{{ $category->id   }}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit </a> <a href="{{ url('admin/category/delete')}}/{{ $category->id   }}" class="confirm btn btn-danger btn-xs"><i class="fa fa-remove"></i> Delete </a>
                        @if( $category->status == 1 )
                         <a href="{{ url('admin/category/block')}}/{{ $category->id   }}" class="btn btn-warning btn-xs"><i class="fa fa-circle-o"></i> Block </a> 
                         @else

                            <a href="{{ url('admin/category/active')}}/{{ $category->id   }}" class="btn btn-success btn-xs"><i class="fa fa-circle"></i> Activitate </a> 
                         @endif
                        <br/><br/>
                        <a href="{{ url('admin/subcategories')}}/{{ $category->id   }}" class="btn btn-info btn-xs"><i class="fa fa-eye"></i>subcategories</a>
                        </div>
                    </div>
                </div>
        @endforeach

            </div>

    @endif

@endsection