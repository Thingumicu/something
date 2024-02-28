<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-semibold text-gray-900">Test Cards</h1>

        <div class="mt-4">
            <label for="card-select" class="block text-sm font-medium text-gray-700">Selecteaza ceva</label>
            <select name="card" id="card-select" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="" disabled selected>Selecteaza o grupa</option>
                @foreach($cards as $index => $card)
                    @php
                        // Assuming 'unique_identifier' is the column in your lessons table that matches the lessonid format
                        $lesson = \App\Models\Lesson::with('subject')->where('id', '=', $card['lessonid'])->first();
                        $lessonName = $lesson && $lesson->subject ? $lesson->subject->name : 'N/A';
                    @endphp
                    <option value="{{ $card['id'] }}" {{ $index == 0 ? 'selected' : '' }}>{{ $lessonName }}</option>
                @endforeach

            </select>
        </div>
    </div>
</x-app-layout>
