@extends('layouts.app')

@section('title', 'Tambah Lowongan Pekerjaan - Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-plus"></i> Tambah Lowongan Pekerjaan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.job-vacancies.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-briefcase"></i> Form Tambah Lowongan Pekerjaan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.job-vacancies.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="title"><i class="fas fa-heading"></i> Judul Lowongan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="company_name"><i class="fas fa-building"></i> Nama Perusahaan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                       id="company_name" name="company_name" value="{{ old('company_name') }}" required>
                                @error('company_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="location"><i class="fas fa-map-marker-alt"></i> Lokasi</label>
                                        <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                               id="location" name="location" value="{{ old('location') }}">
                                        @error('location')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="salary_range"><i class="fas fa-money-bill-wave"></i> Rentang Gaji</label>
                                        <input type="text" class="form-control @error('salary_range') is-invalid @enderror" 
                                               id="salary_range" name="salary_range" value="{{ old('salary_range') }}"
                                               placeholder="Contoh: Rp 5.000.000 - Rp 8.000.000">
                                        @error('salary_range')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description"><i class="fas fa-align-left"></i> Deskripsi Pekerjaan <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="8" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="requirements"><i class="fas fa-list-ul"></i> Persyaratan</label>
                                <textarea class="form-control @error('requirements') is-invalid @enderror" 
                                          id="requirements" name="requirements" rows="6">{{ old('requirements') }}</textarea>
                                @error('requirements')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="deadline"><i class="fas fa-calendar"></i> Deadline Lamaran</label>
                                <input type="date" class="form-control @error('deadline') is-invalid @enderror" 
                                       id="deadline" name="deadline" value="{{ old('deadline') }}">
                                @error('deadline')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="contact_email"><i class="fas fa-envelope"></i> Email Kontak</label>
                                <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                                       id="contact_email" name="contact_email" value="{{ old('contact_email') }}">
                                @error('contact_email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="contact_phone"><i class="fas fa-phone"></i> Telepon Kontak</label>
                                <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" 
                                       id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}">
                                @error('contact_phone')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="application_url"><i class="fas fa-link"></i> URL Lamaran</label>
                                <input type="url" class="form-control @error('application_url') is-invalid @enderror" 
                                       id="application_url" name="application_url" value="{{ old('application_url') }}"
                                       placeholder="https://example.com/apply">
                                @error('application_url')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        <i class="fas fa-eye"></i> Publikasikan Lowongan
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan Lowongan
                        </button>
                        <a href="{{ route('admin.job-vacancies.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection