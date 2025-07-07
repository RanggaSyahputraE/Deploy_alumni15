@extends('layouts.app')

@section('title', 'Edit Profil - Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-user-edit"></i> Edit Profil Admin</h1>
</div>

<div class="row">
    <div class="col-md-4">
        <!-- Profile Photo Card -->
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : asset('images/default_profile.png') }}" 
                     alt="Profile Photo" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;" id="profile-preview">
                <h5>{{ Auth::user()->name }}</h5>
                <p class="text-muted">Administrator</p>
                
                <!-- Upload Photo Form -->
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" id="photo-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="update_type" value="photo">
                    
                    <div class="form-group">
                        <label for="profile_photo" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-camera"></i> Ganti Foto
                        </label>
                        <input type="file" class="d-none" id="profile_photo" name="profile_photo" accept="image/*">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <!-- Profile Information Form -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user"></i> Informasi Profil</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="update_type" value="profile">
                    
                    <div class="form-group">
                        <label for="name"><i class="fas fa-user"></i> Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i> Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password Form -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-lock"></i> Ganti Password</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="update_type" value="password">
                    
                    <div class="form-group">
                        <label for="current_password"><i class="fas fa-key"></i> Password Saat Ini <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" name="current_password" required>
                        @error('current_password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password"><i class="fas fa-lock"></i> Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation"><i class="fas fa-lock"></i> Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key"></i> Ganti Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview profile photo before upload
    document.getElementById('profile_photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-preview').src = e.target.result;
                // Auto submit the form
                document.getElementById('photo-form').submit();
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush