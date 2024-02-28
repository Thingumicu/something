<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-semibold text-gray-900">Sali</h1>

        <div class="mt-4">
            <label for="classroom-select" class="block text-sm font-medium text-gray-700">Selecteaza o sala</label>
            <select name="classroom" id="classroom-select" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="" disabled selected>Selecteaza o sala</option>
                @foreach($classrooms as $index => $classroom)
                    <option value="{{ $classroom['id'] }}" {{ $index == 0 ? 'selected' : '' }}>{{ ltrim($classroom['name'], '_') }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <x-back-button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" />
        </div>

        <div class="mt-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Sala selectata: <span id="selected-classroom" class="text-indigo-600">N/A</span></h3>
        </div>
    </div>

    <script>
        const select = document.getElementById('classroom-select');
        const selectedClassroom = document.getElementById('selected-classroom');

        select.addEventListener('change', function() {
            const selectedIndex = select.selectedIndex;
            const selectedOption = select.options[selectedIndex];
            selectedClassroom.textContent = selectedOption.text;
        });

        // Initialize with the first option's data if available
        if(select.options.length > 1) {
            const initialOption = select.options[1];
            selectedClassroom.textContent = initialOption.text;
        }
    </script>
</x-app-layout>
