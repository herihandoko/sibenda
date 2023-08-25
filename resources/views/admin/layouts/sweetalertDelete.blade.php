<script>
    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
        title: '{{trans('admin.Are you sure?')}}',
        text: "{{trans('admin.You wont be able to revert this!')}}",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '{{trans('admin.Yes, delete it!')}}'
}).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            type: "DELETE",
            url: url,
            success: function (response) {
                Swal.fire(
                    '{{trans('admin.Deleted!')}}',
                    '{{trans('admin.Item has been deleted.')}}',
                    '{{trans('admin.success')}}'
                )
                .then((result)=>{
                    location.reload()
                })
            }
        });
    }
})
});
</script>
