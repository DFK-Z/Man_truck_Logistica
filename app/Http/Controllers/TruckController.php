<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use App\Models\Review;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    public function index()
    {
        $trucks = Truck::all();
        $reviews = Review::where('is_approved', true)
            ->with('user')
            ->latest()
            ->take(3) // ← ТОЛЬКО 3 ОТЗЫВА НА ГЛАВНОЙ
            ->get();

        return view('welcome', compact('trucks', 'reviews'));
    }

    public function show(Int $id)
    {
        $truck = Truck::findOrFail($id);
        $truck->increment('views');
        return view('truck-detail', compact('truck'));
    }
}
