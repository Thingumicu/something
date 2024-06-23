<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-semibold text-gray-900">Intrari</h1>
        <div class="mt-4">
            <label for="card-select" class="block mt-4 text-sm font-medium text-gray-700">Selecteaza o intrare</label>
            <select name="card" id="card-select"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="" disabled selected>Selecteaza o intrare</option>
                @foreach($cards as $index => $card)
                    @php
                        $lesson = $card->lesson;//curs

                        $subject = $lesson->subject->name ?? 'No Subject';//curs -> materie

                        $teacher = ltrim($lesson->teacher->name, '_') ?? 'No Teacher';//curs -> nume profesor

                        // Fetching class names for each class ID
                        $classIds = explode(',', $lesson->classids);
                        $classNames = [];
                        foreach ($classIds as $classId) {
                            $class = Clas::find($classId);
                            if ($class) {
                                $classNames[] = $class->name;
                            }
                        }
                        $class = implode(', ', $classNames);

                        $classroom = $card->classroom->short ?? 'No Classroom';//sala

                        $period = $card->period ?? 'No Period';//ora

                        $dayMapping = [
                            '00001' => 'Luni',
                            '00010' => 'Marti',
                            '00100' => 'Miercuri',
                            '01000' => 'Joi',
                            '10000' => 'Vineri',
                        ];
                        $day = $dayMapping[$card->days] ?? 'No Day';//ziua

                        $periodMapping = [
                            '1' => '08:00 - 08:50',
                            '2' => '09:00 - 09:50',
                            '3' => '10:00 - 10:50',
                            '4' => '11:00 - 11:50',
                            '5' => '12:00 - 12:50',
                            '6' => '13:00 - 13:50',
                            '7' => '14:00 - 14:50',
                            '8' => '15:00 - 15:50',
                            '9' => '16:00 - 16:50',
                            '10' => '17:00 - 17:50',
                            '11' => '18:00 - 18:50',
                            '12' => '19:00 - 19:50',
                            '13' => '20:00 - 20:50',
                            '14' => '21:00 - 21:50',
                        ];

                        $period = $periodMapping[$card->period] ?? 'No Period';

                        $optionText = "{$subject} - {$teacher} - {$class} - {$classroom} - {$period} - {$day}";
                    @endphp
                    <option value="{{ $card->id }}" data-subject="{{ $subject }}" data-teacher="{{ $teacher }}"
                            data-class="{{ $class }}" data-classroom="{{ $classroom }}" data-period="{{ $period }}"
                            data-day="{{ $day }}">{{ $optionText }}</option>
                @endforeach
            </select>
        </div>
        <div class="mt-4">
            <x-back-button
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"/>
        </div>

        <div id="group-header" style="display: none;" class="mt-4">
            <h2 class="text-lg leading-6 font-medium text-gray-900">Subject: <span id="selected-lesson-subject"
                                                                                   class="text-indigo-600">N/A</span>
            </h2>
            <h2 class="text-lg leading-6 font-medium text-gray-900">Teacher: <span id="selected-lesson-teacher"
                                                                                   class="text-indigo-600">N/A</span>
            </h2>
            <h2 class="text-lg leading-6 font-medium text-gray-900">Class: <span id="selected-class"
                                                                                 class="text-indigo-600">N/A</span>
            </h2>
            <h2 class="text-lg leading-6 font-medium text-gray-900">Classroom: <span id="selected-classroom"
                                                                                     class="text-indigo-600">N/A</span>
            </h2>
            <h2 class="text-lg leading-6 font-medium text-gray-900">Period: <span id="selected-period"
                                                                                  class="text-indigo-600">N/A</span>
            </h2>
            <h2 class="text-lg leading-6 font-medium text-gray-900">Day: <span id="selected-day"
                                                                               class="text-indigo-600">N/A</span></h2>
        </div>
    </div>

    <script>
        const select = document.getElementById('card-select');
        const selectedLessonSubject = document.getElementById('selected-lesson-subject');
        const selectedLessonTeacher = document.getElementById('selected-lesson-teacher');
        const selectedClass = document.getElementById('selected-class');
        const selectedClassroom = document.getElementById('selected-classroom');
        const selectedPeriod = document.getElementById('selected-period');
        const selectedDay = document.getElementById('selected-day');

        select.addEventListener('change', function () {
            const selectedIndex = select.selectedIndex;
            const selectedOption = select.options[selectedIndex];
            const groupHeader = document.getElementById('group-header');

            if (selectedOption.value) {
                selectedLessonSubject.textContent = selectedOption.dataset.subject || 'N/A';
                selectedLessonTeacher.textContent = selectedOption.dataset.teacher || 'N/A';
                selectedClass.textContent = selectedOption.dataset.class || 'N/A';
                selectedClassroom.textContent = selectedOption.dataset.classroom || 'N/A';
                selectedPeriod.textContent = selectedOption.dataset.period || 'N/A';
                selectedDay.textContent = selectedOption.dataset.day || 'N/A';
                groupHeader.style.display = '';
            } else {
                groupHeader.style.display = 'none';
            }
        });

        // Initialize with the first option's data if available
        if (select.options.length > 1 && select.options[0].dataset) {
            const initialData = select.options[0].dataset;
            selectedLessonSubject.textContent = initialData.subject || 'N/A';
            selectedLessonTeacher.textContent = initialData.teacher || 'N/A';
            selectedClass.textContent = initialData.class || 'N/A';
            selectedClassroom.textContent = initialData.classroom || 'N/A';
            selectedPeriod.textContent = initialData.period || 'N/A';
            selectedDay.textContent = initialData.day || 'N/A';
        }
    </script>
</x-app-layout>
<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-semibold text-gray-900">Intrari</h1>
        <div class="mt-4">
            <label for="card-select" class="block mt-4 text-sm font-medium text-gray-700">Selecteaza o intrare</label>
            <select name="card" id="card-select"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="" disabled selected>Selecteaza o intrare</option>
                @foreach($cards as $index => $card)
                    @php
                        $lesson = $card->lesson;//curs

                        $subject = $lesson->subject->name ?? 'No Subject';//curs -> materie

                        $teacher = ltrim($lesson->teacher->name, '_') ?? 'No Teacher';//curs -> nume profesor

                        // Fetching class names for each class ID
                        $classIds = explode(',', $lesson->classids);
                        $classNames = [];
                        foreach ($classIds as $classId) {
                            $class = Clas::find($classId);
                            if ($class) {
                                $classNames[] = $class->name;
                            }
                        }
                        $class = implode(', ', $classNames);

                        $classroom = $card->classroom->short ?? 'No Classroom';//sala

                        $period = $card->period ?? 'No Period';//ora

                        $dayMapping = [
                            '00001' => 'Luni',
                            '00010' => 'Marti',
                            '00100' => 'Miercuri',
                            '01000' => 'Joi',
                            '10000' => 'Vineri',
                        ];
                        $day = $dayMapping[$card->days] ?? 'No Day';//ziua

                        $periodMapping = [
                            '1' => '08:00 - 08:50',
                            '2' => '09:00 - 09:50',
                            '3' => '10:00 - 10:50',
                            '4' => '11:00 - 11:50',
                            '5' => '12:00 - 12:50',
                            '6' => '13:00 - 13:50',
                            '7' => '14:00 - 14:50',
                            '8' => '15:00 - 15:50',
                            '9' => '16:00 - 16:50',
                            '10' => '17:00 - 17:50',
                            '11' => '18:00 - 18:50',
                            '12' => '19:00 - 19:50',
                            '13' => '20:00 - 20:50',
                            '14' => '21:00 - 21:50',
                        ];

                        $period = $periodMapping[$card->period] ?? 'No Period';

                        $optionText = "{$subject} - {$teacher} - {$class} - {$classroom} - {$period} - {$day}";
                    @endphp
                    <option value="{{ $card->id }}" data-subject="{{ $subject }}" data-teacher="{{ $teacher }}"
                            data-class="{{ $class }}" data-classroom="{{ $classroom }}" data-period="{{ $period }}"
                            data-day="{{ $day }}">{{ $optionText }}</option>
                @endforeach
            </select>
        </div>
        <div class="mt-4">
            <x-back-button
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"/>
        </div>

        <div class="mt-4">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Subject
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Teacher
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Class
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Classroom
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Period
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Day
                    </th>
                </tr>
                </thead>
                <tbody id="selected-data">
                <!-- Selected data will be populated here -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const select = document.getElementById('card-select');
        const selectedData = document.getElementById('selected-data');

        select.addEventListener('change', function () {
            const selectedIndex = select.selectedIndex;
            const selectedOption = select.options[selectedIndex];

            if (selectedOption.value) {
                const subject = selectedOption.dataset.subject || 'N/A';
                const teacher = selectedOption.dataset.teacher || 'N/A';
                const classValue = selectedOption.dataset.class || 'N/A';
                const classroom = selectedOption.dataset.classroom || 'N/A';
                const period = selectedOption.dataset.period || 'N/A';
                const day = selectedOption.dataset.day || 'N/A';

                // Populate the table with selected data
                selectedData.innerHTML = `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">${subject}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${teacher}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${classValue}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${classroom}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${period}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${day}</td>
                    </tr>
                `;
            } else {
                // Clear the table if no option is selected
                selectedData.innerHTML = '';
            }
        });
    </script>
</x-app-layout>
