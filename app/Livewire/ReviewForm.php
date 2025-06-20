<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewForm extends Component
{
    public $appointment;
    public $rating = 0;
    public $comment = '';
    public $review;

    public function mount($appointment)
    {
        $this->appointment = $appointment;
        $this->review = Review::where('appointment_id', $this->appointment->id)->first();

        if ($this->review) {
            $this->rating = $this->review->rating;
            $this->comment = $this->review->comment;
        }
    }

    public function saveReview()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        if ($this->review) {
            $this->review->update([
                'rating' => $this->rating,
                'comment' => $this->comment,
            ]);
        } else {
            Review::create([
                'appointment_id' => $this->appointment->id,
                'specialist_id' => $this->appointment->assignedSpecialist->id,
                'user_id' => Auth::id(),
                'rating' => $this->rating,
                'comment' => $this->comment,
            ]);
        }

        session()->flash('success', 'Votre avis a été enregistré.');
    }

    public function render()
    {
        return view('livewire.review-form');
    }
}
