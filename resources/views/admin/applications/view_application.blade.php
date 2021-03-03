@extends('layouts.dashboard')

@section('header')
Application ID - {{$id}}
@endsection

@section('content')


@if ($type == 1)
@php
   $businessActivities = json_decode($business_permit_info['business_activities'], true);
@endphp


<style>
    .download_file:hover{
        cursor: pointer;
        color: green;
    }

    .steps-card {
        display: none;
    }

    .steps-card.active {
        display: block;
    }

    .history-tab {
        display: none;
    }

    .history-tab.active {
        display: block;
    }


</style>
<div class="row">
    <div class="col-md-8 col-lg-8">
        <div class="card">
            <div class="card-header card-header-icon card-header-rose">
                <div class="card-icon">
                    <i class="material-icons">language</i>
                </div>
                <h4 class="card-title">
                    {{ $app_type }}
                </h4>
            </div>
            <div class="card-body">
                <div class="d-flex" role="group" aria-label="Basic example">
                    <button type="button" class="steps-btn btn-round btn btn-primary">Form</button>
                    <button type="button" class="steps-btn btn-round btn btn-secondary">Requirements</button>
                    <button type="button" class="steps-btn btn-round btn btn-secondary">Verification</button>
                    <button type="button" class="steps-btn btn-round btn btn-secondary">History</button>
                </div>
            </div>
        </div>


        <div class="card steps-card" id="steptab1">
            <form data-url="" id="updateBusiness"  method="post">
            @csrf
            <div class="card-body">
                <div class="container-fluid">
                    <h5 class="info-text">Basic Information</h5>
                    <div class="row" style="margin-bottom:50px;">
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <select class="selectpicker w-100" disabled="disabled" name="permitType" id="permitType" title="Choose Permit Type"
                                    data-style="select-with-transition" id="">
                                    <option disabled>Choose Permit Type</option>
                                    <option value="New" {{ $business_permit_info['permit_type'] == 'New'  ? 'selected': '' }}>New </option>
                                    <option value="Renewal" {{ $business_permit_info['permit_type'] == 'Renewal'  ? 'selected': '' }}>Renewal</option>
                                    <option value="Transfer of Business Location"  {{ $business_permit_info['permit_type'] == 'Transfer of Business Location'  ? 'selected': '' }}>Transfer of Business Location</option>
                                    <option value="Transfer of Business Ownership"  {{ $business_permit_info['permit_type'] == 'Transfer of Business Ownership'  ? 'selected': '' }}>Transfer of Business Ownership</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <select class="selectpicker w-100" name="modeOfPayment" title="Choose Mode of Payment"
                                    data-style="select-with-transition" id="">
                                    <option disabled>Choose Mode of Payment</option>
                                    <option value="Annually" {{ $business_permit_info['mode_of_payment'] == 'Annually'  ? 'selected': '' }}>Annually </option>
                                    <option value="Semi-Annually" {{ $business_permit_info['mode_of_payment'] == 'Semi-Annually'  ? 'selected': '' }}>Semi-Annually</option>
                                    <option value="Quarterly" {{ $business_permit_info['mode_of_payment'] == 'Quarterly'  ? 'selected': '' }}>Quarterly</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <select class="selectpicker w-100" name="typeOfBusiness" title="Type of Business"
                                    data-style="select-with-transition" id="">
                                    <option disabled>Type of Business</option>
                                    <option value="Sole Proprietorship" {{ $business_permit_info['business_type'] == 'Sole Proprietorship'  ? 'selected': '' }}>Sole Proprietorship </option>
                                    <option value="Partnership" {{ $business_permit_info['business_type'] == 'Partnership'  ? 'selected': '' }}>Partnership</option>
                                    <option value="Corporation" {{ $business_permit_info['business_type'] == 'Corporation'  ? 'selected': '' }}>Corporation</option>
                                    <option value="Cooperative" {{ $business_permit_info['business_type'] == 'Cooperative'  ? 'selected': '' }}>Cooperative</option>
                                </select>
                            </div>
                        </div>
        
                    </div>
        
                    <div class="row" id="renewalInputs">
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group label-floating">
                                <label class="bmd-label-floating">Date of Application</label>
                                <input type="text" class="form-control datepicker"
                                    value="{{ date('m/d/Y', strtotime($business_permit_info['application_date'])) }}">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-5">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">DTI/SEC/CDA/ Registration No.</label>
                                <input type="text" name="dti" id="dti" value="{{$business_permit_info['registration_no']}}" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">TIN NO.</label>
                                <input type="text" name="tin" id="tin" value="{{$business_permit_info['tin_no']}}" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
                    </div>
        
        
                    <div class="row" id="amendmentDiv">
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Amendment</label>
                                <input type="text" name="amendment" value="{{$business_permit_info['amendment']}}" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">From</label>
                                <input type="text" name="from" value="{{$business_permit_info['amendment_from']}}" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">To</label>
                                <input type="text" name="to" class="form-control" value="{{$business_permit_info['amendment_to']}}" aria-required="true" aria-invalid-true="true">
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
                                <input type="text" name="previousOwner" value="{{$business_permit_info['prev_owner']}}" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">New Owner</label>
                                <input type="text" name="newOwner" value="{{$business_permit_info['new_owner']}}" class="form-control" aria-required="true"
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
                                    <input class="form-check-input" name="enjoyTaxIncentive" {{ $business_permit_info['is_enjoy_tax'] == 1  ? 'checked': '' }} type="checkbox" value="1"
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
                                <input type="text" name="taxIncentiveEntity" id="taxIncentiveEntity" value="{{  $business_permit_info['tax_entity'] }}" class="form-control" aria-required="true"
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
                                <input type="text" name="lastName" value="{{  $business_permit_info['tp_last_name'] }}"  class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">First Name</label>
                                <input type="text" name="firstName"  value="{{  $business_permit_info['tp_first_name'] }}" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Middle Name</label>
                                <input type="text" name="middleName"  value="{{  $business_permit_info['tp_middle_name'] }}" class="form-control" aria-required="true"
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
                                <input type="text" name="businessName" value="{{  $business_permit_info['business_name'] }}"  class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
        
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <select class="selectpicker w-100" name="civilStatus" data-style="select-with-transition"
                                    title="Civil Status">
                                    <option disabled selected>Civil Status</option>
                                    <option value="Married" {{ $business_permit_info['civil_status'] == 'Married'  ? 'selected': '' }}>Married</option>
                                    <option value="Windowed"  {{ $business_permit_info['civil_status'] == 'Windowed'  ? 'selected': '' }}>Windowed</option>
                                    <option value="Separated" {{ $business_permit_info['civil_status'] == 'Separated'  ? 'selected': '' }}>Separated</option>
                                    <option value="Divorced" {{ $business_permit_info['civil_status'] == 'Divorced'  ? 'selected': '' }}>Divorced</option>
                                    <option value="Single" {{ $business_permit_info['civil_status'] == 'Single'  ? 'selected': '' }}>Single</option>
                                </select>
                            </div>
                        </div>
        
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Company Represantative</label>
                                <input type="text" name="companyRepresentative" class="form-control" aria-required="true"
                                    aria-invalid-true="true" value="{{  $business_permit_info['company_rep'] }}">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
        
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Position</label>
                                <input type="text" name="position" class="form-control" aria-required="true"
                                    aria-invalid-true="true" value="{{  $business_permit_info['company_position'] }}">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
        
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Trade Name / Franchise</label>
                                <input type="text" name="tradeName" value="{{  $business_permit_info['trade_name'] }}" class="form-control" aria-required="true"
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
                                <input type="text" name="businessAddress" value="{{  $business_permit_info['business_address'] }}" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Postal Code</label>
                                <input type="number" max="2147483647" name="postalCode" value="{{  $business_permit_info['business_postal'] }}" class="form-control" aria-required="true"
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
                                <input type="email" name="email" value="{{  $business_permit_info['business_email'] }}" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Telephone No.</label>
                                <input type="text" name="tel" value="{{  $business_permit_info['business_tel'] }}" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Mobile No.</label>
                                <input type="text" name="mobile"  value="{{  $business_permit_info['business_mobile'] }}" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
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
                                <input type="text" name="ownersHomeAddress" value="{{  $business_permit_info['owner_address'] }}" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Postal Code</label>
                                <input type="number" max="2147483647" name="ownersPostalCode" value="{{  $business_permit_info['owner_postal'] }}" class="form-control" aria-required="true"
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
                                <input type="email" name="ownersEmail" value="{{  $business_permit_info['owner_email'] }}" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Telephone No.</label>
                                <input type="text" name="ownersTelNo" value="{{  $business_permit_info['owner_tel'] }}" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Mobile No.</label>
                                <input type="text" name="ownersMobileNo" value="{{  $business_permit_info['owner_mobile'] }}" class="form-control" aria-required="true"
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
                        <div class="col-sm-12 col-md-8">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Emergency Contact Name</label>
                                <input type="text" name="emergencyContactName" value="{{  $business_permit_info['emergency_contact'] }}" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Email</label>
                                <input type="email" name="emergencyEmail"  value="{{  $business_permit_info['emergency_email'] }}" class="form-control" aria-required="true"
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
                                <input type="text" name="emergencyTelNo" value="{{  $business_permit_info['emergency_tel'] }}" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Mobile No.</label>
                                <input type="text" name="emergencyMobileNo" value="{{  $business_permit_info['emergency_mobile'] }}" class="form-control" aria-required="true"
                                    aria-invalid-true="true">
                                <span class="material-input"></span>
                                <br>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Business Area (in sq.m.)</label>
                                <input type="number" max="2147483647" class="form-control" name ="business_area" value="{{  $business_permit_info['business_area'] }}" aria-required="true" aria-invalid-true="true">
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
                                        <input type="text" name="maleEmployeesInEstablishment" value="{{  $business_permit_info['male_in_establishments'] }}" class="form-control"
                                            aria-required="true" aria-invalid-true="true">
                                        <span class="material-input"></span>
                                        <br>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Female</label>
                                        <input type="text" name="femaleEmployeesInEstablishment" value="{{  $business_permit_info['female_in_establishments'] }}" class="form-control"
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
                                        <input type="text" name="maleEmployeesResidingWithinTheLGU" value="{{  $business_permit_info['male_in_lgu'] }}" class="form-control"
                                            aria-required="true" aria-invalid-true="true">
                                        <span class="material-input"></span>
                                        <br>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Female</label>
                                        <input type="text" name="femaleEmployeesResidingWithinTheLGU" value="{{  $business_permit_info['female_in_lgu'] }}" class="form-control"
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
                                    <input class="form-check-input" {{ $business_permit_info['is_business_rented'] == 1 ? 'checked': '' }} type="checkbox" name="rented" value="1"
                                        id="is_business_rented">
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
                                    <input type="text" name="lessorFullName" id ="lessorFullName" value="{{ $business_permit_info['lessor_name'] }}" class="form-control" aria-required="true"
                                        aria-invalid-true="true">
                                    <span class="material-input"></span>
                                    <br>
                                </div>
                            </div>
        
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Lessor's Full Address</label>
                                    <input type="text" name="lessorFullAddress" id="lessorFullAddress" value="{{ $business_permit_info['lessor_address'] }}" class="form-control" aria-required="true"
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
                                    <input type="text" name="lessorMobileNumber" id="lessorMobileNumber" value="{{ $business_permit_info['lessor_contact'] }}" class="form-control" aria-required="true"
                                        aria-invalid-true="true">
                                    <span class="material-input"></span>
                                    <br>
                                </div>
                            </div>
        
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Monthly Rental</label>
                                    <input type="text" name="monthlyRental"  id="monthlyRental"  value="{{ $business_permit_info['monthly_rental'] }}" class="form-control" aria-required="true"
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
                                <button type="button" class="btn btn-primary btn-sm" id="addBusinessActivity">
                                    <i class="material-icons">
                                    add
                                    </i>
                                </button>
                            </div>
                        </div>
                    </div>
        
                    <div id="businessActivitiesList">
                        @foreach ($businessActivities as $activities)
                              <div class="row">
                                      <div class="col-sm-12 col-md-4">
                                          <div class="form-group bmd-form-group">
                                          <label class="bmd-label-floating">Line of Business</label>
                                          <input type="text" name="lineOfBusines[]" value="{{ $activities['line_of_business'] }}" class="form-control" aria-required="true"
                                              aria-invalid-true="true">
                                          <span class="material-input"></span>
                                          <br>
                                          </div>
                                      </div>
              
                                      <div class="col-sm-12 col-md-4">
                                          <div class="form-group bmd-form-group">
                                          <label class="bmd-label-floating">Capitalization</label>
                                          <input type="number" max="2147483647" name="capitalization[]" value="{{ $activities['capitalization'] }}" class="form-control" aria-required="true"
                                              aria-invalid-true="true">
                                          <span class="material-input"></span>
                                          <br>
                                          </div>
                                      </div>
              
                                      <div class="col-sm-12 col-md-4">
                                          <div class="form-group bmd-form-group">
                                          <label class="bmd-label-floating">No. Of Units</label>
                                          <input type="number" max="2147483647" name="noOfUnits[]" value="{{ $activities['units'] }}" class="form-control" aria-required="true"
                                              aria-invalid-true="true">
                                          <span class="material-input"></span>
                                          <br>
                                          </div>
                                      </div>
                                  </div>
                        @endforeach
                    </div>
                </div>
        
            </div>
            <input type="hidden" name="permitId" id="permitId" value="{{  $business_permit_info['app_id'] }}">
            </form>
        </div>
        <div class="card steps-card">
            <div class="card-body mt-3">

                <div class="container-fluid">
                    <h5 class="info-text">Requirements</h5>
                </div>
            {{-- <div class="container-fluid mb-3">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class=" text-primary">
                                <th>
                                    #
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Description
                                </th>
                                <th>
                                    Location
                                </th>
                                <th>
                                    File
                                </th>
                                <th class="text-right">
                                    Action
                                </th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        1
                                    </td>
                                    <td>
                                        Dakota Rice
                                    </td>
                                    <td>
                                        Niger
                                    </td>
                                    <td>
                                        Oud-Turnhout
                                    </td>
                                    <td>
                                        File.pdf
                                    </td>
                                    <td class="text-right">
                                        <button class="btn btn-link p-2"><i class="material-icons">upload</i></button>
                                    </td>
                                <tr>
                                    <td>
                                        2
                                    </td>
                                    <td>
                                        Dakota Rice
                                    </td>
                                    <td>
                                        Niger
                                    </td>
                                    <td>
                                        Oud-Turnhout
                                    </td>
                                    <td>
                                        None
                                    </td>
                                    <td class="text-right">
                                        <button class="btn btn-link p-2"><i class="material-icons">upload</i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                
            </div> --}}

                <style>
                    .file-img {
                        position: relative;
                    }

                    .file-img:after {
                        content: "";
                        display: block;
                        padding-bottom: 100%;
                    }

                    .file-img img {
                        position: absolute;
                        top: 0;
                        left: 0;
                    }
                </style>

                <div class="row">
                    @foreach ($requirements as $reqKey => $req)
                        @if (isset($attachments))
                            @if (array_key_exists($reqKey, $attachments))
                                @php
                                    $fileInfo = explode('.', $attachments[$reqKey]);
                                @endphp
                                @if ($fileInfo[1] == 'pdf')
                                    @php
                                        $imgsrc = 'https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg';
                                    @endphp
                                @else
                                    @php
                                        $imgsrc = asset('uploads/requirements/'.$user_id.'/'.$attachments[$reqKey]);
                                    @endphp
                                @endif 
                                <div class="file-group mb-3 col-sm-6 col-md-4 upload-item">
                                    <div class="d-flex">
                                        <div class="col-4">
                                            <div class="file-img">
                                                <img src="{{ $imgsrc }}" alt="" style="object-fit: contain;" class="rounded requirements_img" width="100%" height="100%">
                                                <input type="file" name="{{ $reqKey }}" class="fileupload" id="{{ $reqKey }}" hidden>
                                            </div>
                                        </div>
                                        <div class="">
                                            <label for="" class="m-0">{{ $req['name'] }}</label><br>
                                            <a target="_blank" href="{{ asset('uploads/requirements/'.$user_id.'/'.$attachments[$reqKey]) }}" for="" class="text-primary m-0 btnUpload" data-filekey = "{{ $reqKey }}" data-url="{{ route('users.application.upload') }}" style="cursor: pointer;" data-toggle="popover" data-container="body" data-original-title="{{ $req['name'] }}" data-trigger="hover" data-content="{{$req['desc']}}" data-color="primary">
                                                {{-- <i class="fa fa-spinner fa-spin"></i> &nbsp; Uploading --}}
                                                View
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            @else

                                <div class="file-group mb-3 col-sm-6 col-md-4 upload-item">
                                    <div class="d-flex">
                                        <div class="col-4">
                                            <div class="file-img">
                                                <img src="https://via.placeholder.com/150" alt="" style="object-fit: contain;" class="rounded requirements_img" width="100%" height="100%">
                                                <input type="file" name="{{ $reqKey }}" class="fileupload" id="{{ $reqKey }}" hidden>
                                            </div>
                                        </div>
                                        <div class="">
                                            <label for="" class="m-0">{{ $req['name'] }}</label><br>
                                            <label for=""  class="text-default m-0 btnUpload" data-filekey = "{{ $reqKey }}" data-url="{{ route('users.application.upload') }}" style="cursor: pointer;" data-toggle="popover" data-container="body" data-original-title="{{ $req['name'] }}" data-trigger="hover" data-content="{{ $req['desc'] }}" data-color="primary">
                                                {{-- <i class="fa fa-spinner fa-spin"></i> &nbsp; Uploading --}}
                                                Not Submitted
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            @endif
                        @else
                            <div class="file-group mb-3 col-sm-6 col-md-4 upload-item">
                                <div class="d-flex">
                                    <div class="col-4">
                                        <div class="file-img">
                                            <img src="https://via.placeholder.com/150" alt="" style="object-fit: contain;" class="rounded requirements_img" width="100%" height="100%">
                                            <input type="file" name="{{ $reqKey }}" class="fileupload" id="{{ $reqKey }}" hidden>
                                        </div>
                                    </div>
                                    <div class="">
                                        <label for="" class="m-0">{{ $req['name'] }}</label><br>
                                        <label for="" class="text-primary m-0 btnUpload" style="cursor: pointer;" data-filekey = "{{ $reqKey }}" data-url="{{ route('users.application.upload') }}" data-toggle="popover" data-container="body" data-original-title="{{ $req['name'] }}" data-trigger="hover" data-content="{{ $req['desc'] }}" data-color="primary">
                                            {{-- <i class="fa fa-spinner fa-spin"></i> &nbsp; Uploading --}}
                                            View
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                   
                    
                </div>

    
            </div>
        </div>

        <div class="card steps-card" id="steptab4">
            <div class="card-body">
                <div class="container">
                    <h3 class="text-center">Verification</h3>
                    <form data-url="{{ route('admin.verify_application') }}" id="verify_form" method="POST">
                        @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <h5>Verification of Documents</h5>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <th>Description</th>
                                        <th>Office / Agency</th>
                                        <th class="text-center">Yes</th>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Not Needed</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Locational Clearance (for NEW/TRANSERS OF LOCATION)</td>
                                            <td>City Planning and Development Office</td>
                                            <td class="text-center"><input  class="rdio locational_clearance" {{ isset($verify_details) && $verify_details->locational_clearance == 1  ? 'checked': '' }} type="radio" value="1" name="locational_clearance" ></td>
                                            <td class="text-center"><input class="rdio locational_clearance" {{ isset($verify_details) && $verify_details->locational_clearance == 2  ? 'checked': '' }} type="radio" value="2" name="locational_clearance" ></td>
                                            <td class="text-center"><input class="rdio locational_clearance" {{ isset($verify_details) && $verify_details->locational_clearance == 3  ? 'checked': '' }} type="radio" value="3" name="locational_clearance" ></td>
                                        </tr>

                                        <tr>
                                            <td>Barangay Clearance (for New/Renewal)</td>
                                            <td>Barangay</td>
                                            <td class="text-center"><input  type="radio" class="rdio barangay_clearance"  {{ isset($verify_details) && $verify_details->barangay_clearance == 1  ? 'checked': '' }} value="1" name="barangay_clearance" ></td>
                                            <td class="text-center"><input type="radio" value="2" class="rdio barangay_clearance" {{ isset($verify_details) && $verify_details->barangay_clearance == 2  ? 'checked': '' }}  name="barangay_clearance" ></td>
                                            <td class="text-center"><input type="radio" value="3" class="rdio barangay_clearance" {{ isset($verify_details) && $verify_details->barangay_clearance == 3  ? 'checked': '' }}   name="barangay_clearance" ></td>
                                        </tr>

                                        <tr>
                                            <td>Occupancy Permit (For New)</td>
                                            <td>City Engineering Office</td>
                                            <td class="text-center"><input  type="radio" class="rdio occupancy_permit" {{ isset($verify_details) && $verify_details->occupancy_permit == 1  ? 'checked': '' }} value="1" name="occupancy_permit" ></td>
                                            <td class="text-center"><input type="radio" class="rdio occupancy_permit"  {{ isset($verify_details) && $verify_details->occupancy_permit == 2  ? 'checked': '' }} value="2" name="occupancy_permit" ></td>
                                            <td class="text-center"><input type="radio" class="rdio occupancy_permit"  {{ isset($verify_details) && $verify_details->occupancy_permit == 3  ? 'checked': '' }} value="3" name="occupancy_permit" ></td>
                                        </tr>

                                        <tr>
                                            <td>Sanitary Permit/Health Clearance</td>
                                            <td>City Health Office</td>
                                            <td class="text-center"><input  type="radio" value="1" class="rdio sanitary_permit" {{ isset($verify_details) && $verify_details->sanitary_permit == 1  ? 'checked': '' }}  name="sanitary_permit" ></td>
                                            <td class="text-center"><input type="radio" value="2" class="rdio sanitary_permit"  {{ isset($verify_details) && $verify_details->sanitary_permit == 2  ? 'checked': '' }} name="sanitary_permit" ></td>
                                            <td class="text-center"><input type="radio" value="3" class="rdio sanitary_permit"  {{ isset($verify_details) && $verify_details->sanitary_permit == 3  ? 'checked': '' }} name="sanitary_permit"></td>
                                        </tr>

                                        <tr>
                                            <td>City Environmental Certificate</td>
                                            <td>City Environment and Natural Resources Office</td>
                                            <td class="text-center"><input  type="radio" value="1" class="rdio city_environmental_certificate"  {{ isset($verify_details) && $verify_details->city_environmental_certificate == 1  ? 'checked': '' }} name="city_environmental_certificate" ></td>
                                            <td class="text-center"><input  type="radio" value="2" class="rdio city_environmental_certificate"  {{ isset($verify_details) && $verify_details->city_environmental_certificate == 2  ? 'checked': '' }} name="city_environmental_certificate" ></td>
                                            <td class="text-center"><input type="radio" value="3" class="rdio city_environmental_certificate" {{ isset($verify_details) && $verify_details->city_environmental_certificate == 3  ? 'checked': '' }} name="city_environmental_certificate" ></td>
                                        </tr>

                                        <tr>
                                            <td>Veterinary Clearance</td>
                                            <td>City Veterinary Clearance</td>
                                            <td class="text-center"><input  type="radio" value="1" class="rdio vet_clearance" {{ isset($verify_details) && $verify_details->vet_clearance == 1  ? 'checked': '' }} name="vet_clearance" ></td>
                                            <td class="text-center"><input type="radio" value="2" class="rdio vet_clearance" {{ isset($verify_details) && $verify_details->vet_clearance == 2  ? 'checked': '' }} name="vet_clearance" ></td>
                                            <td class="text-center"><input type="radio" value="3" class="rdio vet_clearance" {{ isset($verify_details) && $verify_details->vet_clearance == 3  ? 'checked': '' }} name="vet_clearance" ></td>
                                        </tr>

                                        <tr>
                                            <td>Market Clearance (For Stall Holders)</td>
                                            <td>Economic Enterprise Division (Public Market)</td>
                                            <td class="text-center"><input  type="radio" value="1" class="rdio market_clearance" {{ isset($verify_details) && $verify_details->market_clearance == 1  ? 'checked': '' }} name="market_clearance" ></td>
                                            <td class="text-center"><input type="radio" value="2"  class="rdio market_clearance" {{ isset($verify_details) && $verify_details->market_clearance == 2  ? 'checked': '' }}  name="market_clearance" ></td>
                                            <td class="text-center"><input type="radio" value="3"  class="rdio market_clearance" {{ isset($verify_details) && $verify_details->market_clearance == 3  ? 'checked': '' }} name="market_clearance" ></td>
                                        </tr>

                                        <tr>
                                            <td>Fire Safety Inspection Certificate</td>
                                            <td>
                                            </td>
                                            <td class="text-center"><input  type="radio" value="1" class="rdio fire_cert" {{ isset($verify_details) && $verify_details->fire_cert == 1  ? 'checked': '' }} name="fire_cert" ></td>
                                            <td class="text-center"><input type="radio" value="2" class="rdio fire_cert"  {{ isset($verify_details) && $verify_details->fire_cert == 2  ? 'checked': '' }} name="fire_cert" ></td>
                                            <td class="text-center"><input type="radio" value="3" class="rdio fire_cert"  {{ isset($verify_details) && $verify_details->fire_cert == 3  ? 'checked': '' }} name="fire_cert" ></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
    
                        </div>
                    </div>
                    <input type="hidden" name="permitId" value="{{ $id }}">
                    <div class="modal-footer">
                        <button type="submit" class="btn {{ $status_no > 3 || Auth::user()->user_group_id == 5 ? 'btn-disabled':  'btn-primary'}}" {{ $status_no > 3 ? 'disabled': ''}}>Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="card steps-card" id="steptab4">
            <div class="card-body">
                <div class="container">
                    <h3 class="text-center">History</h3>
                    <div class="history-btns">
                        <button class="history-btn btn btn-round btn-primary">User</button>
                        <button class="history-btn btn btn-round btn-secondary">Admin</button>
                    </div>
                    <div class="history-tabs">
                        <div class="history-tab active">
                            <div class="material-datatables">
                                <table id="usertable" class="table table-striped table-bordered table-hover"
                                    cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="history-tab">
                            <div class="material-datatables">
                                <table id="admintable" class="table table-striped table-bordered table-hover"
                                    cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-4 col-md-4">
        <div class="card">
            <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">sticky_note_2</i>
                </div>
                <h4 class="card-title">Details</h4>
            </div>
            <div class="card-body ">
                <div class="d-flex justify-content-between">
                    <div>
                        App ID
                    </div>
                    <div>
                        {{$id}}
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div>
                        Name
                    </div>
                    <div>
                       {{ $username}}
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div>
                        Status
                    </div>
                    <div>
                        {{ $app_status }}
                    </div>
                </div>
            </div>
        </div>
        @if (Auth::user()->user_group_id == 5)
        <div class="card ">
            <form action="post" data-url = "{{route('admin.applications.save_amount') }}" id="amount_form">
                @csrf
                <div class="card-header">   
                    <h4 class="card-title">Amount to pay</h4>
                </div>
                <div class="card-body">
                    <input type="number" class="form-control" value="{{ $amount != null ? $amount: ''}}" name="amount" id="amount"placeholder="input the amount here">
                </div>
                <input type="hidden" name="amount_app_id" value="{{ $id }}">
                <div class="card-footer justify-content-end">   
                    <button type="submit"   class="btn btn-primary btn-md">Save</button>
                </div>
            </form>
        </div>
        @endif
        
        <div class="card ">
            <form action="post" data-url = "{{route('admin.applications.save_notes') }}" id="note_form">
                @csrf
                <div class="card-header">
                    <h4 class="card-title">Notes</h4>
                </div>
                <div class="card-body">
                    <textarea name="notes"  {{  $status_no  < 2 ? 'disabled': ''}}   class="form-control" id="notes" rows="10" placeholder="Input your notes here....">{{ $notes != null ? $notes: ''}}</textarea>
                </div>
                <input type="hidden" name="note_app_id" value="{{ $id }}">
                <div class="card-footer justify-content-end">   
                    <button type="submit"   class="btn btn-primary btn-md">Save Notes</button>
                </div>
            </form>
        </div>
        <div class="card ">
            <div class="card-header">
                <h4 class="card-title">Actions</h4>
            </div>
            <div class="card-body">
              
                {{-- <button class="btn btn-primary w-100" id="btnSave">Save</button> --}}
                {{-- <button class="btn btn-rose w-100" id="changeStatus">Change Status</button> --}}
                <button class="btn btn-danger w-100" data-url = '{{ route('admin.applications.delete_application') }}' id="deleteApplication">Delete</button>
            </div>
        </div>
       
    </div>
</div> 
@endif


{{-- Change status --}}
<!-- Modal -->
<div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form data-url="{{ route('admin.change_status') }}" method="post" id="change_status_form">
            @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="changeStatusModalLabel">Change Application Status</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <select class="selectpicker w-100" name="application_status" data-style="select-with-transition" title="Change Status">
                <option disabled selected>Change Status</option>
                <option value="2">Pending</option>
                <option value="3">Verified</option>
                <option value="4">Waiting for Payment</option>
                <option value="5">Processing</option>
                <option value="6">Completed</option>
                <option value="7">Rejected</option>
            </select>
        </div>
        <input type="hidden" name ="permitId" value="{{ $id }}">
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>

@endsection


@section('scripts')
<script>
    $(document).ready(function(e){


        var usergroup = "{{ Auth::user()->user_group_id }}"
        console.log(usergroup);
        if (usergroup == 5) {
            $('#verify_form input').attr('disabled', 'disabled');
        }

        $('#updateBusiness input').attr('readonly', 'readonly');
        $('#updateBusiness input[type="checkbox"]').attr('disabled', 'disabled');
        $('#updateBusiness select').attr('disabled', 'disabled');
        $('#updateBusiness button').attr('disabled', 'disabled');
        $('.btnUpload').attr('disabled', 'disabled');
        $('#btnDraft').hide();
        $('#btnSubmitApp').hide();

        if ($('#permitType').val() == 'New') {
            $('#renewalInputs input').attr('disabled', 'disabled');
            $('#amendmentDiv input').attr('disabled', 'disabled');
            $('#ownershipDiv input').attr('disabled', 'disabled');
            $('#enjoyTaxDiv input').attr('disabled', 'disabled');
        }

        // enjoy tax
        if ($('#is_enjoy_tax').is(':checked')) {
            $('#yes_enjoy_tax').show();
        }else{
            $('#yes_enjoy_tax').hide();
        }

            // business rented

        if ($('#is_business_rented').is(':checked')) {
        
            $('#lessor_info').show();
        }else{
            
            $('#lessor_info').hide();
        }
    });
    




    $('#verify_form').submit(function(e){
        e.preventDefault();
        
        if ($('.locational_clearance').is(':checked') == false || $('.occupancy_permit').is(':checked') == false ||  $('.barangay_clearance').is(':checked') == false ||   $('.sanitary_permit').is(':checked') == false || $('.city_environmental_certificate').is(':checked') == false || $('.vet_clearance').is(':checked') == false ||  $('.market_clearance').is(':checked') == false ||  $('.fire_cert').is(':checked') == false) {
            Swal.fire(
                'Failed!',
                'Plesse fill up all inputs',
                'error'
            );
            return false;
        }
        


        var action = $(this).data('url');
        var data = $(this).serialize();

        ajaxPost(action,data,actionResult );

    });

    $('#deleteApplication').click(function(){
        console.log(1);
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
                var action = $(this).data('url');
                let token   = $('meta[name="csrf-token"]').attr('content');
                var id = $('#permitId').val();
                
                var data = {
                    _token : token,
                    id : id
                }
                var deleteApplication = ajaxPost(action,data,actionResult);
            }
        })
     
        
      
    });

    $('#change_status_form').submit(function(e){
        e.preventDefault();
        var action = $(this).data('url');
        var data = $(this).serialize();

        ajaxPost(action,data,changeStatusResult );

    });


    function changeStatusResult(response) {
        if(response.status == false){
            Swal.fire(
                'Failed!',
                response.msg,
                'error'
            ).then((result) => {
                return;
            });
        }else{
            Swal.fire(
                'Success!',
                response.msg,
                'success'
            ).then((result) => {
                window.location.href = '/admin/applications';
            });
        }
    }


    function actionResult(response) {
        if(response.status == false){
            Swal.fire(
                'Failed!',
                response.msg,
                'error'
            ).then((result) => {
                return;
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
    }
    $('#btnVerify').click(function(){
        var status_no = '{{ $status_no }}';

        if (status_no < 2) {
            Swal.fire(
                'Not available!',
                'application is in DRAFT status',
                'error'
            );
            return;
        }else{
            $('#verifyModal').modal('show');
        }
    });

    $('#changeStatus').click(function(){
        var status_no = '{{ $status_no }}';

        if (status_no < 2) {
            Swal.fire(
                'Not available!',
                'application is in DRAFT status',
                'error'
            );
            return;
        }else{
            $('#changeStatusModal').modal('show');
        }
    });

    $('#note_form').submit(function(e){
        e.preventDefault();
        var status_no = '{{ $status_no }}';
      
      
        if (status_no < 2) {
            console.log(1);
            Swal.fire(
                'Not available!',
                'application is in DRAFT status',
                'error'
            );
            return;
        }
        
        if ($('#notes').val() == '') {
            Swal.fire(
                'Failed!',
                'Notes can\'t be blank',
                'error'
            );
            return false;
        }
        var action = $(this).data('url');
        var data = $(this).serialize();
        
        ajaxPost(action,data,noteResult );
    });

    $('#amount_form').submit(function(e){
        e.preventDefault();
       
        if ($('#amount').val() == '') {
            Swal.fire(
                'Failed!',
                'Notes can\'t be blank',
                'error'
            );
            return false;
        }
        var action = $(this).data('url');
        var data = $(this).serialize();
        
        ajaxPost(action,data,changeStatusResult );
    });

    function noteResult(response){
        if(response.status == false){
            Swal.fire(
                'Failed!',
                response.msg,
                'error'
            );
            return false;
        }else{
            Swal.fire(
                'Success!',
                response.msg,
                'success'
            ).then((result) => {
                location.reload();
            });
        }
    }





     
</script>


<script>
    $(document).ready(e => {
        $('#steptab1').addClass('active');

        $('#requirementstable').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
            }
        });
        $('#usertable').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
            }
        });
        $('#admintable').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
            }
        });
    });

    $('.steps-btn').click(function (e) {
        var selected = $(this).index();

        $('.steps-btn').removeClass('btn-primary');
        $('.steps-btn').addClass('btn-secondary');
        $('.steps-btn:eq('+selected+')').removeClass('btn-secondary');
        $('.steps-btn:eq('+selected+')').addClass('btn-primary');

        $('.steps-card').removeClass('active');
        $('.steps-card:eq('+selected+')').addClass('active');
    });

    $('.history-btn').click(function (e) {
        var selected = $(this).index();

        $('.history-btn').removeClass('btn-primary');
        $('.history-btn').addClass('btn-secondary');
        $('.history-btn:eq('+selected+')').removeClass('btn-secondary');
        $('.history-btn:eq('+selected+')').addClass('btn-primary');

        $('.history-tab').removeClass('active');
        $('.history-tab:eq('+selected+')').addClass('active');
    });

    $('.rdio').click(function (e) {

        e.preventDefault();

        console.log($(this).attr('checked'));
        var name = $(this).attr('name');

        if ($(this).attr('checked') != null){
            console.log('uncheck this');
            setTimeout(() => {
                $(`.rdio[name=${name}]`).prop('checked', false);
                $(`.rdio[name=${name}]`).removeAttr('checked');
            }, 100);
        } else {
            console.log('check this');
            setTimeout(() => {
                $(this).prop('checked', true);
                $(this).attr('checked', 'checked');
            }, 100);
        }

    });
</script>
@endsection