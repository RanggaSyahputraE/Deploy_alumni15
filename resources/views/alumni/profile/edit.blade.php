@extends('layouts.app')

@section('title', 'Edit Profil - Alumni')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-user-edit"></i> Edit Profil Alumni</h1>
</div>

<div class="row">
    <div class="col-md-4">
        <!-- Profile Photo Card -->
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : asset('images/default_profile.png') }}" 
                     alt="Profile Photo" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;" id="profile-preview">
                <h5>{{ Auth::user()->alumni->full_name ?? Auth::user()->name }}</h5>
                <p class="text-muted">Alumni {{ Auth::user()->alumni->graduation_year ?? '' }}</p>
                
                <!-- Upload Photo Form -->
                <form action="{{ route('alumni.profile.update') }}" method="POST" enctype="multipart/form-data" id="photo-form">
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
                <form action="{{ route('alumni.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="update_type" value="profile">
                    
                    <!-- Data User -->
                    <h6 class="text-primary"><i class="fas fa-user"></i> Data Akun</h6>
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name"><i class="fas fa-user"></i> Nama Pengguna <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email"><i class="fas fa-envelope"></i> Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
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
                                       id="full_name" name="full_name" value="{{ old('full_name', Auth::user()->alumni->full_name ?? '') }}" required>
                                @error('full_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="place_of_birth"><i class="fas fa-map-marker-alt"></i> Tempat Lahir</label>
                                <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror" 
                                       id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth', Auth::user()->alumni->place_of_birth ?? '') }}">
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
                                       id="date_of_birth" name="date_of_birth" 
                                       value="{{ old('date_of_birth', Auth::user()->alumni && Auth::user()->alumni->date_of_birth ? Auth::user()->alumni->date_of_birth->format('Y-m-d') : '') }}">
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
                                    <option value="Laki-laki" {{ old('gender', Auth::user()->alumni->gender ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('gender', Auth::user()->alumni->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
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
                                        <option value="{{ $year }}" {{ old('graduation_year', Auth::user()->alumni->graduation_year ?? '') == $year ? 'selected' : '' }}>
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
                                  id="address" name="address" rows="3">{{ old('address', Auth::user()->alumni->address ?? '') }}</textarea>
                        @error('address')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_number"><i class="fas fa-phone"></i> Nomor Telepon</label>
                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" 
                                       id="phone_number" name="phone_number" value="{{ old('phone_number', Auth::user()->alumni->phone_number ?? '') }}">
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
                                       id="social_media_facebook" name="social_media_facebook" 
                                       value="{{ old('social_media_facebook', Auth::user()->alumni->social_media_facebook ?? '') }}"
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
                                       id="social_media_instagram" name="social_media_instagram" 
                                       value="{{ old('social_media_instagram', Auth::user()->alumni->social_media_instagram ?? '') }}"
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
                                       id="social_media_linkedin" name="social_media_linkedin" 
                                       value="{{ old('social_media_linkedin', Auth::user()->alumni->social_media_linkedin ?? '') }}"
                                       placeholder="https://linkedin.com/in/username">
                                @error('social_media_linkedin')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- ... MEDIA SOSIAL ... -->

                    <!-- ✅ Tambahkan ini: RIWAYAT PENDIDIKAN -->
                    <h6 class="text-secondary mt-4"><i class="fas fa-university"></i> Riwayat Pendidikan</h6>
                    <hr>

                    <div id="education-container">

                        @php
                            $educations = old('educations', $alumni->educations->toArray());
                            if (empty($educations)) {
                                $educations = [ ['institution_name' => '', 'degree' => '', 'major' => '', 'start_year' => '', 'end_year' => ''] ];
                            }
                        @endphp

                        @foreach($educations as $i => $education)

                        <div class="education-entry border rounded p-3 mb-3">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label>Nama Institusi</label>
                                    <input type="text" name="educations[{{ $i }}][institution_name]" class="form-control"
                                        value="{{ $education['institution_name'] ?? '' }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Gelar</label>
                                    <input type="text" name="educations[{{ $i }}][degree]" class="form-control"
                                        value="{{ $education['degree'] ?? '' }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Jurusan</label>
                                    <input type="text" name="educations[{{ $i }}][major]" class="form-control"
                                        value="{{ $education['major'] ?? '' }}">
                                </div>
                            </div>
                            <div class="form-row mt-2">
                                <div class="col-md-6">
                                    <label>Tahun Mulai</label>
                                    <input type="number" name="educations[{{ $i }}][start_year]" class="form-control"
                                        value="{{ $education['start_year'] ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label>Tahun Selesai</label>
                                    <input type="number" name="educations[{{ $i }}][end_year]" class="form-control"
                                        value="{{ $education['end_year'] ?? '' }}">
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm mt-2 remove-education"><i class="fas fa-times"></i> Hapus</button>
                        </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-outline-secondary btn-sm mb-3" id="add-education"><i class="fas fa-plus"></i> Tambah Pendidikan</button>


                    <!-- ✅ Tambahkan ini: RIWAYAT PEKERJAAN -->
                    <h6 class="text-secondary"><i class="fas fa-briefcase"></i> Riwayat Pekerjaan</h6>
                    <hr>

                    <div id="work-container">
                        @php
                            $works = old('works', $alumni->works->toArray());
                            if (empty($works)) {
                                $works = [ ['company_name' => '', 'position' => '', 'description' => '', 'start_date' => '', 'end_date' => '', 'is_current' => false] ];
                            }
                        @endphp

                        @foreach($works as $i => $work)

                        <div class="work-entry border rounded p-3 mb-3">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label>Nama Perusahaan</label>
                                    <input type="text" name="works[{{ $i }}][company_name]" class="form-control"
                                        value="{{ $work['company_name'] ?? '' }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Posisi</label>
                                    <input type="text" name="works[{{ $i }}][position]" class="form-control"
                                        value="{{ $work['position'] ?? '' }}">
                                </div>
                            </div>
                            <div class="form-row mt-2">
                                <div class="col-md-6">
                                    <label>Tanggal Mulai</label>
                                    <input type="date" name="works[{{ $i }}][start_date]" class="form-control"
                                        value="{{ $work['start_date'] ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label>Tanggal Selesai</label>
                                    <input type="date" name="works[{{ $i }}][end_date]" class="form-control"
                                        value="{{ $work['end_date'] ?? '' }}">
                                </div>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="works[{{ $i }}][is_current]" value="1"
                                    {{ isset($work['is_current']) && $work['is_current'] ? 'checked' : '' }}>
                                <label class="form-check-label">Masih Bekerja di Sini</label>
                            </div>
                            <div class="form-group mt-2">
                                <label>Deskripsi</label>
                                <textarea name="works[{{ $i }}][description]" class="form-control" rows="2">{{ $work['description'] ?? '' }}</textarea>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm mt-2 remove-work"><i class="fas fa-times"></i> Hapus</button>
                        </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-outline-secondary btn-sm mb-4" id="add-work"><i class="fas fa-plus"></i> Tambah Pekerjaan</button>

            <!-- ✅ Ini tombol terakhir -->
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
                <form action="{{ route('alumni.profile.update') }}" method="POST">
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

    // 🔽 Tambahkan kode dinamis di bawah ini 🔽
// Tambah Pendidikan
    document.getElementById('add-education').addEventListener('click', function () {
        const container = document.getElementById('education-container');
        const count = container.children.length;
        const first = container.firstElementChild;
        if (!first) return;

        const clone = first.cloneNode(true);
        clone.querySelectorAll('input, textarea').forEach(input => {
            const name = input.getAttribute('name');
            if (!name) return;
            const updated = name.replace(/\[\d+\]/, `[${count}]`);
            input.setAttribute('name', updated);
            if (input.type === 'checkbox') {
                input.checked = false;
            } else {
                input.value = '';
            }
        });
        container.appendChild(clone);
    });

    // Tambah Pekerjaan
    document.getElementById('add-work').addEventListener('click', function () {
        const container = document.getElementById('work-container');
        const count = container.children.length;
        const first = container.firstElementChild;
        if (!first) return;

        const clone = first.cloneNode(true);
        clone.querySelectorAll('input, textarea').forEach(input => {
            const name = input.getAttribute('name');
            if (!name) return;
            const updated = name.replace(/\[\d+\]/, `[${count}]`);
            input.setAttribute('name', updated);
            if (input.type === 'checkbox') {
                input.checked = false;
            } else {
                input.value = '';
            }
        });
        container.appendChild(clone);
    });

    // Hapus form
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-education')) {
            const entry = e.target.closest('.education-entry');
            if (entry && entry.parentNode.children.length > 1) {
                entry.remove();
            }
        }

        if (e.target.classList.contains('remove-work')) {
            const entry = e.target.closest('.work-entry');
            if (entry && entry.parentNode.children.length > 1) {
                entry.remove();
            }
        }
    });

</script>
@endpush