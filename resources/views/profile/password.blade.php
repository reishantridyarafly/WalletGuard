<div class="tab-pane" id="password">
    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-lock me-1"></i>
        Password</h5>
    <div class="mb-3">
        <label for="old_password" class="form-label">Password</label>
        <div class="input-group input-group-merge">
            <input id="old_password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="old_password" autocomplete="old-password">


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

    <div class="mb-3">
        <label for="password" class="form-label">New Password</label>
        <div class="input-group input-group-merge">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" autocomplete="new-password">

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

    <div class="mb-3">
        <label for="password" class="form-label">Confirm Password</label>
        <div class="input-group input-group-merge">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                autocomplete="new-password">

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

    <div class="text-end">
        <button type="submit" class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i>
            Save</button>
    </div>
</div>
<!-- end password content-->
