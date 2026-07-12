<div class="modal fade" id="modalAddProduk" tabindex="-1" role="dialog" aria-labelledby="modalAddProdukLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 960px;">
        <div class="modal-content border-0 shadow-lg overflow-hidden">
            <div class="modal-header modal-header--gradient pt-4 px-4">
                <h5 class="modal-title font-weight-bold">
                    <i data-lucide="plus-circle" class="mr-2"></i>Tambah Produk Baru
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" id="formAddProduk">
                @csrf
                <div class="modal-body px-4">
                    <div class="row">
                        <!-- Kolom 1: Informasi Produk -->
                        <div class="col-lg-6 border-right">
                            <div class="form-group mb-3 text-center">
                                <label class="text-muted small font-weight-bold uppercase tracking-wider d-block text-left">Foto Produk</label>
                                <div class="product-add-preview mx-auto rounded shadow-sm overflow-hidden mb-3"
                                    style="width: 130px; height: 130px; background: #f8f9fa; border: 2px dashed #dee2e6;">
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted"
                                        id="add-preview-placeholder">
                                        <i data-lucide="image-plus" style="width: 40px; height: 40px; opacity: 0.5;"></i>
                                    </div>
                                    <img src="" id="add-preview-img" class="w-100 h-100 object-fit-cover d-none">
                                </div>
                                <div class="custom-file mb-1">
                                    <input type="file" class="custom-file-input @error('foto_produk') is-invalid @enderror"
                                        id="foto_produk_add" name="foto_produk" accept="image/*">
                                    <label class="custom-file-label rounded-pill border-light bg-light text-truncate"
                                        for="foto_produk_add">Pilih Foto...</label>
                                    @error('foto_produk')
                                        <div class="invalid-feedback text-left d-block">
                                            @if(str_contains($message, 'must not be greater than 2048 kilobytes'))
                                                Ukuran foto produk tidak boleh lebih dari 2 MB.
                                            @else
                                                {{ $message }}
                                            @endif
                                        </div>
                                    @enderror
                                </div>
                                <small class="text-muted d-block text-left mt-1" style="font-size: 0.7rem;">Format: JPG, PNG. Maks: 2MB</small>
                            </div>

                            <div class="form-group mb-3">
                                <label class="text-muted small font-weight-bold uppercase tracking-wider">Nama Produk</label>
                                <input type="text"
                                    class="form-control rounded-pill border-light bg-light px-3 @error('nama_produk') is-invalid @enderror"
                                    name="nama_produk" value="{{ old('nama_produk') }}"
                                    placeholder="Contoh: Kripik Tempe Renyah" required>
                                @error('nama_produk')
                                    <div class="invalid-feedback text-left d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="text-muted small font-weight-bold uppercase tracking-wider">Nama Brand / UMKM</label>
                                <input type="text"
                                    class="form-control rounded-pill border-light bg-light px-3 @error('nama_brand_umkm') is-invalid @enderror"
                                    name="nama_brand_umkm" value="{{ old('nama_brand_umkm') }}"
                                    placeholder="Contoh: UMKM Berkah Jaya" required>
                                @error('nama_brand_umkm')
                                    <div class="invalid-feedback text-left d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="text-muted small font-weight-bold uppercase tracking-wider">Nama Pemilik</label>
                                <input type="text"
                                    class="form-control rounded-pill border-light bg-light px-3 @error('nama_pemilik') is-invalid @enderror"
                                    name="nama_pemilik" value="{{ old('nama_pemilik') }}"
                                    placeholder="Nama lengkap pemilik" required>
                                @error('nama_pemilik')
                                    <div class="invalid-feedback text-left d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="text-muted small font-weight-bold uppercase tracking-wider">Deskripsi Produk</label>
                                <textarea class="form-control border-light bg-light px-3 @error('deskripsi_produk') is-invalid @enderror"
                                    name="deskripsi_produk" rows="3" style="border-radius: 12px;"
                                    placeholder="Jelaskan secara singkat mengenai produk ini...">{{ old('deskripsi_produk') }}</textarea>
                                @error('deskripsi_produk')
                                    <div class="invalid-feedback text-left d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kolom 2: Legalitas Produk -->
                        <div class="col-lg-6">
                            <label class="text-muted small font-weight-bold uppercase tracking-wider">Nomor Dokumen Legalitas</label>
                            <div class="alert alert-info border-0 shadow-sm rounded-lg small mb-3">
                                <i data-lucide="info" class="mr-2" style="width: 14px; vertical-align: middle;"></i>
                                <strong>Syarat Lolos Kurasi:</strong> Wajib memiliki NIB, Sertifikat Halal, dan salah satu dari BPOM atau SP-PIRT.
                            </div>

                            {{-- NIB --}}
                            <div class="legalitas-item mb-2 p-2 rounded-lg border bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="mb-0 font-weight-bold small uppercase tracking-wider" style="font-size: 0.75rem;">1. NIB (Nomor Induk Berusaha)</h6>
                                    <div class="custom-control custom-switch">
                                        <input type="hidden" name="is_nib" value="0">
                                        <input type="checkbox" class="custom-control-input" id="is_nib_add" name="is_nib" value="1" {{ old('is_nib') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_nib_add">Ada</label>
                                    </div>
                                </div>
                                <input type="text" class="form-control form-control-sm rounded-pill border-0 px-3 @error('no_nib') is-invalid @enderror" 
                                    id="input-no_nib_add"
                                    name="no_nib" value="{{ old('no_nib') }}" placeholder="Contoh: 1234567890123" 
                                    inputmode="numeric" maxlength="13">
                                @error('no_nib')
                                    <div class="text-danger small mt-1 d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted mt-1 d-block" style="font-size: 0.7rem;"><i data-lucide="info" class="mr-1" style="width: 10px;"></i> Wajib 13 digit angka</small>
                            </div>

                            {{-- Sertifikat Halal --}}
                            <div class="legalitas-item mb-2 p-2 rounded-lg border bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="mb-0 font-weight-bold small uppercase tracking-wider" style="font-size: 0.75rem;">2. Sertifikat Halal</h6>
                                    <div class="custom-control custom-switch">
                                        <input type="hidden" name="is_sertifikat_halal" value="0">
                                        <input type="checkbox" class="custom-control-input" id="is_sertifikat_halal_add" name="is_sertifikat_halal" value="1" {{ old('is_sertifikat_halal') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_sertifikat_halal_add">Ada</label>
                                    </div>
                                </div>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-0 text-muted font-weight-bold px-2" style="border-radius: 50px 0 0 50px; font-size: 0.75rem;">ID</span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm border-0 px-2 @error('no_sertifikat_halal') is-invalid @enderror" 
                                        id="input-no_sertifikat_halal_add"
                                        name="no_sertifikat_halal" value="{{ old('no_sertifikat_halal') }}" 
                                        placeholder="17 digit angka" inputmode="numeric" maxlength="17" style="border-radius: 0 50px 50px 0;">
                                </div>
                                @error('no_sertifikat_halal')
                                    <div class="text-danger small mt-1 d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted mt-1 d-block" style="font-size: 0.7rem;"><i data-lucide="info" class="mr-1" style="width: 10px;"></i> Masukkan 17 digit angka saja</small>
                            </div>

                            {{-- BPOM & PIRT (One of) --}}
                            <div class="legalitas-item mb-2 p-2 rounded-lg border bg-light" style="border-left: 3px solid #0d6efd !important;">
                                <h6 class="mb-2 font-weight-bold small uppercase tracking-wider" style="font-size: 0.75rem;">3. Izin Edar (BPOM / SP-PIRT)</h6>
                                
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-muted font-weight-500" style="font-size: 0.75rem;">BPOM (MD / ML)</span>
                                        <div class="custom-control custom-switch">
                                            <input type="hidden" name="is_bpom" value="0">
                                            <input type="checkbox" class="custom-control-input" id="is_bpom_add" name="is_bpom" value="1" {{ old('is_bpom') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_bpom_add"></label>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm border-0 px-3 rounded-pill @error('no_bpom') is-invalid @enderror" 
                                        id="input-no_bpom_add"
                                        name="no_bpom" value="{{ old('no_bpom') }}" 
                                        placeholder="Nomor BPOM">
                                    @error('no_bpom')
                                        <div class="text-danger small mt-1 d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-0">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-muted font-weight-500" style="font-size: 0.75rem;">SP-PIRT</span>
                                        <div class="custom-control custom-switch">
                                            <input type="hidden" name="is_sp_pirt" value="0">
                                            <input type="checkbox" class="custom-control-input" id="is_sp_pirt_add" name="is_sp_pirt" value="1" {{ old('is_sp_pirt') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_sp_pirt_add"></label>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="form-control form-control-sm border-0 px-2 flex-grow-1 @error('no_sp_pirt_1') is-invalid @enderror" 
                                            id="input-no_sp_pirt_1_add"
                                            name="no_sp_pirt_1" value="{{ old('no_sp_pirt_1') }}" 
                                            placeholder="13 digit" inputmode="numeric" maxlength="13" style="border-radius: 50px 0 0 50px;">
                                        <div class="bg-white border-0 px-2 py-0 text-muted font-weight-bold" style="font-size: 0.75rem;">-</div>
                                        <input type="text" class="form-control form-control-sm border-0 px-2 @error('no_sp_pirt_2') is-invalid @enderror" 
                                            id="input-no_sp_pirt_2_add"
                                            name="no_sp_pirt_2" value="{{ old('no_sp_pirt_2') }}" 
                                            placeholder="2 digit" inputmode="numeric" maxlength="2" style="border-radius: 0 50px 50px 0; width: 60px;">
                                    </div>
                                    @error('no_sp_pirt_1')
                                        <div class="text-danger small mt-1 d-block">{{ $message }}</div>
                                    @enderror
                                    @error('no_sp_pirt_2')
                                        <div class="text-danger small mt-1 d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted mt-1 d-block" style="font-size: 0.7rem;"><i data-lucide="info" class="mr-1" style="width: 10px;"></i> Wajib 15 digit angka (Format: 13-2)</small>
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <label class="text-muted small font-weight-bold uppercase tracking-wider" style="font-size: 0.75rem;">Catatan / Keterangan</label>
                                <textarea class="form-control border-light bg-light px-3" name="keterangan" rows="2" style="border-radius: 12px; font-size: 0.85rem;" placeholder="Tambahkan catatan jika diperlukan...">{{ old('keterangan') }}</textarea>
                            </div>
                        </div>
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
        $('#foto_produk_add').on('change', function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#add-preview-img').attr('src', e.target.result).removeClass('d-none');
                    $('#add-preview-placeholder').addClass('d-none');
                }
                reader.readAsDataURL(this.files[0]);

                var fileName = this.files[0].name;
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            }
        });

        // Form submission client-side validation
        (function() {
            const form = document.getElementById('formAddProduk');
            if (!form) return;

            form.addEventListener('submit', function(e) {
                try {
                    let isValid = true;
                    
                    // Clean old error messages
                    form.querySelectorAll('.invalid-feedback-custom').forEach(el => el.remove());
                    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

                    const checkField = (toggleId, inputNames, expectedDigits, label) => {
                        const toggle = document.getElementById(toggleId);
                        if (!toggle || !toggle.checked) return;

                        inputNames.forEach((name, index) => {
                            const input = form.querySelector(`[name="${name}"]`);
                            if (!input) return;

                            const val = input.value.trim().replace(/[^0-9]/g, '');
                            const expected = Array.isArray(expectedDigits) ? expectedDigits[index] : expectedDigits;

                            if (val.length !== expected) {
                                isValid = false;
                                input.classList.add('is-invalid');
                                
                                // Add error message if not present
                                const parent = input.closest('.legalitas-item') || input.parentElement;
                                if (!parent.querySelector(`.err-${name}`)) {
                                    const err = document.createElement('div');
                                    err.className = `text-danger small mt-1 invalid-feedback-custom err-${name}`;
                                    err.innerHTML = `<i data-lucide="alert-circle" style="width:10px; height:10px; vertical-align: middle;"></i> <span style="vertical-align: middle;">${label} harus ${expected} digit angka.</span>`;
                                    parent.appendChild(err);
                                    if (window.lucide) lucide.createIcons();
                                }
                            }
                        });
                    };

                    // 1. NIB (13)
                    checkField('is_nib_add', ['no_nib'], 13, 'NIB');
                    
                    // 2. Halal (17)
                    checkField('is_sertifikat_halal_add', ['no_sertifikat_halal'], 17, 'Sertifikat Halal');
                    
                    // 4. SP-PIRT (13 & 2)
                    checkField('is_sp_pirt_add', ['no_sp_pirt_1', 'no_sp_pirt_2'], [13, 2], 'SP-PIRT');

                    if (!isValid) {
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }
                } catch (err) {
                    console.error('Validation Error:', err);
                    e.preventDefault();
                    return false;
                }
            });
        })();

        // Auto-open modal if there are errors (optional, but requested in many cases)
        @if($errors->any() && old('nama_produk'))
            $(document).ready(function () {
                $('#modalAddProduk').modal('show');
            });
        @endif
    </script>
@endpush