@extends('layouts.adminLayouts.admin_design')

@section('main-content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Admin View Currency</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Currency</li>
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
                        <h5 class="card-title">View Currency List</h5>
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Currency Code</th>
                                    <th>Exchange Rate</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($currencies as $currency)


                                    <tr>
                                        <td>{{$currency->id}}</td>
                                        <td>{{$currency->currency_code}}</td>
                                        <td>{{$currency->exchange_rate}}</td>
                                        <td>
                                            @if ($currency->status == 1)
                                                <span class="label label-success">Active</span>
                                                @else
                                                <span class="label label-danger">Deactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{url('/admin/edit-currency',$currency->id)}}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>

                                            <a rel="{{$currency->id}}" rel1="delete-currency" href="javascript:"
                                               {{--href="{{url('/admin/delete-brand',$brand->id)}}"--}}
                                               class="btn btn-xs btn-danger deleteRecord"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>URL</th>
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
