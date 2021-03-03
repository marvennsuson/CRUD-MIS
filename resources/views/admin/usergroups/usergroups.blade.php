@extends('layouts.dashboard')

@section('header')
    User Groups
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">people</i>
                </div>
                <div class="row justify-content-between">
                    <div>
                        <h4 class="card-title">User Groups List</h4>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="toolbar">

                </div>
                <div class="material-datatables">
                    <table id="usergroup_table" cellspacing="0" class="table table-striped table-no-bordered table-hover"  width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Level</th>
                                <th style="width:20%" class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Level</th>
                                <th style="width:20%" class="text-right">Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($user_groups as $ug)
                                <tr>
                                    <td>{{ $ug['user_group'] }}</td>
                                    <td>{{ $ug['description'] }}</td>
                                    <td>{{ $ug['level'] }}</td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-link btn-warning btn-just-icon edit" data-action="{{ route('admin.usergroup.edit') }}" data-usergroupid = '{{ $ug['id'] }}'><i class="material-icons">dvr</i></button>
                                        <button type="button" class="btn btn-link btn-danger btn-just-icon remove" data-action="{{ route('admin.usergroup.delete') }}" data-usergroupid = '{{ $ug['id'] }}'><i class="material-icons">close</i></button>
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
<div class="modal fade" id="user_add_modal" tabindex="-1" role="">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="">
                <div class="modal-header">
                    <h5 class="modal-title">Create a User Group</h5>
                </div>
                <form class="form" id="form_usergroup_add" method="POST" data-url="{{route('admin.usergroup.add')}}" novalidate>
                <div class="modal-body p-5">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group bmd-form-group">
                                <label for="exampleEmail" class="bmd-label-floating"> User Group Name</label>
                                <input type="text" class="form-control" name="user_group" id="user_group" aria-required="true">
                                <label id="user_group-error" style="display: none" class="error" for="user_group"></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group bmd-form-group">
                                <label for="description" class="bmd-label-floating">Description</label>
                                <input type="text" class="form-control" name="description" id="description" aria-required="true">
                                <label id="description-error" style="display: none" class="error" for="description"></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group bmd-form-group">
                                <select class="selectpicker" name="grouplevel" id="grouplevel" data-style="select-with-transition">
                                    <option disabled="" selected>Group Level</option>
                                    @for ($i = 9; $i >= 1; $i--)
                                        <option value="{{ $i  }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <label id="grouplevel-error" style="display: none" class="error" for="grouplevel"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger mr-1" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="usergroup_edit_modal" tabindex="-1" role="">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User Group</h5>
                </div>
                <div class="modal-body">
                    <form class="form" id="form_usergroup_edit" data-url="{{route('admin.usergroup.update')}}" novalidate>
                        @csrf
                        @method("PUT")
                        <div class="is-filled has-success">
                            <label for="exampleEmail" class="bmd-label-floating"> User Group *</label>
                            <input type="text" class="form-control" name="edit_user_group" id="edit_user_group" aria-required="true">
                            <label id="edit_user_group-error" style="display: none" class="error" for="edit_user_group"></label>
                        </div>
                        <div class="is-filled has-success">
                            <label for="editdescription" class="bmd-label-floating"> Description</label>
                            <input type="text" class="form-control"  name="editdescription" id="editdescription" aria-required="true">
                            <label id="editdescription-error" style="display: none" class="error" for="editdescription"></label>
                        </div>
                        <div class="is-filled has-success">

                                <select class="selectpicker" name="editlevel" id="editlevel" data-style="select-with-transition">

                                    @for ($i = 9; $i >= 1; $i--)
                                        <option value="{{ $i  }}" >{{ $i }}</option>
                                    @endfor
                                </select>
                                <label id="editlevel-error" style="display: none" class="error" for="editlevel"></label>

                        </div>
                        <input type="hidden" name="usergroup_id" id="usergroup_id" value="">
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-danger mr-1" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>




{{-- Floating --}}
<div class="floating-button" data-toggle="tooltip" data-placement="left" title="Create a user group.">
    <button class="btn btn-rose btn-round p-3 shadow" data-toggle="modal" data-target="#user_add_modal" id="btn_add_users" >
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
            $('#form_usergroup_add').validate({
                rules: {
                    user_group: {
                        required: true,
                        minlength: 3
                    },
                    description: {
                        required: true,
                        minlength: 5
                    },
                    grouplevel: {
                        required: true,
                    },
                },

                highlight: function(element) {
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
                },
                success: function(element) {
                    $(element).closest('.form-group').find('.error').addClass('d-none');
                    $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
                },
                errorPlacement: function(error, element) {
                    $(element).append(error);
                }
            });

            $('#form_usergroup_edit').validate({
                rules: {
                    edit_user_group: {
                        required: true,
                        minlength: 3
                    },
                    editdescription: {
                        required: true,
                        minlength: 5
                    },
                    editlevel: {
                        required: true,
                    },
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



            $('#usergroup_table').dataTable( {
                "autoWidth": false,
                "columnDefs": [
                    { "orderable": false, "targets": 1 }
                ],
                responsive: true,
            });

            // create user request
            $('#form_usergroup_add').submit(function(e) {
                e.preventDefault();
                var action  = $(this).data('url');
                var data = $(this).serialize();

                var $valid = $('#form_usergroup_add').valid();

                if (!$valid) {
                    return false;
                }

                var createUser = ajaxPost(action,data, createStatus);
            });

            // create user response
            function createStatus(result){
                // validation
                if (result.error) {
                    validations(result.error);
                    return false;
                }

                // validation success
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

            // request edit form
            $(document).on('click', "button.edit", function () {
                var userid = $(this).data('usergroupid');
                var action = $(this).data('action')
                let token   = $('meta[name="csrf-token"]').attr('content');
                var data = {
                    _token : token,
                    id: userid
                };
                var editUserGroup = ajaxPost(action,data, editForm);
            });
            //response edit form
            function editForm(result){
                if (result.status == true) {
                    var usergroup_info = result.data.usergroup_info;

                    $('#edit_user_group').val(usergroup_info.user_group);
                    $('#usergroup_id').val(usergroup_info.id);
                    $('#editdescription').val(usergroup_info.description);
                    $('#editlevel').val(usergroup_info.level);
                          $("#editlevel").val(usergroup_info.level).change();
                    $('#usergroup_edit_modal').modal('show');
                }
            }

            $('#form_usergroup_edit').submit(function(e) {
                e.preventDefault();
                var action = $(this).data('url');
                var data = $(this).serialize();

                var $valid = $('#form_usergroup_edit').valid();

                if (!$valid) {
                    return false;
                }

                var updateUser = ajaxPost(action,data, updateStatus);
            });


            function updateStatus(result) {
                if (result.error) {
                    validations(result.error);
                    return false;
                }
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


            $(document).on('click', "button.remove", function () {
                var userid = $(this).data('usergroupid');
                var action = $(this).data('action')
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

    </script>
@endsection
