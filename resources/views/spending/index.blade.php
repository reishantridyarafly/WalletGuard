@extends('layouts.main')
@section('title', 'Spending')
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
                                <div class="alert alert-success">
                                    <div class="row">
                                        <div class="col-9">
                                            Total Spending
                                        </div>
                                        <div class="col-1">
                                            :
                                        </div>
                                        <div class="col-2 total-spending" id="totalSpending">
                                            <strong>{{ 'Rp. ' . number_format($totalSpending, 0, ',', '.') }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <table id="datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Spending</th>
                                            <th>Category</th>
                                            <th>Description</th>
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
                            <label for="spending" class="form-label">Spending <span class="text-danger">*</span></label>
                            <input type="text" id="spending" name="spending" class="form-control" autofocus>
                            <div class="invalid-feedback errorSpending"></div>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" id="category" class="form-control select2" data-toggle="select2">
                                <option value="">-- Select Category --</option>
                                @foreach ($category as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback errorCategory"></div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                            <div class="invalid-feedback errorDescription"></div>
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
        function updateTotalSpending() {
            $.ajax({
                url: "{{ route('spending.total') }}",
                type: "GET",
                success: function(response) {
                    $('.total-spending').html('<strong>Rp ' + response.totalSpending + '</strong>');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        }

        $(document).ready(function() {
            $('.select2').select2({
                dropdownParent: $('#modal'),
            });

            $('#spending').on('keyup', function(e) {
                $(this).val(formatRupiah($(this).val(), 'Rp. '));
            });

            function formatRupiah(angka, prefix) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#datatable').DataTable({
                processing: true,
                serverside: true,
                ajax: "{{ route('spending.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'spending',
                        name: 'spending'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'description',
                        name: 'description',
                        render: function(data, type, row) {
                            if (data === null) {
                                return "-";
                            } else {
                                return data;
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
            });

            // Add Data
            $('#btnAdd').click(function() {
                $('#id').val('');
                $('#modalLabel').html("Add Data");
                $('#modal').modal('show');
                $('#form').trigger("reset");
                $('#category').val('').trigger('change');

                $('#spending').removeClass('is-invalid');
                $('.errorSpending').html('');

                $('#category').removeClass('is-invalid');
                $('.errorCategory').html('');

                $('#description').removeClass('is-invalid');
                $('.errorDescription').html('');
            });

            // Edit Data
            $('body').on('click', '#btnEdit', function() {
                let id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    url: "spending/" + id + "/edit",
                    dataType: "json",
                    success: function(response) {
                        $('#modalLabel').html("Edit Data");
                        $('#save').val("edit-spending");
                        $('#modal').modal('show');

                        $('#spending').removeClass('is-invalid');
                        $('.errorSpending').html('');

                        $('#category').removeClass('is-invalid');
                        $('.errorCategory').html('');

                        $('#description').removeClass('is-invalid');
                        $('.errorDescription').html('');

                        $('#id').val(response.id);
                        $('#spending').val(response.spending);
                        $('#category').val(response.category_id).trigger('change');
                        $('#description').val(response.description);
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
                            url: "{{ url('spending/"+id+"') }}",
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
                                    $('#datatable').DataTable().ajax.reload();
                                    updateTotalSpending();
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
                    url: "{{ route('spending.store') }}",
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
                            if (response.errors.spending) {
                                $('#spending').addClass('is-invalid');
                                $('.errorSpending').html(response.errors.spending);
                            } else {
                                $('#spending').removeClass('is-invalid');
                                $('.errorSpending').html('');
                            }

                            if (response.errors.category) {
                                $('#category').addClass('is-invalid');
                                $('.errorCategory').html(response.errors.category);
                            } else {
                                $('#category').removeClass('is-invalid');
                                $('.errorCategory').html('');
                            }

                            if (response.errors.description) {
                                $('#description').addClass('is-invalid');
                                $('.errorDescription').html(response.errors.description);
                            } else {
                                $('#description').removeClass('is-invalid');
                                $('.errorDescription').html('');
                            }
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Data saved successfully',
                            })
                            $('#modal').modal('hide');
                            $('#form').trigger("reset");
                            $('#datatable').DataTable().ajax.reload();
                            updateTotalSpending();
                        }
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
