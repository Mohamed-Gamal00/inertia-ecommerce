<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Models\BulkOrder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BulkOrderController extends Controller
{
    public function index()
    {
        return Inertia::render('BulkOrder/Index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'description'  => 'required|string',
        ]);

        BulkOrder::create($request->all());

        return redirect()->back()->with('success', 'تم إرسال طلبك بنجاح، سنتواصل معك قريباً.');
    }
}
