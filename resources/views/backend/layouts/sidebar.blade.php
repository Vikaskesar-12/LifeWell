<style>
    ul#accordionSidebar {
        background-image: linear-gradient(180deg, #072d9a 10%, #000000 100%);
    }
</style>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin') }}">
        <div class="sidebar-brand-icon text-center py-3">
            <img src="{{ asset('images/lifwel1.png') }}" class="img-fluid" style="max-width: 80%; height: auto;"
                alt="LIFWEL Logo">
        </div>

        <!-- <div class="sidebar-brand-text mx-3">Admin</div> -->
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Route::is('admin') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Banner
    </div>

    <!-- Nav Item - Pages Collapse Menu -->

    <li
        class="nav-item {{ Route::is('banner.index') || Route::is('banner.create') || Route::currentRouteName() == 'banner.edit' ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-image"></i>
            <span>Banners</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Banner Options:</h6>
                <a class="collapse-item" href="{{ route('banner.index') }}">Home Banners</a>
                <a class="collapse-item" href="{{ route('banners.index') }}">Other Banners</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Shop
    </div>

    <!-- Categories -->
    <li
        class="nav-item {{ Route::is('category.index') || Route::is('category.create') || Route::currentRouteName() == 'category.edit' ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#categoryCollapse"
            aria-expanded="true" aria-controls="categoryCollapse">
            <i class="fas fa-sitemap"></i>
            <span>Catelog</span>
        </a>
        <div id="categoryCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Catelog Options:</h6>
                <a class="collapse-item" href="{{ route('category.index') }}">Category</a>
                <a class="collapse-item" href="{{ route('collection.index') }}">Collection</a>
                <a class="collapse-item" href="{{ route('specification.index') }}">Specification</a>
                <a class="collapse-item" href="{{ route('brand.index') }}">Brands</a>
                <a class="collapse-item" href="{{ route('admin.attributes.index') }}">Attribute</a>
            </div>
        </div>
    </li>


    {{-- Products --}}
    <li
        class="nav-item {{ Route::is('product.index') || Route::is('product.create') || Route::currentRouteName() == 'product.edit' ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productCollapse"
            aria-expanded="true" aria-controls="productCollapse">
            <i class="fas fa-cubes"></i>
            <span>Products</span>
        </a>
        <div id="productCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Product Options:</h6>
                <a class="collapse-item" href="{{ route('product.index') }}">Products</a>
                <a class="collapse-item" href="{{ url('admin/product/create') }}">Add Products</a>
            </div>
        </div>
    </li>

    {{-- Brands --}}


    {{-- Discount Codes --}}
    <li
        class="nav-item {{ Route::is('discount.index') || Route::is('discount.create') || Route::currentRouteName() == 'discount.edit' ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#discountCollapse"
            aria-expanded="true" aria-controls="discountCollapse">
            <i class="fas fa-tag"></i>
            <span>Discount Codes</span>
        </a>
        <div id="discountCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Discount Options:</h6>
                <a class="collapse-item" href="{{ route('discount.index') }}">Discount Codes</a>
                <a class="collapse-item" href="{{ route('discount.create') }}">Add Discount Code</a>
            </div>
        </div>
    </li>





    <li class="nav-item {{ request()->routeIs('pages') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('admin/pages') }}">
            <i class="fas fa-file-alt"></i>
            <span>CMS</span>
        </a>
    </li>








    <!--Orders -->
    <li class="nav-item {{ Route::is('faq.order') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('order.index') }}">
            <i class="fas fa-hammer fa-chart-area"></i>
            <span>Orders</span>
        </a>
    </li>

    <!-- Reviews -->
    <li class="nav-item {{ Route::is('review.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('review.index') }}">
            <i class="fas fa-comments"></i>
            <span>Reviews</span></a>
    </li>





    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Heading -->
    <div class="sidebar-heading">
        General Settings
    </div>

    <!-- Users -->
    <li
        class="nav-item {{ Route::is('users.index') || Route::is('users.create') || Route::currentRouteName() == 'users.edit' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-users"></i>
            <span>Users</span></a>
    </li>

    <!-- Reviews -->
    <li class="nav-item {{ Route::is('contact.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('contact.index') }}">
            <i class="fas fa-envelope-open-text me-1"></i>
            <span>Enquiry</span>
        </a>
    </li>

    <li
        class="nav-item {{ Route::is('faq.index') || Route::is('faq.create') || Route::currentRouteName() == 'faq.edit' ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#faqCollapse"
            aria-expanded="true" aria-controls="categoryCollapse">
            <i class="fas fa-sitemap"></i>
            <span>Faq</span>
        </a>
        <div id="faqCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Specification Options:</h6>
                <a class="collapse-item" href="{{ route('faq.index') }}">Faq</a>
                <a class="collapse-item" href="{{ route('faq.create') }}">Add Faq</a>
            </div>
        </div>
    </li>
    <!-- General settings -->
    <li class="nav-item {{ Route::is('settings') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('settings') }}">
            <i class="fas fa-cog"></i>
            <span>Settings</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
