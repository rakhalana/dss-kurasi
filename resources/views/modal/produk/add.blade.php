<div class="modal fade" id="modalAddProduk" tabindex="-1" role="dialog" aria-labelledby="modalAddProdukLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg overflow-hidden">
            <div class="modal-header modal-header--gradient pt-4 px-4">
                <h5 class="modal-title font-weight-bold">
                    <i data-lucide="plus-circle" class="mr-2"></i>Tambah Produk Baru
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4">
                    <div class="form-group mb-3">
                        <label class="text-muted small font-weight-bold uppercase tracking-wider">Nama Produk</label>
                        <input type="text" class="form-control rounded-pill border-light bg-light px-3 @error('nama_produk') is-invalid @enderror" name="nama_produk" value="{{ old('nama_produk') }}" placeholder="Contoh: Kripik Tempe Renyah" required>
                        @error('nama_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-muted small font-weight-bold uppercase tracking-wider">Nama Brand / UMKM</label>
                        <input type="text" class="form-control rounded-pill border-light bg-light px-3 @error('nama_brand_umkm') is-invalid @enderror" name="nama_brand_umkm" value="{{ old('nama_brand_umkm') }}" placeholder="Contoh: UMKM Berkah Jaya" required>
                        @error('nama_brand_umkm')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-muted small font-weight-bold uppercase tracking-wider">Deskripsi Produk</label>
                        <textarea class="form-control border-light bg-light px-3 @error('deskripsi_produk') is-invalid @enderror" name="deskripsi_produk" rows="4" style="border-radius: 12px;" placeholder="Jelaskan secara singkat mengenai produk ini...">{{ old('deskripsi_produk') }}</textarea>
                        @error('deskripsi_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer border-top-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-open modal if there are errors
    @if($errors->any() && old('nama_produk'))
        $(document).ready(function() {
            $('#modalAddProduk').modal('show');
        });
    @endif
</script>
@endpush
