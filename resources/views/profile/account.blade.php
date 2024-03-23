<div class="tab-pane" id="account">
    <form id="form_account">
        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-trash-can me-1"></i> Account
        </h5>
        <div class="row">
            <div class="mb-1">
                <div class="alert alert-danger">Are you sure you want to <strong>delete this
                        account</strong>?</div>
            </div>

            <div class="mb-3">
                <label for="new_password" class="form-label">Password</label>
                <div class="input-group input-group-merge">
                    <input type="password" class="form-control" name="password" id="new_password">
                    <div class="input-group-text" data-password="false">
                        <span class="password-eye"></span>
                    </div>
                </div>
                <small class="text-danger errorPassword"></small>
            </div>

        </div> <!-- end row -->

        <div class="text-end">
            <button type="submit" class="btn btn-danger mt-2" id="save_account"><i class="mdi mdi-trash-can"></i>
                Delete</button>
        </div>
    </form>
</div> <!-- end tab-pane -->

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<script>
    $(document).ready(function() {
        $('#form_account').submit(function(e) {
            e.preventDefault();
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
                    $.ajax({
                        data: $(this).serialize(),
                        url: "{{ route('profile.deleteAccount') }}",
                        type: "POST",
                        dataType: 'json',
                        beforeSend: function() {
                            $('#save_account').prop('disabled', true);
                            $('#save_account').html(
                                `<i class="mdi mdi-refresh mdi-spin"></i> Deleting...`
                            );
                        },
                        success: function(response) {
                            if (response.errors && response.errors.password) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.errors.password,
                                });
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Your account has been successfully deleted.',
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(function() {
                                    var logoutForm = document
                                        .getElementById('logout-form');
                                    logoutForm.submit();
                                });
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.error(xhr.status + "\n" + xhr.responseText +
                                "\n" + thrownError);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'An error occurred, please try again later.',
                            });
                        },
                        complete: function() {
                            $('#save_account').prop('disabled', false);
                            $('#save_account').html(
                                '<i class="mdi mdi-trash-can"></i> Delete');
                        }
                    });
                }
            });
        });
    });
</script>
