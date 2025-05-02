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





    public function store(Request $request)

    {
        // dd($request->all());

        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:attributes,code',
            'type' => 'required|in:text,select,multiselect,checkbox,boolean,textarea,price,datetime,date,image,file',
          ]);
         $attribute = Attribute::create([
             'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type,
            'is_required' => $request->has('is_required'),
            'is_unique' => $request->has('is_unique'),
            'value_per_locale' => $request->has('value_per_locale'),
            'value_per_channel' => $request->has('value_per_channel'),
            'is_configurable' => $request->has('is_configurable'),
            'visible_on_front' => $request->has('visible_on_front'),
            'is_comparable' => $request->has('is_comparable'),
            'use_in_navigation' => $request->has('use_in_navigation'),
        ]);
    
        // Only save options if the type supports multiple values
        if (in_array($request->type, ['select', 'multiselect', 'checkbox'])) {
            $names_en = $request->input('option_name_en', []);
            $names_fr = $request->input('option_name_fr', []);
            $colors = $request->input('color', []);
            $texts = $request->input('text_swatches', []);
    
            foreach ($names_en as $index => $en_name) {
                $value = [
                    'attribute_id' => $attribute->id,
                    'value_en' => $en_name,
                    'value_fr' => $names_fr[$index] ?? null,
                    'color' => $colors[$index] ?? null,
                    'text' => $texts[$index] ?? null,
                    'option_type' => $option_types[$index] ?? 'dropdown', // 👈 Save the selected type

                ];

                // dd($value);
    
                AttributeValue::create($value);
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



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:attributes,code,' . $id,
            'type' => 'required|in:text,select,multiselect,checkbox,boolean,textarea,price,datetime,date,image,file',
        ]);
    
        $attribute = Attribute::findOrFail($id);
        $attribute->update([
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type,
            'is_required' => $request->has('is_required'),
            'is_unique' => $request->has('is_unique'),
            'value_per_locale' => $request->has('value_per_locale'),
            'value_per_channel' => $request->has('value_per_channel'),
            'is_configurable' => $request->has('is_configurable'),
            'visible_on_front' => $request->has('visible_on_front'),
            'is_comparable' => $request->has('is_comparable'),
            'use_in_navigation' => $request->has('use_in_navigation'),
        ]);
    
        // Delete old values first
        $attribute->values()->delete();
    
        if (in_array($request->type, ['select', 'multiselect', 'checkbox'])) {
            $option_type = $request->input('option_type');
            $names_en = $request->input('option_name_en', []);
            $names_fr = $request->input('option_name_fr', []);
            $colors = $request->input('color', []);
            $texts = $request->input('text_swatches', []);
            $images = $request->file('image', []);
    
            foreach ($names_en as $index => $en_name) {
                $data = [
                    'attribute_id' => $attribute->id,
                    'value_en' => $en_name,
                    'value_fr' => $names_fr[$index] ?? null,
                    'option_type' => $option_type,
                ];
    
                if ($option_type === 'color') {
                    $data['color'] = $colors[$index] ?? null;
                } elseif ($option_type === 'text') {
                    $data['text'] = $texts[$index] ?? null;
                } elseif ($option_type === 'image' && isset($images[$index])) {
                    $path = $images[$index]->store('attribute_images', 'public');
                    $data['text'] = $path;
                }
    
                AttributeValue::create($data);
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
