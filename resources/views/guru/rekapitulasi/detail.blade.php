@extends('layouts.app')

@section('title', 'Detail Alumni Tahun ' . $year . ' - guru')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-users"></i> Alumni Tahun {{ $year }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="{{ route('guru.rekapitulasi.print', $year) }}" class="btn btn-sm btn-secondary" target="_blank">
                <i class="fas fa-print"></i> Print
            </a>
            <a href="{{ route('guru.rekapitulasi.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<!-- Summary -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="alert alert-info">
            <h5><i class="fas fa-info-circle"></i> Informasi</h5>
            <p class="mb-0">
                Menampilkan <strong>{{ $alumni->count() }}</strong> alumni yang lulus pada tahun <strong>{{ $year }}</strong>.
                Data mencakup informasi pribadi, riwayat pendidikan, dan riwayat pekerjaan.
            </p>
        </div>
    </div>
</div>

<!-- Alumni Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-table"></i> Daftar Alumni Tahun {{ $year }}
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th width="3%">No</th>
                        <th width="5%">Foto</th>
                        <th width="15%">Data Pribadi</th>
                        <th width="12%">Kontak</th>
                        <th width="32%">Riwayat Pendidikan</th>
                        <th width="33%">Riwayat Pekerjaan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alumni as $key => $item)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td class="text-center">
                            <img src="{{ $item->user->profile_photo_path ? asset('storage/' . $item->user->profile_photo_path) : asset('images/default_profile.png') }}" 
                                 alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                        </td>
                        <td>
                            <strong>{{ $item->full_name }}</strong><br>
                            <small class="text-muted">{{ $item->gender ?? '-' }}</small><br>
                            @if($item->place_of_birth || $item->date_of_birth)
                            <small class="text-muted">
                                {{ $item->place_of_birth ?? '' }}
                                @if($item->date_of_birth)
                                    {{ $item->place_of_birth ? ', ' : '' }}{{ $item->date_of_birth->format('d/m/Y') }}
                                @endif
                            </small>
                            @endif
                        </td>
                        <td>
                            <small><strong>Email:</strong><br>{{ $item->user->email }}</small><br>
                            @if($item->phone_number)
                            <small><strong>HP:</strong><br>{{ $item->phone_number }}</small><br>
                            @endif
                            @if($item->address)
                            <small><strong>Alamat:</strong><br>{{ Str::limit($item->address, 50) }}</small>
                            @endif
                        </td>
                        <td>
                            @if($item->educations->isNotEmpty())
                                @foreach($item->educations as $education)
                                <div class="mb-2 p-2 bg-light rounded">
                                    <strong class="text-primary">{{ $education->institution_name }}</strong><br>
                                    @if($education->degree)
                                        <small>{{ $education->degree }}</small>
                                        @if($education->major)
                                            <small> - {{ $education->major }}</small>
                                        @endif
                                        <br>
                                    @endif
                                    <small class="text-muted">{{ $education->start_year ?? '-' }} - {{ $education->end_year ?? 'Sekarang' }}</small>
                                </div>
                                @endforeach
                            @else
                                <span class="text-muted font-italic">Belum ada data pendidikan</span>
                            @endif
                        </td>
                        <td>
                            @if($item->works->isNotEmpty())
                                @foreach($item->works as $work)
                                <div class="mb-2 p-2 bg-light rounded">
                                    <strong class="text-success">{{ $work->company_name }}</strong><br>
                                    @if($work->position)
                                        <small>{{ $work->position }}</small><br>
                                    @endif
                                    @if($work->description)
                                        <small>{{ Str::limit($work->description, 60) }}</small><br>
                                    @endif
                                    <small class="text-muted">
                                        {{ $work->start_date ? $work->start_date->format('m/Y') : '-' }} - 
                                        {{ $work->end_date ? $work->end_date->format('m/Y') : 'Sekarang' }}
                                        @if($work->is_current)
                                            <span class="badge badge-success badge-sm ml-1">Aktif</span>
                                        @endif
                                    </small>
                                </div>
                                @endforeach
                            @else
                                <span class="text-muted font-italic">Belum ada data pekerjaan</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data alumni ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection