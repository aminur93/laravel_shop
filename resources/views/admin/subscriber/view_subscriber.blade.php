@extends('layouts.adminLayouts.admin_design')

@section('main-content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Admin View Subscriber</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Subscriber</li>
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
                        <h5 class="card-title">View Subscriber List</h5>
                        <div class="pull pull-right card-title" style="margin-left: 940px;margin-top: -40px;">
                        <a href="{{ url('/admin/export-newsletter-email') }}" class="btn btn-primary">Export</a>
                        </div>
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($newsLetter as $nl)

                                    <tr>
                                        <td>{{$nl->id}}</td>
                                        <td>{{$nl->email}}</td>
                                        <td>
                                            @if($nl->status == 1)
                                                <a href="{{ url('/admin/update-newsletter-status/'.$nl->id.'/0') }}">
                                                    <span style="color: green">Active</span>
                                                </a>
                                            @else
                                                <a href="{{ url('/admin/update-newsletter-status/'.$nl->id.'/1') }}">
                                                    <span style="color: red">Inactive</span>
                                                </a>
                                            @endif

                                        </td>
                                        <td>
                                            <a href="{{url('/admin/edit-subscriber',$nl->id)}}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>

                                            <a rel="{{$nl->id}}" rel1="delete-subscriber" href="javascript:"
                                               href="{{url('/admin/delete-subscriber',$nl->id)}}"
                                               class="btn btn-xs btn-danger deleteRecord"><i class="fa fa-trash"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Name</th>
                                    <th>Status</th>
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
