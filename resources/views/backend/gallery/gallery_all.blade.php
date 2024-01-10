@extends('admin.admin_dashboard')
@section('admin')

    <div class="page-content">
       
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Gallery Images</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Gallery Images List</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('gallery.add') }}" class="btn btn-primary px-5">Add Gallery Image</a>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <hr/>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">

                    <form action="{{ route('gallery.multiple.delete') }}" method="POST">
                    @csrf

                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="10%">Select</th>
                                    <th width="10%">SN</th>
                                    <th>Image</th>                               
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gallery as $key => $item)
                                <tr>
                                    <td><input type="checkbox" name="selectedItem[]" value="{{ $item->id }}"></td>
                                    <td>{{ $key+1 }}</td>
                                    <td> <img src="{{ url($item->photo_name) }}" alt="" style="width:70px; height:40px"> </td>                              
                                    <td>
                                        <a href="{{ route('gallery.edit',$item->id) }}" class="btn btn-warning px-3 radius-30">Edit</a>
                                        <a href="{{ route('gallery.delete',$item->id) }}" class="btn btn-danger px-3 radius-30" id="delete">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                        </table>
                        <button type="submit" class="btn btn-danger">Delete Selected</button>

                    </form>
                </div>
            </div>
        </div>
        <hr>
       
    </div>

@endsection