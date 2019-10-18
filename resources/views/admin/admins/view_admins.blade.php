@extends('layouts.adminLayouts.admin_design')

@section('main-content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Admin Views</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Admins</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->

    @if (Session::has('flash_message_error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>{!! session('flash_message_error') !!}</strong>
        </div>
    @endif

    @if (Session::has('flash_message_success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>{!! session('flash_message_success') !!}</strong>
        </div>
    @endif

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View Admins List</h5>
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Roles</th>
                                    <th>Status</th>
                                    <th>Created On</th>
                                    <th>Updated On</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                    @foreach($admins as $index => $admin)
                                        <?php
                                            if($admin->type == 'Admin')
                                            {
                                                $roles = "All";
                                            }else{
                                                $roles = "";
                                                if ($admin->category_access == 1){
                                                    $roles .= "Categories, ";
                                                }

                                                if ($admin->brand_access == 1){
                                                    $roles .= "Brand, ";
                                                }

                                                if ($admin->product_access == 1){
                                                    $roles .= "Product, ";
                                                }

                                                if ($admin->order_access == 1){
                                                    $roles .= "Order, ";
                                                }

                                                if ($admin->user_access == 1){
                                                    $roles .= "User, ";
                                                }
                                            }
                                        ?>
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $admin->username }}</td>
                                            <td>{{ $admin->type }}</td>
                                            <td>{{ $roles }}</td>
                                            <td>
                                                @if ($admin->status == 1)
                                                    <span style="color: green">Active</span>
                                                    @else
                                                    <span style="color: red">Inactive</span>
                                                @endif
                                            </td>
                                            <td>{{ $admin->created_at }}</td>
                                            <td>{{ $admin->updated_at }}</td>
                                            <td>
                                                <a href="{{ url('/admin/edit-admins', $admin->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                                ||
                                                <a href="" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Roles</th>
                                    <th>Status</th>
                                    <th>Created On</th>
                                    <th>Updated On</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->

@endsection