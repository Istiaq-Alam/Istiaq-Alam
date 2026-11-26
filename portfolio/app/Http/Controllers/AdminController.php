<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Message;
use App\Models\Project;
use App\Models\Research;
use App\Models\Skill;
use App\Support\SiteDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function showLogin(): View
    {
        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function confirmPassword(Request $request): JsonResponse
    {
        $password = (string) $request->input('admin_password', '');

        return response()->json(['ok' => $password !== '' && Hash::check($password, $request->user()->password)]);
    }

    public function dashboard(): View
    {
        $details = SiteDetails::current();

        return view('admin.dashboard', [
            'projectCount' => Project::count(),
            'researchCount' => Research::count(),
            'skillCount' => Skill::count(),
            'certificateCount' => Certificate::count(),
            'unreadCount' => Message::where('is_read', false)->count(),
            'ogImage' => SiteDetails::ogImageUrl() ?? asset('assets/images/og-image.jpg'),
            'ogCard' => [
                'endpoint' => route('admin.og-image.store'),
                'photo' => '/profile-photo?v='.SiteDetails::photoVersion(),
                'name' => $details['name'],
                'jobTitle' => $details['job_title'],
                'summary' => SiteDetails::summary($details, 220),
                'domain' => parse_url((string) config('app.url'), PHP_URL_HOST) ?: 'www.istiaq-alam.me',
            ],
        ]);
    }
}
