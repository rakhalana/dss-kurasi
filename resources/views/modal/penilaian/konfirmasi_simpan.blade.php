{{-- Modal Konfirmasi Simpan Penilaian --}}
<div class="modal fade" id="modalKonfirmasiSimpan" tabindex="-1" role="dialog" aria-labelledby="modalKonfirmasiSimpanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-body text-center p-5">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success" style="width: 64px; height: 64px;">
                        <i data-lucide="save" class="text-white" style="width: 32px; height: 32px;"></i>
                    </div>
                </div>
                <h5 class="font-weight-bold mb-2">Simpan Penilaian?</h5>
                <p class="text-muted mb-4">
                    Apakah Anda yakin ingin menyimpan penilaian untuk produk <strong class="text-dark">{{ $produkAktif->alternatif->nama_produk }}</strong>? 
                    Anda dapat melanjutkan penilaian ke produk berikutnya setelah menyimpan.
                </p>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-secondary btn-rounded font-weight-bold px-4 py-2 mr-2" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" class="btn btn-success btn-rounded font-weight-bold px-4 py-2" id="btnKonfirmasiSimpan">
                        <i data-lucide="check" class="mr-1" style="width: 16px; height: 16px;"></i> Ya, Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
