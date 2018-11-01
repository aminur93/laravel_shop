<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('/admin/dashboard') }}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>

            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-list"></i><span class="hide-menu">Category </span></a>
                <ul aria-expanded="false" class="collapse  first-level">
                    <li class="sidebar-item"><a href="{{ url('/admin/add-category') }}" class="sidebar-link"><i class="mdi mdi-plus"></i><span class="hide-menu">Add category </span></a></li>
                <li class="sidebar-item"><a href="{{ url('/admin/view-category') }}" class="sidebar-link"><i class="mdi mdi-eye"></i><span class="hide-menu"> View category </span></a></li>
                </ul>
            </li>

            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fab fa-btc"></i><span class="hide-menu"> Brand </span></a>
                <ul aria-expanded="false" class="collapse  first-level">
                    <li class="sidebar-item"><a href="{{ url('/admin/add-brand') }}" class="sidebar-link"><i class="mdi mdi-plus"></i><span class="hide-menu">Add Brand </span></a></li>
                <li class="sidebar-item"><a href="{{ url('/admin/view-brand') }}" class="sidebar-link"><i class="mdi mdi-eye"></i><span class="hide-menu"> View Brand </span></a></li>
                </ul>
            </li>

            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fab fa-product-hunt"></i><span class="hide-menu"> Product </span></a>
                <ul aria-expanded="false" class="collapse  first-level">
                    <li class="sidebar-item"><a href="{{ url('/admin/add-product') }}" class="sidebar-link"><i class="mdi mdi-plus"></i><span class="hide-menu">Add Product </span></a></li>
                    <li class="sidebar-item"><a href="{{ url('/admin/view-product') }}" class="sidebar-link"><i class="mdi mdi-eye"></i><span class="hide-menu"> View Product </span></a></li>
                </ul>
            </li>

            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-gift"></i><span class="hide-menu"> Coupons </span></a>
                <ul aria-expanded="false" class="collapse  first-level">
                    <li class="sidebar-item"><a href="{{ url('/admin/add-coupons') }}" class="sidebar-link"><i class="mdi mdi-plus"></i><span class="hide-menu">Add Coupons </span></a></li>
                    <li class="sidebar-item"><a href="{{ url('/admin/view-coupons') }}" class="sidebar-link"><i class="mdi mdi-eye"></i><span class="hide-menu"> View Coupons </span></a></li>
                </ul>
            </li>

            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-image"></i><span class="hide-menu"> Banners </span></a>
                <ul aria-expanded="false" class="collapse  first-level">
                    <li class="sidebar-item"><a href="{{ url('/admin/add-banners') }}" class="sidebar-link"><i class="mdi mdi-plus"></i><span class="hide-menu">Add Banners </span></a></li>
                    <li class="sidebar-item"><a href="{{ url('/admin/view-banners') }}" class="sidebar-link"><i class="mdi mdi-eye"></i><span class="hide-menu"> View Banners </span></a></li>
                </ul>
            </li>
               
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