@extends('layouts.app')

@section('title', 'Tambah Alumni - Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-user-plus"></i> Tambah Data Alumni</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.alumni.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Form Tambah Alumni</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.alumni.store') }}" method="POST">
                    @csrf
                    
                    <!-- Data User -->
                    <h6 class="text-primary"><i class="fas fa-user"></i> Data Akun</h6>
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name"><i class="fas fa-user"></i> Nama Pengguna <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email"><i class="fas fa-envelope"></i> Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password"><i class="fas fa-lock"></i> Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation"><i class="fas fa-lock"></i> Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>

                    <!-- Data Alumni -->
                    <h6 class="text-success mt-4"><i class="fas fa-graduation-cap"></i> Data Alumni</h6>
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="full_name"><i class="fas fa-id-card"></i> Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                       id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                                @error('full_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="place_of_birth"><i class="fas fa-map-marker-alt"></i> Tempat Lahir</label>
                                <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror" 
                                       id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth') }}">
                                @error('place_of_birth')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date_of_birth"><i class="fas fa-calendar"></i> Tanggal Lahir</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                       id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                                @error('date_of_birth')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="gender"><i class="fas fa-venus-mars"></i> Jenis Kelamin</label>
                                <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="graduation_year"><i class="fas fa-graduation-cap"></i> Tahun Kelulusan <span class="text-danger">*</span></label>
                                <select class="form-control @error('graduation_year') is-invalid @enderror" 
                                        id="graduation_year" name="graduation_year" required>
                                    <option value="">Pilih Tahun Kelulusan</option>
                                    @for($year = date('Y'); $year >= 1990; $year--)
                                        <option value="{{ $year }}" {{ old('graduation_year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                                @error('graduation_year')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="address"><i class="fas fa-home"></i> Alamat</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3">{{ old('address') }}</textarea>
                        @error('address')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_number"><i class="fas fa-phone"></i> Nomor Telepon</label>
                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" 
                                       id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                                @error('phone_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <h6 class="text-info mt-4"><i class="fas fa-share-alt"></i> Media Sosial</h6>
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="social_media_facebook"><i class="fab fa-facebook"></i> Facebook</label>
                                <input type="url" class="form-control @error('social_media_facebook') is-invalid @enderror" 
                                       id="social_media_facebook" name="social_media_facebook" value="{{ old('social_media_facebook') }}"
                                       placeholder="https://facebook.com/username">
                                @error('social_media_facebook')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="social_media_instagram"><i class="fab fa-instagram"></i> Instagram</label>
                                <input type="url" class="form-control @error('social_media_instagram') is-invalid @enderror" 
                                       id="social_media_instagram" name="social_media_instagram" value="{{ old('social_media_instagram') }}"
                                       placeholder="https://instagram.com/username">
                                @error('social_media_instagram')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="social_media_linkedin"><i class="fab fa-linkedin"></i> LinkedIn</label>
                                <input type="url" class="form-control @error('social_media_linkedin') is-invalid @enderror" 
                                       id="social_media_linkedin" name="social_media_linkedin" value="{{ old('social_media_linkedin') }}"
                                       placeholder="https://linkedin.com/in/username">
                                @error('social_media_linkedin')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan Data Alumni
                        </button>
                        <a href="{{ route('admin.alumni.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection