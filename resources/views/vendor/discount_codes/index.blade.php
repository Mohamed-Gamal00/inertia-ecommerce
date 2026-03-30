@extends('vendor.layouts.app')
@section('title', 'كوبونات الخصم')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">كوبونات الخصم الخاصه بي</h5>
    <a href="{{ route('vendor.discount_code.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="mdi mdi-plus-circle-outline"></i> إضافة كوبون جديد
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>الاسم</th>
                        <th>الكود</th>
                        <th>الخصم</th>
                        <th>مرات الاستخدام</th>
                        <th>الحالة</th>
                        <th width="100">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($discounts as $code)
                        <tr>
                            <td class="fw-bold">{{ $code->name }}</td>
                            <td><code class="bg-light px-2 py-1 rounded text-primary">{{ $code->code }}</code></td>
                            <td>{{ $code->price }} {{ $code->discount_type == 'percentage' ? '%' : 'ر.س' }}</td>
                            <td>{{ $code->number_of_used }}</td>
                            <td>
                                @if($code->status)
                                    <span class="badge bg-success">نشط</span>
                                @else
                                    <span class="badge bg-danger">غير نشط</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('vendor.discount_code.edit', $code->id) }}" class="btn btn-sm btn-outline-primary" title="تعديل">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <form action="{{ route('vendor.discount_code.destroy', $code->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الكوبون؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                            <i class="mdi mdi-trash-can-outline"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="mdi mdi-ticket-percent-outline d-block fs-1 mb-2"></i>
                                لا توجد كوبونات خصم حالياً
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $discounts->links() }}
        </div>
    </div>
</div>

@endsection
