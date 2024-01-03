@section('script-bottom')
<script>

window.addEventListener('show-delete-confirmation',()=>{
    Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            @this.dispatch('deleteConfirmed');
        }
    })
});

window.addEventListener('show-delete-message',event=>{
    Swal.fire(
        'Deleted!',
        event.detail[0].message,
        'success'
    )
});

$('.startdate').change(function(e) {
    @this.set('start_date', $(this).val())
})
$('.end-date').change(function(e) {
    @this.set('end_date', $(this).val())
})
</script>
@endsection
