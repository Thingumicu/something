<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-semibold text-gray-900">Materii</h1>

        <div class="mt-4">
            <label for="subject-select" class="block text-sm font-medium text-gray-700">Selecteaza o materie</label>
            <select name="subject" id="subject-select" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="" disabled selected>Selecteaza o materie</option>
                @foreach($subjects as $index => $subject)
                    <option value="{{ $subject['id'] }}" {{ $index == 0 ? 'selected' : '' }}>{{ ltrim($subject['name'], '_') }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <x-back-button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" />
        </div>

        <div class="mt-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Materie: <span id="selected-subject" class="text-indigo-600">N/A</span></h3>
        </div>
    </div>

    <script>
        const select = document.getElementById('subject-select');
        const selectedSubject = document.getElementById('selected-subject');

        select.addEventListener('change', function() {
            const selectedIndex = select.selectedIndex;
            const selectedOption = select.options[selectedIndex];
            selectedSubject.textContent = selectedOption.text;
        });

        // Display the selected option text
        if(select.selectedIndex >= 0) {
            selectedSubject.textContent = select.options[select.selectedIndex].text;
        }
    </script>
</x-app-layout>
