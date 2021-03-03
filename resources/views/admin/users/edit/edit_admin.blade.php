
@extends('layouts.dashboard')
@section('header')
Profile
@endsection
@section('content')
<div class="content">
    <div class="container-fluid">
      <form  enctype="multipart/form-data" id="Updateprofile" method="POST" role="form">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-header-icon card-header-rose">
              <div class="card-icon">
                <i class="material-icons">perm_identity</i>
              </div>
              <h4 class="card-title">Edit Admin Information -
                <small class="category">Complete your Information</small>
              </h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  @if ($errors->has('firstname')) <p class="text-danger">{{ $errors->first('firstname')}}</p> @endif
                  <div class="form-group @error('firstname') has-danger @enderror">
                    <label class="bmd-label-floating">Fist Name</label>
                    <input type="text" class="form-control" name="firstname" value="{{ old('firstname') ?? $user['firstname'] }}">
                  </div>
                </div>
                <div class="col-md-4">
                  @if ($errors->has('middlename')) <p class="text-danger">{{ $errors->first('middlename')}}</p> @endif
                  <div class="form-group @error('middlename') has-danger @enderror">
                    <label class="bmd-label-floating">Middle Name</label>
                    <input type="text" class="form-control" name="middlename" value="{{ old('middlename') ?? $user['middlename'] }}">
                  </div>
                </div>
                <div class="col-md-4">
                  @if ($errors->has('lastname')) <p class="text-danger">{{ $errors->first('lastname')}}</p> @endif
                  <div class="form-group @error('lastname') has-danger @enderror">
                    <label class="bmd-label-floating">Last Name</label>
                    <input type="text" class="form-control" name="lastname" value="{{ old('lastname') ?? $user['lastname'] }}">
                  </div>
                </div>
                {{-- <div class="col-md-3">
                  @if ($errors->has('exname')) <p class="text-danger">{{ $errors->first('exname')}}</p> @endif
                  <div class="form-group @error('exname') has-danger @enderror">
                    <label class="bmd-label-floating">Suffix (optional):</label>
                    <input type="text" class="form-control" name="exname" value="{{ old('exname')  ?? $user['exname']  }}">
                  </div>
                </div> --}}
              </div>
                <div class="row">
                  {{-- <div class="col-md-6">
                    @if ($errors->has('username')) <p class="text-danger">{{ $errors->first('username')}}</p> @endif
                    <div class="form-group  @error('username') has-danger @enderror">

                      <label class="bmd-label-floating">Username</label>
                      <input type="text" class="form-control" name="username" value="{{ old('username') ??  $user['username'] }}">
                    </div>
                  </div> --}}
                  <div class="col-md-8">
                    @if ($errors->has('email')) <p class="text-danger">{{ $errors->first('email')}}</p> @endif
                    <div class="form-group  @error('email') has-danger @enderror">
                      <label class="bmd-label-floating">Email address</label>
                      <input type="email" class="form-control" name="email" value="{{ old('email') ?? $user['email']}}">
                      <label id="email_error" class="error" for="email" style="display:none"></label>
                    </div>
                  </div>
                  <div class="col-md-4">
                    @if ($errors->has('mobile')) <p class="text-danger">{{ $errors->first('mobile')}}</p> @endif
                    <div class="form-group @error('address') has-danger @enderror">
                      <label class="bmd-label-floating">Mobile Number</label>
                      <input type="text" class="form-control" name="mobile" value="{{ old('mobile') ?? $user['mobile'] }}">
                    </div>

                  </div>

                </div>
                <div class="row">
                      <div class="col-md-4">
                        @if ($errors->has('gender')) <p class="text-danger">{{ $errors->first('gender')}}</p> @endif
                        <div class="form-group @error('gender') has-danger @enderror">
                          <select class="selectpicker w-100" name="gender" data-style="select-with-transition">
                            <option value="n/a" selected>Choose Gender</option>
                            <option value="Male" {{ $user['gender'] == "Male" ? "selected" : ''  }}>Male</option>
                            <option value="Female" {{ $user['gender'] == "Female" ? "selected" : ''  }}>Female</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        @if ($errors->has('age')) <p class="text-danger">{{ $errors->first('age')}}</p> @endif
                        <div class="form-group @error('age') has-danger @enderror">
                          <label class="bmd-label-floating">Age</label>
                          <input type="text" class="form-control" name="age" value="{{ old('age') ?? $user['age'] }}">
                        </div>
                      </div>
                      <div class="col-md-4">
                        @if ($errors->has('dob')) <p class="text-danger">{{ $errors->first('dob')}}</p> @endif
                        <div class="form-group @error('dob') has-danger @enderror">
                          <label class="bmd-label-floating">Date Of birth</label>
                          <input type="text" class="form-control datepicker" name="dob" value="{{ old('dob') ?? $user['dob'] }}">

                        </div>
                      </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    @if ($errors->has('address')) <p class="text-danger">{{ $errors->first('address')}}</p> @endif
                    <div class="form-group @error('address') has-danger @enderror">
                      <label class="bmd-label-floating">Address</label>
                      <input type="text" class="form-control" name="address" value="{{ old('address') ?? $user['address'] }}">
                    </div>
                  </div>
                  <div class="col-md-4">
                    @if ($errors->has('postalcode')) <p class="text-danger">{{ $errors->first('postalcode')}}</p> @endif
                    <div class="form-group @error('postalcode') has-danger @enderror">
                      <label class="bmd-label-floating">Postal Code</label>
                      <input type="text" class="form-control" name="postalcode" value="{{ old('postalcode') ?? $user['postalcode'] }}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    @if ($errors->has('province')) <p class="text-danger">{{ $errors->first('province')}}</p> @endif
                    <div class="form-group @error('province') has-danger @enderror">
                      <label class="bmd-label-floating">Province</label>
                      <input type="text" class="form-control" name="province"  value="{{ old('province') ?? $user['province'] }}">
                    </div>
                  </div>
                  <div class="col-md-4">
                    @if ($errors->has('city')) <p class="text-danger">{{ $errors->first('city')}}</p> @endif
                    <div class="form-group @error('city') has-danger @enderror">
                      <label class="bmd-label-floating">City</label>
                      <input type="text" class="form-control" name="city" value="{{ old('city') ?? $user['city'] }}">
                    </div>
                  </div>
                  <div class="col-md-4">
                    @if ($errors->has('barangay')) <p class="text-danger">{{ $errors->first('barangay')}}</p> @endif
                    <div class="form-group @error('barangay') has-danger @enderror">
                      <label class="bmd-label-floating">Barangay</label>
                      <input type="text" class="form-control" name="barangay" value="{{ old('barangay') ?? $user['barangay'] }}">
                    </div>
                  </div>


                </div>
                {{-- <div class="row">

                  <div class="col-md-4">
                    @if ($errors->has('housenumber')) <p class="text-danger">{{ $errors->first('housenumber')}}</p> @endif
                    <div class="form-group @error('housenumber') has-danger @enderror">
                      <label class="bmd-label-floating">House#/bld#/blk</label>
                      <input type="text" class="form-control" name="housenumber" value="{{ old('housenumber') ?? $user['housenumber'] }}">
                    </div>
                  </div>
                  <div class="col-md-4">
                    @if ($errors->has('streetname')) <p class="text-danger">{{ $errors->first('streetname')}}</p> @endif
                    <div class="form-group @error('streetname') has-danger @enderror">
                      <label class="bmd-label-floating">Street/Avenue</label>
                      <input type="text" class="form-control" name="streetname" value="{{ old('streetname') ?? $user['streetname'] }}">
                    </div>
                  </div>
                </div> --}}

                <div class="row">
                  <div class="col-md-6">
                    @if ($errors->has('usergroups')) <p class="text-danger">{{ $errors->first('usergroups')}}</p> @endif
                    <div class="form-group @error('usergroups') has-danger @enderror">
                      <select class="selectpicker w-100" name="usergroups" id="usergroups" data-style="select-with-transition">
                        <option value="n/a" selected>Choose User Groups</option>
                          @foreach ($user_groups as $item)
                              <option value="{{ $item['id'] }}" {{  ($user['user_group_id'] === $item['id'] ) ? 'selected' : ''  }} >{{  $item['user_group']   }}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    @if ($errors->has('userlevel')) <p class="text-danger">{{ $errors->first('userlevel')}}</p> @endif
                    <div class="form-group @error('userlevel') has-danger @enderror">
                      <select class="selectpicker form-control" name="userlevel" id="userlevel" data-style="btn btn-link">
                        <option value="n/a" selected>Choose User Level</option>
                        @for ($i = Auth::user()->user_level; $i >= 2; $i--)
                        <option value="{{ $i  }}" {{ ($i == $user['user_level']) ? 'selected' : ''  }} >{{ $i }}</option>
                       @endfor
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
        
                  <div class="col-md-6">
                    @if ($errors->has('password')) <p class="text-danger">{{ $errors->first('password')}}</p> @endif
                    <div class="form-group  @error('password') has-danger @enderror">

                      <label for="password" class="bmd-label-floating">Password</label>
                      <input type="password" id="password" class="form-control" name="password" value="{{ old('password')  }}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    @if ($errors->has('cpassword')) <p class="text-danger">{{ $errors->first('cpassword')}}</p> @endif
                    <div class="form-group  @error('cpassword') has-danger @enderror">
                      <label class="bmd-label-floating">Confirm Password</label>
                      <input type="password" class="form-control"  equalTo="#password" name="cpassword" value="{{ old('cpassword') }}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    @if ($errors->has('otherinfo')) <p class="text-danger">{{ $errors->first('otherinfo')}}</p> @endif
                    <div class="form-group">
                      <label>Other info</label>
                      <div class="form-group @error('otherinfo') has-danger @enderror">
                        <label class="bmd-label-floating">Other information About you</label>
                        <textarea class="form-control" rows="5" name="otherinfo" >{{ old('otherinfo') ?? $user['otherinfo'] }}</textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-rose pull-right">Update Profile</button>
                <div class="clearfix"></div>

            </div>
          </div>
        </div>

        <style>
          .card-avatar-custom {
            width: 130px;
            height: 130px; margin: -50px auto 0;
            border-radius: 50%;
            overflow: hidden;
            padding: 0;
            box-shadow: 0 16px 38px -12px rgba(0, 0, 0, 0.56), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2);
          }
        </style>
    <input type="hidden"  name="id" value="{{ $user['id'] }}">
        <div class="col-md-4">
          <div class="card card-profile">
            <div class="card-avatar-custom" style="">

                <div class="fileinput-new">
                  <img class="img" style="height: 130px; width: 130px; object-fit: cover;" src="{{ (!empty($user['avatar'])) ? asset('images/'.$user['avatar']) : asset('img/logo.png')  }}" />
                </div>


            </div>
            <div class="card-body">
              {{-- <h6 class="card-category text-gray">CEO / Co-Founder</h6> --}}
              <h4 class="card-title">{{  $user['firstname'].' '.$user['middlename'].'. '.$user['lastname'] }}</h4>
              <p class="card-description">
              {{ $user['otherinfo'] }}
              </p>
              {{-- <a href="#pablo" class="btn btn-rose btn-round">Follow</> --}}
                <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                  <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
                  <div>
                    <span class="btn btn-round btn-rose btn-file">
                      <span class="fileinput-new">Add Photo</span>
                      <span class="fileinput-exists">Change</span>
                      <input id="useravatar" type="file"  name="useravatar" class="form-control"  accept="image/*" />
                   @csrf
                      @method("PUT")
                    </span>
                    <br />
                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                  </div>
                </div>
            </div>
          </div>
        </div>

      </div>
    </form>
    </div>
  </div>

@endsection
@section('scripts')
<script type="text/javascript">

    $(document).ready(function () {
          md.initFormExtendedDatetimepickers();
       $.ajaxSetup({
  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
  });

  $("#Updateprofile").submit(function(e){
                  e.preventDefault();
                  // let form_data = $("#Updateprofile").serializeArray();
                     var fa = $(this);
                  //  let form =  fa.serializeArray()  + '&useravatar=' + $('#useravatar').val();fa.serialize()
                  var formData = new FormData($(this)[0]);

                  $.ajax({
                      url : "{{ route('admin.users.update') }}",
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
                            $.each(response.msg, function (key, val) {
                        $("#" + key + "_error").text(val[0]).css('display','block');
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
              })

        });


  </script>
@endsection
