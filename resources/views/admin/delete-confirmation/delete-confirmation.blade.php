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

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition,showError);
  } else { 
    alert("Geolocation is not supported by this browser.");
  }
}

function showPosition(position) {
    @this.dispatch('latitude-longitude',{latitude:position.coords.latitude, longitude:position.coords.longitude}) ;
    // @this.set('latitude',);
    // @this.set('longitude',position.coords.longitude);  
}

$(document).ready(function(){
    getLocation();

});

function showError(error) {
  switch(error.code) {
    case error.PERMISSION_DENIED:
      alert("User denied the request for Geolocation.")
      break;
    case error.POSITION_UNAVAILABLE:
      alert("Location information is unavailable.")
      break;
    case error.TIMEOUT:
      alert("The request to get user location timed out.")
      break;
    case error.UNKNOWN_ERROR:
      alert("An unknown error occurred.")
      break;
  }
}
</script>
@endsection
