@extends('layouts.dashboard')

@section('header')
    Applications
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">people</i>
                    </div>
                    <div class="row justify-content-between">
                        <div>
                            <h4 class="card-title">Applications</h4>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="toolbar">

                    </div>
                    <div class="material-datatables">
                        <table id="application_table" cellspacing="0" class="table table-striped table-no-bordered table-hover"  width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>App ID</th>
                                    <th>Full Name</th>
                                    <th>Status</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th style="width:10%" class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>App ID</th>
                                    <th>Full Name</th>
                                    <th>Status</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th style="width:10%" class="text-right">Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($applications as $app)
                                    @if ($app['status'] == 2)
                                        @php
                                            $status = 'Pending';    
                                        @endphp
                                    @elseif($app['status'] == 3)
                                        @php
                                            $status = 'Verified';    
                                        @endphp
                                    @elseif($app['status'] == 4)
                                        @php
                                            $status = 'Waiting for Payment';    
                                        @endphp
                                    @elseif($app['status'] == 5)
                                        @php
                                            $status = 'Processing';    
                                        @endphp
                                    @elseif($app['status'] == 6)
                                        @php
                                            $status = 'Completed';    
                                        @endphp
                                    @elseif($app['status'] == 7)
                                        @php
                                            $status = 'Rejected';    
                                        @endphp
                                    @elseif($app['status'] == 1)
                                        @php
                                            $status = 'Draft';    
                                        @endphp
                                    @endif


                                    @if ($app['type'] == 1)
                                        @php
                                            $type = 'Business Permit';    
                                        @endphp
                                    @elseif($app['type'] == 2)
                                        @php
                                            $type = 'Cedula';    
                                        @endphp
                                    @else
                                        @php
                                            $type = 'Mayor\'s Permit';    
                                        @endphp
                                    @endif

                                <tr>
                                    <td style="font-weight: lighter !important;">{{ $app['app_id'] }}</td>
                                    <td style="font-weight: lighter !important;">{{ $app['user']['firstname'] . ' ' . $app['user']['lastname']}}</td>
                                    <td style="font-weight: lighter !important;">{{ $status }}</td>
                                    <td style="font-weight: lighter !important;">{{ $type }}</td>
                                    <td style="font-weight: lighter !important;">{{ date('m/d/Y', strtotime($app['created_at']))  }}</td>
                                    <td class="text-right">
                                        <a class="btn btn-link btn-warning btn-just-icon edit"
                                            href="{{ route('admin.view_application', $app['app_id']) }}"><i
                                                class="material-icons">dvr</i></a>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Filter</h4>
                </div>
                <div class="card-body">
                    <form action="">
                        <select name="permitType" id="permitType" class="selectpicker w-100" data-style="select-with-transition">
                            <option value="" selected>Permit Type</option>
                            <option value="1">Business Permit</option>
                            <option value="2">Cedula</option>
                            <option value="3">Mayor's Permit</option>
                        </select>
                        <br>
                        <br>
                        @if (Auth::user()->user_group_id != 5)
                            <select name="permitStatus" id="permitStatus" class="form-control selectpicker w-100" data-style="btn btn-link">
                                <option value="" selected>Status</option>
                                <option value="1">Draft</option>
                                <option value="2">Pending</option>
                                <option value="3">Verified</option>
                                <option value="4">Waiting for Payment</option>
                                <option value="5">Processing</option>
                                <option value="6">Completed</option>
                                <option value="7">Rejected</option>
                            </select>
                            <br>
                            <br>
                        @endif

                       
                        <select name="filterType" id="filterType" class="selectpicker w-100" data-style="select-with-transition">
                            <option value="" selected>Filter Type</option>
                            <option value="1">Application ID</option>
                            <option value="2">Name</option>
                        </select>
                        <br>
                        <br>
                        <input type="text" class="form-control" name="inputSearch" id="inputSearch"  placeholder="Search">
                        <br>


                        <div class="d-flex mb-3">
                            <div class="form-group">
                                <label class="label-control">From</label>
                                <input type="text" name="fromDate" id="fromDate" class="form-control datepicker" value="{{ date('m/d/Y',strtotime(date('m/d/y'). ' -1 day')) }}"/>
                            </div>
        
                            <div class="form-group">
                                <label class="label-control">To</label>
                                <input type="text" name="toDate" id="toDate" class="form-control datepicker" value="{{ date('m/d/Y') }}"/>
                            </div>
                        </div>
        
                        <div class="text-right">
                            <button id="btnSearch" data-url="{{ route('admin.applications.search') }}" name="btnSearch" type="button" class="btn btn-rose btn-round">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

<style>
    .custom-modal {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        z-index: 9999;
        background: rgba(0, 0, 0, 0.5);
        overflow: auto;
        padding: 24px 5%;
        display: none;
    }

    

    .closeBtn {
        position: absolute;
        top: 0;
        transform: translateY(-50%);
        right: 8px;
        z-index: 10000;
        padding: 8px;
        border: none;
        border-radius: 50px;
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.2);
    }

</style>

@section('scripts')
    <script>
        $(document).ready(e => {
            
            $('#application_table').dataTable( {
                "columnDefs": [
                    { "orderable": false, "targets": 5 }
                ],
                responsive: true,
                // "destroy": true,
            });
            $('.custom-modal').hide();
        });

        $('.closeBtn').click(function() {
            openApplicationModal();
        });

        var body = false;

        function openApplicationModal() {
            $('#applicationModal').fadeToggle(300);
            if (body == false) {
                $('body').css("overflow", "hidden");
                body = true;
            } else {
                $('body').css("overflow", "auto");
                body = false;
            }
        }

        md.initFormExtendedDatetimepickers();

        $('.edit').click(e => {
            openApplicationModal();
        });

        $('#btnNext').click(e => {
            $('#applicationModal').scroll();
            $("#applicationModal").animate({
                scrollTop: 0
            }, 300);
        });


        $('#is_enjoy_tax').change(() => {
            if ($('#is_enjoy_tax').is(':checked')) {
                $('#yes_enjoy_tax').show();
            }else{
                $('#yes_enjoy_tax').hide();
            }
        });
        $('#is_business_rented').change(() => {
            if ($('#is_business_rented').is(':checked')) {
                $('#lessor_info').show();
            }else{
                $('#lessor_info').hide();
            }
        });
        $('#is_business_rented').change(() => {
            if ($('#is_business_rented').is(':checked')) {
                $('#lessor_info').show();
            }else{
                $('#lessor_info').hide();
            }
        });

      var businessLimit = 0;

      $('#addBusinessActivity').click(function (){
        if (businessLimit < 7){
          var html = `
          <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Line of Business</label>
                                <input type="text" name="lineOfBusines[]" class="form-control" aria-required="true" aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
                
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Capitalization</label>
                                <input type="text" name="capitalization[]" class="form-control" aria-required="true" aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
        
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">No. Of Units</label>
                                <input type="text" name="noOfUnits[]" class="form-control" aria-required="true" aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
        `;
        $('#businessActivitiesList').append(html);

        businessLimit++;
        }
      });



      $('.remove').click(e => {
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
          Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          )
        }
      })
      });


      $('#btnSearch').click(function(){
            let token   = $('meta[name="csrf-token"]').attr('content');
            var fromdate = $('#fromDate').val();
            var todate = $('#toDate').val();
            var action = $(this).data('url');
            var permit_type = $('#permitType').val();
            var application_status = $('#permitStatus').val();
            var filter_type = $('#filterType').val();
            var searchInput = $('#inputSearch').val();

            if (filter_type != '') {
                if (searchInput == '') {
                    Swal.fire(
                        'Failed!',
                        'Search textbox is empty',
                        'error'
                    );
                    return;
                }
            }



            var data = {
                _token : token,
                type : permit_type,
                from_date : fromdate,
                to_date : todate,
                status : application_status,
                f_type : filter_type,
                search : searchInput
            };


            ajaxPost(action,data,searchResult);
      });


      function searchResult(result) {
        // console.log(result);return;
        if (result.status == true) {
            
            var tableData = '<tbody>';
            for (const [key,value] of Object.entries(result.applications)) {
                var date = new Date(value.created_at);
               

                let app_status = '';
                let type = '';
                if (value.status == 2) {
                    app_status = 'Pending';
                }else if(value.status == 3){
                    app_status = 'Verified';
                }else if(value.status == 4){
                    app_status = 'Waiting for Payment';
                }else if(value.status == 5){
                    app_status = 'Processing';
                }else if(value.status == 6){
                    app_status = 'Completed';
                }else if(value.status == 7){
                    app_status = 'Rejected';
                }else{
                    app_status = 'Draft';
                }
                

                if (value.type == 1) {
                    type = 'Business Permit';
                }else if(value.type == 2){
                    type = 'Cedula';
                }else{
                    type = 'Mayor\'s Permit';
                }


                tableData = tableData + '<tr>'+
                    '<td>'+value.app_id+'</td>'+
                    '<td>'+value.firstname+' '+value.lastname+'</td>'+
                    '<td>'+app_status+'</td>'+
                    '<td>'+type+'</td>'+
                    '<td>'+((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + date.getFullYear()+'</td>'+
                    '<td class="text-right">'+
                        '<a class="btn btn-link btn-warning btn-just-icon edit"'+
                           ' href="/admin/view-application/'+value.app_id+'"><i class="material-icons">dvr</i></a>'+
                    '</td>'+
                '</tr>'
                
            }   
            tableData = tableData + '</tbody>';           
            $('#application_table').DataTable().clear().destroy();
            $('#application_table tbody').replaceWith(tableData);
            $('#application_table').dataTable( {
                "columnDefs": [
                    { "orderable": false, "targets": 5 }
                ],
                responsive: true,
            });
        }else{
            Swal.fire(
                'Failed!',
                result.msg,
                'error'
            );
        }
      }

    </script>
@endsection
