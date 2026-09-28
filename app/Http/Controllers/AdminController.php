<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $trucks = Truck::all();
        return view('admin.index', compact('trucks'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('trucks', 'public');
            $validated['image'] = $path;
        }

        Truck::create($validated);
        return redirect()->route('admin.index')->with('success', 'Грузовик добавлен!');
    }

    public function edit(Truck $truck)
    {
        return view('admin.edit', compact('truck'));
    }

    public function update(Request $request, Truck $truck)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($truck->image && Storage::disk('public')->exists($truck->image)) {
                Storage::disk('public')->delete($truck->image);
            }
            $path = $request->file('image')->store('trucks', 'public');
            $validated['image'] = $path;
        }

        $truck->update($validated);
        return redirect()->route('admin.index')->with('success', 'Грузовик обновлен!');
    }

    public function destroy(Truck $truck)
    {
        if ($truck->image && Storage::disk('public')->exists($truck->image)) {
            Storage::disk('public')->delete($truck->image);
        }
        $truck->delete();
        return redirect()->route('admin.index')->with('success', 'Грузовик удален!');
    }
}
