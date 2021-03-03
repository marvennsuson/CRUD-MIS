@extends('layouts.users')

@section('header')
To Pay
@endsection


@section('content')
@if ($data['applications'])
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header card-header-rose card-header-icon">
        <div class="card-icon">
          <i class="material-icons">assignment</i>
        </div>
        <h4 class="card-title">To Pay</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table" id="permitapplication">
            <thead>
              <tr>
                <th>Application ID</th>
                <th>Type</th>
                <th>Status</th>
                <th>Amount</th>
                <th>Date of payment</th>
                <th class="text-right">Actions</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($data['applications'] as $app)
  
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
                
              @elseif ($app['status'] == 2)
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
                <td>{{ $type }}</td>
                <td>{{ $status }}</td>
                <td>₱&nbsp;{{ number_format($app['amount']) }}.00</td>
                <td>{{ (!empty($app['dateofPay'])) ? date('M d, Y  ', strtotime( $app['dateofPay']))  : '' }}</td>
                <td class="text-right"> @if ($app['status'] === 5)
                  <button disabled class="btn btn-info">Processing</button>
                      
                @elseif($app['status'] === 6)
                <button disabled class="btn btn-success">Completed</button>
                @else
                <a href="{{ route('users.permits.payment-gateway', $app['app_id']) }}">
                  <button class="btn btn-primary">Pay Now</button>
                </a>
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
      There's nothing to Pay for.
    </div>
  </div>
</div>

@endif




@endsection





@section('scripts')
<script>
  
  $(function () {
    $('#permitapplication').dataTable( {
                "autoWidth": false,
                "columnDefs": [
                    { "orderable": false, "targets": 1 }
                ],
                responsive: true,
            });
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

@endsection