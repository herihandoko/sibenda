  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/admin/css/font-awesome5.css')}}">
  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('assets/admin/css/style.css')}}?v=1.2">
  <link rel="stylesheet" href="{{asset('assets/admin/css/components.css')}}">
  <link rel="stylesheet" href="{{asset('assets/admin/bundles/datatables/datatables.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/admin/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/admin/css/jquery-ui.css')}}">
  <link rel="stylesheet" href="{{asset('assets/admin/css/select2.css')}}">
  <link rel="stylesheet" href="{{asset('assets/admin/css/custom.css')}}">


  @stack('style')
  @if (GetSetting('site_direction') == 'RTL')
      <link rel="stylesheet" href="{{asset('/assets/admin/css/rtl.css')}}">
  @endif

  <link rel="stylesheet" href="{{asset('assets/toastr/toastr.min.css')}}">

