@php
    use Illuminate\Support\Carbon;
@endphp

@extends('authkit::layouts.dashboard')
@section('page_title', 'نشست‌ها')

@vite(['resources/js/dashboard/terminate-other-sessions.js'], 'vendor/authkit/build')

@section('content')

    <!-- ----------------------------------- -->
    <!-- Sessions List -->
    <!-- ----------------------------------- -->
    <div class="card">

        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h3 class="m-0 fw-bold fs-18">نشست‌های فعال</h3>
            <a href="{{ route('dashboard') }}" class="p-1">
                <x-authkit::icons.arrow-left-icon color="var(--secondary)" />
            </a>
        </div>

        <div class="card-body p-3 p-md-4">

            @forelse($sessions as $session)
                @php
                    $isMobile = in_array($session->device, ['iPhone', 'iPad', 'Android'], true);
                    $isDesktop = in_array($session->device, ['Windows', 'Mac', 'Linux'], true);
                @endphp


                <div class="border rounded-3 p-3 mb-3">
                    <div class="d-flex align-items-center gap-3">

                        <!-- Device Icon -->
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-3 bg-body-secondary" style="width: 48px; height: 48px;">
                            @if ($isMobile)
                                <x-authkit::icons.mobile-icon color="var(--secondary)" :width="25" :height="25" />
                            @elseif ($isDesktop)
                                <x-authkit::icons.monitor-icon color="var(--secondary)" :width="25" :height="25" />
                            @else
                                <x-authkit::icons.security-icon color="var(--secondary)" :width="25" :height="25" />
                            @endif
                        </div>

                        <!-- Device Information -->
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                                <span class="fw-bold fs-14 text-body">{{ $session->device ?: 'دستگاه ناشناس' }}</span>

                                @if ($session->isCurrent)
                                    <span class="badge bg-success-subtle text-success fs-11 fw-medium">
                                        <span class="d-inline-block rounded-circle bg-success me-1" style="width: 6px; height: 6px; vertical-align: middle;"></span>
                                        دستگاه فعلی
                                    </span>
                                @endif
                            </div>

                            <div class="d-flex align-items-center gap-2 text-secondary fs-12">
                                @if ($session->isCurrent)
                                    <span>نشست فعلی شما</span>
                                @else
                                    <span>آخرین فعالیت: {{ Carbon::parse($session->last_activity)->diffForHumans() }}</span>
                                @endif
                            </div>
                        </div>

                        @if ($session->isCurrent)
                            <div class="flex-shrink-0 text-success">
                                <x-authkit::icons.tick-icon color="var(--success)" :width="20" :height="20" />
                            </div>
                        @endif

                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-body-secondary mx-auto mb-3" style="width: 58px; height: 58px;">
                        <x-authkit::icons.monitor-icon color="var(--secondary)" :width="27" :height="27" />
                    </div>
                    <span class="text-secondary fs-13">هیچ نشست فعالی یافت نشد.</span>
                </div>
            @endforelse
        </div>

        @if (count($sessions) > 1)
            <div class="card-footer py-3 px-3 px-md-4 bg-transparent border-0 d-flex justify-content-between align-items-center flex-wrap gap-3">
                <span class="text-secondary fs-12">{{ count($sessions) }} نشست فعال</span>
                <button type="button" class="btn btn-dark px-30 py-12 rounded-3 fw-medium fs-13" data-bs-toggle="modal" data-bs-target="#logoutSessionsModal">
                    خروج از سایر نشست‌ها
                </button>
            </div>
        @endif
    </div>


    <!-- ----------------------------------- -->
    <!-- Logout Other Devices Modal -->
    <!-- ----------------------------------- -->
    <div class="modal fade" id="logoutSessionsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-medium fs-18">خروج از سایر نشست‌ها</h5>
                    <button type="button" class="btn-close border-0" style="outline: none !important" data-bs-dismiss="modal"></button>
                </div>

                <form novalidate id="terminate-other-sessions-form" action="{{ route('sessions.destroy') }}" method="POST" class="modal-body">
                    @csrf

                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-3 bg-danger-subtle" style="width: 42px; height: 42px;">
                            <x-authkit::icons.security-icon color="var(--danger)" :width="22" :height="22" />
                        </div>
                        <p class="text-secondary fw-light fs-14 mb-0">با این کار از تمام دستگاه‌های دیگر خارج می‌شوید و نشست فعلی شما فعال باقی می‌ماند.</p>
                    </div>

                    <div class="position-relative mt-20">
                        <label class="form-group rounded-3 fw-light p-14 d-flex align-items-center justify-content-between gap-2">
                            <input type="password" name="password" class="form-control rounded-0 border-0 p-0" placeholder=" " required autocomplete="current-password">
                            <span class="form-label text-secondary fw-light fs-13">گذرواژه فعلی</span>
                            <x-authkit::icons.lock-icon color="var(--secondary)" />
                        </label>
                    </div>
                    <span id="password_error" class="fw-medium text-danger fs-12 ms-1 mt-1 d-none"></span>
                </form>

                <div class="modal-footer">
                    <button type="button" class="btn text-secondary border-0 px-30 py-12 fw-medium fs-14 rounded-3" data-bs-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-danger px-30 py-12 fw-medium fs-13 rounded-3" id="submit-terminate-sessions-form" form="terminate-other-sessions-form">خروج از سایر نشست‌ها</button>
                </div>
            </div>
        </div>
    </div>

@endsection
