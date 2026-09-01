@extends('layouts.admin')

@section('content')
    <h1>Daftar Produk</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('products.index') }}" class="form-inline mb-3">
        <label for="product-search" class="sr-only">Cari produk</label>
        <input
            id="product-search"
            type="search"
            name="search"
            value="{{ request('search') }}"
            class="form-control mr-2"
            placeholder="Cari produk atau kategori"
        >
        <button type="submit" class="btn btn-outline-dark mr-2">Cari</button>
        @if(request()->filled('search'))
            <a href="{{ route('products.index') }}" class="btn btn-link">Reset</a>
        @endif
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td><img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100"></td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        Belum ada produk di katalog.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $products->links() }}
@endsection
