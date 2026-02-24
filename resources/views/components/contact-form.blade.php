<section id="contact" class="bg-gray-900 py-20 border-t border-gray-800">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white tracking-widest">CONTACT</h2>
            <p class="text-gray-400 mt-2">お問い合わせはこちらから</p>
        </div>

        {{-- 送信成功メッセージの表示 --}}
        @if (session('status'))
            <div class="max-w-md mx-auto bg-green-600 text-white p-4 rounded-lg mb-8 text-center shadow-lg">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- お名前 --}}
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                        class="w-full bg-gray-800 border-gray-700 text-white rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-3 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- メールアドレス --}}
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                        class="w-full bg-gray-800 border-gray-700 text-white rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-3 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- メッセージ --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Message</label>
                <textarea name="message" rows="4" 
                    class="w-full bg-gray-800 border-gray-700 text-white rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-3 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 送信ボタン --}}
            <div class="text-center">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-10 rounded-full transition duration-300 shadow-lg">
                    SEND MESSAGE
                </button>
            </div>
        </form>
    </div>
</section>
<footer class="bg-gray-900 py-8 border-t border-gray-800 text-center">
    <p class="text-gray-500 text-sm">
        &copy; {{ date('Y') }} UNDER TONE. All rights reserved.
    </p>
</footer>