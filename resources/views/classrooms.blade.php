<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-semibold text-gray-900">Sali</h1>

        <div class="mt-4">
            <label for="classroom-select" class="block text-sm font-medium text-gray-700">Selecteaza o sala</label>
            <select name="classroom" id="classroom-select"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="" disabled selected>Selecteaza o sala</option>
                @foreach($classrooms->sortBy('name') as $index => $classroom)
                    <option value="{{ $classroom['id'] }}">{{ $classroom['short'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <x-back-button
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"/>
        </div>

        <div id="group-header" class="mt-6 text-center" style="display:none;">
            <h3 class="text-lg leading-6 font-medium text-gray-900"><span id="selected-classroom"
                                                                          class="text-indigo-600">N/A</span></h3>
            <!-- Schedule Table Placeholder -->
            <div id="schedule-table" class="mt-4">
                <!-- Dynamically generated schedule will be inserted here -->
            </div>
        </div>
    </div>

    <script>
        const select = document.getElementById('classroom-select');
        const selectedClassroom = document.getElementById('selected-classroom');
        const scheduleTable = document.getElementById('schedule-table');

        select.addEventListener('change', function () {
            const selectedIndex = select.selectedIndex;
            const selectedOption = select.options[selectedIndex];
            const groupHeader = document.getElementById('group-header');

            if (selectedOption.value) {
                selectedClassroom.textContent = selectedOption.text;
                groupHeader.style.display = '';
            } else {
                groupHeader.style.display = 'none';
            }

            updateScheduleTable(selectedOption.value);
        });

        // Display the selected option text
        if (select.selectedIndex >= 0) {
            selectedClassroom.textContent = select.options[select.selectedIndex].text;
        }

        function updateScheduleTable(classId) {
            // Define the start and end hours
            const startHour = 8; // Starting at 8
            const endHour = 21; // Up to 21, for 21-22 slot

            // Start building the table HTML
            let tableHTML = `
            <table class="min-w-full divide-y divide-gray-200 border border-black-900">
                <thead>
                    <tr>
                        @foreach($headers as $header)
            <th class="text-center px-6 py-3 bg-gray-50 text-left text-xs font-small text-gray-500 border border-black-900 uppercase tracking-wider">{{ $header }}</th>
                      @endforeach
            </tr>
        </thead>

        <tbody>`;

            // Loop from startHour to endHour and generate table rows
            for (let hour = startHour; hour <= endHour; hour++) {
                // Format the time slot string
                let timeSlot = `${hour}-${hour+1}`;

                // Generate the row with dynamic time slots
                tableHTML += `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap border border-black-900">${timeSlot}</td>
                            @foreach($contents as $content)
                <th class="text-center px-6 py-3 bg-gray-50 text-left text-xs font-small text-gray-500 border border-black-900 lowercase tracking-wider">{{ $content }}</th>
                            @endforeach
                </tr>`;
            }

            // Close the table HTML
            tableHTML += `
                </tbody>
            </table>`;

            // Update the scheduleTable's innerHTML with the generated table HTML
            scheduleTable.innerHTML = tableHTML;
        }

    </script>

</x-app-layout>
