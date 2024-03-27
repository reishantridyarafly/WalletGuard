@extends('layouts.main')
@section('title', 'Users')
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>
                    <h4 class="page-title">@yield('title')</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="basic-preview">
                                <div class="d-md-flex justify-content-between align-items-end mb-3">
                                    <div></div>
                                    <div class="text-md-end">
                                        <button type="button" class="btn btn-primary btn-sm ms-md-1" id="btnAdd">
                                            <i class="mdi mdi-plus"></i> Add Data
                                        </button>
                                    </div>
                                </div>
                                <table id="datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Telephone</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th width="10">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div> <!-- end preview-->
                        </div> <!-- end tab-content-->
                    </div> <!-- end card body-->
                </div> <!-- end card -->


            </div>
            <!-- end col-12 -->
        </div> <!-- end row -->

    </div> <!-- container -->

    <!-- modal -->
    <div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalLabel"></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="id" id="id">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" autofocus>
                            <div class="invalid-feedback errorName"></div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control">
                            <div class="invalid-feedback errorEmail"></div>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Telephone <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="phone_number" name="phone_number" class="form-control">
                            <div class="invalid-feedback errorPhoneNumber"></div>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-control select2" data-toggle="select2">
                                <option value="">-- Select Type --</option>
                                <option value="0">Administrator</option>
                                <option value="1">User</option>
                            </select>
                            <div class="invalid-feedback errorType"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="save">Save</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                dropdownParent: $('#modal'),
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#datatable').DataTable({
                processing: true,
                serverside: true,
                ajax: "{{ route('users.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'active_status',
                        name: 'active_status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });

            // Add Data
            $('#btnAdd').click(function() {
                $('#id').val('');
                $('#modalLabel').html("Add Data");
                $('#modal').modal('show');
                $('#form').trigger("reset");

                $('#name').removeClass('is-invalid');
                $('.errorName').html('');

                $('#email').removeClass('is-invalid');
                $('.errorEmail').html('');

                $('#phone_number').removeClass('is-invalid');
                $('.errorPhoneNumber').html('');

                $('#type').removeClass('is-invalid');
                $('.errorType').html('');
                $('#type').val('').trigger('change');
            });

            // Edit Data
            $('body').on('click', '#btnEdit', function() {
                let id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    url: "users/" + id + "/edit",
                    dataType: "json",
                    success: function(response) {
                        $('#modalLabel').html("Edit Data");
                        $('#save').val("edit-users");
                        $('#modal').modal('show');

                        $('#name').removeClass('is-invalid');
                        $('.errorName').html('');

                        $('#email').removeClass('is-invalid');
                        $('.errorEmail').html('');

                        $('#phone_number').removeClass('is-invalid');
                        $('.errorPhoneNumber').html('');

                        $('#type').removeClass('is-invalid');
                        $('.errorType').html('');

                        $('#id').val(response.id);
                        $('#name').val(response.name);
                        $('#email').val(response.email);
                        $('#phone_number').val(response.phone_number);
                        if (response.type == 'Administrator') {
                            $('#type').val('0').trigger('change');
                        } else {
                            $('#type').val('1').trigger('change');
                        }

                    }
                });
            })

            // Delete Data
            $('body').on('click', '#btnDelete', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Delete',
                    text: "Are you sure?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete!',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ url('users/"+id+"') }}",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.success,
                                    });
                                    $('#datatable').DataTable().ajax.reload()
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" +
                                    thrownError);
                            }
                        })
                    }
                })
            })

            // Add & edit proccess
            $('#form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    data: $(this).serialize(),
                    url: "{{ route('users.store') }}",
                    type: "POST",
                    dataType: 'json',
                    beforeSend: function() {
                        $('#save').attr('disable', 'disabled');
                        $('#save').text('Proses...');
                    },
                    complete: function() {
                        $('#save').removeAttr('disable');
                        $('#save').html('save');
                    },
                    success: function(response) {
                        if (response.errors) {
                            if (response.errors.name) {
                                $('#name').addClass('is-invalid');
                                $('.errorName').html(response.errors.name);
                            } else {
                                $('#name').removeClass('is-invalid');
                                $('.errorName').html('');
                            }

                            if (response.errors.email) {
                                $('#email').addClass('is-invalid');
                                $('.errorEmail').html(response.errors.email);
                            } else {
                                $('#email').removeClass('is-invalid');
                                $('.errorEmail').html('');
                            }

                            if (response.errors.phone_number) {
                                $('#phone_number').addClass('is-invalid');
                                $('.errorPhoneNumber').html(response.errors.phone_number);
                            } else {
                                $('#phone_number').removeClass('is-invalid');
                                $('.errorPhoneNumber').html('');
                            }

                            if (response.errors.type) {
                                $('#type').addClass('is-invalid');
                                $('.errorType').html(response.errors.type);
                            } else {
                                $('#type').removeClass('is-invalid');
                                $('.errorType').html('');
                            }
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Data saved successfully',
                            })
                            $('#modal').modal('hide');
                            $('#form').trigger("reset");
                            $('#datatable').DataTable().ajax.reload()
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.error(xhr.status + "\n" + xhr.responseText + "\n" +
                            thrownError);
                    }
                });
            });

            $(document).on('change', '#active_status', function() {
                var userId = $(this).data('id'); // Mendapatkan ID pengguna
                var isActive = $(this).prop('checked') ? 0 : 1; // Mendapatkan status aktif

                // Kirim permintaan Ajax untuk memperbarui status aktif
                $.ajax({
                    url: "{{ route('users.updateActiveStatus') }}", // URL untuk memperbarui status aktif
                    method: 'POST',
                    data: {
                        id: userId,
                        active_status: isActive
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Data saved successfully',
                        })
                        $('#datatable').DataTable().ajax.reload()
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.error(xhr.status + "\n" + xhr.responseText + "\n" +
                            thrownError);
                    }
                });
            });
        });
    </script>
@endsection
