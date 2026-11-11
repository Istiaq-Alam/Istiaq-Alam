<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Support\SiteDetails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteDetailsController extends Controller
{
    public function edit(): View
    {
        return view('admin.details', ['details' => SiteDetails::current()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'job_title' => ['required', 'string', 'max:255'],
            'about_1' => ['required', 'string', 'max:5000'],
            'about_2' => ['required', 'string', 'max:5000'],
            'education' => ['array'],
            'education.*.title' => ['required', 'string', 'max:255'],
            'education.*.period' => ['required', 'string', 'max:255'],
            'education.*.text' => ['required', 'string', 'max:2000'],
            'experience' => ['array'],
            'experience.*.title' => ['required', 'string', 'max:255'],
            'experience.*.period' => ['required', 'string', 'max:255'],
            'experience.*.text' => ['required', 'string', 'max:2000'],
        ]);

        $data['education'] = array_values($data['education'] ?? []);
        $data['experience'] = array_values($data['experience'] ?? []);

        SiteSetting::store(SiteDetails::KEY, $data);

        return redirect()->route('admin.details.edit')->with('success', 'Details updated.');
    }
}
