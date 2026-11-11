<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Support\ImageUrl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public const CATEGORIES = ['CyberSecurity', 'Applications', 'Web development', 'Learn', 'Github'];

    public function index(): View
    {
        return view('admin.projects.index', ['projects' => Project::orderBy('sort_order')->get()]);
    }

    public function create(): View
    {
        return view('admin.projects.form', ['project' => new Project(), 'categories' => self::CATEGORIES]);
    }

    public function store(Request $request): RedirectResponse
    {
        Project::create($this->validated($request));

        return redirect()->route('admin.projects.index')->with('success', 'Project created.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.form', ['project' => $project, 'categories' => self::CATEGORIES]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $project->update($this->validated($request, $project));

        return redirect()->route('admin.projects.index')->with('success', 'Project updated.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted.');
    }

    private function validated(Request $request, ?Project $project = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'sub_category' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'project_url' => ['nullable', 'string', 'max:2048'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif,svg', 'max:2048'],
            'is_github_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = ImageUrl::encodeUpload($request->file('thumbnail'));
        } else {
            unset($data['thumbnail']);
        }

        $data['is_github_featured'] = $request->boolean('is_github_featured');
        $data['sort_order'] = $data['sort_order'] ?? ($project?->sort_order ?? 0);

        return $data;
    }
}
