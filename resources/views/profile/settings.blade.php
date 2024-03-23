<div class="tab-pane show active" id="settings">
    <form id="form_settings">
        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Personal
            Info</h5>
        <div class="row">
            <div class="mb-3">
                <label for="name" class="form-label">Photo</label>
                <div class="d-flex align-items-center">
                    <img class="rounded-circle" alt="{{ auth()->user()->name }}" id="photoPreview"
                        style="width: 100px; height: 100px; margin-right: 15px"
                        src="{{ auth()->user()->avatar == '' ? 'https://ui-avatars.com/api/?background=random&name=' . auth()->user()->name : asset('storage/avatar/' . auth()->user()->avatar) }}">
                    <button type="button" class="btn btn-danger btn-sm mt-1" id="deletePhoto">Delete Photo</button>
                </div>
                <small style="display: block; margin-top: 10px;">Maximum photo is 5 Mb.</small>
                <input type="file" name="photo" id="photo" class="form-control mt-2"
                    onchange="previewPhoto(this)">
                <div class="invalid-feedback errorPhoto"></div>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name"
                    value="{{ auth()->user()->name }}">
                <div class="invalid-feedback errorName"></div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email"
                    value="{{ auth()->user()->email }}">
                <div class="invalid-feedback errorEmail"></div>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Telephone</label>
                <input type="number" class="form-control" id="phone_number" name="phone_number"
                    placeholder="Enter telephone" value="{{ auth()->user()->phone_number }}">
                <div class="invalid-feedback errorPhoneNumber"></div>
            </div>
        </div> <!-- end row -->

        <div class="text-end">
            <button type="submit" class="btn btn-success mt-2" id="save_settings"><i class="mdi mdi-content-save"></i>
                Save</button>
        </div>
    </form>
</div>
<!-- end settings content-->

<script>
    function previewPhoto(input) {
        var photoPreview = document.getElementById('photoPreview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#form_settings').submit(function(e) {
            e.preventDefault();
            $.ajax({
                data: new FormData(this),
                url: "{{ route('profile.settings') }}",
                type: "POST",
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#save_settings').attr('disable', 'disabled');
                    $('#save_settings').text('Process...');
                },
                complete: function() {
                    $('#save_settings').removeAttr('disable');
                    $('#save_settings').html(`<i class="mdi mdi-content-save"></i> Save`);
                },
                success: function(response) {
                    if (response.errors) {
                        if (response.errors.photo) {
                            $('#photo').addClass('is-invalid');
                            $('.errorPhoto').html(response.errors.photo);
                        } else {
                            $('#photo').removeClass('is-invalid');
                            $('.errorPhoto').html('');
                        }

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
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Data saved successfully',
                        }).then(function() {
                            top.location.href = "{{ route('profile.index') }}";
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(xhr.status + "\n" + xhr.responseText + "\n" +
                        thrownError);
                }
            });
        });

        $('body').on('click', '#deletePhoto', function() {
            Swal.fire({
                title: 'Delete Photo',
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
                        url: "{{ route('profile.deletePhoto') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: response.success,
                                }).then(function() {
                                    top.location.href =
                                        "{{ route('profile.index') }}";
                                });
                            } else {
                                if (response.errors.photo) {
                                    $('#photo').addClass('is-invalid');
                                    $('.errorPhoto').html(response.errors.photo);
                                } else {
                                    $('#photo').removeClass('is-invalid');
                                    $('.errorPhoto').html('');
                                }
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.error(xhr.status + "\n" + xhr.responseText +
                                "\n" + thrownError);
                        }
                    });
                }
            });
        });
    });
</script>
