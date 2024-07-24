@section('script-bottom')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        window.addEventListener('razorpay-modal', event => {
           console.log();
            var options = {
                "key": "{{env('RAZORPAY_KEY')}}",
                "amount":  event.detail[0].amount,
                "currency": "INR",
                "name": "GROSCOPE TECHNOLOGY PRIVATE LIMITED",
                // "image": "YOUR COMPANY IMAGE",
                "order_id": event.detail[0].order_id,
                "handler": function(response) {
                    @this.dispatch('updateRequest', {
                        response:response,
                    })
                },
                "prefill":{
                    'contact':"{{auth()->user()->mobile_no}}",
                    'email':"{{auth()->user()->email}}",
                },
                "theme": {
                    "color": "#5b73e8"
                }
            };
            options.handler = function(response) {
                @this.dispatch('updateRequest', {
                    response:response,
                });
            };
            options.theme.image_padding = false;
            options.modal = {
                ondismiss: function(response) {
                    @this.dispatch('updateRequest', {
                        response:{razorpay_order_id:options.order_id},
                    });
                },
                escape: true,
                backdropclose: false
            };
            var rzp1 = new Razorpay(options);
            rzp1.on('payment.failed', function(response) {
                @this.dispatch('updateRequest', {
                        response:response,
                    });
            });
            rzp1.open(); 
        });

    </script>
@endsection