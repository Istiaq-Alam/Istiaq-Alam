<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Research;
use App\Support\ImageUrl;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ResearchController extends Controller
{
    public function index(): View
    {
        return view('admin.researches.index', ['researches' => Research::orderBy('sort_order')->orderByDesc('id')->get()]);
    }

    public function create(): View
    {
        return view('admin.researches.form', ['research' => new Research(), 'publishedDate' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        Research::where('sort_order', '>=', $data['sort_order'])->increment('sort_order');
        Research::create($data);

        return redirect()->route('admin.researches.index')->with('success', 'Research created.');
    }

    public function edit(Research $research): View
    {
        return view('admin.researches.form', [
            'research' => $research,
            'publishedDate' => $this->toInputDate($research->published_date),
        ]);
    }

    public function update(Request $request, Research $research): RedirectResponse
    {
        $research->update($this->validated($request, $research));

        return redirect()->route('admin.researches.index')->with('success', 'Research updated.');
    }

    public function pdf(Research $research): Response
    {
        abort_unless($research->pdf, 404);

        $binary = base64_decode(substr($research->pdf, strlen('data:application/pdf;base64,')));

        return response($binary, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.Str::slug($research->title ?: 'research').'.pdf"',
        ]);
    }

    public function destroy(Research $research): RedirectResponse
    {
        $research->delete();

        return redirect()->route('admin.researches.index')->with('success', 'Research deleted.');
    }

    private function validated(Request $request, ?Research $research = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'published_date' => ['required', 'date'],
            'description' => ['required', 'string'],
            'research_url' => ['nullable', 'string', 'max:2048'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif,svg', 'max:2048'],
            'pdf' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = ImageUrl::encodeUpload($request->file('thumbnail'));
        } else {
            unset($data['thumbnail']);
        }

        if ($request->hasFile('pdf')) {
            $data['pdf'] = 'data:application/pdf;base64,'.base64_encode($request->file('pdf')->get());
        } else {
            unset($data['pdf']);
        }

        $data['sort_order'] = $data['sort_order'] ?? ($research?->sort_order ?? 0);
        $data['published_date'] = Carbon::parse($data['published_date'])->format('F d, Y');

        return $data;
    }

    private function toInputDate(string $value): ?string
    {
        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable) {
            return null;
        }
    }
}
