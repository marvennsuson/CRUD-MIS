@extends('layouts.users')

@section('header')
{{-- Application ID - {{$data['id']}} --}}
@endsection

@section('content')
@if ($data['type'] == 1)
@php
$businessActivities = json_decode($data['business_permit_info']['business_activities'], true);
@endphp

<style>
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


<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex container-fluid justify-content-between mb-3">
                    <h4 class="card-title">
                        {{ $data['app_type'] }}
                    </h4>
                    <h4 class="">Step 1 - 3</h4>
                </div>
                <div class="d-flex pl-4" role="group" aria-label="Basic example">
                    <button type="button" class="steps-btn font-weight-bold btn-round btn btn-primary">Form</button>
                    <button type="button" class="steps-btn font-weight-bold btn-round btn btn-secondary">Requirements</button>
                    <button type="button" id="history_tab" class="steps-btn font-weight-bold btn-round btn btn-secondary">History</button>
                    {{-- <button type="button" class="steps-btn font-weight-bold btn btn-secondary col">Miscellaneous</button> --}}
                </div>
                <div class="steps-card" id="steptab1">
                    <form data-url="" id="updateBusiness" method="post">
                        @csrf
                        <div class="card-body">
                            <h5 class="info-text">Basic Information</h5>
                                <div class="row" style="margin-bottom:50px;">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <select class="selectpicker w-100" disabled="disabled" name="permitType"
                                                id="permitType" title="Choose Permit Type" data-style="select-with-transition"
                                                id="">
                                                <option disabled>Choose Permit Type</option>
                                                <option value="New"
                                                    {{ $data['business_permit_info']['permit_type'] == 'New'  ? 'selected': '' }}>
                                                    New </option>
                                                <option value="Renewal"
                                                    {{ $data['business_permit_info']['permit_type'] == 'Renewal'  ? 'selected': '' }}>
                                                    Renewal</option>
                                                <option value="Transfer of Business Location"
                                                    {{ $data['business_permit_info']['permit_type'] == 'Transfer of Business Location'  ? 'selected': '' }}>
                                                    Transfer of Business Location</option>
                                                <option value="Transfer of Business Ownership"
                                                    {{ $data['business_permit_info']['permit_type'] == 'Transfer of Business Ownership'  ? 'selected': '' }}>
                                                    Transfer of Business Ownership</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <select class="selectpicker w-100" name="modeOfPayment"
                                                title="Choose Mode of Payment" data-style="select-with-transition" id="">
                                                <option disabled>Choose Mode of Payment</option>
                                                <option value="Annually"
                                                    {{ $data['business_permit_info']['mode_of_payment'] == 'Annually'  ? 'selected': '' }}>
                                                    Annually </option>
                                                <option value="Semi-Annually"
                                                    {{ $data['business_permit_info']['mode_of_payment'] == 'Semi-Annually'  ? 'selected': '' }}>
                                                    Semi-Annually</option>
                                                <option value="Quarterly"
                                                    {{ $data['business_permit_info']['mode_of_payment'] == 'Quarterly'  ? 'selected': '' }}>
                                                    Quarterly</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <select class="selectpicker w-100" name="typeOfBusiness" title="Type of Business"
                                                data-style="select-with-transition" id="">
                                                <option disabled>Type of Business</option>
                                                <option value="Sole Proprietorship"
                                                    {{ $data['business_permit_info']['business_type'] == 'Sole Proprietorship'  ? 'selected': '' }}>
                                                    Sole Proprietorship </option>
                                                <option value="Partnership"
                                                    {{ $data['business_permit_info']['business_type'] == 'Partnership'  ? 'selected': '' }}>
                                                    Partnership</option>
                                                <option value="Corporation"
                                                    {{ $data['business_permit_info']['business_type'] == 'Corporation'  ? 'selected': '' }}>
                                                    Corporation</option>
                                                <option value="Cooperative"
                                                    {{ $data['business_permit_info']['business_type'] == 'Cooperative'  ? 'selected': '' }}>
                                                    Cooperative</option>
                                            </select>
                                        </div>
                                    </div>
        
                                </div>
        
                                <div class="row" id="renewalInputs">
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-group label-floating">
                                            <label class="bmd-label-floating">Date of Application</label>
                                            <input type="text" name="date_of_application" class="form-control datepicker"
                                                value="{{ date('m/d/Y', strtotime($data['business_permit_info']['application_date'])) }}">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-5">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">DTI/SEC/CDA/ Registration No.</label>
                                            <input type="text" name="dti" id="dti"
                                                value="{{$data['business_permit_info']['registration_no']}}"
                                                class="form-control" aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">TIN NO.</label>
                                            <input type="text" name="tin" id="tin"
                                                value="{{$data['business_permit_info']['tin_no']}}" class="form-control"
                                                aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                </div>
        
        
                                <div class="row" id="amendmentDiv">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Amendment</label>
                                            <input type="text" name="amendment"
                                                value="{{$data['business_permit_info']['amendment']}}" class="form-control"
                                                aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">From</label>
                                            <input type="text" name="from"
                                                value="{{$data['business_permit_info']['amendment_from']}}" class="form-control"
                                                aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">To</label>
                                            <input type="text" name="to" class="form-control"
                                                value="{{$data['business_permit_info']['amendment_to']}}" aria-required="true"
                                                aria-invalid-true="true">
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
                                            <input type="text" name="previousOwner"
                                                value="{{$data['business_permit_info']['prev_owner']}}" class="form-control"
                                                aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">New Owner</label>
                                            <input type="text" name="newOwner"
                                                value="{{$data['business_permit_info']['new_owner']}}" class="form-control"
                                                aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="row" id="enjoyTaxDiv">
                                    <div class="col-md-6 mb-1">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" name="enjoyTaxIncentive"
                                                    {{ $data['business_permit_info']['is_enjoy_tax'] == 1  ? 'checked': '' }}
                                                    type="checkbox" value="1" id="is_enjoy_tax">
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
                                            <input type="text" name="taxIncentiveEntity" id="taxIncentiveEntity"
                                                value="{{  $data['business_permit_info']['tax_entity'] }}" class="form-control"
                                                aria-required="true" aria-invalid-true="true">
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
                                            <input type="text" name="lastName"
                                                value="{{  $data['business_permit_info']['tp_last_name'] }}"
                                                class="form-control" aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">First Name</label>
                                            <input type="text" name="firstName"
                                                value="{{  $data['business_permit_info']['tp_first_name'] }}"
                                                class="form-control" aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Middle Name</label>
                                            <input type="text" name="middleName"
                                                value="{{  $data['business_permit_info']['tp_middle_name'] }}"
                                                class="form-control" aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-8">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Business Name</label>
                                            <input type="text" name="businessName"
                                                value="{{  $data['business_permit_info']['business_name'] }}"
                                                class="form-control" aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
        
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <select class="selectpicker w-100" name="civilStatus"
                                                data-style="select-with-transition" title="Civil Status">
                                                <option disabled selected>Civil Status</option>
                                                <option value="Married"
                                                    {{ $data['business_permit_info']['civil_status'] == 'Married'  ? 'selected': '' }}>
                                                    Married</option>
                                                <option value="Windowed"
                                                    {{ $data['business_permit_info']['civil_status'] == 'Widowed'  ? 'selected': '' }}>
                                                    Windowed</option>
                                                <option value="Separated"
                                                    {{ $data['business_permit_info']['civil_status'] == 'Separated'  ? 'selected': '' }}>
                                                    Separated</option>
                                                <option value="Divorced"
                                                    {{ $data['business_permit_info']['civil_status'] == 'Divorced'  ? 'selected': '' }}>
                                                    Divorced</option>
                                                <option value="Single"
                                                    {{ $data['business_permit_info']['civil_status'] == 'Single'  ? 'selected': '' }}>
                                                    Single</option>
                                            </select>
                                        </div>
                                    </div>
        
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Company Represantative</label>
                                            <input type="text" name="companyRepresentative" class="form-control"
                                                aria-required="true" aria-invalid-true="true"
                                                value="{{  $data['business_permit_info']['company_rep'] }}">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
        
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Position</label>
                                            <input type="text" name="position" class="form-control" aria-required="true"
                                                aria-invalid-true="true"
                                                value="{{  $data['business_permit_info']['company_position'] }}">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
        
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Trade Name / Franchise</label>
                                            <input type="text" name="tradeName"
                                                value="{{  $data['business_permit_info']['trade_name'] }}" class="form-control"
                                                aria-required="true" aria-invalid-true="true">
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
                                            <input type="text" name="businessAddress"
                                                value="{{  $data['business_permit_info']['business_address'] }}"
                                                class="form-control" aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Postal Code</label>
                                            <input type="number" name="postalCode" max="2147483647"
                                                value="{{  $data['business_permit_info']['business_postal'] }}"
                                                class="form-control" aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Email</label>
                                            <input type="email" name="email"
                                                value="{{  $data['business_permit_info']['business_email'] }}"
                                                class="form-control" aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Telephone No.</label>
                                            <input type="text" name="tel"
                                                value="{{  $data['business_permit_info']['business_tel'] }}"
                                                class="form-control" aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Mobile No.</label>
                                            <input type="text" name="mobile"
                                                value="{{  $data['business_permit_info']['business_mobile'] }}"
                                                class="form-control" aria-required="true" aria-invalid-true="true">
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
                                            <input type="text" name="ownersHomeAddress"
                                                value="{{  $data['business_permit_info']['owner_address'] }}"
                                                class="form-control" aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Postal Code</label>
                                            <input type="number" max="2147483647" name="ownersPostalCode"
                                                value="{{  $data['business_permit_info']['owner_postal'] }}"
                                                class="form-control" aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Email</label>
                                            <input type="email" name="ownersEmail"
                                                value="{{  $data['business_permit_info']['owner_email'] }}" class="form-control"
                                                aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Telephone No.</label>
                                            <input type="text" name="ownersTelNo"
                                                value="{{  $data['business_permit_info']['owner_tel'] }}" class="form-control"
                                                aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Mobile No.</label>
                                            <input type="text" name="ownersMobileNo"
                                                value="{{  $data['business_permit_info']['owner_mobile'] }}"
                                                class="form-control" aria-required="true" aria-invalid-true="true">
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
                                            <input type="text" name="emergencyContactName"
                                                value="{{  $data['business_permit_info']['emergency_contact'] }}"
                                                class="form-control" aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Email</label>
                                            <input type="email" name="emergencyEmail"
                                                value="{{  $data['business_permit_info']['emergency_email'] }}"
                                                class="form-control" aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="row">
        
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Telephone No.</label>
                                            <input type="text" name="emergencyTelNo"
                                                value="{{  $data['business_permit_info']['emergency_tel'] }}"
                                                class="form-control" aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Mobile No.</label>
                                            <input type="text" name="emergencyMobileNo"
                                                value="{{  $data['business_permit_info']['emergency_mobile'] }}"
                                                class="form-control" aria-required="true" aria-invalid-true="true">
                                            <span class="material-input"></span>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Business Area (in sq.m.)</label>
                                            <input type="number" class="form-control" max="2147483647" name="business_area"
                                                value="{{  $data['business_permit_info']['business_area'] }}"
                                                aria-required="true" aria-invalid-true="true">
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
                                                    <input type="text" name="maleEmployeesInEstablishment"
                                                        value="{{  $data['business_permit_info']['male_in_establishments'] }}"
                                                        class="form-control" aria-required="true" aria-invalid-true="true">
                                                    <span class="material-input"></span>
                                                    <br>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group bmd-form-group">
                                                    <label class="bmd-label-floating">Female</label>
                                                    <input type="text" name="femaleEmployeesInEstablishment"
                                                        value="{{  $data['business_permit_info']['female_in_establishments'] }}"
                                                        class="form-control" aria-required="true" aria-invalid-true="true">
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
                                                    <input type="text" name="maleEmployeesResidingWithinTheLGU"
                                                        value="{{  $data['business_permit_info']['male_in_lgu'] }}"
                                                        class="form-control" aria-required="true" aria-invalid-true="true">
                                                    <span class="material-input"></span>
                                                    <br>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group bmd-form-group">
                                                    <label class="bmd-label-floating">Female</label>
                                                    <input type="text" name="femaleEmployeesResidingWithinTheLGU"
                                                        value="{{  $data['business_permit_info']['female_in_lgu'] }}"
                                                        class="form-control" aria-required="true" aria-invalid-true="true">
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
                                                <input class="form-check-input"
                                                    {{ $data['business_permit_info']['is_business_rented'] == 1 ? 'checked': '' }}
                                                    type="checkbox" name="rented" value="1" id="is_business_rented">
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
                                                <input type="text" name="lessorFullName" id="lessorFullName"
                                                    value="{{ $data['business_permit_info']['lessor_name'] }}"
                                                    class="form-control" aria-required="true" aria-invalid-true="true">
                                                <span class="material-input"></span>
                                                <br>
                                            </div>
                                        </div>
        
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Lessor's Full Address</label>
                                                <input type="text" name="lessorFullAddress" id="lessorFullAddress"
                                                    value="{{ $data['business_permit_info']['lessor_address'] }}"
                                                    class="form-control" aria-required="true" aria-invalid-true="true">
                                                <span class="material-input"></span>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Lessor's Full Telephone/Mobile No.</label>
                                                <input type="text" name="lessorMobileNumber" id="lessorMobileNumber"
                                                    value="{{ $data['business_permit_info']['lessor_contact'] }}"
                                                    class="form-control" aria-required="true" aria-invalid-true="true">
                                                <span class="material-input"></span>
                                                <br>
                                            </div>
                                        </div>
        
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Monthly Rental</label>
                                                <input type="text" name="monthlyRental" id="monthlyRental"
                                                    value="{{ $data['business_permit_info']['monthly_rental'] }}"
                                                    class="form-control" aria-required="true" aria-invalid-true="true">
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
                                                <input type="text" name="lineOfBusines[]"
                                                    value="{{ $activities['line_of_business'] }}" class="form-control"
                                                    aria-required="true" aria-invalid-true="true">
                                                <span class="material-input"></span>
                                                <br>
                                            </div>
                                        </div>
        
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Capitalization</label>
                                                <input type="number" name="capitalization[]" max="2147483647"
                                                    value="{{ $activities['capitalization'] }}" class="form-control"
                                                    aria-required="true" aria-invalid-true="true">
                                                <span class="material-input"></span>
                                                <br>
                                            </div>
                                        </div>
        
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">No. Of Units</label>
                                                <input type="number" name="noOfUnits[]" max="2147483647"
                                                    value="{{ $activities['units'] }}" class="form-control" aria-required="true"
                                                    aria-invalid-true="true">
                                                <span class="material-input"></span>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    {{-- <div class="card">
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
                                </div> --}}
                                </div>
        
                        </div>
                        <input type="hidden" name="permitId" id="permitId"
                            value="{{  $data['business_permit_info']['app_id'] }}">
                    </form>
                </div>
        
        
                <div class="steps-card" id="steptab2">
                    <div class="d-flex container-fluid justify-content-end">
                        <h4 class="">Step 4</h4>
                    </div>
                    <div class="container-fluid">
                        <h4 class="text-center">Requirements</h4>
                    </div>
                    {{-- <div class="container-fluid">
                        <h5 class="info-text">Requirements</h5>
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
                        @foreach ($data['requirements'] as $reqKey => $req)
                        @if (isset($data['attachments']))
                        @if (array_key_exists($reqKey, $data['attachments']))
                        @php
                        $fileInfo = explode('.', $data['attachments'][$reqKey]);
                        @endphp
                        @if ($fileInfo[1] == 'pdf')
                        @php
                        $imgsrc = 'https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg';
                        @endphp
                        @else
                        @php
                        $imgsrc =
                        asset('uploads/requirements/'.Auth::guard('resident')->user()->id.'/'.$data['attachments'][$reqKey]);
                        @endphp
                        @endif
                        <div class="file-group mb-3 col-sm-6 col-md-4 upload-item">
                            <div class="d-flex">
                                <div class="col-4">
                                    <div class="file-img">
                                        <img src="{{ $imgsrc }}" alt="" style="object-fit: contain;"
                                            class="rounded requirements_img" width="100%" height="100%">
                                        <input type="file" name="{{ $reqKey }}" class="fileupload" id="{{ $reqKey }}"
                                            hidden>
                                    </div>
                                </div>
                                <div class="">
                                    <label for="" class="m-0">{{ $req['name'] }}</label><br>
                                    <label for="" class="text-primary m-0 btnUpload" data-filekey="{{ $reqKey }}"
                                        data-url="{{ route('users.application.upload') }}" style="cursor: pointer;"
                                        data-toggle="popover" data-container="body" data-original-title="{{ $req['name'] }}"
                                        data-trigger="hover" data-content="{{$req['desc']}}" data-color="primary">
                                        {{-- <i class="fa fa-spinner fa-spin"></i> &nbsp; Uploading --}}
                                        Browse
                                    </label>
                                </div>
                            </div>
                        </div>
    
                        @else
    
                        <div class="file-group mb-3 col-sm-6 col-md-4 upload-item">
                            <div class="d-flex">
                                <div class="col-4">
                                    <div class="file-img">
                                        <img src="https://via.placeholder.com/150" alt="" style="object-fit: contain;"
                                            class="rounded requirements_img" width="100%" height="100%">
                                        <input type="file" name="{{ $reqKey }}" class="fileupload" id="{{ $reqKey }}"
                                            hidden>
                                    </div>
                                </div>
                                <div class="">
                                    <label for="" class="m-0">{{ $req['name'] }}</label><br>
                                    <label for="" class="text-primary m-0 btnUpload" data-filekey="{{ $reqKey }}"
                                        data-url="{{ route('users.application.upload') }}" style="cursor: pointer;"
                                        data-toggle="popover" data-container="body" data-original-title="{{ $req['name'] }}"
                                        data-trigger="hover" data-content="{{ $req['desc'] }}" data-color="primary">
                                        {{-- <i class="fa fa-spinner fa-spin"></i> &nbsp; Uploading --}}
                                        Browse
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
                                        <img src="https://via.placeholder.com/150" alt="" style="object-fit: contain;"
                                            class="rounded requirements_img" width="100%" height="100%">
                                        <input type="file" name="{{ $reqKey }}" class="fileupload" id="{{ $reqKey }}"
                                            hidden>
                                    </div>
                                </div>
                                <div class="">
                                    <label for="" class="m-0">{{ $req['name'] }}</label><br>
                                    <label for="" class="text-primary m-0 btnUpload" style="cursor: pointer;"
                                        data-filekey="{{ $reqKey }}" data-url="{{ route('users.application.upload') }}"
                                        data-toggle="popover" data-container="body" data-original-title="{{ $req['name'] }}"
                                        data-trigger="hover" data-content="{{ $req['desc'] }}" data-color="primary">
                                        {{-- <i class="fa fa-spinner fa-spin"></i> &nbsp; Uploading --}}
                                        Browse
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
    
    
                    </div>
                </div>
        
        
                <div class="steps-card" id="steptab3">
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
        
                <div class="steps-card" id="steptab4">
                    <div class="card-body">
                        <div class="container">
                            <h3 class="text-center">Miscellaneous</h3>
        
        
                            <div class="row">
        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

    </div>




    <div class="col-lg-4">
        <div class="card">
            <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">sticky_note_2</i>
                </div>
                <h4 class="card-title">Details</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        App ID
                    </div>
                    <div>
                        {{ $data['business_permit_info']['app_id'] }}
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div>
                        Status
                    </div>
                    <div>
                        {{ $data['app_status'] }}
                    </div>
                </div>
            </div>
        </div>
        @if ($data['status_no'] == 4)
        <div class="card ">
            <div class="card-header">
                <h4 class="card-title">Amount to pay</h4>
            </div>
            <div class="card-body">
                <h5>&#8369;{{$data['amount'] != null ? number_format($data['amount'],2): 0.00}}</h5>
            </div>

        </div>
        @endif

        <div class="card ">
            <form action="post" data-url="{{route('users.application.save_notes') }}" id="note_form">
                @csrf
                <div class="card-header">
                    <h4 class="card-title">Notes</h4>
                </div>
                <div class="card-body">
                    <textarea name="notes" class="form-control" id="notes" rows="10"
                        placeholder="Input your notes here....">{{ $data['user_notes'] }}</textarea>
                </div>
                <input type="hidden" name="note_app_id" value="{{ $data['id'] }}">
                <div class="card-footer justify-content-end">
                    <button type="submit" class="btn btn-primary btn-md">Save Notes</button>
                </div>
            </form>
        </div>

        <div class="card ">
            <div class="card-header">
                <h4 class="card-title">Actions</h4>
            </div>
            <div class="card-body">
                <button class="btn btn-rose w-100 {{ $data['status_no'] > 1 ? 'd-none': '' }}" type="button"
                    id="btnSubmitApp" data-url='{{ route('users.application.submit_application') }}'>Submit
                    Application</button>
                <button class="btn btn-info w-100 {{ $data['status_no'] > 1 ? 'd-none': '' }}" type="button"
                    id="btnDraft" data-url='{{ route('users.application.save_draft') }}'>Save Draft</button>
                <button class="btn btn-danger w-100" data-url='{{ route('users.application.delete_application') }}'
                    id="btnDelete">Delete</button>
            </div>
        </div>
    </div>

</div>

@endif


<style>
    .upload-item {
        padding-bottom: 30px;
        position: relative;
    }

    .filebtnlabel {
        position: absolute;
        bottom: 0;
        width: 90%;
        left: 50%;
        transform: translateX(-50%);
    }
</style>
@endsection


@section('scripts')
<script>
    let wizvalidator = {
      permitType: {
        required  :  true
      },
      modeOfPayment: {
        required  :  true
      },
      typeOfBusiness: {
        required  :  true
      },
      lastName: {
        required: true,
      },
      firstName: {
        required: true,
      },
      middleName: {
        required: true,
      },
      businessName: {
        required: true,
      },
      civilStatus: {
        required: true,
      },
      companyRepresentative: {
        required: true,
      },
      position: {
        required: true,
      },
      tradeName: {
        required: true,
      },
      businessAddress: {
        required: true,
      },
      postalCode: {
        required: true,
      },
      email: {
        required: true,
      },
      tel: {
        required: true,
      },
      mobile: {
        required: true,
      },
      ownersHomeAddress: {
        required: true,
      },
      ownersPostalCode: {
        required: true,
      },
      ownersEmail: {
        required: true,
        email: true
      },
      ownersTelNo: {
        required: true,
      },
      ownersMobileNo: {
        required: true,
      },
      emergencyContactName: {
        required: true,
      },
      emergencyEmail: {
        email: true,
        required: true,
      },
      emergencyTelNo: {
        required: true,
      },
      emergencyMobileNo: {
        required: true,
      },
      maleEmployeesInEstablishment: {
        required: true,
      },
      femaleEmployeesInEstablishment: {
        required: true,
      },
      maleEmployeesResidingWithinTheLGU: {
        required: true,
      },
      femaleEmployeesResidingWithinTheLGU: {
        required: true,
      },
      business_area:{
        required:true,
      },
      "lineOfBusines[]": "required",
      "capitalization[]": "required",
      "noOfUnits[]": "required",
    }
    

    var $validator = $('#updateBusiness').validate({
      rules: wizvalidator,

      highlight: function(element) {
        $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
      },
      success: function(element) {
        $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
      },
      errorPlacement: function(error, element) {
        $(element).append(error);
      }
    });

   
    $(document).ready(function() {
        // demo.initUpdateBusinessPermit();
        md.initFormExtendedDatetimepickers();
        var status = '{{ $data["status_no"] }}';

        if (status > 1) {
            $('#updateBusiness input').attr('readonly', 'readonly');
            $('#updateBusiness input[type="checkbox"]').attr('disabled', 'disabled');
            $('#updateBusiness select').attr('disabled', 'disabled');
            $('#updateBusiness button').attr('disabled', 'disabled');
            // $('.btnUpload').attr('disabled', 'disabled');
            
            
        }
        // permit type rules
        if ($('#permitType').val() == 'New') {
            $('#tin').rules('remove');
            $('#dti').rules('remove');
            $('#renewalInputs input').attr('disabled', 'disabled');
            $('#amendmentDiv input').attr('disabled', 'disabled');
            $('#ownershipDiv input').attr('disabled', 'disabled');
            $('#enjoyTaxDiv input').attr('disabled', 'disabled');
      
        }else if($('#permitType').val() == 'Transfer of Business Ownership'){
            $('#previousOwner').rules('add', {  required: true })
            $('#newOwner').rules('add', {  required: true })
            $('#tin').rules('add', { required: true});
            $('#dti').rules('add', { required: true});
        }
        else if ($('#permitType').val() == 'Renewal'){
            $('#tin').rules('add', { required: true});
            $('#dti').rules('add', { required: true});
            $('#renewalInputs').show();
        }else{
            $('#tin').rules('add', { required: true});
            $('#dti').rules('add', { required: true});
        }


        // enjoy tax
        if ($('#is_enjoy_tax').is(':checked')) {
            $('#taxIncentiveEntity').rules('add', { required: true});
            $('#yes_enjoy_tax').show();
        }else{
            $('#taxIncentiveEntity').rules('remove');
            $('#yes_enjoy_tax').hide();
        }

        // business rented

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

    $(document).on('click', '.btnUpload', function () {
        $(this).closest('.upload-item').find('.fileupload').click();    
    });

    $(document).on('change', '.fileupload', function(){
        
        $(this).closest('.upload-item').find('.btnUpload').html('<i class="fa fa-spinner fa-spin"></i> &nbsp; Uploading');
       
        var id = $(this).attr('id');
        var file = document.getElementById(id).files;
        let token   = $('meta[name="csrf-token"]').attr('content');
        var permitId = $('#permitId').val();
        var action = $(this).closest('.upload-item').find('.btnUpload').data('url');
        var fd = new FormData();
        

        if (file.length > 0) {
            if (file.length > 1) {
                // multiple files
            }else{
                if ((file[0].size  / 1000000) > 32 ) {
                    Swal.fire(
                        'Failed!',
                        'File must not exceed in 32mb',
                        'error'
                    );
                    $(this).closest('.upload-item').find('.btnUpload').html('Browse');
                    return false;
                }
                
                // single file

                fd.append('_token', token);
                fd.append('file', file[0]);
                fd.append('id', permitId);
                fd.append('file_key', id);

                // regex for image validation
                var reg = /image/g;
                if (file[0].type == 'application/pdf' || file[0].type.match(reg)) {
                    $.ajax({
                        url: action,
                        type:"POST",
                        data:fd,
                        dataType: 'JSON',
                        success:function(response){
                            if (response.status == true) {
                                Swal.fire(
                                    'Success!',
                                    response.msg,
                                    'success'
                                ).then(function(result){
                                    if (file[0].type == 'application/pdf') {
                                        // if pdf
                                        $('#'+id).closest('.upload-item').find('.requirements_img').attr('src','https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg');
                                    }else{
                                        // if img
                                        var reader = new FileReader();
                                        reader.onload = function() {
                                            $('#'+id).closest('.upload-item').find('.requirements_img').attr('src', reader.result);
                                        }
                                        reader.readAsDataURL(file[0]);
                                    }
                                    $('#'+id).closest('.upload-item').find('.btnUpload').html('Browse');
                                });
                              
                            }
                        },
                        processData: false,
                        contentType: false
                    });
                    return;
                }else{
                    Swal.fire(
                        'Failed!',
                        'File type must be pdf or image',
                        'error'
                    ).then(function(result){
                        $('#'+id).val('');
                        $('#'+id).closest('.upload-item').find('.btnUpload').html('Browse');
                    });
                }   

            }
        }else{
            $(this).closest('.upload-item').find('.requirements_img').attr('src','https://via.placeholder.com/150');
        }
        
    });


    $('#btnDraft').click(function(e){
        var action = $(this).data('url');
        var formData = new FormData($('#updateBusiness')[0]);
        
        var updateDraft = ajaxPost(action,formData,updateResult);
    });


    $(document).on("click","#btnSubmitApp",function() {
        var action = $(this).data('url');
        var formData = new FormData($('#updateBusiness')[0]);

        var $valid = $('#updateBusiness').valid();
        if (!$valid) {
            $validator.focusInvalid();
            return false;
        }
        var updateApplication = ajaxPost(action,formData,updateResult);
    });


    function updateResult(response) {
        if(response.status == false){
            Swal.fire(
                'Failed!',
                response.msg,
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
    }

    $('#btnDelete').click(function(e){
        var action = $(this).data('url');
        let token   = $('meta[name="csrf-token"]').attr('content');
        var id = $('#permitId').val();
        var formData = new FormData();

        formData.append('_token', token);
        formData.append('id', id);

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
                var updateDraft = ajaxPost(action,formData,deleteResult);
            }
        });
        
       
    });

    function deleteResult(response) {
        if(response.status == false){
            Swal.fire(
                'Failed!',
                response.msg,
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
                window.location.href = '/application-status';
            });
        }
    }


    $('#addBusinessActivity').click(function (){
        // if (businessLimit < 7){
          var html = `
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
        `;
        $('#businessActivitiesList').append(html);
        
        // businessLimit++;
        // }
      });

    $('#note_form').submit(function(e){
        e.preventDefault();

        if ($('#notes').val() == '') {
            Swal.fire(
                'Failed!',
                'Notes can\'t be blank',
                'error'
            );
            return false;
        }


        var action = $(this).data('url');
        var data = new FormData($(this)[0]);
        
        ajaxPost(action,data,noteResult);
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


    $(function () {
        $('[data-toggle="popover"]').popover()
    });

    $('#history_tab').click(function(e) {
      
        var permitId = '{{ $data['business_permit_info']['app_id'] }}';
        let token   = $('meta[name="csrf-token"]').attr('content');
        var action = '/application/history';
        var postData = {
            _token : token,
            id : permitId
        };
        $.ajax({
            url: action,
            type:"POST",
            data:postData,
            dataType: 'JSON',
            success:function(response){
               
                $('#usertable').DataTable().clear().destroy();
                $('#admintable').DataTable().clear().destroy();
                $('#usertable').DataTable({
                    "aaData": response.user_history,
                    "columns": [
                        { "data" : "fullname"},
                        { "data" : "description"},
                        { "data" : "date"}
                    ],
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
                $('#admintable').DataTable({
                    "aaData": response.admin_history,
                    "columns": [
                        { "data" : "fullname"},
                        { "data" : "description"},
                        { "data" : "date"}
                    ],
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
             
            },
            // processData: false,
            // contentType: false
        });

     
    });




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
</script>
@endsection