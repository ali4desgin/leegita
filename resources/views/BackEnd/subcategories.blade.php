@extends("BackEnd.layout.master")

@section("title")
Subcategories | Legita Admin Panel
@endsection
@section("description")
Subcategories | Legita Admin Panel
@endsection



@section("content")

    @if(!empty($subcategories))
       
        <div class="row">

        @foreach($subcategories as $subcategory )
                <div class="col-md-3 col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                         {{  $subcategory->title }}
                        </div>
                        <div class="panel-body">
                            <p><img src="{{ url('public/uploads/subcategories_images') }}/{{ $subcategory->image    }}" class="img-circle img-thumbnail center-block" style="    height: 174px;"/></p>
                            <p> {{  $subcategory->description }}</p>
                        </div>
                        <div class="panel-footer">  <a href="{{ url('admin/subcategory/delete')}}/{{ $category_id   }}/{{ $subcategory->id   }}" class="confirm btn btn-danger btn-xs"><i class="fa fa-remove"></i> Delete </a>
                        @if( $subcategory->status == 1 )
                         <a href="{{ url('admin/subcategory/block')}}/{{ $category_id   }}/{{ $subcategory->id   }}" class="btn btn-warning btn-xs"><i class="fa fa-circle-o"></i> Block </a> 
                         @else

                            <a href="{{ url('admin/subcategory/active')}}/{{ $category_id   }}/{{ $subcategory->id   }}" class="btn btn-success btn-xs"><i class="fa fa-circle"></i> Activitate </a> 
                         @endif
                       
                        <a href="{{ url('admin/items')}}/{{ $category_id   }}/{{ $subcategory->id   }}" class="btn btn-info btn-xs"><i class="fa fa-eye"></i>items</a>
                        </div>
                    </div>
                </div>
        @endforeach

            </div>

    @endif

@endsection