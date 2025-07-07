<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobVacancyController extends Controller
{
    /**
     * Display a listing of job vacancies for admin.
     */
    public function index()
    {
        $jobVacancies = JobVacancy::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.job_vacancies.index', compact('jobVacancies'));
    }

    /**
     * Show the form for creating a new job vacancy.
     */
    public function create()
    {
        return view('admin.job_vacancies.create');
    }

    /**
     * Store a newly created job vacancy in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'contact_email' => 'nullable|email|max:255',
            'application_link' => 'nullable|url|max:255',
            'deadline' => 'nullable|date|after_or_equal:today',
        ]);

        JobVacancy::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'company_name' => $request->company_name,
            'location' => $request->location,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'contact_email' => $request->contact_email,
            'application_link' => $request->application_link,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('admin.job-vacancies.index')->with('success', 'Lowongan pekerjaan berhasil ditambahkan.');
    }

    /**
     * Display the specified job vacancy.
     */
    public function show(JobVacancy $jobVacancy)
    {
        return view('admin.job_vacancies.show', compact('jobVacancy'));
    }

    /**
     * Show the form for editing the specified job vacancy.
     */
    public function edit(JobVacancy $jobVacancy)
    {
        return view('admin.job_vacancies.edit', compact('jobVacancy'));
    }

    /**
     * Update the specified job vacancy in storage.
     */
    public function update(Request $request, JobVacancy $jobVacancy)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'contact_email' => 'nullable|email|max:255',
            'application_link' => 'nullable|url|max:255',
            'deadline' => 'nullable|date|after_or_equal:today',
        ]);

        $jobVacancy->update($request->all());

        return redirect()->route('admin.job-vacancies.index')->with('success', 'Lowongan pekerjaan berhasil diperbarui.');
    }

    /**
     * Remove the specified job vacancy from storage.
     */
    public function destroy(JobVacancy $jobVacancy)
    {
        $jobVacancy->delete();
        return redirect()->route('admin.job-vacancies.index')->with('success', 'Lowongan pekerjaan berhasil dihapus.');
    }

    /**
     * Display job vacancies for public (alumni & guru).
     */
    public function indexPublic(Request $request)
    {
        $query = JobVacancy::query();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('company_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('location', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        $jobVacancies = $query->orderBy('deadline', 'asc')->paginate(10);
        return view('job_vacancies.index', compact('jobVacancies'));
    }

    /**
     * Display job vacancy detail for public.
     */
    public function showPublic(JobVacancy $jobVacancy)
    {
        return view('job_vacancies.show', compact('jobVacancy'));
    }
}