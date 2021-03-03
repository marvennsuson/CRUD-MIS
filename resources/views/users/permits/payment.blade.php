@extends('layouts.users')

@section('header')
Payment Gateway
@endsection


@section('content')
<h2 class="text-center">Payment Gateway</h2>
<form method="POST" id="formsubmitpayment">
@csrf
    @foreach ($data['ApplicationInfo'] as $paymentinfo)
    <input type="hidden" id="appid" value="{{ $paymentinfo['app_id'] }}">
    <input type="hidden" id="amountid" value="{{ $paymentinfo['amount'] }}">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="container-fluid">
                        <h4 class="font-weight-bold">Payment Options</h4>
    
                        <ul class="nav nav-pills nav-pills-primary tabcontent"  role="tablist">
                            <li class="nav-item idol ">
                                <a class="nav-link active" id="gcashtabs" data-toggle="tab" data-tabs="gcash" href="#link1" role="tablist" 
                                    aria-expanded="true">
                                    GCash
                                </a>
                            </li>
                            <li class="nav-item idol">
                                <a class="nav-link" data-toggle="tab"   id="paymayatabs" href="#link2" data-tabs="paymaya" role="tablist"
                                    aria-expanded="false">
                                    Paymaya
                                </a>
                            </li>
                            <li class="nav-item idol">
                                <a class="nav-link" data-toggle="tab" id="coinphtabs" href="#link3" data-tabs="coinph" role="tablist"
                                    aria-expanded="false">
                                    Coins.ph
                                </a>
                            </li>
                            <li class="nav-item idol">
                                <a class="nav-link" data-toggle="tab" id="bpitabs" href="#link4" data-tabs="bpi" role="tablist"
                                    aria-expanded="false">
                                    BPI
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content tab-space">
                            <div class="tab-pane active" id="link1" aria-expanded="true">
                                <div class="text-center">
                                    <img src="/img/gcash.webp" alt="" height="100px" style="border-radius: 8px;">
                                    <br>
                                    <br>
                                    <h4>Send your payment to this account</h4>
                                    <br>
                                    <p>Account  Number: 09277578983</p>
                                    <p class="text-warning font-weight-bold">
                                        Please enter the code below to the 'Message' textbox shown in your GCash app
                                    </p>
    
                                    <h2 class="font-weight-bold">{{ $paymentinfo['app_id'] }}</h2>
                                    <br>
                                </div>
                            </div>
                            <div class="tab-pane" id="link2" aria-expanded="false">
                                <div class="text-center">
                                    <img src="/img/paymaya.webp" alt="" height="100px" style="border-radius: 8px;">
                                </div>
                                <div class="text-center">
                                    <h4>Scan to Pay</h4>
                                    <img src="/img/paymayaqr.png" alt="" height="200px">
                                    <br>
                                    <br>
                                    <p>or</p>                                  
                                    <h4>Send your payment to this account</h4>
                                    <p>Account  Number: 0925 507 8983</p>
                                    <p class="text-warning font-weight-bold">
                                        Enter the code below to your Optional Message textbox in Paymaya
                                    </p>
    
                                    <h2 class="font-weight-bold">{{ $paymentinfo['app_id'] }}</h2>
                                    <br>
                                </div>
                            </div>
                            <div class="tab-pane" id="link3" aria-expanded="false">
                                <div class="text-center">
                                    <img src="/img/coinsph.png" alt="" height="100px" style="border-radius: 8px;">
                                </div>
                                <div class="text-center">
                                    <h4>Scan to Pay</h4>
                                    <img src="/img/coinsphqr.png" alt="" height="200px">
                                    <br>
                                    <br>
                                    <p class="text-warning font-weight-bold">
                                        Enter the code below to your Optional Message textbox in Coins.phya
                                    </p>
    
                                    <h2 class="font-weight-bold">{{ $paymentinfo['app_id'] }}</h2>
                                    <br>
                                </div>
                            </div>
                            <div class="tab-pane" id="link4" aria-expanded="false">
                                <div class="text-center">
                                    <img src="/img/bpi.jpg" alt="" height="100px" style="border-radius: 8px;">
                                </div>
                                <br>
                                <br>
                                <div class="text-center">
                                    <h4>Scan to Pay</h4>
                                    <img src="/img/bpiqr.png" alt="" height="200px">
                                    <br>
                                    <br>
                                    <p class="text-warning font-weight-bold">
                                        Enter the code below to your Optional Message textbox in BPI.
                                    </p>
    
                                    <h2 class="font-weight-bold">{{ $paymentinfo['app_id'] }}</h2>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                        
                        <div class="container-fluid">
                            <h4 class="font-weight-bold">Amount to pay</h4>
                            <div class="d-flex justify-content-between ">
                                <h3>PHP</h3>
                                <h3 class="font-weight-bold mr-5">₱&nbsp;{{ $paymentinfo['amount'] }}</h3>
                            </div>
                            <p>Press done if you have finished paying from your desired payment option.</p>
                            <button type="submit"  class="btn btn-primary w-100">DONE</button>
                            <br>
                            <br>
                            <p class="text-center font-italic">Note: Your payment will be processed and you will be notified in your account.</p> 
                        </div>
                       
                </div>
            </div>
        </div>
    </div>

    @endforeach
</form>

@endsection

@section('scripts')

<script type="text/javascript">

    $(document).ready(function () {
          md.initFormExtendedDatetimepickers();
//        $.ajaxSetup({
//   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
//   });

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    // here is the new selected tab id
    var selectedTabId = e.target.id;
});
var currentab = 0;
    var name = 'Gcash';

    $('.idol').click(function (e){
        currentab = $(this).index();
        name = $.trim($('.idol:eq('+currentab+')').text());
    });

  $("#formsubmitpayment").submit(function(e){
                  e.preventDefault();

            //  var active = $( "#gcashtabs" ).tabs( "option", "active" );

                var appid = $('#appid').val();
                var amount = $('#amountid').val();
                  $.ajax({
                      
                      url : "{{ route('users.paymentTransaction') }}",
                      type : "POST",
                      data : {"_token": "{{ csrf_token() }}", paymentMethod:name, appid:appid ,amount:amount },
                    
                      success : function(response){
                        if(response.status == false){
                          var values = '';
                            jQuery.each(response.msg, function (key, value) {
                                values += value
                            });
                            Swal.fire(
                                'Failed!',
                                values,
                                'error'
                            ).then((result) => {
                                // location.reload();
                            });

                        }else{
                            Swal.fire(
                                'Success!',
                                response.msg,
                                'success'
                            ).then((result) => {
                            window.location.href='{{ route("users.permits.topay") }}';
                            });
                        }
                      },
                    //   cache: false,
                    //   contentType: false,
                    //   processData: false
                   
                  });
                 
              })

        });


  </script>
@endsection