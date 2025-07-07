@extends("layouts.app")

@section("title", "Edit Berita")

@section("content")
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-edit"></i> Edit Berita</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Edit Berita</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("PUT")

            <div class="form-group">
                <label for="title"><i class="fas fa-heading"></i> Judul Berita <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error("title") is-invalid @enderror" id="title" name="title" value="{{ old("title", $news->title) }}" required>
                @error("title")
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="content"><i class="fas fa-align-left"></i> Isi Berita <span class="text-danger">*</span></label>
                <textarea class="form-control @error("content") is-invalid @enderror" id="content" name="content" rows="10" required>{{ old("content", $news->content) }}</textarea>
                @error("content")
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="image"><i class="fas fa-image"></i> Gambar Berita</label>
                <input type="file" class="form-control-file @error("image") is-invalid @enderror" id="image" name="image" accept="image/*">
                <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                @error("image")
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                @if($news->image_path)
                    <div class="mt-2">
                        <img src="{{ asset("storage/" . $news->image_path) }}" alt="Gambar Berita Saat Ini" style="max-width: 200px; height: auto;">
                        <p class="text-muted mt-1">Gambar saat ini</p>
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection

@push("scripts")
<script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace("content");
</script>
@endpush