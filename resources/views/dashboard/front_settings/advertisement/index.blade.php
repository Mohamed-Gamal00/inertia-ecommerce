@extends('dashboard.index')
@section('title', 'الشريط المتحرك')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">شريط متحرك</li>
@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <x-alert type='success' />
                    <x-alert type='dark' />

                    <div class="container">
                        <table class="table mt-3 align-middle">
                            <thead>
                                <tr>
                                    <th>العنوان</th>
                                    <th>الحالة</th>
                                    <th>الاعدادات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($advertisements as $advertisement)
                                    <tr>
                                        <td>{{ $advertisement->title }}</td>
                                        <td>
                                            <span class="badge {{ $advertisement->is_active ? 'bg-success' : 'bg-secondary' }} fs-6 px-3 py-2">
                                                {{ $advertisement->is_active ? 'مفعل' : 'غير مفعل' }}
                                            </span>
                                        </td>
                                        <td class="d-flex align-items-center gap-2">

                                            {{-- Toggle button --}}
                                            <form action="{{ route('advertisements.toggle', $advertisement->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-sm {{ $advertisement->is_active ? 'btn-danger' : 'btn-success' }}"
                                                    title="{{ $advertisement->is_active ? 'إيقاف' : 'تفعيل' }}">
                                                    <i class="fas {{ $advertisement->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} me-1"></i>
                                                    {{ $advertisement->is_active ? 'إيقاف' : 'تفعيل' }}
                                                </button>
                                            </form>

                                            {{-- Edit button --}}
                                            <a href="{{ route('advertisements.edit', $advertisement->id) }}"
                                                class="btn btn-sm btn-primary" title="تعديل">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
