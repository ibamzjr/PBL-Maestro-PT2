@extends('layouts.admin')

@section('content')
    <h1>Daftar Kategori</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="GET" action="{{ route('categories.index') }}" class="form-inline mb-3">
        <label for="category-search" class="sr-only">Cari kategori</label>
        <input
            id="category-search"
            type="search"
            name="search"
            value="{{ request('search') }}"
            class="form-control mr-2"
            placeholder="Cari kategori"
        >
        <button type="submit" class="btn btn-outline-dark mr-2">Cari</button>
        @if(request()->filled('search'))
            <a href="{{ route('categories.index') }}" class="btn btn-link">Reset</a>
        @endif
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Produk</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->products_count }}</td>
                    <td><img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" width="100"></td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        Belum ada kategori di katalog.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $categories->links() }}
@endsection
