<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the sliders.
     */
    public function index()
    {
        $sliders = Slider::orderBy('order')->paginate(10);
        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new slider.
     */
    public function create()
    {
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created slider in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'caption' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $imagePath = $request->file('image')->store('sliders', 'public');

        Slider::create([
            'image_path' => $imagePath,
            'caption' => $request->caption,
            'order' => $request->order ?? (Slider::max('order') + 1),
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified slider.
     */
    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified slider in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'caption' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($slider->image_path) {
                Storage::disk('public')->delete($slider->image_path);
            }
            $imagePath = $request->file('image')->store('sliders', 'public');
            $slider->image_path = $imagePath;
        }

        $slider->caption = $request->caption;
        $slider->order = $request->order ?? $slider->order;
        $slider->save();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil diperbarui.');
    }

    /**
     * Remove the specified slider from storage.
     */
    public function destroy(Slider $slider)
    {
        if ($slider->image_path) {
            Storage::disk('public')->delete($slider->image_path);
        }
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil dihapus.');
    }
}