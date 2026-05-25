<!-- Modal Warning AHP Belum Aktif -->
<div class="modal fade" id="warningAHPModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg overflow-hidden">
            <div class="modal-header bg-white border-bottom-0 pt-4 px-4 justify-content-center">
                <h5 class="modal-title font-weight-bold text-warning">Perhatian</h5>
            </div>
            <div class="modal-body text-center px-5 pb-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4"
                    style="width: 80px; height: 80px; background-color: rgba(246, 194, 62, 0.15);">
                    <i data-lucide="alert-triangle" class="text-warning"
                        style="width: 40px; height: 40px;"></i>
                </div>
                <h4 class="font-weight-bold text-dark mb-2">Bobot AHP Belum Ditentukan</h4>
                <p class="text-muted mb-0">Saat ini tidak ada bobot kriteria yang aktif di sistem.</p>
                <p class="text-muted small mt-2">Silakan tentukan bobot kriteria terlebih dahulu sebelum menambahkan periode kurasi baru.</p>
            </div>
            <div class="modal-footer border-top-0 justify-content-center pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4 mr-2"
                    data-dismiss="modal">Batal</button>
                <a href="{{ route('admin.bobot.index') }}" class="btn btn-warning rounded-pill px-4 shadow-sm text-white font-weight-bold">
                    Tentukan Bobot Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
