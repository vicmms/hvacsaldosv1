@props(['color' => 'light'])

<img class="w-12 h-12"
    src="{{ $color == 'light' ? asset('images/saldo-hvac-white.png') : asset('images/saldo-hvac-blue.png') }}"
    alt="saldos hvac">
