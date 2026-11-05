
@php
    use Illuminate\Support\Carbon;
@endphp

@extends('authkit::layouts.dashboard')
@section('page_title', 'نشست ها')

@vite(['resources/js/dashboard/terminate-other-sessions.js'], 'vendor/authkit/build')

@section('content')

    <!-- ----------------------------------- -->
    <!-- Sessions List -->
    <!-- ----------------------------------- -->
    <div class="card">

        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h3 class="m-0 fw-bold fs-18">نشست های فعال</h3>
            <a href="{{ route('dashboard') }}" class="p-1">
                <x-authkit::icons.arrow-left-icon color="var(--secondary)" />
            </a>
        </div>

        <div class="card-body">
            <div class="row g-3">
                @forelse($sessions as $session)
                    <div class="col-12 col-md-6">
                        <div class="d-flex align-items-center gap-2 border rounded-3 p-3 h-100">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px">
                                @if (in_array($session->device, ['iPhone', 'iPad', 'Android'], true))
                                    <x-authkit::icons.mobile-icon color="var(--secondary)" />
                                @elseif (in_array($session->device, ['Windows', 'Mac', 'Linux'], true))
                                    <x-authkit::icons.monitor-icon color="var(--secondary)" />
                                @endif
                            </div>

                            <div class="d-flex flex-column align-items-start gap-1 overflow-hidden">
                                <span class="text-dark fw-medium fs-14">{{ $session->device }}</span>

                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    @if ($session->id === session()->getId())
                                        <small class="badge bg-success-subtle text-success fs-11">دستگاه فعلی</small>
                                    @else
                                        <small class="text-secondary fs-13">
                                            آخرین فعالیت: {{ Carbon::parse($session->last_activity)->diffForHumans() }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <small class="d-block text-center text-secondary">هیچ سشن فعالی یافت نشد.</small>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="card-footer py-3 bg-transparent border-0 d-flex justify-content-end">
            @if (count($sessions) > 1)
                <button class="btn btn-outline-primary px-30 py-12 rounded-3 fw-medium fs-13" data-bs-toggle="modal" data-bs-target="#logoutSessionsModal">
                    خروج از سایر نشست‌ها
                </button>
            @endif
        </div>
    </div>


    
    <!-- ----------------------------------- -->
    <!-- Logout Other Devices Modal -->
    <!-- ----------------------------------- -->
    <div class="modal fade" id="logoutSessionsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-medium fs-20">خروج از سایر نشست‌ها</h5>
                    <button type="button" class="btn-close border-0" style="outline: none !important" data-bs-dismiss="modal"></button>
                </div>

                <form novalidate id="terminate-other-sessions-form" action="{{ route('sessions.destroy') }}" method="POST" class="modal-body">
                    @csrf
                    <p class="text-secondary fw-light fs-14">برای ادامه، لطفاً رمز عبور خود را وارد کنید.</p>
                    <div class="position-relative mt-20 mt-md-500">
                        <label class="form-group rounded-3 fw-light p-14 d-flex align-items-center justify-content-between gap-2">
                            <input type="password" name="password" class="form-control rounded-0 border-0 p-0" placeholder=" " required autocomplete="off">
                            <span class="form-label text-secondary fw-light fs-13">گذرواژه</span>
                            <x-authkit::icons.lock-icon color="var(--secondary)" />
                        </label>
                    </div>
                    <small id="password_error" class="fw-medium text-danger fs-12 ps-1 mt-1 d-none"></small>
                </form>

                <div class="modal-footer">
                    <button type="button" class="btn text-secondary border-0 px-30 py-12 fw-medium fs-14 rounded-3" data-bs-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-danger px-30 py-12 fw-medium fs-14 rounded-3" id="submit-terminate-sessions-form" form="terminate-other-sessions-form">خروج از سایر نشست‌ها</button>
                </div>
            </div>
        </div>
    </div>
@endsection