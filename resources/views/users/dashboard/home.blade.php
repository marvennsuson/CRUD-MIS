@extends('layouts.users')

@section('header')
Dashboard
@endsection
@section('content')

<div class="d-flex flex-wrap" id="reverse">

  <div class="col-lg-4">
    {{-- Account Progress --}}
    <div class="card">
      <div class="card-body">
          <div class="d-flex align-items-center">
            <div>
              <div class="account-progress" data-percent="10" data-scale-color="#ffb400"><span>10%</span></div>
            </div>
            <div class="flex-grow-1 p-3">
              <h5>Great! Your account is almost complete!</h5>
              <div class="text-right"><a href="{{route('users.profile')}}" class="text-rose">Next Steps</a></div>
            </div>
          </div>
      </div>
    </div>

    <div class="card mb-0">
      <div class="card-header card-header-icon card-header-rose d-none d-sm-block">
        <div class="card-icon">
          <i class="material-icons">qr_code_2</i>
        </div>
        <h4 class="card-title">My Digital ID</h4>
      </div>
      <div class="card-body pt-4 pb-0">
          <div class="row">
            <div class="col-6 align-self-center">
              <div id="qrid"></div>
            </div>
            <div class="col-6">
              <h4 class="font-weight-bold d-block d-sm-none">My Digital ID</h4>
              <p class="">
                {{Auth::guard('resident')->user()->firstname . ' ' . Auth::guard('resident')->user()->lastname}}</p>
              <button id="qrid-btn" class="btn btn-rose btn-sm" data-toggle="modal"
                data-target="#qridModal">View</button>
            </div>
          </div>
          <br>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="card">
      <div class="card-header card-header-icon card-header-rose">
        <div class="card-icon">
          <i class="material-icons">fact_check</i>
        </div>
        <h4 class="card-title">Your Applications</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive material-datatables">
          <table class="table" id="applicationsTable">
            <thead>
              <tr>
                <th>Application ID</th>
                <th>Type</th>
                <th>Status</th>
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
                <td class="text-right"><a href="{{ route('users.view_application', $app['app_id']) }}"
                    class="btn btn-link btn-warning btn-just-icon edit" data-toggle="tooltip" data-placement="top"
                    title="Edit">
                    <i class="material-icons">
                      dvr
                    </i>
                  </a></td>
              </tr>

              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="qridModal" tabindex="-1" role="dialog" aria-labelledby="qridModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="qridModalLabel">Scan My QR Code</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="qrid2" width="100%">
          Loading <i class="fa fa-spinner fa-spin text-success" style="font-size:24px"></i>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Done</button>
      </div>
    </div>
  </div>
</div>



@endsection

@section('scripts')
<script>
  function reverseColumn(x) {
    if (x.matches) { // If media query matches
      $('#reverse').removeClass('flex-row-reverse');
      $('#reverse').addClass('flex-wrap');
    } else {
      $('#reverse').addClass('flex-row-reverse');
      $('#reverse').removeClass('flex-wrap');
    }
  }
  
  var x = window.matchMedia("(max-width: 768px)")
  reverseColumn(x) // Call listener function at run time
  x.addListener(reverseColumn) // Attach listener function on state changes
</script>


<script src="/js/easypiechart.js"></script>
<script>
  $('.account-progress').easyPieChart({
          barColor: '#4caf50',
          lineWidth: 12,
          scaleLength: 0,
          size: 75
  });
</script>


<script src="/qrcode/qrcode.js"></script>
<script type="text/javascript">
  $(document).ready(e => {
        $('#applicationsTable').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
            },
            scrollY: 300,
        });
    });


    // QR CODE 1

    var qrid_width = $("#qrid").width();
    var qrcode = new QRCode("qrid", {
        text: "{{Auth::guard('resident')->user()->email}}",
        width: qrid_width,
        height: qrid_width,
        colorDark : "#000000",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
    });

    $(window).resize(function(){
        qrid_width = $("#qrid").width();
        $('#qrid').html('');
        qrcode = new QRCode("qrid", {
            text: "{{Auth::guard('resident')->user()->email}}",
            width: qrid_width,
            height: qrid_width,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    });

    // QR Code 2

    var modalshown = false;

    $('#qrid-btn').click(function () {

      setTimeout(() => {
        $('#qrid2').html('');
        var qrid2_width = $("#qrid2").width();
        var qrcode = new QRCode("qrid2", {
            text: "{{Auth::guard('resident')->user()->email}}",
            width: qrid2_width,
            height: qrid2_width,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
      }, 1000);
      
    });

    $(window).resize(function() {
        if(modalshown == true){
          qrid2_width = $("#qrid2").width();
          $('#qrid2').html('');
          qrcode = new QRCode("qrid2", {
              text: "{{Auth::guard('resident')->user()->email}}",
              width: qrid2_width,
              height: qrid2_width,
              colorDark : "#000000",
              colorLight : "#ffffff",
              correctLevel : QRCode.CorrectLevel.H
          });
        }
    });

    
</script>

@if (Session::has('status'))
<script>
  $(document).ready(e => {
          $('.alert').alert();
          setTimeout(function () {
            md.showNotification('bottom', 'right', '{{Session::get('status')}}');
          }, 2000)
        });
</script>
@endif
@endsection