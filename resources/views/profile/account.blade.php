<div class="tab-pane" id="account">
    <form>
        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-trash-can me-1"></i> Account
        </h5>
        <div class="row">
            <div class="mb-3">
                <div class="alert alert-danger">Are you sure you want to <strong>delete this
                        account</strong>
                    ?</div>
            </div>

            <div class="mb-3">
                <label for="old_password" class="form-label">Password</label>
                <div class="input-group input-group-merge">
                    <input id="old_password" type="password"
                        class="form-control @error('password') is-invalid @enderror" name="old_password"
                        autocomplete="old-password">


                    <div class="input-group-text" data-password="false">
                        <span class="password-eye"></span>
                    </div>
                </div>
                @error('password')
                    <small class="text-danger">
                        <strong>{{ $message }}</strong>
                    </small>
                @enderror
            </div>

        </div> <!-- end row -->

        <div class="text-end">
            <button type="submit" class="btn btn-danger mt-2"><i class="mdi mdi-trash-can"></i>
                Delete</button>
        </div>
    </form>


</div> <!-- end tab-pane -->
<!-- end about me section content -->
