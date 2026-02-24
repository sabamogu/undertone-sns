@props(['disabled' => false])

<!-- <input {{ $attributes->merge(['class' => 'bg-gray-300 border-gray-400 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>
<style>
    /* 背景を暗い色にして、伏せ字（白）を見やすくする場合 */
    input:-webkit-autofill {
        -webkit-box-shadow: 0 0 0px 1000px #374151 inset !important; /* bg-gray-700相当 */
        -webkit-text-fill-color: #ffffff !important; /* 文字を白にする */
    }
</style> -->
<style>
    /* 入力欄そのものの色を濃いグレーに固定 */
    .dark-input {
        background-color: #111827 !important; /* bg-gray-900 */
        color: white !important;
    }

    /* ブラウザの自動補完（薄いグレーになるやつ）を完全に上書き */
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus {
        -webkit-text-fill-color: white !important;
        -webkit-box-shadow: 0 0 0px 1000px #111827 inset !important; /* 濃いグレーで塗りつぶす */
        transition: background-color 5000s ease-in-out 0s;
    }
</style>

<input {{ $attributes->merge(['class' => 'dark-input border-gray-700 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>