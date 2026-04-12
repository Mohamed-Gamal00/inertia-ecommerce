@extends('dashboard.index')
@section('title', 'تعديل سؤال')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('common_questions.index') }}">الأسئلة الشائعة</a></li>
    <li class="breadcrumb-item active">تعديل سؤال</li>
@endsection

@section('section')

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom fw-bold">
                <i class="mdi mdi-pencil-outline me-2 text-primary"></i>
                تعديل السؤال
            </div>
            <div class="card-body">

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('common_questions.update', $commonQuestion->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            السؤال <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $commonQuestion->title) }}" />
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            الإجابة <span class="text-danger">*</span>
                        </label>
                        <textarea name="description" rows="5"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description', $commonQuestion->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="mdi mdi-content-save me-1"></i>
                            حفظ التعديلات
                        </button>
                        <a href="{{ route('common_questions.index') }}" class="btn btn-outline-secondary px-4">
                            إلغاء
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
