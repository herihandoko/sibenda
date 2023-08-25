<nav class="navbar navbar-expand-lg main-navbar">
    <div class=" mr-auto">
      <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
      </ul>
    </div>
    <ul class="navbar-nav navbar-right">
        <li ><a href="{{url('/')}}" onclick="event.preventDefault(); window.open('{{url('/')}}')" class="nav-link nav-link-lg"> <i class="fas fa-globe-asia    "></i> </a>
        </li>
      <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="{{asset(Auth::guard('admin')->user()->avatar)}}" class="rounded-circle mr-1">
        <div class="d-sm-none d-lg-inline-block">Hi, {{Auth::guard('admin')->user()->name}}</div></a>
        <div class="dropdown-menu dropdown-menu-right">

<!--          <a href="{{route('admin.user-profile.index')}}" class="dropdown-item has-icon">
            <i class="far fa-user"></i> {{trans('admin.Profile')}}
          </a>-->
<!--          <a href="{{route('admin.settings')}}" class="dropdown-item has-icon">
            <i class="fas fa-cog"></i> {{trans('admin.Settings')}}
          </a>-->
          <!--<div class="dropdown-divider"></div>-->
          <a href="{{route('user.logout')}}" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();" class="dropdown-item has-icon text-danger">
            <i class="fas fa-sign-out-alt"></i> {{trans('admin.Logout')}}
          </a>
          <form id="logout-form" action="{{route('admin.logout')}}" method="POST" class="d-none">
            @csrf </form>
        </div>
      </li>
    </ul>
  </nav>
