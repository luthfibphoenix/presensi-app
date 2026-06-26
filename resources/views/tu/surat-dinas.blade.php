@extends('layout.app')

@section('title', 'Surat Perjalanan Dinas')

@section('content')
<div class="h-full flex flex-col gap-6 overflow-y-auto no-scrollbar pb-24 md:pb-10" x-data="{
    searchGuru: '',
    selectedGuruId: null,
    gurus: {!! json_encode($gurus) !!},
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
    <div class="max-w-4xl mx-auto w-full bg-white rounded-[2.5rem] border border-gray-100 shadow-sm p-6 md:p-10 flex-shrink-0">
        <div class="flex items-center gap-5 mb-10">
            <div class="w-16 h-16 rounded-3xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 shadow-sm">
                <i class="fas fa-plane-departure text-2xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-black text-gray-800 uppercase tracking-tight">Surat Perjalanan Dinas</h2>
                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mt-1">Lengkapi formulir penugasan pegawai</p>
            </div>
        </div>

        <form action="{{ route('tu.surat_dinas') }}" target="_blank" method="GET" class="space-y-8">
            <input type="hidden" name="print" value="1">
            
            {{-- Pegawai Selection (Dropdown) --}}
            <div class="relative" x-data="{ open: false, selectedGuru: null }">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 ml-1">Pegawai / Guru yang Ditugaskan</label>
                <input type="hidden" name="guru_id" :value="selectedGuru?.id" required>
                
                <div @click="open = !open" class="w-full flex items-center justify-between bg-gray-50 px-6 py-4 rounded-2xl border-2 border-transparent hover:border-blue-100 cursor-pointer transition-all group" :class="open ? 'ring-2 ring-blue-500/20 border-blue-500 bg-white' : ''">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-gray-400 shadow-sm group-hover:text-blue-500 transition-colors">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="leading-tight">
                            <span x-text="selectedGuru ? selectedGuru.fullname : 'Pilih Nama Pegawai...'" class="block text-sm font-black text-gray-700"></span>
                            <span x-text="selectedGuru ? (selectedGuru.position || '-') : 'Klik untuk mencari data'" class="block text-[10px] font-bold text-gray-400 uppercase tracking-tighter"></span>
                        </div>
                    </div>
                    <i class="fas fa-chevron-down text-xs text-gray-300 transition-transform duration-300" :class="open ? 'rotate-180 text-blue-500' : ''"></i>
                </div>

                {{-- Dropdown Panel --}}
                <div x-show="open" @click.outside="open = false" x-transition.opacity class="absolute z-50 left-0 right-0 mt-3 bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden flex flex-col max-h-80" x-cloak>
                    <div class="p-4 border-b border-gray-50 bg-gray-50/50">
                        <div class="relative">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 text-sm"></i>
                            <input type="text" x-model="searchGuru" placeholder="Cari nama atau jabatan..." class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-sm font-bold outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                        </div>
                    </div>
                    <div class="overflow-y-auto custom-scrollbar p-2">
                        <template x-for="guru in filteredGurus" :key="guru.id">
                            <div @click="selectedGuru = guru; open = false" class="flex items-center gap-4 p-3 rounded-xl hover:bg-blue-50 cursor-pointer transition-all group" :class="selectedGuru?.id == guru.id ? 'bg-blue-600' : ''">
                                <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 flex-shrink-0 group-hover:bg-white group-hover:text-blue-600 transition-all" :class="selectedGuru?.id == guru.id ? 'bg-white text-blue-600' : ''">
                                    <i class="fas fa-user text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-black truncate" :class="selectedGuru?.id == guru.id ? 'text-white' : 'text-gray-700'" x-text="guru.fullname"></p>
                                    <p class="text-[10px] font-bold uppercase tracking-tighter truncate" :class="selectedGuru?.id == guru.id ? 'text-blue-100' : 'text-gray-400'" x-text="guru.position || '-'"></p>
                                </div>
                                <i x-show="selectedGuru?.id == guru.id" class="fas fa-check text-white text-xs mr-2"></i>
                            </div>
                        </template>
                        <div x-show="filteredGurus.length === 0" class="p-8 text-center">
                            <i class="fas fa-user-slash text-gray-200 text-2xl mb-2"></i>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Tidak menemukan pegawai</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Lokasi Section --}}
            <div class="space-y-4">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1 ml-1">Informasi Lokasi Tujuan</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="relative">
                        <input type="hidden" name="provinsi_name" :value="provinces.find(p => p.id === selectedProvince)?.name">
                        <select x-model="selectedProvince" @change="fetchRegencies()" name="provinsi" required class="w-full px-5 py-4 bg-gray-50 border-2 border-transparent rounded-2xl text-sm font-bold focus:bg-white focus:border-blue-500 transition-all outline-none appearance-none">
                            <option value="">Pilih Provinsi</option>
                            <template x-for="p in provinces" :key="p.id">
                                <option :value="p.id" x-text="p.name"></option>
                            </template>
                        </select>
                        <i class="fas fa-map-marker-alt absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none"></i>
                    </div>
                    <div class="relative">
                        <input type="hidden" name="kabupaten_name" :value="regencies.find(r => r.id === selectedRegency)?.name">
                        <select x-model="selectedRegency" @change="fetchDistricts()" name="kabupaten" required :disabled="!selectedProvince" class="w-full px-5 py-4 bg-gray-50 border-2 border-transparent rounded-2xl text-sm font-bold focus:bg-white focus:border-blue-500 transition-all outline-none appearance-none disabled:opacity-50">
                            <option value="">Pilih Kab/Kota</option>
                            <template x-for="r in regencies" :key="r.id">
                                <option :value="r.id" x-text="r.name"></option>
                            </template>
                        </select>
                        <i class="fas fa-city absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none"></i>
                    </div>
                    <div class="relative">
                        <input type="hidden" name="kecamatan_name" :value="districts.find(d => d.id === selectedDistrict)?.name">
                        <select x-model="selectedDistrict" name="kecamatan" required :disabled="!selectedRegency" class="w-full px-5 py-4 bg-gray-50 border-2 border-transparent rounded-2xl text-sm font-bold focus:bg-white focus:border-blue-500 transition-all outline-none appearance-none disabled:opacity-50">
                            <option value="">Pilih Kecamatan</option>
                            <template x-for="d in districts" :key="d.id">
                                <option :value="d.id" x-text="d.name"></option>
                            </template>
                        </select>
                        <i class="fas fa-map absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none"></i>
                    </div>
                </div>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                        <i class="fas fa-building text-gray-300 group-focus-within:text-blue-500 transition-colors"></i>
                    </div>
                    <input type="text" name="tujuan" required class="w-full pl-14 pr-6 py-4 bg-gray-50 border-2 border-transparent rounded-2xl text-sm font-bold focus:bg-white focus:border-blue-500 transition-all outline-none shadow-sm" placeholder="Nama Instansi / Lokasi Spesifik (Contoh: Gedung Guru Purworejo)">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 ml-1">Tgl Berangkat</label>
                    <div class="relative">
                        <i class="far fa-calendar-alt absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                        <input type="date" name="tanggal_mulai" required class="w-full pl-12 pr-5 py-4 bg-gray-50 border-2 border-transparent rounded-2xl text-sm font-bold focus:bg-white focus:border-blue-500 transition-all outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 ml-1">Tgl Kembali</label>
                    <div class="relative">
                        <i class="far fa-calendar-check absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                        <input type="date" name="tanggal_selesai" required class="w-full pl-12 pr-5 py-4 bg-gray-50 border-2 border-transparent rounded-2xl text-sm font-bold focus:bg-white focus:border-blue-500 transition-all outline-none">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 ml-1">Keperluan / Dasar Penugasan</label>
                <textarea name="keperluan" required rows="3" class="w-full px-6 py-5 bg-gray-50 border-2 border-transparent rounded-3xl text-sm font-bold focus:bg-white focus:border-blue-500 transition-all outline-none resize-none shadow-sm" placeholder="Masukkan deskripsi tugas atau keperluan perjalanan dinas..."></textarea>
            </div>

            <div class="pt-6 border-t border-gray-100 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3 text-amber-500">
                    <i class="fas fa-info-circle text-lg"></i>
                    <p class="text-[10px] font-black uppercase tracking-widest leading-tight">Pastikan semua data sudah sesuai standar kedinasan</p>
                </div>
                <button type="submit" class="w-full md:w-auto bg-blue-600 text-white font-black py-4 px-12 rounded-2xl shadow-xl hover:bg-blue-700 hover:-translate-y-1 active:translate-y-0 transition-all flex items-center justify-center gap-3 text-xs uppercase tracking-widest">
                    <i class="fas fa-print text-sm"></i> Cetak Surat Tugas
                </button>
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
