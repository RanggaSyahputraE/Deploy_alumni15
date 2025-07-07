<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumni;
use App\Models\User;
use App\Models\Teacher;
use App\Models\News;
use App\Models\Slider;
use App\Models\Role;
use App\Exports\StatisticsExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    // Menampilkan dashboard admin
    public function index()
    {
        $totalAlumni = Alumni::count();
        $totalGuru = Teacher::count();
        $totalBerita = News::count();
        $sliders = Slider::orderBy('order')->get();

        return view('admin.dashboard', compact('totalAlumni', 'totalGuru', 'totalBerita', 'sliders'));
    }

    // Menampilkan daftar alumni dengan fitur pencarian dan filter
    public function alumniIndex(Request $request)
    {
        $query = Alumni::with('user');

        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('graduation_year')) {
            $query->where('graduation_year', $request->graduation_year);
        }

        $alumni = $query->orderBy('graduation_year', 'desc')->paginate(10)->withQueryString();

        return view('admin.alumni.index', compact('alumni'));
    }

    // Menampilkan form tambah alumni
    public function alumniCreate()
    {
        return view('admin.alumni.create');
    }

    // Menyimpan data alumni baru
    public function alumniStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'full_name' => 'required|string|max:255',
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'address' => 'nullable|string',
            'graduation_year' => 'required|integer|min:1900|max:' . date('Y'),
            'phone_number' => 'nullable|string|max:20',
            'social_media_facebook' => 'nullable|url|max:255',
            'social_media_instagram' => 'nullable|url|max:255',
            'social_media_linkedin' => 'nullable|url|max:255',
        ]);

        $alumniRole = Role::where('name', 'alumni')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $alumniRole->id,
        ]);

        Alumni::create([
            'user_id' => $user->id,
            'full_name' => $request->full_name,
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'graduation_year' => $request->graduation_year,
            'phone_number' => $request->phone_number,
            'social_media_facebook' => $request->social_media_facebook,
            'social_media_instagram' => $request->social_media_instagram,
            'social_media_linkedin' => $request->social_media_linkedin,
        ]);

        return redirect()->route('admin.alumni.index')->with('success', 'Data alumni berhasil ditambahkan.');
    }

    // Menampilkan detail alumni
    public function alumniShow(Alumni $alumni)
    {
        $alumni->load('educations', 'works', 'user');
        return view('admin.alumni.show', compact('alumni'));
    }

    // Menampilkan form edit alumni
    public function alumniEdit(Alumni $alumni)
    {
        $alumni->load('educations', 'works', 'user');
        return view('admin.alumni.edit', compact('alumni'));
    }

    // Menyimpan update data alumni
    public function alumniUpdate(Request $request, Alumni $alumni)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $alumni->user->id,
            'full_name' => 'required|string|max:255',
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'address' => 'nullable|string',
            'graduation_year' => 'required|integer|min:1900|max:' . date('Y'),
            'phone_number' => 'nullable|string|max:20',
            'social_media_facebook' => 'nullable|url|max:255',
            'social_media_instagram' => 'nullable|url|max:255',
            'social_media_linkedin' => 'nullable|url|max:255',
        ]);

        $alumni->user->update([
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

        return redirect()->route('admin.alumni.index')->with('success', 'Data alumni berhasil diperbarui.');
    }

    // Menghapus data alumni
    public function alumniDestroy(Alumni $alumni)
    {
        $alumni->user->delete();
        return redirect()->route('admin.alumni.index')->with('success', 'Data alumni berhasil dihapus.');
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


    // Menampilkan form edit profil admin
    public function editProfile()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    // Memperbarui data profil admin
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $type = $request->input('update_type');

        if ($type === 'photo') {
            $request->validate([
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($request->hasFile('profile_photo')) {
                if ($user->profile_photo_path) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }

                $path = $request->file('profile_photo')->store('profile-photos', 'public');
                $user->profile_photo_path = $path;
                $user->save();
            }

            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
        }

        if ($type === 'profile') {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            ]);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
        }

        if ($type === 'password') {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|confirmed|min:8',
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini salah.']);
            }

            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->back()->with('success', 'Password berhasil diganti.');
        }

        return redirect()->back()->with('error', 'Permintaan tidak valid.');
    }

    // Menampilkan daftar guru
    public function guruIndex(Request $request)
    {
        $query = Teacher::with('user');

        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', function ($q) use ($request) {
                    $q->where('email', 'like', '%' . $request->search . '%');
                });
        }

        $teachers = $query->orderBy('full_name')->paginate(10);
        return view('admin.guru.index', compact('teachers'));
    }

    // Menampilkan form tambah guru
    public function guruCreate()
    {
        return view('admin.guru.create');
    }

    // Menampilkan detail guru
    public function guruShow(Teacher $teacher)
    {
        $teacher->load('user');
        return view('admin.guru.show', compact('teacher'));
    }

    // Menampilkan form edit guru
    public function guruEdit(Teacher $teacher)
    {
        $teacher->load('user');
        return view('admin.guru.edit', compact('teacher'));
    }

    // Menyimpan update data guru
    public function guruUpdate(Request $request, $id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $teacher->user->id,
            'full_name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:100',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $teacher->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->boolean('is_active'),
        ]);

        $teacher->update([
            'full_name' => $request->full_name,
            'nip' => $request->nip,
            'subject' => $request->subject,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    // Menyimpan data guru baru
public function guruStore(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|confirmed|min:6',
        'full_name' => 'required|string|max:255',
        'nip' => 'nullable|string|max:50',
        'subject' => 'nullable|string|max:100',
        'phone_number' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'is_active' => 'nullable|boolean',
    ]);

    $guruRole = Role::where('name', 'guru')->firstOrFail();

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role_id' => $guruRole->id,
        'is_active' => $request->has('is_active'),
    ]);

    Teacher::create([
        'user_id' => $user->id,
        'full_name' => $request->full_name,
        'nip' => $request->nip,
        'subject' => $request->subject,
        'phone_number' => $request->phone_number,
        'address' => $request->address,
    ]);

    return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan.');
}


    // Fungsi cetak alumni satuan atau semua
    public function printAlumni($id = null)
    {
        if ($id) {
            $alumni = Alumni::with(['user', 'educations', 'works'])->findOrFail($id);
            return view('admin.alumni.print_single', compact('alumni'));
        } else {
            $alumni = Alumni::with('user')->get();
            return view('admin.alumni.print_all', compact('alumni'));
        }
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
        
        return view('admin.rekapitulasi.index', compact('rekapitulasi', 'totalAlumni'));
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
            return redirect()->route('admin.rekapitulasi.index')
                ->with('error', 'Tidak ada data alumni untuk tahun ' . $year);
        }

        return view('admin.rekapitulasi.detail', compact('alumni', 'year'));
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

        return view('admin.rekapitulasi.print', compact('alumni', 'year'));
    }

    
}
