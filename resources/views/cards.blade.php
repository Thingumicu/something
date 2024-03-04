@php
    use App\Models\Lesson;
@endphp
<x-app-layout>
    <div class="mt-4">
{{--        <label for="search-input" class="block text-sm font-medium text-gray-700">Search:</label>--}}
{{--        <input type="text" id="search-input" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">--}}

        <label for="card-select" class="block mt-4 text-sm font-medium text-gray-700">Selecteaza ceva</label>
        <select name="card" id="card-select"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
            <option value="" disabled selected>Selecteaza ceva</option>
            @foreach ($cards as $card)
                @php
                    $lesson = $card->lesson;
                    $subject = $lesson->subject->name ?? 'No Subject';
                    $teacher = $lesson->teacher->name ?? 'No Teacher';
                    $classroom = $card->classroom->name ?? 'No Classroom';
                    $period = $card->period->period ?? 'No Period';
                    $days = $card->daysDef->name ?? 'No DaysDef';
                    $optionText = "{$subject} - {$teacher} - {$classroom} - {$period} - {$days}";
                @endphp
                <option value="{{ $card->id }}">{{ $optionText }}</option>
            @endforeach
        </select>
    </div>

    <script>
        // Get the select element and search input
        const select = document.getElementById('card-select');
        const searchInput = document.getElementById('search-input');

        // Add event listener for input event on search input
        searchInput.addEventListener('input', function () {
            const searchTerm = searchInput.value.toLowerCase();
            const options = select.getElementsByTagName('option');

            // Loop through options and show/hide based on search term
            for (let i = 0; i < options.length; i++) {
                const optionText = options[i].textContent.toLowerCase();
                if (optionText.includes(searchTerm)) {
                    options[i].style.display = '';
                } else {
                    options[i].style.display = 'none';
                }
            }
        });
    </script>

</x-app-layout>
