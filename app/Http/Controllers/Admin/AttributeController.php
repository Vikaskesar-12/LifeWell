<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\AttributeValue;

class AttributeController extends Controller
{
    // Show all attributes
    public function index()
    {
        $attributes = Attribute::with('values')->get();
        return view('backend.attribute.index', compact('attributes'));
    }

    // Show create form
    public function create()
    {

        // dd('bhucdbu');
        return view('backend.attribute.create');
    }

    // Store new attribute
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:attributes,code',
            'type' => 'required|in:text,select,multiselect',
            'values' => 'nullable|array'
        ]);

        $attribute = Attribute::create([
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type
        ]);

        // If select or multiselect, save values
        if (in_array($request->type, ['select', 'multiselect']) && $request->has('values')) {
            foreach ($request->values as $value) {
                AttributeValue::create([
                    'attribute_id' => $attribute->id,
                    'value' => $value
                ]);
            }
        }

        return redirect()->route('admin.attributes.index')->with('success', 'Attribute created successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $attribute = Attribute::with('values')->findOrFail($id);
        return view('backend.attribute.edit', compact('attribute'));
    }

    // Update attribute
    public function update(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:attributes,code,' . $attribute->id,
            'type' => 'required|in:text,select,multiselect',
            'values' => 'nullable|array'
        ]);

        $attribute->update([
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type
        ]);

        // Update values
        AttributeValue::where('attribute_id', $attribute->id)->delete();

        if (in_array($request->type, ['select', 'multiselect']) && $request->has('values')) {
            foreach ($request->values as $value) {
                AttributeValue::create([
                    'attribute_id' => $attribute->id,
                    'value' => $value
                ]);
            }
        }

        return redirect()->route('admin.attributes.index')->with('success', 'Attribute updated successfully.');
    }

        // Delete attribute
        public function destroy($id)
        {
            $attribute = Attribute::findOrFail($id);
            $attribute->delete();
            return redirect()->route('admin.attributes.index')->with('success', 'Attribute deleted.');
        }
}
