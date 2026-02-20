@if ($errors->any())
    <div class="mb-6 p-4 bg-red-900/50 border border-red-500 text-red-200 rounded-lg">
        <div class="font-bold mb-2">入力内容にエラーがあります：</div>
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('status'))
    <div class="mb-6 p-4 bg-green-900/50 border border-green-500 text-green-200 rounded-lg font-bold">
        {{ session('status') }}
    </div>
@endif
