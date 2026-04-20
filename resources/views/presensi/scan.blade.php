@extends('layout.app')

@section('title', 'Scan QR Presensi')

@section('content')
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4 text-center">Arahkan Kamera ke QR Code Guru</h3>
    
    <div id="reader" width="600px" class="mx-auto max-w-lg mb-6 border-2 border-dashed border-gray-300 rounded-lg overflow-hidden"></div>
    
    <div id="result-message" class="hidden rounded-md p-4 mb-4 text-center font-bold">
    </div>

    <div class="text-center mt-4">
        <p class="text-sm text-gray-500 mb-4">Atau masukkan token secara manual (untuk keperluan testing):</p>
        <div class="flex max-w-md mx-auto">
            <input type="text" id="manual_token" class="flex-1 rounded-l-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan token teks">
            <button onclick="processToken(document.getElementById('manual_token').value)" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">Submit</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const resultMessage = document.getElementById('result-message');
    
    function processToken(token) {
        // Stop scanner if running
        try {
            html5QrcodeScanner.clear();
        } catch(e) {}
        
        resultMessage.className = 'rounded-md p-4 mb-4 text-center font-bold bg-blue-100 text-blue-700';
        resultMessage.innerText = 'Memproses...';
        resultMessage.classList.remove('hidden');

        fetch("{{ route('presensi.process_scan') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ token: token })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                resultMessage.className = 'rounded-md p-4 mb-4 text-center font-bold bg-green-100 text-green-700 border border-green-400';
                resultMessage.innerText = data.message;
            } else {
                resultMessage.className = 'rounded-md p-4 mb-4 text-center font-bold bg-red-100 text-red-700 border border-red-400';
                resultMessage.innerText = data.message;
            }
        })
        .catch(error => {
            resultMessage.className = 'rounded-md p-4 mb-4 text-center font-bold bg-red-100 text-red-700 border border-red-400';
            resultMessage.innerText = 'Terjadi kesalahan sistem.';
        });
    }

    function onScanSuccess(decodedText, decodedResult) {
        processToken(decodedText);
    }

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: {width: 250, height: 250} },
        /* verbose= */ false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
@endpush
@endsection
