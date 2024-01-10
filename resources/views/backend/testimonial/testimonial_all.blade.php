@extends('admin.admin_dashboard')
@section('admin')

    <div class="page-content">
       
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Testimonials</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Testimonials List</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('testimonial.add') }}" class="btn btn-primary px-5">Add Testimonials</a>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <hr/>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>City</th>                               
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($testimonial as $key => $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td> <img src="{{ url($item->image) }}" alt="" style="width:70px; height:40px"> </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->city }}</td>                                
                                <td>
                                    <a href="{{ route('testimonial.edit',$item->id) }}" class="btn btn-warning px-3 radius-30">Edit</a>
                                    <a href="{{ route('testimonial.delete',$item->id) }}" class="btn btn-danger px-3 radius-30" id="delete">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                    </table>
                </div>
            </div>
        </div>
        <hr>
       
    </div>

@endsection