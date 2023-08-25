<!-- General JS Scripts -->
<script src="{{asset('assets/admin/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/admin/js/popper.min.js')}}"></script>
<script src="{{asset('assets/admin/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/admin/js/jquery.nicescroll.min.js')}}"></script>
<script src="{{asset('assets/admin/js/moment.min.js')}}"></script>
<script src="{{asset('assets/admin/js/stisla.js')}}"></script>
<script src="{{asset('assets/admin/js/jquery-ui.js')}}"></script>
<script src="{{asset('assets/admin/js/tagsinput.js')}}"></script>
<script src="{{asset('assets/admin/plugins/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('assets/admin/js/select2.js')}}"></script>
<!-- JS Libraies -->


<!-- Template JS File -->
<script src="{{asset('assets/admin/js/scripts.js')}}"></script>
<script src="{{asset('assets/admin/js/custom.js')}}"></script>
<!-- Page Specific JS File -->

<script src="{{asset('assets/toastr/toastr.min.js')}}"></script>



<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@include('sweetalert::alert')
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
</script>
<script>
    @if(Session::has('message'))
    var type="{{Session::get('alert-type','info')}}"
    switch(type){
        case 'info':
        toastr.info("{{Session::get('message')}}");
            break;
        case 'success':
        toastr.success("{{Session::get('message')}}");
            break;
        case 'warning':
        toastr.warning("{{Session::get('message')}}");
            break;
        case 'error':
        toastr.error("{{Session::get('message')}}");
            break;
    }
    @endif
</script>
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            toastr.error('{{$error}}');
        </script>
    @endforeach
@endif

@stack('script')
<script src="{{url('assets/admin/bundles/datatables/datatables.min.js')}}"></script>
<script src="{{url('assets/admin/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}">
</script>
<script src="{{asset('assets/vendor/datatables/buttons.server-side.js')}}"></script>
{{-- Dependent Scripts --}}
