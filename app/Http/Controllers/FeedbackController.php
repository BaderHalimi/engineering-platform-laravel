<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Feedback;
use Illuminate\Http\RedirectResponse;

class FeedbackController extends Controller
{
    public function store(StoreFeedbackRequest $request): RedirectResponse
    {
        $attachments = collect($request->file('attachments', []))
            ->map(fn ($file) => $file->store('feedback-attachments', 'public'))
            ->all();

        Feedback::create([
            ...$request->safe()->only(['email', 'title', 'content']),
            'attachments' => $attachments,
        ]);

        return back()->with('success', __('home.feedback.submit').' ✔');
    }
}
