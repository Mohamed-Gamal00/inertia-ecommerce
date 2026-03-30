<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VendorsController extends Controller
{
    public function index()
    {
        $vendors = Company::where('is_vendor', true)->withCount('products')->latest()->paginate(20);
        return view('dashboard.vendors.index', compact('vendors'));
    }

    public function show($id)
    {
        $vendor = Company::where('is_vendor', true)->withCount('products')->findOrFail($id);
        return view('dashboard.vendors.show', compact('vendor'));
    }

    public function approve($id)
    {
        Company::where('id', $id)->where('is_vendor', true)->update(['status' => 'active']);
        return back()->with('success', 'تم تفعيل حساب البائع بنجاح.');
    }

    public function suspend($id)
    {
        Company::where('id', $id)->where('is_vendor', true)->update(['status' => 'suspended']);
        return back()->with('dark', 'تم إيقاف حساب البائع.');
    }

    public function destroy($id)
    {
        Company::where('id', $id)->where('is_vendor', true)->delete();
        return redirect()->route('vendors.index')->with('dark', 'تم حذف البائع.');
    }
}
