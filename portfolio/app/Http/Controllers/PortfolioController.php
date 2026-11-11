<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Message;
use App\Models\Project;
use App\Models\Research;
use App\Models\Skill;
use App\Support\SiteDetails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        return view('portfolio', [
            'details' => SiteDetails::current(),
            'projects' => Project::where('is_github_featured', false)->orderBy('sort_order')->orderByDesc('id')->get(),
            'githubProjects' => Project::where('is_github_featured', true)->orderBy('sort_order')->orderByDesc('id')->get(),
            'researches' => Research::orderBy('sort_order')->orderByDesc('id')->get(),
            'skills' => Skill::orderBy('sort_order')->get(),
            'certificates' => Certificate::orderBy('sort_order')->orderByDesc('id')->get(),
        ]);
    }

    public function sendMessage(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        Message::create($data);

        return redirect(route('home').'#contact')->with('success', 'Thanks for reaching out! Your message has been sent.');
    }
}
