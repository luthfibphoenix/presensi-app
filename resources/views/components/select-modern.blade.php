@props([
    'name', 
    'label' => null, 
    'options' => [], 
    'selected' => null, 
    'placeholder' => 'Pilih Opsi',
    'required' => false,
    'id' => null
])

<div x-data="{ 
    open: false, 
    value: '{{ $selected }}',
    label: '{{ $options[$selected] ?? $placeholder }}',
    select(val, text) {
        this.value = val;
        this.label = text;
        this.open = false;
        $refs.hiddenInput.value = val;
        $refs.hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
        $refs.hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
        
        // Auto-submit if needed (can be customized)
        if($refs.hiddenInput.hasAttribute('onchange')) {
             $refs.hiddenInput.onchange();
        }
    }
}" class="relative w-full">
    @if($label)
    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">{{ $label }}</label>
    @endif
    
    <input type="hidden" name="{{ $name }}" x-ref="hiddenInput" value="{{ $selected }}" @if($required) required @endif @if($id) id="{{ $id }}" @endif>
    
    <button type="button" @click="open = !open" 
            class="w-full flex items-center justify-between bg-gray-50 px-5 py-3.5 rounded-2xl border-2 border-gray-50 focus:border-blue-500 focus:bg-white outline-none transition-all font-bold text-sm text-gray-700">
        <span x-text="label"></span>
        <i class="fas fa-chevron-down text-xs text-gray-300 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
    </button>

    <div x-show="open" 
         @click.outside="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
         class="absolute left-0 mt-2 w-full bg-white rounded-2xl shadow-2xl border border-gray-100 z-[70] overflow-hidden py-2"
         x-cloak>
        <div class="max-h-60 overflow-y-auto no-scrollbar">
            @if(!$required)
            <button type="button" @click="select('', '{{ $placeholder }}')" 
                    class="w-full px-5 py-3 text-left text-sm font-bold text-gray-500 hover:bg-gray-50 transition">
                {{ $placeholder }}
            </button>
            @endif
            
            @foreach($options as $val => $text)
            <button type="button" @click="select('{{ $val }}', '{{ $text }}')" 
                    class="w-full px-5 py-3 text-left text-sm font-bold transition flex items-center justify-between"
                    :class="value == '{{ $val }}' ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600'">
                <span>{{ $text }}</span>
                <i x-show="value == '{{ $val }}'" class="fas fa-check text-[10px]"></i>
            </button>
            @endforeach
        </div>
    </div>
</div>
