@extends('dashboard.index')
@section('title', 'الأسئلة الشائعة')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">الأسئلة الشائعة</li>
@endsection

@section('section')

<x-alert type='success' />

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="mb-0 fw-bold">
            <i class="mdi mdi-frequently-asked-questions me-2 text-primary"></i>
            الأسئلة الشائعة
        </h4>
        <small class="text-muted">{{ $questions->count() }} سؤال مضاف</small>
    </div>
    <a href="{{ route('common_questions.create') }}" class="btn btn-primary">
        <i class="mdi mdi-plus me-1"></i>
        إضافة سؤال
    </a>
</div>

@forelse($questions as $i => $question)
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <div class="d-flex align-items-start gap-3">

            {{-- Number badge --}}
            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0"
                style="width:40px; height:40px; font-size:14px; font-weight:700; color:#1a237e">
                {{ $i + 1 }}
            </div>

            {{-- Content --}}
            <div class="flex-grow-1 min-w-0">
                <div class="fw-bold mb-1" style="font-size:15px; color:#111827">
                    {{ $question->title }}
                </div>
                <p class="text-muted mb-0" style="font-size:13px; line-height:1.7">
                    {{ Str::limit($question->description, 180) }}
                </p>
            </div>

            {{-- Actions --}}
            <div class="d-flex gap-2 flex-shrink-0">
                <a href="{{ route('common_questions.edit', $question->id) }}"
                    class="btn btn-sm btn-outline-primary" title="تعديل">
                    <i class="mdi mdi-pencil-outline"></i>
                </a>
                <form action="{{ route('common_questions.destroy', $question->id) }}" method="POST"
                    onsubmit="return confirm('هل أنت متأكد من حذف هذا السؤال؟')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                        <i class="mdi mdi-trash-can-outline"></i>
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@empty
<div class="card border-0 shadow-sm">
    <div class="card-body text-center py-5">
        <i class="mdi mdi-help-circle-outline text-muted" style="font-size:48px"></i>
        <p class="text-muted mt-3 mb-3">لا توجد أسئلة مضافة بعد</p>
        <a href="{{ route('common_questions.create') }}" class="btn btn-primary">
            <i class="mdi mdi-plus me-1"></i> إضافة أول سؤال
        </a>
    </div>
</div>
@endforelse

@endsection
