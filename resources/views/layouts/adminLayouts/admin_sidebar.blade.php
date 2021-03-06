<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('/admin/dashboard') }}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>

                @if(Session::get('adminDetails')['category_full_access'] == 1)

            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-list"></i><span class="hide-menu">Category </span></a>
                <ul aria-expanded="false" class="collapse  first-level">
                    <li class="sidebar-item"><a href="{{ url('/admin/add-category') }}" class="sidebar-link"><i class="mdi mdi-plus"></i><span class="hide-menu">Add category </span></a></li>
                <li class="sidebar-item"><a href="{{ url('/admin/view-category') }}" class="sidebar-link"><i class="mdi mdi-eye"></i><span class="hide-menu"> View category </span></a></li>
                </ul>
            </li>

                @else
            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-list"></i><span class="hide-menu">Category </span></a>
                <ul aria-expanded="false" class="collapse  first-level">
                    @if(Session::get('adminDetails')['category_edit_access'] == 1)
                    <li class="sidebar-item"><a href="{{ url('/admin/add-category') }}" class="sidebar-link"><i class="mdi mdi-plus"></i><span class="hide-menu">Add category </span></a></li>
                    @endif
                        @if(Session::get('adminDetails')['category_view_access'] == 1)
                    <li class="sidebar-item"><a href="{{ url('/admin/view-category') }}" class="sidebar-link"><i class="mdi mdi-eye"></i><span class="hide-menu"> View category </span></a></li>
                            @endif
                </ul>
            </li>

                @endif

                @if(Session::get('adminDetails')['brand_access'] == 1)

            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fab fa-btc"></i><span class="hide-menu"> Brand </span></a>
                <ul aria-expanded="false" class="collapse  first-level">
                    <li class="sidebar-item"><a href="{{ url('/admin/add-brand') }}" class="sidebar-link"><i class="mdi mdi-plus"></i><span class="hide-menu">Add Brand </span></a></li>
                <li class="sidebar-item"><a href="{{ url('/admin/view-brand') }}" class="sidebar-link"><i class="mdi mdi-eye"></i><span class="hide-menu"> View Brand </span></a></li>
                </ul>
            </li>

                @endif

            @if(Session::get('adminDetails')['product_access'] == 1)

            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fab fa-product-hunt"></i><span class="hide-menu"> Product </span></a>
                <ul aria-expanded="false" class="collapse  first-level">
                    <li class="sidebar-item"><a href="{{ url('/admin/add-product') }}" class="sidebar-link"><i class="mdi mdi-plus"></i><span class="hide-menu">Add Product </span></a></li>
                    <li class="sidebar-item"><a href="{{ url('/admin/view-product') }}" class="sidebar-link"><i class="mdi mdi-eye"></i><span class="hide-menu"> View Product </span></a></li>
                </ul>
            </li>
            @endif

                @if(Session::get('adminDetails')['type'] == 'Admin')

            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-gift"></i><span class="hide-menu"> Coupons </span></a>
                <ul aria-expanded="false" class="collapse  first-level">
                    <li class="sidebar-item"><a href="{{ url('/admin/add-coupons') }}" class="sidebar-link"><i class="mdi mdi-plus"></i><span class="hide-menu">Add Coupons </span></a></li>
                    <li class="sidebar-item"><a href="{{ url('/admin/view-coupons') }}" class="sidebar-link"><i class="mdi mdi-eye"></i><span class="hide-menu"> View Coupons </span></a></li>
                </ul>
            </li>
                @endif

                @if(Session::get('adminDetails')['type'] == 'Admin')

            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-image"></i><span class="hide-menu"> Banners </span></a>
                <ul aria-expanded="false" class="collapse  first-level">
                    <li class="sidebar-item"><a href="{{ url('/admin/add-banners') }}" class="sidebar-link"><i class="mdi mdi-plus"></i><span class="hide-menu">Add Banners </span></a></li>
                    <li class="sidebar-item"><a href="{{ url('/admin/view-banners') }}" class="sidebar-link"><i class="mdi mdi-eye"></i><span class="hide-menu"> View Banners </span></a></li>
                </ul>
            </li>
                @endif

                @if(Session::get('adminDetails')['order_access'] == 1)

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fab fa-first-order"></i><span class="hide-menu"> Order </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{ url('/admin/view-orders') }}" class="sidebar-link"><i class="mdi mdi-eye"></i><span class="hide-menu"> View Orders </span></a></li>
                    </ul>
                </li>

                @endif

                @if(Session::get('adminDetails')['user_access'] == 1)

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-user-plus"></i><span class="hide-menu"> Users </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{ url('/admin/view-users') }}" class="sidebar-link"><i class="mdi mdi-eye"></i><span class="hide-menu"> View users </span></a></li>
                        <li class="sidebar-item"><a href="{{ url('/admin/view-users/charts') }}" class="sidebar-link"><i class="mdi mdi-file-chart"></i><span class="hide-menu"> View users Charts</span></a></li>
                    </ul>
                </li>

                @endif


                @if(Session::get('adminDetails')['type'] == 'Admin')
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-user-secret"></i><span class="hide-menu"> Admin/Sub-Admins </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{ url('/admin/add-admins') }}" class="sidebar-link"><i class="mdi mdi-plus"></i><span class="hide-menu"> Add Admin/Sub-Admins </span></a></li>
                        <li class="sidebar-item"><a href="{{ url('/admin/view-admins') }}" class="sidebar-link"><i class="mdi mdi-eye"></i><span class="hide-menu"> View Admin/Sub-Admins </span></a></li>
                    </ul>
                </li>
                @endif

                @if(Session::get('adminDetails')['type'] == 'Admin')
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-globe"></i><span class="hide-menu"> Cms Pages </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{ url('/admin/add-cms-page') }}" class="sidebar-link"><i class="mdi mdi-plus"></i><span class="hide-menu">Add Cms </span></a></li>
                        <li class="sidebar-item"><a href="{{ url('/admin/view-cms-page') }}" class="sidebar-link"><i class="mdi mdi-eye"></i><span class="hide-menu"> View Cms </span></a></li>
                    </ul>
                </li>

                @endif

                @if(Session::get('adminDetails')['type'] == 'Admin')
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-currency-usd"></i><span class="hide-menu"> Currency </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{ url('/admin/add-currency') }}" class="sidebar-link"><i class="mdi mdi-plus"></i><span class="hide-menu">Add Currency </span></a></li>
                        <li class="sidebar-item"><a href="{{ url('/admin/view-currency') }}" class="sidebar-link"><i class="mdi mdi-eye"></i><span class="hide-menu"> View Currency </span></a></li>
                    </ul>
                </li>
                @endif

                @if(Session::get('adminDetails')['type'] == 'Admin')
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-shipping-fast"></i><span class="hide-menu"> Shipping Charges </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{ url('/admin/view-shipping') }}" class="sidebar-link"><i class="mdi mdi-eye"></i><span class="hide-menu"> View Shipping Charge </span></a></li>
                    </ul>
                </li>
                    @endif

                @if(Session::get('adminDetails')['type'] == 'Admin')
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-envelope-open"></i><span class="hide-menu"> Subscriber </span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="{{ url('/admin/view-subscriber') }}" class="sidebar-link"><i class="mdi mdi-eye"></i><span class="hide-menu"> View Subscriber </span></a></li>
                        </ul>
                    </li>
                @endif
               
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->