@extends('layouts.dashboard')

{{-- @section('header')
To Pay
@endsection --}}


@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@if ($transactions)
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header card-header-rose card-header-icon">
        <div class="card-icon">
          <i class="material-icons">assignment</i>
        </div>
        <h4 class="card-title">Transactions</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table" id="transactionTable">
            <thead>
              <tr>
                <th>Application ID</th>
                <th>Full Name</th>
                <th>Type</th>
                <th>Status</th>
                <th>Amount</th>
                <th>Mode of Payment</th>
                <th>Date</th>
                <th class="text-right">Actions</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($transactions as $app)
  
              @if ($app['status'] == 1)
                  @php
                    $status = 'Draft';
                  @endphp
              @elseif ($app['status'] == 2)
                @php
                  $status = 'Pending';
                @endphp

              @elseif ($app['status'] == 3)
                @php
                  $status = 'Verified';
                @endphp
              @elseif ($app['status'] == 4)
                @php
                  $status = 'Waiting for payment';
                @endphp

              @elseif ($app['status'] == 5)
                @php
                  $status = 'Processing';
                @endphp
              @elseif ($app['status'] == 6)
                @php
                  $status = 'Completed';
                @endphp
              @else
                @php
                    $status = 'Rejected';
                @endphp
              @endif

              @if ($app['type'] == 1)
                  @php
                    $type = 'Business Permit';
                  @endphp
                
              @elseif ($app['type'] == 2)
                  @php
                    $type = 'Cedula';
                  @endphp
                
              @else
                  @php
                    $type = 'Mayor\'s Permit';
                  @endphp
                
              @endif

              <tr>
                <td>{{ $app['app_id'] }}</td>
                <td>{{ $app['user']['firstname'] ." ". $app['user']['lastname'] }}</td>
                <td>{{ $type }}</td>
                <td>{{ $status }}</td>
                <td>&#8369; {{$app['amount'] != null ? number_format($app['amount'],2): "0.00"}}</td>
                <td>{{ $app['paymentType'] }}</td>
                <td>{{ date('m/d/Y H:i:s', strtotime($app['dateofPay']))}}</td>
                <td class="text-right">
                  @if ($app['status'] > 5)
                    <label for="" class="text-success">Completed</label>
                  @else
                    <button type="button" class="btn btn-success btn-sm confirm" data-url="{{ route('admin.transactions.complete') }}" data-appid = "{{ $app['app_id'] }}" >Complete Payment</button>
                  @endif
                  
                </td>
              </tr>
              
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@else
<div class="empty">
  <div class="card">
    <div class="card-header card-header-text card-header-primary">
      <div class="card-text">
        <h4 class="card-title">Oops!</h4>
      </div>
    </div>
    <div class="card-body">
      There's no Transaction yet! 
    </div>
  </div>
</div>

@endif


<div id="preloader" style="z-index: 99999; display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100vh; background: rgba(255,255,255, 0.5);">
  <div class="preloader-body" style="text-align: center; position: absolute; width: 100%; top: 50%; transform: translateY(-50%)">
      <img src="/img/logo.png" alt="" width="150px">
      <h3 class="text-center">{{config('app.name', 'LGU MIS')}} <i class="fa fa-spinner fa-spin text-success" style="font-size:24px"></i></h3>
  </div>
</div>

@endsection





@section('scripts')
<script>
     $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    $(document).ready(e => {

      $('#transactionTable').DataTable({
          "pagingType": "full_numbers",
          "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
          ],
          responsive: true,
          language: {
          search: "_INPUT_",
          searchPlaceholder: "Search records",
          destroy:true
          }
          
      });
     
    });
    $(document).on("click",".confirm",function() {
      let token   = $('meta[name="csrf-token"]').attr('content');
      var app_id = $(this).data('appid');
      var action = $(this).data('url');
      var data = {
        _token : token,
        id : app_id,
      };
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, confirm it!'
      }).then((result) => {
        console.log(result);
        if (result.value == true) {
          $('#preloader').fadeIn()
          ajaxPost(action,data,postResponse);
        }else{
          return false;
        }
      })

      

    });


    function postResponse(result) {
      $('#preloader').fadeOut();

      if(result.status == false){
        Swal.fire(
            'Failed!',
            result.msg,
            'error'
        );
        return false;
      }else{
        Swal.fire(
            'Success!',
            result.msg,
            'success'
        ).then((result) => {
            location.reload();
        });
      }
    }



    
</script>

@endsection