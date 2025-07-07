<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumni;
use App\Models\Teacher;
use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    // Menampilkan halaman dashboard guru
    public function index()
    {
        $user = Auth::user();
        $teacher = $user->teacher;
        $latestNews = News::orderBy('created_at', 'desc')->take(5)->get();

        return view('guru.dashboard', compact('teacher', 'latestNews'));
    }

    // Menampilkan daftar alumni dengan fitur filter (nama, gender, tahun lulus)
    public function listAlumni(Request $request)
    {
        $query = Alumni::with('user');

        // 🔍 Filter berdasarkan nama (search)
        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%');
        }

        // 👤 Filter berdasarkan gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // 📅 Filter berdasarkan tahun kelulusan
        if ($request->filled('graduation_year')) {
            $query->where('graduation_year', $request->graduation_year);
        }

        // Paginate + simpan query string
        $alumni = $query->paginate(10)->withQueryString();

        return view('guru.alumni.index', compact('alumni'));
    }

    // Menampilkan detail 1 alumni
    public function showAlumni(Alumni $alumni)
    {
        $alumni->load('user', 'educations', 'works');
        return view('guru.alumni.show', compact('alumni'));
    }

    // Cetak satu alumni ke tampilan print
    public function printAlumni($id)
    {
        $alumni = Alumni::with(['user', 'educations', 'works'])->findOrFail($id);
        return view('guru.alumni.print_single', compact('alumni'));
    }

    // Cetak seluruh data alumni
    public function printAllAlumni()
    {
        $alumni = Alumni::with('user')->get();
        return view('guru.alumni.print_all', compact('alumni'));
    }

// Menampilkan statistik alumni
public function showStatistics()
{
    $alumniByYear = \App\Models\Alumni::selectRaw('graduation_year, COUNT(*) as total')
        ->groupBy('graduation_year')
        ->orderBy('graduation_year')
        ->get();

    $alumniByGender = \App\Models\Alumni::selectRaw('gender, COUNT(*) as total')
        ->groupBy('gender')
        ->get();

    $educationStats = \App\Models\AlumniEducation::selectRaw('degree, COUNT(*) as total')
        ->groupBy('degree')
        ->orderByDesc('total')
        ->get();

    $workStats = \App\Models\AlumniWork::selectRaw('position, COUNT(*) as total')
        ->groupBy('position')
        ->orderByDesc('total')
        ->limit(10)
        ->get();

    $currentWorkStats = \App\Models\AlumniWork::where('is_current', true)->count();
    $notWorkingStats = \App\Models\Alumni::whereDoesntHave('works')->count();

    return view('admin.statistics', compact(
        'alumniByYear',
        'alumniByGender',
        'educationStats',
        'workStats',
        'currentWorkStats',
        'notWorkingStats'
    ));
}



    // Menampilkan form edit profil guru
    public function editProfile()
    {
        $user = Auth::user();
        $teacher = $user->teacher;
        return view('guru.profile.edit', compact('user', 'teacher'));
    }

    // Memperbarui profil guru berdasarkan tipe update
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;
        $updateType = $request->input('update_type');

        // ✅ Update foto profil
        if ($updateType === 'photo') {
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

        // ✅ Update password
        if ($updateType === 'password') {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini salah.']);
            }

            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->back()->with('success', 'Password berhasil diperbarui.');
        }

        // ✅ Update data profil umum (nama, email, NIP, dll)
        if ($updateType === 'profile') {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'full_name' => 'required|string|max:255',
                'nip' => 'nullable|string|unique:teachers,nip,' . $teacher->id,
                'phone_number' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'subject' => 'nullable|string|max:255',
            ]);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $teacher->update([
                'full_name' => $request->full_name,
                'nip' => $request->nip,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'subject' => $request->subject,
            ]);

            return redirect()->route('guru.dashboard')->with('success', 'Profil berhasil diperbarui.');
        }

        // ❌ Permintaan tidak valid
        return back()->withErrors(['update_type' => 'Permintaan tidak valid.']);
    }

    // ==========================================
    // METHODS UNTUK REKAPITULASI ALUMNI
    // ==========================================

    /**
     * Menampilkan ringkasan rekapitulasi berdasarkan tahun kelulusan
     */
    public function rekapitulasiIndex()
    {
        $rekapitulasi = Alumni::selectRaw('graduation_year, COUNT(*) as total_alumni')
            ->groupBy('graduation_year')
            ->orderBy('graduation_year', 'desc')
            ->get();

        $totalAlumni = Alumni::count();
        
        return view('guru.rekapitulasi.index', compact('rekapitulasi', 'totalAlumni'));
    }

    /**
     * Menampilkan detail alumni berdasarkan tahun kelulusan
     */
    public function rekapitulasiDetail($year)
    {
        $alumni = Alumni::with(['user', 'educations', 'works'])
            ->where('graduation_year', $year)
            ->orderBy('full_name')
            ->get();

        if ($alumni->isEmpty()) {
            return redirect()->route('guru.rekapitulasi.index')
                ->with('error', 'Tidak ada data alumni untuk tahun ' . $year);
        }

        return view('guru.rekapitulasi.detail', compact('alumni', 'year'));
    }

    /**
     * Print detail alumni berdasarkan tahun kelulusan
     */
    public function rekapitulasiPrint($year)
    {
        $alumni = Alumni::with(['user', 'educations', 'works'])
            ->where('graduation_year', $year)
            ->orderBy('full_name')
            ->get();

        if ($alumni->isEmpty()) {
            abort(404, 'Tidak ada data alumni untuk tahun ' . $year);
        }

        return view('guru.rekapitulasi.print', compact('alumni', 'year'));
    }
    
    
}


