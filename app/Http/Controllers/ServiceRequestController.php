<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Models\ServicesRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ServiceRequestController extends Controller
{
    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $documents = collect($request->file('documents', []))
            ->map(fn (UploadedFile $file) => [
                'name' => $file->getClientOriginalName(),
                'path' => $file->store('service-requests/documents', 'public'),
                'size' => $file->getSize(),
            ])->all();

        ServicesRequest::create([
            ...collect($data)->except('documents')->all(),
            'reference' => 'SR-'.Str::upper(Str::random(8)),
            'status' => 'pending',
            'documents' => $documents,
            'meta' => ['source' => 'website', 'ip' => $request->ip()],
        ]);

        return back()->with('success', 'تم استلام طلبك بنجاح! سنتواصل معك خلال 24 ساعة.');
    }
}
