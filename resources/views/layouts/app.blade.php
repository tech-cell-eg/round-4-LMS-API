@include('layouts.head')
<body style="background-color: #f8f9fa;">    <div class="container-scroller">
      <div class="row p-0 m-0 proBanner" id="proBanner">
        <div class="col-md-12 p-0 m-0">
          <div class="card-body card-body-padding d-flex align-items-center justify-content-between">
            <div class="ps-lg-1">
              <div class="d-flex align-items-center justify-content-between">
                <p class="mb-0 font-weight-medium me-3 buy-now-text">Free 24/7 customer support, updates, and more with this template!</p>
                <a href="https://www.bootstrapdash.com/product/corona-free/?utm_source=organic&utm_medium=banner&utm_campaign=buynow_demo" target="_blank" class="btn me-2 buy-now-btn border-0">Get Pro</a>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-between">
              <a href="https://www.bootstrapdash.com/product/corona-free/"><i class="mdi mdi-home me-3 text-white"></i></a>
              <button id="bannerClose" class="btn border-0 p-0">
                <i class="mdi mdi-close text-white me-0"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- partial:partials/_sidebar.html -->
       @if (!Request::is('instructor/login'))
      @include('layouts.sidebar')
     @endif

      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
      <!-- @include('layouts.navbar') -->
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">



           @hasSection('rating-summary')
        <div class="container mx-auto mb-4">
            @yield('rating-summary')
        </div>
        @endif
        
            @yield('content')

          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
         @include('layouts.footer')

@yield('scripts')
         