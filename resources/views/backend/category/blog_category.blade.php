@extends('admin.admin_dashboard')
@section('admin')

    <div class="page-content">
       
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Blog Categories</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Blog Categories List</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Blog Category</button>
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
                            <tr style="text-align: center">
                                <th>SN</th>
                                <th>Category Name</th>
                                <th>Category Slug</th>                                
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($category as $key => $item)
                            <tr>
                                <td>{{ $key+1 }}</td>                                
                                <td>{{ $item->category_name }}</td>
                                <td>{{ $item->category_slug }}</td>                                
                                <td>                                    
                                    <button type="button" class="btn btn-warning px-3 radius-30" data-bs-toggle="modal" data-bs-target="#editCategoryModal" id="{{ $item->id }}" onclick="categoryEdit(this.id)">Edit</button>
                                    <a href="{{ route('blog.category.delete',$item->id) }}" class="btn btn-danger px-3 radius-30" id="delete">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                    </table>
                </div>
            </div>
        </div>
        <hr>
       
    </div>

    <!-- Add Category Modal Start -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Blog Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('blog.category.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Blog Category Name</label>
                            <input type="text" name="category_name" class="form-control">
                        </div>                    
                    </div>
                    <div class="modal-footer">   
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Category Modal End -->

    <!-- Edit Category Modal Start -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Blog Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('blog.category.update') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="cat_id" id="cat_id">
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Blog Category Name</label>
                            <input type="text" name="category_name" class="form-control" id="cat">
                        </div>                    
                    </div>
                    <div class="modal-footer">   
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Category Modal End -->


    <script>
        function categoryEdit(id){
            $.ajax({
                type: 'GET',
                url: '/blog/category/edit/'+id,
                dataType: 'json', 

                success:function(data){
                    $('#cat').val(data.category_name);
                    $('#cat_id').val(data.id);
                }
            })
        }
    </script>

@endsection