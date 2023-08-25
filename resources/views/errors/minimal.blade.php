
    <!DOCTYPE html>
    <head>
        <!-- Meta Tags -->
        <meta name="viewport" content="width=device-width,initial-scale=1.0" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <!-- Page Title -->
        <title> @yield('title') </title>
    </head>
    <body>

        <div id="wrapper" class="clearfix">

            <!-- Start main-content -->
            <div class="main-content-area">

              <!-- Section: home -->
              <section id="home" class="fullscreen bg-lightest">
                <div class="display-table text-center">
                  <div class="display-table-cell">
                    <div class="container pt-0 pb-0">
                      <div class="row">
                        <div class="col"></div>
                        <div class="col-lg-8">
                          <h1 class="font-size-150 text-theme-colored1 mt-0 mb-0"><i class="fa fa-map-signs text-gray-silver"></i>@yield('code')!</h1>
                          <h2 class="mt-0">{{trans('frontend.Oops!')}} @yield('message')</h2>
                          <a class="btn btn-theme-colored1 btn-round btn-circled" href="{{url('/')}}">{{trans('frontend.Return Home!')}}</a>
                        </div>
                        <div class="col"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            </div>
            <!-- end main-content -->
          </div>



    </body>
    </html>








