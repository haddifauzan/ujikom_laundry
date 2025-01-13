<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function toggleDisplay(Review $review)
    {
        $review->update([
            'is_displayed' => !$review->is_displayed
        ]);

        return redirect()->back()->with('success', 
            $review->is_displayed ? 'Review is now visible on homepage.' : 'Review has been hidden from homepage.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->back()->with('success', 'Review has been deleted successfully.');
    }
}
