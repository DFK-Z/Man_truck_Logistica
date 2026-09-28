<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::where('is_approved', true)
            ->with('user')
            ->latest()
            ->paginate(12); // По 12 отзывов на страницу

        return view('reviews.index', compact('reviews'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|min:3|max:1000',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'message' => $validated['message'],
            'rating' => $validated['rating'] ?? 5,
            'is_approved' => true,
        ]);

        return back()->with('success', 'Спасибо за ваш отзыв!');
    }
}
