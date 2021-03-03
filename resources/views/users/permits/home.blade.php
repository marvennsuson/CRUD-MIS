@extends('layouts.users')

@section('header')
Apply Permits
@endsection
@section('content')

<div class="row">
  <div class="col-lg-4 cards">
    <div class="card card-pricing card-raised">
      <div class="card-body">
        <h5 class="card-category">Business Permit</h5>
        <div class="card-icon icon-rose">
          <i class="material-icons">description</i>
        </div>
        <br>
        <p class="card-description">
          Lorem ipsum dolor, sit amet consectetur adipisicing elit. Provident dolorum ipsam libero rem, minima ut nulla,
          consequatur quaerat expedita reiciendis voluptate sit ea labore ad ducimus deserunt iure officia aspernatur.
        </p>
        <button class="btn btn-rose btn-round" onclick="openBusinessPermit()">
          <i class="material-icons">add</i>Apply
        </button>
      </div>
    </div>
  </div>
  <div class="col-lg-4 cards">
    <div class="card card-pricing card-raised">
      <div class="card-body">
        <h5 class="card-category">Mayor's Permit</h5>
        <div class="card-icon icon-rose">
          <i class="material-icons">text_snippet</i>
        </div>
        <br>
        <p class="card-description">
          Lorem ipsum dolor, sit amet consectetur adipisicing elit. Provident dolorum ipsam libero rem, minima ut nulla,
          consequatur quaerat expedita reiciendis voluptate sit ea labore ad ducimus deserunt iure officia aspernatur.
        </p>
        <button class="btn btn-disabled btn-round btn-disabled">
          <i class="material-icons">add</i>Coming Soon
        </button>
      </div>
    </div>
  </div>
  <div class="col-lg-4 cards">
    <div class="card card-pricing card-raised">
      <div class="card-body">
        <h5 class="card-category">Cedula</h5>
        <div class="card-icon icon-rose">
          <i class="material-icons">request_quote</i>
        </div>
        <br>
        <p class="card-description">
          Lorem ipsum dolor, sit amet consectetur adipisicing elit. Provident dolorum ipsam libero rem, minima ut nulla,
          consequatur quaerat expedita reiciendis voluptate sit ea labore ad ducimus deserunt iure officia aspernatur.
        </p>
        <button class="btn btn-disabled btn-round btn-disabled">
          <i class="material-icons">add</i>Coming Soon
        </button>
      </div>
    </div>
  </div>
</div>


<style>
  .custom-modal {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    z-index: 9000;
    background: rgba(0, 0, 0, 0.5);
    overflow: auto;
    display: block;
  }

  #closeBtn {
    position: absolute;
    top: 8px;
    right: 14px;
    z-index: 10000;
    padding: 8px;
  }

  .swal2-container {
    z-index: 9999;
  }

  /* .wizard-container {
    margin-left: 50%;
    transform: translateX(-50%);
  } */
</style>



<div class="custom-modal p-sm-0" id="businessPermitModal">
  
  <!--      Wizard container        -->
  <div class="wizard-container col-sm-12 col-md-10 col-lg-8 mx-auto">
    <div class="card card-wizard" data-color="rose" id="wizardProfile">
      <form data-url="{{ route('users.businessPermit.add')}}" id="form_business" method="POST" enctype="multipart/form-data" novalidate="novalidate">
        @csrf
        <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
        <div class="card-header text-center">
          <h3 class="card-title">
            Business Permit Wizard
            <button id="closeBtn" class="btn btn-disabled btn-round">
              <i class="material-icons">
                close
              </i>
            </button>
          </h3>
          {{-- <h6 class="card-description">1. Provide accurate information and print legibility to avoi delays. Incomplete application form will be return to the applicant. <br>2. Ensure that all documents attached to this form (if any) are complete and properly filled up.</h6> --}}
        </div>
        <div class="wizard-navigation">
          <ul class="nav nav-pills">
            <li class="nav-item" style="width: 25%;">
              <a class="nav-link active" href="#basicinfo" data-toggle="tab" role="tab">
                Step 1
              </a>
            </li>
            <li class="nav-item" style="width: 25%;">
              <a class="nav-link" href="#pogi" data-toggle="tab" role="tab">
                Step 2
              </a>
            </li>
            <li class="nav-item" style="width: 25%;">
              <a class="nav-link" href="#otherinfo" data-toggle="tab" role="tab">
                Step 3
              </a>
            </li>
          </ul>
          <div class="moving-tab"
            style="width: 149.927px; transform: translate3d(-8px, 0px, 0px); transition: transform 0s ease 0s;">
            Step 1
          </div>
        </div>
        <div class="card-body">
          <div class="tab-content">
            <div class="tab-pane active" id="basicinfo">
              <h5 class="info-text">Basic Information</h5>
              <div class="row" style="margin-bottom:50px;">
                <div class="col-sm-12 col-md-4">
                  <div class="form-group">
                    <select class="selectpicker w-100" id="permitType" name="permitType" title="Choose Permit Type"
                      data-style="select-with-transition">
                      <option disabled>Choose Permit Type</option>
                      <option value="New">New </option>
                      <option value="Renewal">Renewal</option>
                      <option value="Transfer of Business Location">Transfer of Business Location</option>
                      <option value="Transfer of Business Ownership">Transfer of Business Ownership</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12 col-md-4">
                  <div class="form-group">
                    <select class="selectpicker w-100" name="modeOfPayment" title="Choose Mode of Payment"
                      data-style="select-with-transition">
                      <option disabled>Choose Mode of Payment</option>
                      <option value="Annually">Annually </option>
                      <option value="Semi-Annually">Semi-Annually</option>
                      <option value="Quarterly">Quarterly</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12 col-md-4">
                  <div class="form-group">
                    <select class="selectpicker w-100" name="typeOfBusiness" title="Ownership"
                      data-style="select-with-transition" id="">
                      <option disabled>Ownership</option>
                      <option value="Sole Proprietorship">Sole Proprietorship </option>
                      <option value="Partnership">Partnership</option>
                      <option value="Corporation">Corporation</option>
                      <option value="Cooperative">Cooperative</option>
                    </select>
                  </div>
                </div>

              </div>

              <div class="row" id="renewalInputs">
                <div class="col-sm-12 col-md-3">
                  <div class="form-group label-floating">
                    <label class="bmd-label-floating">Date of Application</label>
                    <input type="text" name="date_of_application" class="form-control datepicker"
                      value="{{ Carbon\Carbon::now()->format('m/d/Y') }}">
                    <span class="material-input"></span>
                    <br>
                  </div>
                </div>
                <div class="col-sm-12 col-md-5">
                  <div class="form-group bmd-form-group">
                    <label class="bmd-label-floating">DTI/SEC/CDA/ Registration No.</label>
                    <input type="text" name="dti" id="dti" class="form-control" aria-required="true" aria-invalid-true="true">
                    <span class="material-input"></span>
                    <br>
                  </div>
                </div>
                <div class="col-sm-12 col-md-4">
                  <div class="form-group bmd-form-group">
                    <label class="bmd-label-floating">TIN NO.</label>
                    <input type="text" name="tin" id="tin" class="form-control" aria-required="true" aria-invalid-true="true">
                    <span class="material-input"></span>
                    <br>
                  </div>
                </div>
              </div>


              <div class="row" id="amendmentDiv">
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
              <div class="row" id="ownershipDiv">
                <div class="col-sm-6 col-md-6">
                  <div class="form-group bmd-form-group">
                    <label class="bmd-label-floating">Previous Owner</label>
                    <input type="text" name="previousOwner" id="previousOwner" class="form-control" aria-required="true"
                      aria-invalid-true="true">
                    <span class="material-input"></span>
                    <br>
                  </div>
                </div>
                <div class="col-sm-6 col-md-6">
                  <div class="form-group bmd-form-group">
                    <label class="bmd-label-floating">New Owner</label>
                    <input type="text" name="newOwner" id="newOwner" class="form-control" aria-required="true"
                      aria-invalid-true="true">
                    <span class="material-input"></span>
                    <br>
                  </div>
                </div>
              </div>

              <div class="row" id="enjoyTaxDiv">
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
                    <input type="text" name="taxIncentiveEntity" id="taxIncentiveEntity" class="form-control" aria-required="true"
                      aria-invalid-true="true">
                    <span class="material-input"></span>
                    <br>
                  </div>
                </div>
              </div>


            </div>

            <div class="tab-pane" id="pogi">
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
                    <select class="selectpicker" name="civilStatus" data-style="select-with-transition"
                      title="Civil Status">
                      <option disabled>Civil Status</option>
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
                    <input type="number" name="postalCode" class="form-control" aria-required="true"
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
                    <input type="number" name="ownersPostalCode" class="form-control" aria-required="true"
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

            </div>

            <div class="tab-pane" id="otherinfo">
              {{-- <h5 class="info-text">Other Information</h5> --}}



              <div class="row">
                <div class="col-sm-12 col-md-12">
                  <div class="form-group">
                    <h6 for="label-control">In case of emergency Information</h6>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-8">
                  <div class="form-group bmd-form-group">
                    <label class="bmd-label-floating">Emergency Contact Name</label>
                    <input type="text" name="emergencyContactName" class="form-control" aria-required="true"
                      aria-invalid-true="true">
                    <span class="material-input"></span>
                    <br>
                  </div>
                </div>
                <div class="col-sm-12 col-md-4">
                  <div class="form-group bmd-form-group">
                    <label class="bmd-label-floating">Email</label>
                    <input type="text" name="emergencyEmail" class="form-control" aria-required="true"
                      aria-invalid-true="true">
                    <span class="material-input"></span>
                    <br>
                  </div>
                </div>
              </div>

              <div class="row">
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
                <div class="col-sm-12 col-md-4">
                  <div class="form-group bmd-form-group">
                    <label class="bmd-label-floating">Business Area (in sq.m.)</label>
                    <input type="number" class="form-control"  max="2147483647" name="business_area" aria-required="true" aria-invalid-true="true">
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
                        <input type="number" max="2147483647" name="maleEmployeesInEstablishment" class="form-control" aria-required="true"
                          aria-invalid-true="true">
                        <span class="material-input"></span>
                        <br>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group bmd-form-group">
                        <label class="bmd-label-floating">Female</label>
                        <input type="number" max="2147483647" name="femaleEmployeesInEstablishment" class="form-control"
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
                        <input type="number" max="2147483647" name="maleEmployeesResidingWithinTheLGU" class="form-control"
                          aria-required="true" aria-invalid-true="true">
                        <span class="material-input"></span>
                        <br>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group bmd-form-group">
                        <label class="bmd-label-floating">Female</label>
                        <input type="number"  max="2147483647" name="femaleEmployeesResidingWithinTheLGU" class="form-control"
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
                      <input type="text" name="lessorFullName" id="lessorFullName" class="form-control" aria-required="true"
                        aria-invalid-true="true">
                      <span class="material-input"></span>
                      <br>
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-6">
                    <div class="form-group bmd-form-group">
                      <label class="bmd-label-floating">Lessor's Full Address</label>
                      <input type="text" name="lessorFullAddress" id="lessorFullAddress" class="form-control" aria-required="true"
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
                      <input type="text" name="lessorMobileNumber" id="lessorMobileNumber" class="form-control" aria-required="true"
                        aria-invalid-true="true">
                      <span class="material-input"></span>
                      <br>
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-6">
                    <div class="form-group bmd-form-group">
                      <label class="bmd-label-floating">Monthly Rental</label>
                      <input type="number"  max="2147483647" name="monthlyRental" id="monthlyRental" class="form-control" aria-required="true"
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
                  <div>
                    <button type="button" class="btn btn-primary" id="addBusinessActivity">
                      <i class="material-icons">
                        add
                      </i>
                    </button>
                  </div>
                </div>
              </div>

              <div id="businessActivitiesList">
                <div class="card">
                  <div class="card-body">
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
                          <input type="number" max="2147483647" name="capitalization[]" class="form-control" aria-required="true"
                            aria-invalid-true="true">
                          <span class="material-input"></span>
                          <br>
                        </div>
                      </div>

                      <div class="col-sm-12 col-md-4">
                        <div class="form-group bmd-form-group">
                          <label class="bmd-label-floating">No. Of Units</label>
                          <input type="number"  max="2147483647" name="noOfUnits[]" class="form-control" aria-required="true"
                            aria-invalid-true="true">
                          <span class="material-input"></span>
                          <br>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


              {{-- END --}}

            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="mr-auto">
            <input type="button" class="btn btn-previous btn-fill btn-default btn-wd disabled" name="previous"
              value="Previous">
          </div>
          <div class="ml-auto">
            <input type="button" id="btnNext" class="btn btn-next btn-fill btn-rose btn-wd" name="next" value="Next">
            <input type="submit" class="btn btn-finish btn-fill btn-rose btn-wd" name="finish" value="SUBMIT"
              style="display: none;">
          </div>
          <div class="clearfix"></div>
        </div>
      </form>
    </div>
  </div>
  <!-- wizard container -->
</div>


@endsection

@section('scripts')
<script>
    $(document).ready(function() {
      $('#businessPermitModal').fadeToggle(300);
      // Initialise the wizard
      demo.initMaterialWizard();
      setTimeout(function() {
        $('.card.card-wizard').addClass('active');
      }, 600);
      md.initFormExtendedDatetimepickers();
          if ($('.slider').length != 0) {
            md.initSliders();
          }
    });


    
    $(document).on('change', "#permitType", function () {
      $('#previousOwner').rules('remove');
      $('#newOwner').rules('remove');
      $('#tin').rules('remove');
      $('#dti').rules('remove');

      if ($(this).val() == 'New') {
        $('#tin').rules('remove');
        $('#dti').rules('remove');
        $('#renewalInputs input').attr('disabled', 'disabled');
        $('#amendmentDiv input').attr('disabled', 'disabled');
        $('#ownershipDiv input').attr('disabled', 'disabled');
        $('#enjoyTaxDiv input').attr('disabled', 'disabled');
        
        return false;
      }else if($(this).val() == 'Transfer of Business Ownership'){
        $('#previousOwner').rules('add', {  required: true })
        $('#newOwner').rules('add', {  required: true })
        $('#tin').rules('add', { required: true});
        $('#dti').rules('add', { required: true});
 
      }
      else if ($(this).val() == 'Renewal'){
        $('#tin').rules('add', { required: true});
        $('#dti').rules('add', { required: true});
        $('#renewalInputs').show();
     
      }else{
        $('#tin').rules('add', { required: true});
        $('#dti').rules('add', { required: true});
  
      }
      $('#renewalInputs input').removeAttr('disabled');
      $('#amendmentDiv input').removeAttr('disabled');
      $('#ownershipDiv input').removeAttr('disabled');
      $('#enjoyTaxDiv input').removeAttr('disabled');
    });

    $('#is_enjoy_tax').change(() => {
        if ($('#is_enjoy_tax').is(':checked')) {
            $('#taxIncentiveEntity').rules('add', { required: true});
            $('#yes_enjoy_tax').show();
        }else{
            $('#taxIncentiveEntity').rules('remove');
            $('#yes_enjoy_tax').hide();
        }
    });
    $('#is_business_rented').change(() => {
        if ($('#is_business_rented').is(':checked')) {
            $('#lessorFullName').rules('add', { required: true});
            $('#lessorFullAddress').rules('add', { required: true});
            $('#lessorMobileNumber').rules('add', { required: true});
            $('#monthlyRental').rules('add', { required: true});
            $('#lessor_info').show();
        }else{
            $('#lessorFullName').rules('remove');
            $('#lessorFullAddress').rules('remove');
            $('#lessorMobileNumber').rules('remove');
            $('#monthlyRental').rules('remove');
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
                                <input type="number" max="2147483647" name="capitalization[]" class="form-control" aria-required="true" aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
        
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">No. Of Units</label>
                                <input type="number" max="2147483647" name="noOfUnits[]" class="form-control" aria-required="true" aria-invalid-true="true">
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

      $('#closeBtn').click(function (){
        openBusinessPermit();
      });

      var body = false;

      function openBusinessPermit(){
          $('#businessPermitModal').fadeToggle(300);
          if(body == false){
            $('body').css("overflow", "hidden");
            body = true;
          } else {
            $('body').css("overflow", "auto");
            body = false;
          }
      }


      $('#btnNext').click(e => {
        $('#businessPermitModal').scroll();
        $("#businessPermitModal").animate({
        scrollTop: 0
        }, 300);
      });


      $('#form_business').submit(function(e){
        e.preventDefault();
        var action = $(this).data('url');
        var formData = new FormData($(this)[0]);
        
        var $valid = $('.card-wizard form').valid();
        if (!$valid) {
          return false;
        }
        
        var submitBusinessPermit = ajaxPost(action,formData, response);
      });


      function response (result){
        
        var redirectlink = '/view-application/'+result.id;
        if(result.status == false){
            Swal.fire(
                'Failed!',
                result.msg,
                'error'
            ).then((result) => {
                // location.reload();
            });
        }else{
            Swal.fire(
                'Success!',
                result.msg,
                'success'
            ).then((result) => {
              window.location.href = redirectlink;
            });
        }
        return false;
      }
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