<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DiscountCode;

class DiscountCodeController extends Controller
{
    // Show all discount codes
    public function index()
    {
        $discounts = DiscountCode::orderBy('id', 'DESC')->get();
        return view('backend.discount.index', compact('discounts'));
    }  

    // Show add form
    public function create()
    {
        return view('backend.discount.create');
    }

    // Store new discount
    public function store(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'code' => 'required|unique:discount_codes,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:1'
        ]);

        DiscountCode::create([
            'code' => $request->code,
            'type' => $request->type,
            'value' => $request->value,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'usage_limit' => $request->usage_limit ?? null,
            'used_count' => 0,
            'is_active' => true,
        ]);

                // dd($request->all());


        return redirect()->route('discount.index')->with('success', 'Discount code created successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $discount = DiscountCode::findOrFail($id);
        return view('backend.discount.edit', compact('discount'));
    }

    // Update code
    public function update(Request $request, $id)
    {
        $discount = DiscountCode::findOrFail($id);

        $request->validate([
            'code' => 'required|unique:discount_codes,code,' . $discount->id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:1'
        ]);

        $discount->update($request->all());

        return redirect()->route('discount.index')->with('success', 'Discount code updated successfully.');
    }

    // Delete code
    public function destroy($id)
    {
        $discount = DiscountCode::findOrFail($id);
        $discount->delete();
        return redirect()->back()->with('success', 'Discount code deleted.');
    }

    // Toggle status
    public function toggleStatus($id)
    {
        $discount = DiscountCode::findOrFail($id);
        $discount->is_active = !$discount->is_active;
        $discount->save();

        return redirect()->back()->with('success', 'Status updated.');
    }
}
