@php($customLogoUrl = \App\Models\StoreSetting::assetUrl('brand_logo_path'))

<div class="brand-lockup">
    @if ($customLogoUrl)
        <img class="brand-lockup__mark" src="{{ $customLogoUrl }}" alt="Logo de MÖBELS Alejandro">
    @else
        <svg class="brand-lockup__mark" viewBox="0 0 88 88" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <defs>
                <linearGradient id="brandMarkGradient" x1="12" y1="10" x2="75" y2="79" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#4F8191" />
                    <stop offset="1" stop-color="#202F5B" />
                </linearGradient>
            </defs>
            <rect x="6" y="6" width="76" height="76" rx="24" fill="url(#brandMarkGradient)" />
            <rect x="19" y="20" width="50" height="48" rx="12" fill="rgba(255,255,255,0.1)" stroke="rgba(255,255,255,0.18)" />
            <path d="M24 61V29H31L44 46L57 29H64V61H57V41L44.8 57H43L31 41V61H24Z" fill="#F6FBFD" />
            <circle cx="52" cy="19" r="3.5" fill="#D5C4B3" />
            <circle cx="62" cy="19" r="3.5" fill="#D5C4B3" />
        </svg>
    @endif

    <span class="brand-lockup__copy">
        <strong class="brand-font">M&Ouml;BELS ALEJANDRO</strong>
        <span>Melamina, herreria y amoblamientos a medida</span>
    </span>
</div>
