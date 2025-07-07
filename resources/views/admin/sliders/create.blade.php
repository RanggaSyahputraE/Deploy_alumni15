@extends('layouts.app')

@section('title', 'Tambah Slider - Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-plus"></i> Tambah Slider Baru</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.sliders.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-image"></i> Form Tambah Slider</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="title"><i class="fas fa-heading"></i> Judul Slider <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description"><i class="fas fa-align-left"></i> Deskripsi</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="link_url"><i class="fas fa-link"></i> URL Link (Opsional)</label>
                                <input type="url" class="form-control @error('link_url') is-invalid @enderror" 
                                       id="link_url" name="link_url" value="{{ old('link_url') }}"
                                       placeholder="https://example.com">
                                @error('link_url')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order"><i class="fas fa-sort-numeric-up"></i> Urutan Tampil <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                               id="order" name="order" value="{{ old('order', 1) }}" min="1" required>
                                        @error('order')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">
                                                <i class="fas fa-eye"></i> Tampilkan Slider
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="image"><i class="fas fa-image"></i> Gambar Slider <span class="text-danger">*</span></label>
                                <input type="file" class="form-control-file @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*" required>
                                <small class="form-text text-muted">
                                    Format: JPG, JPEG, PNG, GIF<br>
                                    Ukuran maksimal: 2MB<br>
                                    Resolusi yang disarankan: 1200x400px
                                </small>
                                @error('image')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <!-- Image Preview -->
                            <div id="image-preview-container" style="display: none;">
                                <label>Preview:</label>
                                <img id="image-preview" class="img-thumbnail" style="max-width: 100%; height: auto;">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan Slider
                        </button>
                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview image before upload
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-preview-container').style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('image-preview-container').style.display = 'none';
        }
    });
</script>
@endpush