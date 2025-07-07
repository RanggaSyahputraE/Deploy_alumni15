<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumni;
use App\Models\News;
use App\Models\Education;
use App\Models\Work;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AlumniController extends Controller
{
    /**
     * Show alumni dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $alumni = $user->alumni;
        $latestNews = News::orderBy('created_at', 'desc')->take(5)->get();
        return view('alumni.dashboard', compact('alumni', 'latestNews'));
    }

    /**
     * Show edit profile form.
     */
    public function editProfile()
    {
        $user = Auth::user();
        $alumni = $user->alumni;
        $alumni->load('educations', 'works');
        return view('alumni.profile.edit', compact('user', 'alumni'));
    }

    /**
     * Update alumni profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $alumni = $user->alumni;

        // Update foto profil
        if ($request->update_type === 'photo') {
            $request->validate([
                'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $user->profile_photo_path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->save();

            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
        }

        // Update password (jika diperlukan)
        if ($request->update_type === 'password') {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Password saat ini salah.']);
            }

            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->back()->with('success', 'Password berhasil diperbarui.');
        }

        // Update data profil umum
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'full_name' => 'required|string|max:255',
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'graduation_year' => 'required|integer|min:1900|max:' . date('Y'),
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
            'social_media_facebook' => 'nullable|url|max:255',
            'social_media_instagram' => 'nullable|url|max:255',
            'social_media_linkedin' => 'nullable|url|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $alumni->update($request->only([
            'full_name',
            'place_of_birth',
            'date_of_birth',
            'gender',
            'address',
            'graduation_year',
            'phone_number',
            'social_media_facebook',
            'social_media_instagram',
            'social_media_linkedin',
        ]));

        // Hapus semua riwayat pendidikan & simpan ulang
            $alumni->educations()->delete();
            if ($request->has('educations')) {
                foreach ($request->educations as $eduData) {
                    $alumni->educations()->create($eduData);
                }
            }

            // Hapus semua riwayat pekerjaan & simpan ulang
            $alumni->works()->delete();
            if ($request->has('works')) {
                foreach ($request->works as $workData) {
                    $workData['is_current'] = isset($workData['is_current']);
                    $alumni->works()->create($workData);
                }
            }

            //==

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Search alumni.
     */
    public function searchAlumni(Request $request)
    {
        $query = Alumni::query();

        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->filled('graduation_year')) {
            $query->where('graduation_year', $request->graduation_year);
        }

        $alumni = $query->paginate(10);

        return view('alumni.search_results', compact('alumni'));
    }

    /**
     * View alumni detail.
     */
    public function viewAlumniDetail(Alumni $alumni)
    {
        return view('alumni.view_detail', compact('alumni'));
    }

    //debug

    


}

