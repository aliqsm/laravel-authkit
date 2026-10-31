@extends('authkit::layouts.dashboard')
@section('page_title', 'ویرایش حساب')


@vite('resources/js/dashboard/update-profile.js', 'vendor/authkit/build')


@section('content')

    <!-- ----------------------------------- -->
    <!-- Edit Profile -->
    <!-- ----------------------------------- -->
    <div class="card">

        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h3 class="m-0 fw-bold fs-18">ویرایش حساب</h3>
            <a href="{{ route('dashboard') }}" class="p-1">
                <x-authkit::icons.arrow-left-icon color="var(--secondary)" />
            </a>
        </div>

        <div class="card-body p-4">
            <form id="edit-profile-form" action="{{ route('profile.update') }}" method="POST" novalidate>
                @csrf
                @method('PUT')

                <p class="text-secondary fw-light fs-14 mb-4">اطلاعات جدید خود را وارد کنید.</p>

                <div class="row g-3">

                    <!-- Name -->
                    <div class="col-12 col-md-6">
                        <div class="position-relative">
                            <label class="form-group rounded-3 fw-light p-14 @error('name') is-invalid @enderror d-flex align-items-center justify-content-between gap-2">
                                <input type="text" name="name" class="form-control rounded-0 border-0 p-0" placeholder=" " value="{{ old('name', $user->name) }}" maxlength="255" autocomplete="name" required autofocus>
                                <span class="form-label text-secondary fw-light fs-13">نام</span>
                            </label>
                        </div>
                        <small id="name_error" class="fw-medium text-danger fs-12 ps-1 mt-1 d-none"></small>
                    </div>

                    <!-- Email -->
                    <div class="col-12 col-md-6">
                        <div class="position-relative bg-light">
                            <label class="form-group rounded-3 fw-light p-14 @error('email') is-invalid @enderror d-flex align-items-center justify-content-between gap-2">
                                <input type="email" name="email" class="form-control rounded-0 border-0 p-0 bg-light text-secondary" placeholder=" " value="{{ old('email', $user->email) }}" maxlength="255"
                                    autocomplete="email" required disabled>
                                <span class="form-label text-secondary fw-light fs-13">ایمیل</span>
                            </label>
                        </div>
                        <small id="email_error" class="fw-medium text-danger fs-12 ps-1 mt-1 d-none"></small>
                    </div>

                </div>
            </form>
        </div>

        <!-- Form Actions -->
        <div class="card-footer py-3 bg-transparent border-0 d-flex justify-content-end gap-2">
            <a href="{{ route('dashboard') }}" class="btn text-secondary border-0 px-30 py-12 rounded-3 fw-medium fs-14">انصراف</a>
            <button type="submit" id="submit-edit-profile-form" form="edit-profile-form" class="btn btn-outline-dark px-30 py-12 rounded-3 fw-medium fs-14">ذخیره تغییرات</button>
        </div>

    </div>

@endsection
