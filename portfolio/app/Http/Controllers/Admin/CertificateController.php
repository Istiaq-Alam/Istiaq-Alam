<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Support\ImageUrl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CertificateController extends Controller
{
    public function index(): View
    {
        return view('admin.certificates.index', ['certificates' => Certificate::orderBy('sort_order')->get()]);
    }

    public function create(): View
    {
        return view('admin.certificates.form', ['certificate' => new Certificate()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Certificate::create($this->validated($request, true));

        return redirect()->route('admin.certificates.index')->with('success', 'Certificate created.');
    }

    public function edit(Certificate $certificate): View
    {
        return view('admin.certificates.form', ['certificate' => $certificate]);
    }

    public function update(Request $request, Certificate $certificate): RedirectResponse
    {
        $certificate->update($this->validated($request, false, $certificate));

        return redirect()->route('admin.certificates.index')->with('success', 'Certificate updated.');
    }

    public function destroy(Certificate $certificate): RedirectResponse
    {
        $certificate->delete();

        return redirect()->route('admin.certificates.index')->with('success', 'Certificate deleted.');
    }

    private function validated(Request $request, bool $imageRequired, ?Certificate $certificate = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif,svg', 'max:2048'],
            'credential_url' => ['nullable', 'string', 'max:2048'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = ImageUrl::encodeUpload($request->file('image'));
        } else {
            unset($data['image']);
        }

        $data['sort_order'] = $data['sort_order'] ?? ($certificate?->sort_order ?? 0);

        return $data;
    }
}
