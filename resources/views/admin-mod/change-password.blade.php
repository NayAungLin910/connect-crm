@extends('layout.master')
@section('title', "Change Password $user->name - Connect CRM")
@section('description', "Change password for the user, $user->name of the Connect Customer Relationship Management")
@section('keywords', "Change Password $user->name Business Connect CRM Customer Relationship Management")
@section('content')
    <div class="row mt-4">
        <div class="col-sm-5">
            <h4 class="text-center">Change Password of {{ $user->name }}</h4>
            <form class="mt-4" action="{{ url('/change-password') }}" method="POST">
                @csrf
                <div class="form-group my-2">
                    <label for="old-password-id">Enter Old Password</label>
                    <input type="password" name="old_password" class="form-control my-2" id="old-password-id">
                    @if ($errors->has('old_password'))
                        <p class="text-danger">{{ $errors->first('old_password') }}</p>
                    @endif
                    <button type="button" class="btn btn-sm btn-primary" id="toogle-old-btn">
                        <i class="bi bi-eye-slash" id="old-password-eye-icon"></i>
                    </button>
                </div>
                <div class="form-group my-2">
                    <label for="new-password-id">Enter New Password</label>
                    <input type="password" name="new_password" class="form-control my-2" id="new-password-id">
                    @if ($errors->has('new_password'))
                        <p class="text-danger">{{ $errors->first('new_password') }}</p>
                    @endif
                    <button type="button" class="btn btn-sm btn-primary" id="toogle-new-btn">
                        <i class="bi bi-eye-slash" id="new-password-eye-icon"></i>
                    </button>
                </div>
                <div class="form-group my-2">
                    <label for="confirm-password-id">Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control my-2" id="confirm-password-id">
                    @if ($errors->has('confirm_password'))
                        <p class="text-danger">{{ $errors->first('confirm_password') }}</p>
                    @endif
                    <button type="button" class="btn btn-sm btn-primary" id="toogle-confirm-btn">
                        <i class="bi bi-eye-slash" id="confirm-password-eye-icon"></i>
                    </button>
                </div>
                <div class="d-flex mt-4 justify-content-around align-items-center">
                    <a href="{{ url('/profile') }}" type="submit" class="btn btn-sm btn-dark">
                        <i class="bi bi-chevron-left mx-1"></i>
                        Back
                    </a>
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="bi bi-check2 mx-1"></i>
                        Save
                    </button>
                </div>
            </form>
        </div>
        <div class="col-sm-4"></div>
    </div>
@endsection
@section('script')
    <script>
        // toogling for old password input
        const toogleOldBtn = document.querySelector('#toogle-old-btn');
        const oldPassword = document.querySelector('#old-password-id');

        toogleOldBtn.addEventListener("click", function() {
            const type = oldPassword.getAttribute("type") === "password" ? "text" : "password";
            oldPassword.setAttribute("type", type);
            $('#old-password-eye-icon').toggleClass("bi bi-eye");
        });

        // toogling for new password input
        const toogleNewBtn = document.querySelector('#toogle-new-btn');
        const newPassword = document.querySelector('#new-password-id');

        toogleNewBtn.addEventListener("click", function() {
            const type = newPassword.getAttribute("type") === "password" ? "text" : "password";
            newPassword.setAttribute("type", type);
            $('#new-password-eye-icon').toggleClass("bi bi-eye");
        });

        // toogling for confirm password input
        const toogleConfirmBtn = document.querySelector('#toogle-confirm-btn');
        const confirmPassword = document.querySelector('#confirm-password-id');

        toogleConfirmBtn.addEventListener("click", function() {
            const type = confirmPassword.getAttribute("type") === "password" ? "text" : "password";
            confirmPassword.setAttribute("type", type);
            $('#confirm-password-eye-icon').toggleClass("bi bi-eye");
        });
    </script>
@endsection
