@extends('layouts.dashboard')
@section('header')
    Residents
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
                        <h4 class="card-title">Residents List</h4>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="toolbar">

                </div>
                <div class="material-datatables">
                        <table id="user_table" class="table table-striped table-no-bordered table-hover" cellspacing="0"  width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>User Group</th>
                                    <th>User Level</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>User Group</th>
                                    <th>User Level</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </tfoot>
                            <tbody id="Recordlist">

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
                <form method="POST" id="filterform" >
                  @csrf
                    <div class="form-group w-100">
                      <select name="filter" id="filter" class="selectpicker" data-style="select-with-transition">
                          <option value="0" selected>Filter Type</option>
                          <option  value="name">Name</option>
                          <option value="email">Email</option>
                          <option value="date">Date Created</option>
                      </select>
                    </div>
                    <div class="form-group bmd-form-group mb-3">
                        <label for="name" class="bmd-label-floating">Search</label>
                        <input type="text" class="form-control" id="name" name="textname">
                    </div>

                    <div class="d-flex mb-3">
                        <div class="form-group">
                            <label class="label-control">From</label>
                            <input type="text" class="form-control datetimepicker" name="textdatefrom"/>
                        </div>

                        <div class="form-group">
                            <label class="label-control">To</label>
                            <input type="text" class="form-control datetimepicker" name="textdateto"/>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-rose btn-round">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="user_add_modal" role="dialog">
    <div class="modal-dialog modal-lg-xl "  >
        <div class="wizard-container ">
            <div class="card card-wizard modal-content" data-color="rose" id="wizardProfile">
              <form enctype="multipart/form-data" class="form" id="form_user_add" data-url="{{route('user.resident.add')}}" novalidate>
                <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                <div class="card-header text-center">
                  <h3 class="card-title">
                    Build Your Profile
                  </h3>
                  <h5 class="card-description">This information will let us know more about you.</h5>
                </div>
                <div class="wizard-navigation">
                  <ul class="nav nav-pills">
                    <li class="nav-item">
                      <a class="nav-link active" href="#about" id="abouttabs" data-toggle="tab" role="tab">
                        About
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#account" id="accounttabs" data-toggle="tab" role="tab">
                        Account
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#address" id="addresstabs" data-toggle="tab" role="tab">
                        Address
                      </a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="about">
                      <h5 class="info-text"> Let's start with the basic information (with validation)</h5>
                      <div class="row justify-content-center">
                        <div class="col-sm-4">
                          <div class="picture-container">
                            <div class="picture">
                              <img src="/img/default-avatar.png" class="picture-src" id="wizardPicturePreview" title="" />
                              <input type="file" id="wizard-picture" name="Profileimage"  accept="image/*">
                            </div>
                            <h6 class="description">Choose Picture</h6>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="input-group form-control-lg">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="material-icons">face</i>
                              </span>
                            </div>
                            <div class="form-group">
                              <label for="firstName" class="bmd-label-floating">First Name (required)</label>
                              <input type="text" class="form-control" id="firstName" name="firstName" required>
                              {{-- <label id="firstName-error" class="error" for="firstName" style="display:none">This field is required.</label> --}}
                            </div>
                          </div>
                          <div class="input-group form-control-lg">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="material-icons">record_voice_over</i>
                              </span>
                            </div>
                            <div class="form-group">
                              <label for="lastName" class="bmd-label-floating">Last Name</label>
                              <input type="text" class="form-control" id="lastName" name="lastName" required>
                              {{-- <label id="lastName-error" class="error" for="lastName" style="display:none">This field is required.</label> --}}
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-10 mt-3">
                          <div class="input-group form-control-lg">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="material-icons">email</i>
                              </span>
                            </div>
                            <div class="form-group">
                              <label for="email" class="bmd-label-floating">Email (required)</label>
                              <input type="email" class="form-control" id="email" name="email" email="true" required>
                              {{-- <label id="email-error" class="error" for="email" style="display:none">This field is required.</label> --}}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="account">
                      {{-- <h5 class="info-text"> What are you doing? (checkboxes) </h5> --}}
                      <div class="row justify-content-center">
                                <div class="col-lg-10">
                                                  <div class="row">
                                          <div class="col-lg-12">
                                            <div class="input-group form-control-lg">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                  <i class="material-icons">password</i>
                                                </span>
                                              </div>
                                              <div class="form-group">
                                                <label for="custompassword" class="bmd-label-floating">password</label>
                                                <input type="password" class="form-control" id="custompassword" name="custompassword" required>
                                                {{-- <label id="custompassword-error" class="error" for="custompassword" style="display:none">This field is required.</label> --}}
                                              </div>
                                            </div>
                                          </div>
                                                  </div>
                                              <div class="row">
                                                    <div class="col-lg-12">
                                                      <div class="input-group form-control-lg">
                                                        <div class="input-group-prepend">
                                                          <span class="input-group-text">
                                                            <i class="material-icons">password</i>
                                                          </span>
                                                        </div>
                                                        <div class="form-group">
                                                          <label for="Customconfirmpassword" class="bmd-label-floating">Confirm password</label>
                                                          <input type="password" class="form-control" equalTo="#custompassword" id="Customconfirmpassword" name="Customconfirmpassword" required>
                                                          {{-- <label id="Customconfirmpassword-error" class="error" for="Customconfirmpassword" style="display:none">This field is required or Not the same.</label> --}}
                                                        </div>
                                                      </div>
                                                    </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-lg-12">
                                                  <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                                      <span class="input-group-text">
                                                        <i class="material-icons">trending_up</i>
                                                      </span>
                                                    </div>
                                                    <div class="form-group">
                                                      <label for="Customstatus" class="bmd-label-floating">Active</label>
                                                      <select class="selectpicker form-control" title="Choose Here"  name="Customstatus" id="Customstatus" data-style="btn btn-link">
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                    {{-- <label id="Customstatus-error" class="error" for="Customstatus" style="display:none">This field is required.</label> --}}
                                                    </div>
                                                  </div>
                                                </div>
                                          </div>
                               


                                </div>
                    
                      </div>
                    </div>
                    <div class="tab-pane" id="address">
                      <div class="row justify-content-center">
                        <div class="col-sm-12">
                          <h5 class="info-text"> Are you living in a nice area? </h5>
                        </div>
                        <div class="col-sm-7">
                          <div class="form-group">
                            <label for="streetname" class="bmd-label-floating">Street Name</label>
                            <input type="text" class="form-control" name="streetname" id="streetname">
                            {{-- <label id="streetname-error" class="error" for="streetname" style="display:none">This field is required.</label> --}}
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label for="houseno" class="bmd-label-floating">house No.</label>
                            <input type="text" class="form-control" name="houseno" id="houseno">
                            {{-- <label id="houseno-error" class="error" for="houseno" style="display:none">This field is required.</label> --}}
                          </div>
                        </div>
           
                      </div>
                      <div class="row justify-content-center">

                        <div class="col-sm-5">
                          <div class="form-group">
                            <label for="city" class="bmd-label-floating">City</label>
                            <input type="text" class="form-control" id="city" name="city">
                            {{-- <label id="city-error" class="error" for="city" style="display:none">This field is required.</label> --}}
                          </div>
                        </div>
                        <div class="col-sm-5">
                          <div class="form-group">
                            <label for="barangay" class="bmd-label-floating">Barangay</label>
                            <input type="text" class="form-control" id="barangay" name="barangay">
                            {{-- <label id="barangay-error" class="error" for="barangay" style="display:none">This field is required.</label> --}}
                          </div>
                        </div>

                      </div>
                      <div class="row justify-content-center">

                        <div class="col-sm-5">
                          <div class="form-group">
                            <label for="province" class="bmd-label-floating">Province</label>
                            <input type="text" class="form-control" id="province" name="province">
                            {{-- <label id="province-error" class="error" for="province" style="display:none">This field is required.</label> --}}
                          </div>
                        </div>
                        <div class="col-sm-5">
                          <div class="form-group">
                            <label for="postalcode" class="bmd-label-floating">Postal Code</label>
                            <input type="text" class="form-control" id="postalcode" name="postalcode">
                            {{-- <label id="postalcode-error" class="error" for="postalcode" style="display:none">This field is required.</label> --}}
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="mr-auto">
                    <input type="button" class="btn btn-previous btn-fill btn-default btn-wd disabled" name="previous" id="prevs" value="Previous">
                  </div>
                  <div class="ml-auto">
                    <input type="button" id="oblack"class="btn btn-next btn-fill btn-rose btn-wd" name="next" value="Next">
                    <input type="submit" class="btn btn-finish btn-fill btn-rose btn-wd"  value="Finish" style="display: none;">
                  </div>
                  <div class="clearfix"></div>
                </div>
              </form>
            </div>
          </div>
    </div>
</div>


{{-- Floating --}}
<div class="floating-button" data-toggle="tooltip" data-placement="left" title="Create a user.">
    <button class="btn btn-rose btn-round p-3 shadow modalput"  id="btn_add_users" >
        <i class="material-icons">person_add_alt_1</i>
    </button>
</div>

<style>
    .floating-button{
        position: fixed;
        bottom: 5%;
        right: 16px;
    }
</style>

@endsection
@section('scripts')
  <script>
      $(document).ready( function () {
        var table =  $('#user_table').dataTable();
        $( "#abouttabs" ).click(function() {
            $( "#prevs" ).click();
});
$( "#accounttabs" ).click(function() {
            $( "#prevs" ).click();
});
        $('#form_user_add').validate({
                rules: {
                  firstName:{required: true,},
                  lastName:{required: true,},
                  email:{required: true,},
                  custompassword:{required: true,},
                  Customconfirmpassword:{required: true,},
                  streetname:{required: true,},
                  houseno:{required: true,},
                  city:{required: true,},
                  barangay:{required: true,},
                  province:{required: true,},
                  postalcode:{required: true,},
                  Customstatus:{required: true,},
                },

                highlight: function(element) {
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
                },
                success: function(element) {
                    $(element).closest('.form-group').find('.error').addClass('d-none');
                    $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
                },
                errorPlacement: function(error, element) {
                    console.log(error);
                    $(element).append(error);
                }
            });

            $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

  $("#form_user_add").submit(function(e){
                  e.preventDefault();
                var $valid = $('#form_user_add').valid();
                var action  = $('#form_user_add').data('url');
                  var formData = new FormData($(this)[0]);
                  if (!$valid) {
              
                      return false;
                  }
                  $.ajax({
                      url : action,
                      type : "POST",
                      data : formData,
                      async:false,
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
                                location.reload();
                            });
                        }
                      },
                      cache: false,
                      contentType: false,
                      processData: false
                  });
              });


          $(document).on('click', "button.remove", function () {
              var userid = $(this).data('userid');
              var action = "{{ route('user.resident.delete') }}";
              let token   = $('meta[name="csrf-token"]').attr('content');

              var data = {
                  _token : token,
                  id: userid
              };

              if (userid) {
                  Swal.fire({
                      title: 'Are you sure?',
                      text: "You won't be able to revert this!",
                      type: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {
                      if (result.value) {
                          var editUser = ajaxPost(action,data, deleteStatus);
                      }
                  })
              }

          });

          function deleteStatus(result) {
              if(result.status == false){
                  Swal.fire(
                      'Failed!',
                      result.msg,
                      'error'
                  ).then((result) => {
                      location.reload();
                  });
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


      });

      $('.datetimepicker').datetimepicker({
          format: 'YYYY-MM-DD',
          icons: {
              time: "fa fa-clock-o",
              date: "fa fa-calendar",
              up: "fa fa-chevron-up",
              down: "fa fa-chevron-down",
              previous: 'fa fa-chevron-left',
              next: 'fa fa-chevron-right',
              today: 'fa fa-screenshot',
              clear: 'fa fa-trash',
              close: 'fa fa-remove'
          }
      });

      $(document).ready(function() {
      demo.initMaterialWizard();
      setTimeout(function() {
        $('.card.card-wizard').addClass('active');
      }, 500);


    });
  </script>



<script type="text/javascript">
  $( "#btn_add_users" ).click(function() {
     
    var screensize = document.documentElement.clientWidth;
if (screensize  < 580) {
  $('#user_add_modal').find('.moving-tab').css('width', '130');
        
        $('.moving-tab').css({
          'transform': 'translate3d( 0px, 0px, 0)',
          'transition': 'all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1)'
   
        });
        
}
else {
  $('#user_add_modal').find('.moving-tab').css('width', '350');
        
        $('.moving-tab').css({
          'transform': 'translate3d( 0px, 0px, 0)',
          'transition': 'all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1)'
   
        });
    
}

   $('#user_add_modal').modal({show:true})


});
 $(document).ready(function () {
      $.ajaxSetup({
  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
  });
      $("#user_table").dataTable({
        "columnDefs": [{
          "orderable": false,
          "targets": 0
              }],
              "autoWidth": false,
              ajax: "{{ route('user.resident.generated') }}",
              lengthMenu: [10, 25, 50, 100],
              columns: [
                          { data: 0 },
                          { data: 1 },
                          { data: 2 },
                          { data: 3 },
                          { data: 4 },
                      ],
                  orderable: true,
                  searchable: true,
                  deferRender: true,
                  info: true,
                  stateSave: true,
                  clear:true,
                  destroy: true,
                  responsive: true,
      });
      });

   $(document).ready(function () {
      $.ajaxSetup({
 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
 });

 $("#filterform").submit(function(e){
                 e.preventDefault();
                    var fa = $(this);
                    var formData = new FormData($(this)[0]);
                 $.ajax({
                     url : "{{ route('user.resident.GetFiltered') }}",
                     header: $('meta[name="csrf-token"]').attr('content'),
                     type : "POST",
                     data: fa.serialize(),
                     dataType: 'json',
                     async:false,
                     success:function(response){
                       var datatable = $('#user_table').DataTable();
                      datatable.clear().draw();
                      datatable.rows.add(response.data);
                      datatable.columns.adjust().draw();
                     }
                 });
                 return false;
             });

       });


 </script>
@endsection
