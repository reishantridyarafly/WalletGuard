<div class="tab-pane" id="password">
    <form id="form_password">
        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-lock me-1"></i>
            Password</h5>
        <div class="row">
            <div class="mb-3">
                <label for="old_password" class="form-label">Old Password</label>
                <div class="input-group input-group-merge">
                    <input type="password" class="form-control" name="old_password" id="old_password">
                    <div class="input-group-text" data-password="false">
                        <span class="password-eye"></span>
                    </div>
                </div>
                <small class="text-danger errorOldPassword"></small>
            </div>

            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <div class="input-group input-group-merge">
                    <input type="password" class="form-control" name="password" id="new_password">
                    <div class="input-group-text" data-password="false">
                        <span class="password-eye"></span>
                    </div>
                </div>
                <small class="text-danger errorPassword"></small>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <div class="input-group input-group-merge">
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                    <div class="input-group-text" data-password="false">
                        <span class="password-eye"></span>
                    </div>
                </div>
                <small class="text-danger errorConfirmationPassword"></small>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success mt-2" id="save_password"><i
                        class="mdi mdi-content-save"></i>
                    Save</button>
            </div>
        </div>
    </form>
</div>
<!-- end password content-->


<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#form_password').submit(function(e) {
            e.preventDefault();
            $.ajax({
                data: $(this).serialize(),
                url: "{{ route('profile.updatePassword') }}",
                type: "POST",
                dataType: 'json',
                beforeSend: function() {
                    $('#save_password').attr('disable', 'disabled');
                    $('#save_password').text('Process...');
                },
                complete: function() {
                    $('#save_password').removeAttr('disable');
                    $('#save_password').html(`<i class="mdi mdi-content-save"></i> Save`);
                },
                success: function(response) {
                    if (response.errors) {
                        if (response.errors.old_password) {
                            $('#old_password').addClass('is-invalid');
                            $('.errorOldPassword').html(response.errors.old_password);
                        } else {
                            $('#old_password').removeClass('is-invalid');
                            $('.errorOldPassword').html('');
                        }

                        if (response.errors.password) {
                            $('#new_password').addClass('is-invalid');
                            $('.errorPassword').html(response.errors.password);
                        } else {
                            $('#new_password').removeClass('is-invalid');
                            $('.errorPassword').html('');
                        }

                        if (response.errors.password_confirmation) {
                            $('#password_confirmation').addClass('is-invalid');
                            $('.errorConfirmationPassword').html(response.errors
                                .password_confirmation);
                        } else {
                            $('#password_confirmation').removeClass('is-invalid');
                            $('.errorConfirmationPassword').html('');
                        }
                    } else {
                        if (response.error_password) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.error_password,
                            })
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.success,
                            }).then(function() {
                                top.location.href =
                                    "{{ route('profile.index') }}";
                            });
                        }
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
