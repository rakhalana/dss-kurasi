{{-- Modal Validasi Hasil Kurasi (Layak Retail Bersyarat -> Layak Retail / Tetap) --}}
<div class="modal fade" id="modalValidasi-{{ $res->alternatif->id_alternatif }}" tabindex="-1" role="dialog" aria-labelledby="modalValidasiLabel-{{ $res->alternatif->id_alternatif }}" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header modal-header--gradient pt-4 px-4">
                <h5 class="modal-title font-weight-bold">
                    <i data-lucide="check-square" class="mr-2"></i>Validasi Hasil Kurasi
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('hasil.validate_override', ['id_periode' => $periode->id_periode_kurasi, 'id_alternatif' => $res->alternatif->id_alternatif]) }}" method="POST" id="formValidasi-{{ $res->alternatif->id_alternatif }}">
                @csrf
                <div class="modal-body px-4">
                    <div class="alert alert-light border small mb-4">
                        <i data-lucide="info" class="mr-2 text-muted" style="width: 14px; vertical-align: middle;"></i>
                        Rekomendasi awal sistem SPK untuk produk <strong>{{ $res->alternatif->nama_produk }}</strong> adalah <strong>Layak Retail Bersyarat</strong>. Tentukan status kelayakan akhir produk ini.
                    </div>

                    <div class="form-group mb-4">
                        <label class="text-muted small font-weight-bold uppercase tracking-wider">Keputusan Kelayakan Akhir</label>
                        <div class="custom-control custom-radio mb-3">
                            <input type="radio" id="status_layak_retail-{{ $res->alternatif->id_alternatif }}" name="status_override" value="layak_retail" class="custom-control-input status-override-radio" checked>
                            <label class="custom-control-label text-dark font-weight-600" for="status_layak_retail-{{ $res->alternatif->id_alternatif }}">
                                Layak Retail
                            </label>
                            <small class="text-muted d-block">Meningkatkan status rekomendasi menjadi Layak Retail (Catatan/Komentar wajib diisi).</small>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="status_bersyarat-{{ $res->alternatif->id_alternatif }}" name="status_override" value="layak_retail_bersyarat" class="custom-control-input status-override-radio">
                            <label class="custom-control-label text-dark font-weight-600" for="status_bersyarat-{{ $res->alternatif->id_alternatif }}">
                                Layak Retail Bersyarat (Tetap)
                            </label>
                            <small class="text-muted d-block">Menetapkan keputusan kelayakan produk tetap Bersyarat (Catatan/Komentar opsional).</small>
                        </div>
                    </div>
                    
                    <div class="form-group mb-0">
                        <label class="text-muted small font-weight-bold uppercase tracking-wider">
                            Catatan Komentar Validasi <span class="komentar-required-label text-danger font-weight-bold" id="req-label-{{ $res->alternatif->id_alternatif }}">(Wajib)</span>
                        </label>
                        <textarea class="form-control border-light bg-light px-3" 
                            id="textarea-komentar-{{ $res->alternatif->id_alternatif }}"
                            name="komentar_override" 
                            rows="3" 
                            style="border-radius: 12px;" 
                            placeholder="Tulis alasan atau komentar validasi tambahan..." 
                            required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                        <i data-lucide="check" class="mr-1" style="width: 14px;"></i> Simpan Validasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function() {
        const idAlt = "{{ $res->alternatif->id_alternatif }}";
        const form = document.getElementById('formValidasi-' + idAlt);
        if (!form) return;

        const radios = form.querySelectorAll('.status-override-radio');
        const textarea = form.querySelector('#textarea-komentar-' + idAlt);
        const reqLabel = form.querySelector('#req-label-' + idAlt);

        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked && this.value === 'layak_retail') {
                    textarea.required = true;
                    reqLabel.textContent = '(Wajib)';
                    reqLabel.className = 'komentar-required-label text-danger font-weight-bold';
                } else {
                    textarea.required = false;
                    reqLabel.textContent = '(Opsional)';
                    reqLabel.className = 'komentar-required-label text-muted font-weight-normal';
                }
            });
        });
    })();
</script>
