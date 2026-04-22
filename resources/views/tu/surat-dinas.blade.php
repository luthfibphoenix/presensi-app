@extends('layout.app')

@section('title', 'Surat Perjalanan Dinas')

@section('content')
<div class="h-full flex flex-col gap-6 overflow-hidden" x-data="{
    searchGuru: '',
    selectedGuruId: null,
    gurus: {{ json_encode($gurus) }},
    provinces: [],
    regencies: [],
    districts: [],
    selectedProvince: '',
    selectedRegency: '',
    selectedDistrict: '',
    
    async fetchProvinces() {
        const res = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
        this.provinces = await res.json();
    },
    async fetchRegencies() {
        if (!this.selectedProvince) return;
        const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${this.selectedProvince}.json`);
        this.regencies = await res.json();
        this.selectedRegency = '';
        this.districts = [];
    },
    async fetchDistricts() {
        if (!this.selectedRegency) return;
        const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${this.selectedRegency}.json`);
        this.districts = await res.json();
        this.selectedDistrict = '';
    },
    get filteredGurus() {
        if (this.searchGuru === '') return this.gurus;
        return this.gurus.filter(g => {
            const nameMatch = g.fullname ? g.fullname.toLowerCase().includes(this.searchGuru.toLowerCase()) : false;
            const posMatch = g.position ? g.position.toLowerCase().includes(this.searchGuru.toLowerCase()) : false;
            return nameMatch || posMatch;
        });
    }
}" x-init="fetchProvinces()">
    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm p-8 flex-1 flex flex-col overflow-hidden">
        <div class="flex items-center gap-4 mb-8 flex-shrink-0">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100">
                <i class="fas fa-plane-departure text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-black text-gray-800 uppercase tracking-tight">Buat Surat Perjalanan Dinas (SPD)</h2>
                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">Lengkapi formulir untuk mencetak surat tugas</p>
            </div>
        </div>

        <form action="{{ route('tu.surat_dinas') }}" target="_blank" method="GET" class="flex-1 flex flex-col overflow-hidden">
            <input type="hidden" name="print" value="1">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 flex-1 overflow-hidden">
                {{-- Left Side: Guru Selection --}}
                <div class="lg:col-span-4 flex flex-col overflow-hidden">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Pilih Pegawai / Guru</label>
                    <div class="relative mb-4">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-300 text-sm"></i>
                        </div>
                        <input type="text" x-model="searchGuru" placeholder="Cari nama atau jabatan..." class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                    </div>
                    
                    <div class="flex-1 overflow-y-auto pr-2 space-y-2 custom-scrollbar">
                        <template x-for="guru in filteredGurus" :key="guru.id">
                            <label class="block cursor-pointer group">
                                <input type="radio" name="guru_id" :value="guru.id" required class="hidden peer" x-model="selectedGuruId">
                                <div class="flex items-center gap-4 p-4 rounded-2xl border border-gray-50 bg-gray-50/30 peer-checked:bg-blue-600 peer-checked:border-blue-700 peer-checked:shadow-lg peer-checked:scale-[1.02] transition-all group-hover:bg-gray-50">
                                    <div class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-gray-400" :class="selectedGuruId == guru.id ? 'text-blue-600' : 'text-gray-400'">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-black transition-colors" :class="selectedGuruId == guru.id ? 'text-white' : 'text-gray-700'" x-text="guru.fullname"></p>
                                        <p class="text-[10px] font-bold uppercase tracking-tighter transition-colors" :class="selectedGuruId == guru.id ? 'text-blue-100' : 'text-gray-400'" x-text="guru.position || '-'"></p>
                                    </div>
                                    <div x-show="selectedGuruId == guru.id" class="px-3 py-1 bg-white/20 rounded-lg border border-white/20">
                                        <span class="text-[9px] font-black text-white uppercase tracking-widest">Terpilih</span>
                                    </div>
                                </div>
                            </label>
                        </template>
                    </div>
                </div>
                
                {{-- Right Side: Details Form --}}
                <div class="lg:col-span-8 flex flex-col gap-6 overflow-y-auto pr-2 custom-scrollbar">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Lokasi Section --}}
                        <div class="space-y-4 md:col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Informasi Lokasi Tujuan</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <input type="hidden" name="provinsi_name" :value="provinces.find(p => p.id === selectedProvince)?.name">
                                    <select x-model="selectedProvince" @change="fetchRegencies()" name="provinsi" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                                        <option value="">Pilih Provinsi</option>
                                        <template x-for="p in provinces" :key="p.id">
                                            <option :value="p.id" x-text="p.name"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <input type="hidden" name="kabupaten_name" :value="regencies.find(r => r.id === selectedRegency)?.name">
                                    <select x-model="selectedRegency" @change="fetchDistricts()" name="kabupaten" required :disabled="!selectedProvince" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none disabled:opacity-50">
                                        <option value="">Pilih Kab/Kota</option>
                                        <template x-for="r in regencies" :key="r.id">
                                            <option :value="r.id" x-text="r.name"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <input type="hidden" name="kecamatan_name" :value="districts.find(d => d.id === selectedDistrict)?.name">
                                    <select x-model="selectedDistrict" name="kecamatan" required :disabled="!selectedRegency" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none disabled:opacity-50">
                                        <option value="">Pilih Kecamatan</option>
                                        <template x-for="d in districts" :key="d.id">
                                            <option :value="d.id" x-text="d.name"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-building text-gray-300"></i>
                                    </div>
                                    <input type="text" name="tujuan" required class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none" placeholder="Nama Instansi / Lokasi Spesifik (Contoh: Gedung Guru Pontianak)">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 md:col-span-2">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Tgl Berangkat</label>
                                <input type="date" name="tanggal_mulai" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Tgl Kembali</label>
                                <input type="date" name="tanggal_selesai" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Keperluan / Dasar Penugasan</label>
                            <textarea name="keperluan" required rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none resize-none" placeholder="Masukkan deskripsi tugas atau keperluan perjalanan dinas..."></textarea>
                        </div>
                    </div>

                    <div class="mt-auto pt-6 border-t border-gray-50 flex items-center justify-between sticky bottom-0 bg-white">
                        <div class="flex items-center gap-3 text-amber-500">
                            <i class="fas fa-exclamation-circle text-sm"></i>
                            <p class="text-[10px] font-bold uppercase tracking-tight">Pastikan data wilayah dan guru sudah benar.</p>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white font-black py-4 px-10 rounded-2xl shadow-lg hover:bg-blue-700 active:scale-95 transition-all flex items-center gap-3 text-xs uppercase tracking-widest">
                            <i class="fas fa-print text-sm"></i> Cetak Surat Tugas
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #cbd5e1;
}
</style>
@endsection
