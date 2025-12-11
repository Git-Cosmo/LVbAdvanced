@props(['loading' => false, 'type' => 'submit', 'loadingText' => 'Loading...'])

<button 
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-4 py-2 bg-accent-blue text-white rounded-lg hover:bg-blue-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed']) }}
    x-data="{ loading: {{ $loading ? 'true' : 'false' }} }"
    @click="if ($el.form && !$el.form.checkValidity()) { return; } loading = true"
    :disabled="loading"
    :aria-busy="loading.toString()"
>
    <span x-show="!loading" class="flex items-center gap-2">
        {{ $slot }}
    </span>
    <span x-show="loading" class="flex items-center gap-2">
        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span>{{ $loadingText }}</span>
    </span>
</button>
