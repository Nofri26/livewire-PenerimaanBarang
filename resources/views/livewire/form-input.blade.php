<div>
    <div class="row mb-3">
        <div class="col-md-12 text-end align-self-end">
            <button class="btn btn-danger" wire:click="logout">Logout</button>
        </div>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @csrf
    <div class="row mb-3">
        <div class="col-md-12">
            <div id="myDropzone" class="dropzone" enctype="multipart/form-data"></div>
        </div>
    </div>
    <form wire:submit.prevent="simpan">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="penerimaanBarang" class="form-label">No Penerimaan Barang</label>
                <input type="text" class="form-control" wire:model="noPenerima" disabled readonly>
            </div>
            <div class="col-md-6">
                <label for="invoice" class="form-label">No Surat Jalan / Invoice</label>
                <input type="text" class="form-control @error('invoice') is-invalid @enderror" placeholder="No Surat Jalan / Invoice" wire:model="invoice">
                @error('invoice')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="supplier" class="form-label">Supplier</label>
                <select name="supplier" class="form-select dropdown-toggle @error('supplier') is-invalid @enderror" wire:model="supplier">
                    <option hidden>Select Supplier</option>
                    @foreach ($suppliers as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
                @error('supplier')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" wire:model="tanggal" max={{ $maxDate }}>
            </div>
        </div>
        <div>
            @foreach ($forms as $key => $form)
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="parameterKarat" class="form-label">Parameter Karat</label>
                    <select name="parameterKarat" class="form-select @error('parameterKarat') is-invalid @enderror" wire:model="forms.{{ $key }}.parameterKarat">
                        <option hidden>Select Karat</option>
                        @foreach ($karat as $item)
                            <option value="{{ $item->id }}">{{ $item->parameter }}</option>
                        @endforeach
                    </select>
                    @error('parameterKarat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="beratReal" class="form-label">Berat Real</label>
                    <input type="number" step="0.1" class="form-control @error('beratReal') is-invalid @enderror" placeholder="0" wire:model="forms.{{ $key }}.beratReal" wire:change="hitungTotalBeratReal">
                    @error('beratReal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="beratKotor" class="form-label">Berat Kotor</label>
                    <input type="number" step="0.1" class="form-control @error('beratKotor') is-invalid @enderror" placeholder="0" wire:model="forms.{{ $key }}.beratKotor">
                    @error('beratKotor')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-3 text-end align-self-end">
                    @if ($loop->last)
                        <a class="btn btn-primary" wire:click="tambahForm">+</a>
                    @else
                        <a class="btn btn-danger" wire:click="hapusForm({{ $key }})">-</a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="totalBeratKotor" class="form-label">Total Berat Kotor</label>
                <input type="number" step="0.1" class="form-control @error('totalBeratKotor') is-invalid @enderror" placeholder="0" wire:model="totalBeratKotor">
                @error('totalBeratKotor')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-3">
                <label for="totalBeratReal" class="form-label">Total Berat Real</label>
                <input type="number" step="0.1" class="form-control @error('totalBeratReal')is-invalid @enderror" placeholder="0" wire:model="totalBeratReal" disabled readonly>
                @error('totalBeratReal')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-3">
                <label for="beratTimbangan" class="form-label">Berat Timbangan</label>
                <input type="number" step="0.1" class="form-control @error('beratTimbangan') is-invalid @enderror" placeholder="0" wire:model="beratTimbangan">
                @error('beratTimbangan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-3">
                <label for="beratSelisih" class="form-label">Selisih</label>
                <input type="number" step="0.1" class="form-control {{-- @error('beratSelisih')is-invalid @enderror --}}" placeholder="0" wire:model="beratSelisih" disabled readonly>
                {{-- @error('beratSelisih')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror --}}
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="catatan" class="form-label">Catatan</label>
                <textarea type="text" class="form-control @error('catatan') is-invalid @enderror" placeholder="Catatan" wire:model="catatan"></textarea>
                @error('catatan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="tipePembayaran" class="form-label">Tipe Pembayaran</label>
                <select name="tipePembayaran" class="form-select @error('tipePembayaran') is-invalid @enderror" wire:model="tipePembayaran">
                    <option hidden>Pilih Tipe Pembayaran</option>
                    <option value="0">Lunas</option>
                    <option value="1">Tempo</option>
                </select>
                @error('tipePembayaran')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            @if ($showFormTempo)
                <div class="col-md-3">
                    <label for="jatuhTempo" class="form-label">Jatuh Tempo</label>
                    <input type="date" class="form-control @error('jatuhTempo') is-invalid @enderror" wire:model="jatuhTempo" min={{ $maxDate }}>
                    @error('jatuhTempo')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                </div>
            @elseif($showFormLunas)
                <div class="col-md-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" step="0.1" class="form-control @error('harga') is-invalid @enderror" placeholder="0" wire:model="harga">
                    @error('harga')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            @endif
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="namaPengirim" class="form-label">Nama Pengirim</label>
                <input type="text" class="form-control @error('namaPengirim') is-invalid @enderror" placeholder="Nama Pengirim" wire:model="namaPengirim">
                @error('namaPengirim')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="user" class="form-label">PIC</label>
                <input type="text" class="form-control" placeholder="{{ session('name') }}" disabled readonly>
            </div>
        </div>

        <div class="row text-end align-self-end">
            <div class="col-md-12">
                <button class="btn btn-danger" wire:click="batal">Batal</button>
                <button class="btn btn-success" type="submit">Simpan</button>
            </div>
        </div>
    </form>
</div>