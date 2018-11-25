@extends("BackEnd.layout.master")

@section("title")
Customer | Legita Admin Panel
@endsection
@section("description")
Customer | Legita Admin Panel
@endsection



@section("content")

    @if(!empty($customers))
    <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Customers List
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info">
                                    <thead>
                                       
                                        <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 80px;">id</th>
                                        
                                        <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 200px;">Email</th>
                                        

                                        <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 200px;">Username</th>


                                        

                                        <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 100px;">Register date</th>
                                        
                                        <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 50px;">Status</th>

                                        <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 163px;">  Manage</th></tr>
                                       
                                        
                                    </thead>
                                    <tbody>
                                        
                                    @foreach($customers as $customer) 
           
           

                                        
                                    <tr class="gradeA odd">
                                            <td class="sorting_1">{{ $customer->id }}</td>
                                            <td class=" ">{{ $customer->email }}</td>
                                            <td class=" ">{{ $customer->name }}</td>
                                            <td class="center ">{{ $customer->created_date }}</td>
                                            <td class="center ">
                                            @if($customer->status == 1)
                                                <a href="{{  url('admin/customer/block') }}/{{ $customer->id }}" class="confirm btn btn-sm btn-warning"><i class="fa fa-circle-o"></i> Block</a>
                                            @else
                                                <a href="{{  url('admin/customer/active') }}/{{ $customer->id }}" class="confirm btn btn-sm btn-success"><i class="fa fa-circle"></i> Activitate</a>
                                            @endif
                                            
                                            </td>
                                            <td class="center ">
                                                <a href="{{  url('admin/customer/profile') }}/{{ $customer->id }}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Profile</a>
                                                <a href="{{  url('admin/customer/edit') }}/{{ $customer->id }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>
                                                <a href="{{  url('admin/customer/delete') }}/{{ $customer->id }}" class="confirmProccess btn btn-sm btn-danger"><i class="fa fa-close"></i> Delete</a>
                                            </td>
                                            
                                    </tr>




                                    @endforeach


                                        
                                        </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
    @else

    <div class="alert alert-warning text-center">There is no any customer registe </div>
    @endif

@endsection