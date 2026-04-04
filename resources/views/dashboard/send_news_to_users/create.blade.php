@extends('dashboard.index')

@section('title', 'النشرة البريدية')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">النشرة البريدية</li>
@endsection

@section('section')

<x-alert type="success" />
<x-alert type="danger" />

<div class="row g-4">

    {{-- ── Stats card ── --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-4 flex-wrap">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                    <i class="mdi mdi-email-newsletter text-primary fs-3"></i>
                </div>
                <div>
                    <div class="text-muted small">إجمالي المشتركين</div>
                    <div class="fw-bold fs-4">{{ $users->count() }} مشترك</div>
                </div>
                <div class="ms-auto">
                    <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-2" style="font-size:13px">
                        <i class="mdi mdi-check-circle-outline me-1"></i>
                        النشرة البريدية نشطة
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Compose form ── --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-bottom fw-bold">
                <i class="mdi mdi-send-outline me-2 text-primary"></i>
                إرسال نشرة بريدية
            </div>
            <div class="card-body">
                <form action="{{ route('user_news.send') }}" method="post">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">عنوان الرسالة</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            placeholder="مثال: عروض نهاية الأسبوع 🎉" value="{{ old('title') }}" />
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">نص الرسالة</label>
                        <textarea name="body" rows="6" class="form-control @error('body') is-invalid @enderror"
                            placeholder="اكتب محتوى النشرة هنا...">{{ old('body') }}</textarea>
                        @error('body')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Subscriber selection --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label fw-semibold mb-0">اختر المشتركين</label>
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label fw-semibold text-primary" for="selectAll">
                                    تحديد الكل ({{ $users->count() }})
                                </label>
                            </div>
                        </div>

                        @error('users')
                            <div class="text-danger small mb-2">{{ $message }}</div>
                        @enderror

                        <div class="border rounded p-3" style="max-height:220px; overflow-y:auto; background:#f8f9fb">
                            @forelse($users as $user)
                                <div class="form-check mb-2">
                                    <input class="form-check-input subscriber-cb" type="checkbox"
                                        name="users[]" value="{{ $user->id }}" id="u_{{ $user->id }}">
                                    <label class="form-check-label" for="u_{{ $user->id }}" dir="ltr">
                                        {{ $user->subscription_email }}
                                    </label>
                                </div>
                            @empty
                                <p class="text-muted mb-0 text-center py-3">لا يوجد مشتركين بعد</p>
                            @endforelse
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary px-5">
                        <i class="mdi mdi-send me-1"></i>
                        إرسال النشرة
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ── Subscribers list ── --}}
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-bottom fw-bold">
                <i class="mdi mdi-account-group-outline me-2 text-primary"></i>
                قائمة المشتركين
            </div>
            <div class="card-body p-0">
                @if($users->count())
                <div style="max-height:420px; overflow-y:auto">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th class="ps-3">#</th>
                                <th>البريد الإلكتروني</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $i => $user)
                            <tr>
                                <td class="ps-3 text-muted small">{{ $i + 1 }}</td>
                                <td dir="ltr" style="font-size:13px">{{ $user->subscription_email }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="mdi mdi-email-off-outline fs-1 d-block mb-2"></i>
                    لا يوجد مشتركين حتى الآن
                </div>
                @endif
            </div>
        </div>
    </div>

</div>

<script>
    document.getElementById('selectAll').addEventListener('change', function () {
        document.querySelectorAll('.subscriber-cb').forEach(cb => cb.checked = this.checked);
    });
</script>

@endsection
