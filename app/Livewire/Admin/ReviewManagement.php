<?php

namespace App\Livewire\Admin;


use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Review;

class ReviewManagement extends Component
{
    use WithPagination;

    public $perPage = 10;



    public function acceptReview($id)
    {
        $review = Review::find($id);
        if ($review) {
            $review->update(['status' => 'accepted']);
        }
    }

    public function refuseReview($id)
    {
        $review = Review::find($id);
        if ($review) {
            $review->update(['status' => 'refused']);
        }
    }

    public function render()
    {
        $reviews = Review::where('status', 'pending')->paginate($this->perPage);

        return view('livewire.admin.review-management', compact('reviews'));
    }
}
