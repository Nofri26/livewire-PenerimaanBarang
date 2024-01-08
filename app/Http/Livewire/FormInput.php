<?php

namespace App\Http\Livewire;

use App\Models\Berat;
use App\Models\Karat;
use App\Models\Pembayaran;
use Livewire\Component;
use App\Models\Penerima;
use App\Models\Supplier;
use Livewire\WithFileUploads;

class FormInput extends Component
{
    use WithFileUploads;
    public $file;

    public $namaPengirim;
    public $noPenerima;
    public $invoice;
    public $totalBeratKotor;
    public $totalBeratReal;
    public $beratTimbangan;
    public $beratSelisih;
    public $tanggal;
    public $catatan;
    public $supplier;
    public $user;
    public $pembayaran;

    public $parameterKarat;
    public $beratReal;
    public $beratKotor;

    public $tipePembayaran;
    public $harga;
    public $jatuhTempo;
    public $showFormLunas = false;
    public $showFormTempo = false;
    public $forms = [];

    public function mount()
    {
        $this->tanggal = now()->toDateString();
        $this->noPenerima = Penerima::generateNomorPenerima();
        $this->forms[] = ['parameterKarat' => null, 'beratReal' => null, 'beratKotor' => null];
    }

    public function hitungBeratSelisih()
    {
        $totalBeratReal = is_numeric($this->totalBeratReal) ? $this->totalBeratReal : 0;
        $beratTimbangan = is_numeric($this->beratTimbangan) ? $this->beratTimbangan : 0;

        $beratSelisih = $totalBeratReal - $beratTimbangan;

        $this->beratSelisih = $beratSelisih;
    }

    public function updatedTotalBeratReal()
    {
        $this->hitungBeratSelisih();
    }

    public function updatedBeratTimbangan()
    {
        $this->hitungBeratSelisih();
    }

    public function updated($propertyName)
    {
        if ($propertyName == 'totalBeratReal' || $propertyName == 'beratTimbangan') {
            $this->hitungBeratSelisih();
        }
    }

    public function hitungTotalBeratReal()
    {
        $totalBeratReal = 0;

        foreach ($this->forms as $form) {
            if (!empty($form['beratReal'])) {
                $totalBeratReal += $form['beratReal'];
            }
        }

        $this->totalBeratReal = $totalBeratReal;
    }

    public function updatedTipePembayaran()
    {
        $this->showFormLunas = $this->tipePembayaran == 0;
        $this->showFormTempo = $this->tipePembayaran == 1;

        $this->resetValidation();

        if ($this->tipePembayaran == 0) {
            $this->rules['harga'] = 'required|numeric|min:0.1';
            $this->rules['jatuhTempo'] = '';
        } elseif ($this->tipePembayaran == 1) {
            $this->rules['jatuhTempo'] = 'required';
            $this->rules['harga'] = '';
        }
    }

    public function tambahForm()
    {
        $this->forms[] = ['parameterKarat' => null, 'beratReal' => null, 'beratKotor' => null];
    }

    public function hapusForm($index)
    {
        unset($this->forms[$index]);
        $this->forms = array_values($this->forms);
    }

    protected $rules = [
        'namaPengirim' => 'required',
        'noPenerima' => 'required',
        'invoice' => 'required',
        'totalBeratKotor' => 'required|numeric|min:0.1',
        'totalBeratReal' => 'required|numeric|min:0.1',
        'beratTimbangan' => 'required|numeric|min:0.1',
        'beratSelisih' => 'required',
        'tanggal' => 'required',
        'catatan' => 'required',
        'supplier' => 'required',
        'parameterKarat' => 'required',
        'beratReal' => 'required|numeric|min:0.1',
        'beratKotor' => 'required|numeric|min:0.1',
        'tipePembayaran' => 'required',
        'file' => 'image|max:2048'
    ];

    public function simpan()
    {
        $this->validate();
        try {
            $pembayaran = Pembayaran::create([
                'tipe' => $this->tipePembayaran,
                'jatuh_tempo' => $this->jatuhTempo,
                'harga' => $this->harga
            ]);

            $pembayaranId = $pembayaran->id;
            $penerima = Penerima::create([
                'nama_pengirim' => $this->namaPengirim,
                'no_penerima' => $this->noPenerima,
                'invoice' => $this->invoice,
                'total_berat_kotor' => $this->totalBeratKotor,
                'total_berat_real' => 1,
                'berat_timbangan' => $this->beratTimbangan,
                'berat_selisih' => 1,
                'tanggal' => $this->tanggal,
                'catatan' => $this->catatan,
                'supplier_id' => $this->supplier,
                'user_id' => session('id'),
                'pembayaran_id' => $pembayaranId,
            ]);

            $penerimaId = $penerima->id;
            foreach ($this->forms as $form) {
                Berat::create([
                    'berat_real' => $form['beratReal'],
                    'berat_kotor' => $form['beratKotor'],
                    'penerima_id' => $penerimaId,
                    'karat_id' => $form['parameterKarat'],
                ]);
            }

            $tempNoPenerima = $this->noPenerima;
            $tempForms = [$this->forms[0] = ['parameterKarat' => null, 'beratReal' => null, 'beratKotor' => null]];
            $this->reset([
                'namaPengirim',
                'invoice',
                'totalBeratKotor',
                'totalBeratReal',
                'beratTimbangan',
                'beratSelisih',
                'catatan',
                'supplier',
                'forms',
                'tipePembayaran',
                'jatuhTempo',
                'harga',
                'file'
            ]);

            $this->noPenerima = $tempNoPenerima;
            $this->forms = $tempForms;
            session()->flash('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {

            session()->flash('error', session('id') . 'Gagal menyimpan data. Error: ' . $e->getMessage());
        }
    }

    public function batal()
    {
        // Logika untuk membatalkan
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/login');
    }

    public function render()
    {
        return view('livewire.form-input', [
            'maxDate' => now()->toDateString(),
            'suppliers' => Supplier::orderBy('id', 'asc')->get(),
            'karat' => Karat::orderBy('id', 'asc')->get(),
            'showFormLunas' => $this->showFormLunas,
            'showFormTempo' => $this->showFormTempo,
        ]);
    }
}
