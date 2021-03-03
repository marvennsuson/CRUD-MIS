@extends('layouts.dashboard')

@section('header')
    Pending Applications
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
                            <h4 class="card-title">Pending Applications</h4>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="toolbar">

                    </div>
                    <div class="material-datatables">
                        <table id="user_table" cellspacing="0" class="table table-striped table-no-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>App ID</th>
                                    <th>User ID</th>
                                    <th>Status</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-link btn-warning btn-just-icon edit"
                                            data-action="{{ route('admin.users.edit') }}" data-userid='12'><i
                                                class="material-icons">dvr</i></button>
                                        <button type="button" class="btn btn-link btn-danger btn-just-icon remove"
                                            data-action="{{ route('admin.users.delete') }}" data-userid='12'><i
                                                class="material-icons">close</i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
          <div class="card">
              <div class="card-header card-header-icon card-header-rose">
                  <div class="card-icon">
                      <i class="material-icons">filter_alt</i>
                  </div>
                  <h4 class="card-title">Filter</h4>
              </div>
              <div class="card-body">
                  <form action="">
                      <select class="selectpicker w-100" data-style="btn btn-rose" title="Filter Type">
                          <option disabled selected>Filter Type</option>
                          <option value="2">Foobar</option>
                          <option value="3">Is great</option>
                          <option value="4">Is awesome</option>
                          <option value="5">Is wow</option>
                          <option value="6">Boom !</option>
                      </select>
                      <div class="form-group bmd-form-group mb-3">
                          <label for="name" class="bmd-label-floating">Name</label>
                          <input type="email" class="form-control" id="name">
                      </div>
      
                      <div class="d-flex mb-3">
                          <div class="form-group">
                              <label class="label-control">From</label>
                              <input type="text" class="form-control datetimepicker" value="01/02/2020"/>
                          </div>
      
                          <div class="form-group">
                              <label class="label-control">To</label>
                              <input type="text" class="form-control datetimepicker" value="01/02/2020"/>
                          </div>
                      </div>
      
                      <div class="text-right">
                          <button class="btn btn-rose btn-round">Search</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
    </div>




    {{-- Modal for Business Permit --}}

    <style>
      .nav-link.active {
        background: #4caf50 !important;
      }
    </style>

    <div class="custom-modal" id="applicationModal">
        <div class="card">
            <div class="card-header card-header-danger">
                <h4 class="card-title">Application ID - User ID</h4>
                <p class="category">Application Type - Status</p>
                <button class="closeBtn">
                    <i class="material-icons">
                        close
                    </i>
                </button>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills nav-pills-primary justify-content-end" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#applicationTab" role="tablist" aria-expanded="true">
                            Application
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#attachmentsTab" role="tablist" aria-expanded="false">
                            Attachments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#verificationTab" role="tablist" aria-expanded="false">
                            Verification
                        </a>
                    </li>
                </ul>
                <div class="tab-content tab-space">
                    <div class="tab-pane active" id="applicationTab" aria-expanded="true">
                        <div class="container-fluid">
                          <h5 class="info-text">Basic Information</h5>
                          <div class="row" style="margin-bottom:50px;">
                            <div class="col-sm-12 col-md-4">
                              <div class="form-group">
                                <select class="selectpicker" name="permitType" title="Choose Permit Type"
                                  data-style="select-with-transition" id="">
                                  <option disabled>Choose Permit Type</option>
                                  <option value="New">New </option>
                                  <option value="Renewal">Renewal</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                              <div class="form-group">
                                <select class="selectpicker" name="modeOfPayment" title="Choose Mode of Payment"
                                  data-style="select-with-transition" id="">
                                  <option disabled>Choose Mode of Payment</option>
                                  <option value="Annually">Annually </option>
                                  <option value="Semi-Annually">Semi-Annually</option>
                                  <option value="Quarterly">Quarterly</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                              <div class="form-group">
                                <select class="selectpicker" name="typeOfBusiness" title="Type of Business"
                                  data-style="select-with-transition" id="">
                                  <option disabled>Type of Business</option>
                                  <option value="Sole Proprietorship">Sole Proprietorship </option>
                                  <option value="Partnership">Partnership</option>
                                  <option value="Corporation">Corporation</option>
                                  <option value="Cooperative">Cooperative</option>
                                </select>
                              </div>
                            </div>

                          </div>

                          <div class="row">
                            <div class="col-sm-12 col-md-3">
                              <div class="form-group label-floating">
                                <label class="bmd-label-floating">Date of Application</label>
                                <input type="text" class="form-control datepicker"
                                  value="{{ Carbon\Carbon::now()->format('m/d/Y') }}">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                            <div class="col-sm-12 col-md-5">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">DTI/SEC/CDA/ Registration No.</label>
                                <input type="text" name="dti" class="form-control" aria-required="true" aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">TIN NO.</label>
                                <input type="text" name="tin" class="form-control" aria-required="true" aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                          </div>


                          <div class="row">
                            <div class="col-sm-12 col-md-4">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Amendment</label>
                                <input type="text" name="amendment" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">From</label>
                                <input type="text" name="from" class="form-control" aria-required="true" aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">To</label>
                                <input type="text" name="to" class="form-control" aria-required="true" aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                          </div>

                          <div class="row" style="margin-bottom:10px;">
                            <div class="col-sm-12 col-md-12">
                              <div class="form-group">
                                <h6 for="label-control">Change of Ownership</h6>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6 col-md-6">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Previous Owner</label>
                                <input type="text" name="previousOwner" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">New Owner</label>
                                <input type="text" name="newOwner" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6 mb-1">
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input class="form-check-input" name="enjoyTaxIncentive" type="checkbox" value="1"
                                    id="is_enjoy_tax">
                                  Are you enjoying tax incentive from any Government Entity?
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                              {{-- <div class="checkbox form-horizontal-checkbox">
                                        <label style="color:#AAAAAA">
                                            <input type="checkbox" name="is_enjoy_tax" id="is_enjoy_tax"><span class="checkbox-material"></span>
                                            Are you enjoying tax incentive from any Government Entity?
                                        </label>
                                    </div> --}}
                            </div>

                            <div class="col-md-6" id="yes_enjoy_tax" style="display:none">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Please specify the entity</label>
                                <input type="text" name="taxIncentiveEntity" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-sm-12">
                              <div class="form-group">
                                <h6 for="label-control">NAME OF TAXPAYER/REGISTRANT</h6>
                              </div>
                            </div>
                          </div>
            
                          <div class="row">
                            <div class="col-sm-4 col-md-4">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Last Name</label>
                                <input type="text" name="lastName" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">First Name</label>
                                <input type="text" name="firstName" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Middle Name</label>
                                <input type="text" name="middleName" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6 col-md-8">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Business Name</label>
                                <input type="text" name="businessName" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
            
                            <div class="col-sm-6 col-md-4">
                              <div class="form-group">
                                <select class="selectpicker form-control" name="civilStatus" data-style="select-with-transition"
                                  title="Civil Status">
                                  <option disabled selected>Civil Status</option>
                                  <option value="Married">Married</option>
                                  <option value="Windowed">Windowed</option>
                                  <option value="Separated">Separated</option>
                                  <option value="Divorced">Divorced</option>
                                  <option value="Single">Single</option>
                                </select>
                              </div>
                            </div>
            
                          </div>
                          <div class="row">
                            <div class="col-sm-12 col-md-6">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Company Represantative</label>
                                <input type="text" name="companyRepresentative" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
            
                            <div class="col-sm-6 col-md-3">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Position</label>
                                <input type="text" name="position" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
            
                            <div class="col-sm-6 col-md-3">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Trade Name / Franchise</label>
                                <input type="text" name="tradeName" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
            
                          </div>
            
                          <div class="row">
                            <div class="col-sm-12 col-md-12">
                              <div class="form-group">
                                <h6 for="label-control">Business contact details</h6>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6 col-md-8">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">EXACT BUSINESS ADDRESS</label>
                                <input type="text" name="businessAddress" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Postal Code</label>
                                <input type="text" name="postalCode" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                          </div>
            
                          <div class="row">
                            <div class="col-sm-12 col-md-4">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Email</label>
                                <input type="text" name="email" class="form-control" aria-required="true" aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Telephone No.</label>
                                <input type="text" name="tel" class="form-control" aria-required="true" aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Mobile No.</label>
                                <input type="text" name="mobile" class="form-control" aria-required="true" aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Mobile No.</label>
                                <input type="text" name="mobile" class="form-control" aria-required="true" aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                          </div>
            
                          <div class="row">
                            <div class="col-sm-12 col-md-12">
                              <div class="form-group">
                                <h6 for="label-control">Owner's contact details</h6>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6 col-md-8">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Owner's Home Address</label>
                                <input type="text" name="ownersHomeAddress" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Postal Code</label>
                                <input type="text" name="ownersPostalCode" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                          </div>
            
                          <div class="row">
                            <div class="col-sm-12 col-md-4">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Email</label>
                                <input type="text" name="ownersEmail" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Telephone No.</label>
                                <input type="text" name="ownersTelNo" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Mobile No.</label>
                                <input type="text" name="ownersMobileNo" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                          </div>
  
                          <div class="row">
                            <div class="col-sm-12 col-md-12">
                              <div class="form-group">
                                <h6 for="label-control">In case of emergency Information</h6>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-12">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Emergency Contact Name</label>
                                <input type="text" name="emergencyContactName" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                          </div>
            
                          <div class="row">
                            <div class="col-sm-12 col-md-4">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Email</label>
                                <input type="text" name="emergencyEmail" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Telephone No.</label>
                                <input type="text" name="emergencyTelNo" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Mobile No.</label>
                                <input type="text" name="emergencyMobileNo" class="form-control" aria-required="true"
                                  aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                          </div>
            
                          <div class="row">
                            <div class="col-sm-12 col-md-12">
                              <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Business Area (in sq.m.)</label>
                                <input type="text" class="form-control" aria-required="true" aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                              </div>
                            </div>
                          </div>
            
                          <div class="row">
                            <div class="col-sm-12 col-md-6">
                              <label>Total No. of Employees in Establishment</label>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Male</label>
                                    <input type="text" name="maleEmployeesInEstablishment" class="form-control" aria-required="true"
                                      aria-invalid-true="true">
                                    <span class="material-input"></span>
                                    <br>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Female</label>
                                    <input type="text" name="femaleEmployeesInEstablishment" class="form-control"
                                      aria-required="true" aria-invalid-true="true">
                                    <span class="material-input"></span>
                                    <br>
                                  </div>
                                </div>
                              </div>
                            </div>
            
                            <div class="col-sm-12 col-md-6">
                              <label>No. of Employees Residing within the LGU</label>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Male</label>
                                    <input type="text" name="maleEmployeesResidingWithinTheLGU" class="form-control"
                                      aria-required="true" aria-invalid-true="true">
                                    <span class="material-input"></span>
                                    <br>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Female</label>
                                    <input type="text" name="femaleEmployeesResidingWithinTheLGU" class="form-control"
                                      aria-required="true" aria-invalid-true="true">
                                    <span class="material-input"></span>
                                    <br>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
            
                          <div class="row">
                            <div class="col-sm-12">
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" name="rented" value="1" id="is_business_rented">
                                  Check only if business place is rented
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                            </div>
                          </div>
            
                          <div id="lessor_info" style="display:none">
                            <div class="row">
                              <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                  <h6 for="label-control">Lessor's Information</h6>
                                </div>
                              </div>
                            </div>
            
                            <div class="row">
                              <div class="col-sm-12 col-md-6">
                                <div class="form-group bmd-form-group">
                                  <label class="bmd-label-floating">Lessor's Full Name</label>
                                  <input type="text" name="lessorFullName" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                  <span class="material-input"></span>
                                  <br>
                                </div>
                              </div>
            
                              <div class="col-sm-12 col-md-6">
                                <div class="form-group bmd-form-group">
                                  <label class="bmd-label-floating">Lessor's Full Address</label>
                                  <input type="text" name="lessorFullAddress" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                  <span class="material-input"></span>
                                  <br>
                                </div>
                              </div>
                            </div>
            
                            <div class="row">
                              <div class="col-sm-12 col-md-6">
                                <div class="form-group bmd-form-group">
                                  <label class="bmd-label-floating">Lessor's Full Telephone/Mobile No.</label>
                                  <input type="text" name="lessorMobileNumber" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                  <span class="material-input"></span>
                                  <br>
                                </div>
                              </div>
            
                              <div class="col-sm-12 col-md-6">
                                <div class="form-group bmd-form-group">
                                  <label class="bmd-label-floating">Monthly Rental</label>
                                  <input type="text" name="monthlyRental" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                  <span class="material-input"></span>
                                  <br>
                                </div>
                              </div>
                            </div>
                          </div>
                          <br><br>
            
                          <div class="container-fluid">
                            <div class="row justify-content-between">
                              <div class="">
                                <h5>Business Activity/Activities</h5>
                              </div>
                            </div>
                          </div>
            
                          <div id="businessActivitiesList">
                            <div class="row">
                              <div class="col-sm-12 col-md-4">
                                <div class="form-group bmd-form-group">
                                  <label class="bmd-label-floating">Line of Business</label>
                                  <input type="text" name="lineOfBusines[]" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                  <span class="material-input"></span>
                                  <br>
                                </div>
                              </div>
        
                              <div class="col-sm-12 col-md-4">
                                <div class="form-group bmd-form-group">
                                  <label class="bmd-label-floating">Capitalization</label>
                                  <input type="text" name="capitalization[]" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                  <span class="material-input"></span>
                                  <br>
                                </div>
                              </div>
        
                              <div class="col-sm-12 col-md-4">
                                <div class="form-group bmd-form-group">
                                  <label class="bmd-label-floating">No. Of Units</label>
                                  <input type="text" name="noOfUnits[]" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                  <span class="material-input"></span>
                                  <br>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                    </div>



                    <div class="tab-pane" id="attachmentsTab" aria-expanded="false">
                      <div id="accordion">
                        <div class="card">
                          <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                              <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                                aria-expanded="true" aria-controls="collapseOne">
                                Barangay Business Clearance
                              </button>
                            </h5>
                          </div>
        
                          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                              <p>Barangay Business Clearance na may kasamang resibo (Official Receipt).</p>
                              <div class="">
                                <button type="button" class="btn btn-primary">Download <i class="material-icons">download</i></button>
                                {{-- <input type="file" name="barangayBusinessClearance" class="-input" --}}
                                  {{-- id="barangayBusinessClearance"> --}}
                                {{-- <label class=""  for="barangayBusinessClearance">Barangay Business Clearance</label> --}}
                              </div>
                            </div>
                          </div>
                        </div>
        
                        <div class="card">
                          <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                              <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                                data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Tax Declaration ng Lote at Building
                              </button>
                            </h5>
                          </div>
                          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                              <p>
                                Taxt Declaration ng Lote at Building
                              </p>
                              <div class="">
                                <button type="button" class="btn btn-primary">Download <i class="material-icons">download</i></button>
                                {{-- <input type="file" name="taxDeclarationNgLoteAtBuilding"  class="-input" --}}
                                  {{-- id="taxDeclarationNgLoteAtBuilding"> --}}
                                {{-- <label class="" for="taxDeclarationNgLoteAtBuilding">Tax Declaration ng Lote at Building</label> --}}
                              </div>
                            </div>
                          </div>
                        </div>
        
                        <div class="card">
                          <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                              <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                                data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Resibo ng Buwis ng Lupa
                              </button>
                            </h5>
                          </div>
                          <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                              <p>Resibo ng Buwis ng Lupa na kinatatayuan ng Negosyo. Kung hindi sarili ang lote o building, mag
                                upload ng Lease Contract na updated at notaryado, at kung hindi umuupa: Kapahintulutan mula sa
                                may-ari ng lupa na pinapayagang magtayo ng negosyo sa nasabing ari-arian ng walang bayad
                                (notaryado, at I.D. na may pirma ng may ari ng Lupa.</p>
                              <div class="">
                                <button type="button" class="btn btn-primary">Download <i class="material-icons">download</i></button>
                                {{-- <input type="file" name="resiboNgBuwisNgLupa"  class="-input" id="resiboNgBuwisNgLupa"> --}}
                                {{-- <label class="-label"for="resiboNgBuwisNgLupa">Resibo ng Buwis ng Lupa</label> --}}
                              </div>
                            </div>
                          </div>
                        </div>
        
                        <div class="card">
                          <div class="card-header" id="headingFour">
                            <h5 class="mb-0">
                              <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                                data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Building Permit o Occupancy Permit
                              </button>
                            </h5>
                          </div>
                          <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                            <div class="card-body">
                              <p>Building Permit o Occupancy Permit</p>
                              <div class="">
                                <button type="button" class="btn btn-primary">Download <i class="material-icons">download</i></button>
                                {{-- <input type="file" name="buildingPermitOOccupancyPermit" class="-input" --}}
                                  {{-- id="buildingPermitOOccupancyPermit"> --}}
                                {{-- <label class="-label"for="buildingPermitOOccupancyPermit">Building Permit o Occupancy Permit</label> --}}
                              </div>
                            </div>
                          </div>
                        </div>
        
                        <div class="card">
                          <div class="card-header" id="headingFive">
                            <h5 class="mb-0">
                              <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                                data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                DTI Registration o SEC and Articles of Incorporation & By-Laws
                              </button>
                            </h5>
                          </div>
                          <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                            <div class="card-body">
                              <p>DTI Registration o SEC and Articles of Incorporation & By-Laws</p>
                              <div class="">
                                <button type="button" class="btn btn-primary">Download <i class="material-icons">download</i></button>
                                {{-- <input type="file" name="dtiRegistrationOSecAndArticlesOfIncorporationByLaws" class="-input" --}}
                                  {{-- id="dtiRegistrationOSecAndArticlesOfIncorporationByLaws"> --}}
                                {{-- <label class="" for="dtiRegistrationOSecAndArticlesOfIncorporationByLaws">DTI Registration o SEC and Articles of Incorporation & By-Laws</label> --}}
                              </div>
                            </div>
                          </div>
                        </div>
        
        
                        <div class="card">
                          <div class="card-header" id="headingSix">
                            <h5 class="mb-0">
                              <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                                data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                Sketch
                              </button>
                            </h5>
                          </div>
                          <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
                            <div class="card-body">
                              <p>Occupational Permit or Masterlist of Employees (kung lima pataas) na may kalakip na cedula ng
                                bawat isa</p>
                              <div class="">
                                <button type="button" class="btn btn-primary">Download <i class="material-icons">download</i></button>
                                {{-- <input type="file" name="occupationalPermitOrMasterlistOfEmployees" class="-input" --}}
                                  {{-- id="occupationalPermitOrMasterlistOfEmployees"> --}}
                                {{-- <label class="" for="occupationalPermitOrMasterlistOfEmployees">Occupational Permit or Masterlist of Employees</label> --}}
                              </div>
                            </div>
                          </div>
                        </div>
        
                        <div class="card">
                          <div class="card-header" id="headingSeven">
                            <h5 class="mb-0">
                              <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                                data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                Authorization Letter
                              </button>
                            </h5>
                          </div>
                          <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion">
                            <div class="card-body">
                              <p>Authorization Letter kung hindi ang may-ari ang mag aayos ng kanyang permit na may kalakip na
                                I.D. ng may-ari ng negosyo na may pirma at I.D. ng mag-aayos ng business permit.</p>
                              <div class="">
                                <button type="button" class="btn btn-primary">Download <i class="material-icons">download</i></button>
                                {{-- <input type="file" name="authorizationLetter" class="-input" --}}
                                  {{-- id="authorizationLetter"> --}}
                                {{-- <label class="" for="occupationalPermitOrMasterlistOfEmployees">Occupational Permit or Masterlist of Employees</label> --}}
                              </div>
                            </div>
                          </div>
                        </div>
        
                        <div class="card">
                          <div class="card-header" id="headingEight">
                            <h5 class="mb-0">
                              <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                                data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                Iba pa
                              </button>
                            </h5>
                          </div>
                          <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordion">
                            <div class="card-body">
                              <p>Iba pa</p>
                              <div class="">
                                <button type="button" class="btn btn-primary">Download <i class="material-icons">download</i></button>
                                {{-- <input type="file" name="ibaPa" class="-input" id="ibaPa" multiple> --}}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> 
                    
                    <div class="tab-pane" id="verificationTab" aria-expanded="false">
                        <form action="">
                          <div class="container-fluid">

                            <h5>Verification of Documents</h5>
                            <div class="row mb-3">
                              <div class="col-3">
                                <b>Description</b>
                              </div>
                              <div class="col-3">
                                <b>Office / Agency</b>
                              </div>
                              <div class="col-2 text-center">
                                <b>Yes</b>
                              </div>
                              <div class="col-2 text-center">
                                <b>No</b>
                              </div>
                              <div class="col-2 text-center">
                                <b>Not Needed</b>
                              </div>
                            </div>

                            <div class="row mb-3">
                              <div class="col-3">
                                Locational Clearance (for NEW/TRANSERS OF LOCATION)
                              </div>
                              <div class="col-3">
                               City Planning and Development Office
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status1" id="">
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status1" id="">
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status1" id="">
                              </div>
                            </div>

                            <div class="row mb-3">
                              <div class="col-3">
                                Occupancy Permit (For New)
                              </div>
                              <div class="col-3">
                               City Engineering Office
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status2" id="">
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status2" id="">
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status2" id="">
                              </div>
                            </div>

                            <div class="row mb-3">
                              <div class="col-3">
                                Barangay Clearance (for New/Renewal)
                              </div>
                              <div class="col-3">
                               Barangay
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status3" id="">
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status3" id="">
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status3" id="">
                              </div>
                            </div>

                            <div class="row mb-3">
                              <div class="col-3">
                                Sanitary Permit/Health Clearance
                              </div>
                              <div class="col-3">
                               City Health Office
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status4" id="">
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status4" id="">
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status4" id="">
                              </div>
                            </div>

                            <div class="row mb-3">
                              <div class="col-3">
                                City Environmental Certificate
                              </div>
                              <div class="col-3">
                                City Environment and Natural Resources Office
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status5" id="">
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status5" id="">
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status5" id="">
                              </div>
                            </div>

                            <div class="row mb-3">
                              <div class="col-3">
                                Veterinary Clearance
                              </div>
                              <div class="col-3">
                                City Veterinary Clearance
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status6" id="">
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status6" id="">
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status6" id="">
                              </div>
                            </div>

                            <div class="row mb-3">
                              <div class="col-3">
                                Market Clearance (For Stall Holders)
                              </div>
                              <div class="col-3">
                                Economic Enterprise Division (Public Market)
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status7" id="">
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status7" id="">
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status7" id="">
                              </div>
                            </div>

                            <div class="row mb-3">
                              <div class="col-3">
                                Fire Safety Inspection Certificate
                              </div>
                              <div class="col-3">
                                Bureau of Fire Protection
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status8" id="">
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status8" id="">
                              </div>
                              <div class="col-2 text-center">
                                <input type="radio" name="status8" id="">
                              </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Verify</button>

                          </div>
                        </form>
                    </div>
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

    </script>
@endsection
