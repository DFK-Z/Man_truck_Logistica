<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('user')->latest()->get();
        return view('admin.reviews', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);
        return back()->with('success', 'Отзыв одобрен!');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Отзыв удален!');
    }
    public function toggleApproval(Review $review)
    {
        $review->update(['is_approved' => !$review->is_approved]);
        $status = $review->is_approved ? 'одобрен' : 'скрыт';
        return back()->with('success', "Отзыв $status!");
    }
}
