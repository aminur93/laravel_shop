@extends('layouts.adminLayouts.admin_design')

@section('main-content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Admin View Cms page</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Cms page</li>
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
                        <h5 class="card-title">View Cms Page List</h5>
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Title</th>
                                    <th>Url</th>
                                    <th>Status</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($cms as $cm)


                                    <tr>
                                        <td>{{$cm->id}}</td>
                                        <td>{{$cm->title}}</td>
                                        <td>{{$cm->url}}</td>
                                        <td>
                                            @if ($cm->status == 1)
                                                Active
                                                @else
                                                Deactivate
                                            @endif
                                        </td>
                                        <td>{{$cm->description}}</td>
                                        <td style="display:inline-block;width:170px;">

                                            <a href="{{$cm->id}}" data-toggle="modal" data-target="#add-new-event{{$cm->id}}" class="btn btn-info btn-sm">
                                                <i class="ti-plus"></i>
                                            </a>

                                            <a href="{{url('/admin/edit_cms',$cm->id)}}" class="btn btn-cyan btn-sm"><i class="fas fa-edit"></i></a>

                                            <a rel="{{$cm->id}}" rel1="delete-cms" href="javascript:"
                                               {{--href="{{url('/admin/delete-product',$product->id)}}"--}}
                                            class="btn btn-danger btn-sm deleteRecord"><i class="fas fa-trash" style="margirn-top:10px;"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Modal Add Category -->
                                    <div class="modal fade none-border" id="add-new-event{{$cm->id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"><strong>{{$cm->title}}</strong></h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Cms ID:</strong> {{$cm->id}}</p>
                                                    <p><strong>Cms Title:</strong> {{$cm->title}}</p>
                                                    <p><strong>Cms Url:</strong> {{$cm->url}}</p>
                                                    <p><strong>Cms status:</strong>
                                                        @if ($cm->status == 1)
                                                            Active
                                                        @else
                                                            Deactivate
                                                        @endif
                                                    </p>
                                                    <p><strong>Cms Created At:</strong> {{$cm->created_at}}</p>
                                                    <p><strong>Cms Description:</strong> {{$cm->description}}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Save</button>
                                                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END MODAL -->
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Title</th>
                                    <th>Url</th>
                                    <th>Status</th>
                                    <th>Description</th>
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
