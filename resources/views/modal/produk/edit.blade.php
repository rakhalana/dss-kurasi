<div class="modal fade" id="modalEditProduk-{{ $item->id_alternatif }}" tabindex="-1" role="dialog" aria-labelledby="modalEditProdukLabel-{{ $item->id_alternatif }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg overflow-hidden">
            <div class="modal-header modal-header--gradient pt-4 px-4">
                <h5 class="modal-title font-weight-bold">
                    <i data-lucide="edit-3" class="mr-2"></i>Ubah Info Produk
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.produk.update', $item->id_alternatif) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4">
                    <div class="form-group mb-3">
                        <label class="text-muted small font-weight-bold uppercase tracking-wider">Nama Produk</label>
                        <input type="text" class="form-control rounded-pill border-light bg-light px-3" name="nama_produk" value="{{ $item->nama_produk }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-muted small font-weight-bold uppercase tracking-wider">Nama Brand / UMKM</label>
                        <input type="text" class="form-control rounded-pill border-light bg-light px-3" name="nama_brand_umkm" value="{{ $item->nama_brand_umkm }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-muted small font-weight-bold uppercase tracking-wider">Deskripsi</label>
                        <textarea class="form-control border-light bg-light px-3" name="deskripsi_produk" rows="3" style="border-radius: 12px;">{{ $item->deskripsi_produk }}</textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
