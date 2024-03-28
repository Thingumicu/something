@php
    use App\Models\Lesson;
@endphp
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

                        $classroom = $card->classroom->short ?? 'No Classroom';//sala

                        $period = $card->period ?? 'No Period';//ora
                        $dayMapping = [

]
                        $day = $card->days ?? 'No Day';//ziua

                        $optionText = "{$subject} - {$teacher} - {$classroom} - {$period} - {$day}";
                    @endphp
                    <option value="{{ $card->id }}" data-subject="{{ $subject }}" data-teacher="{{ $teacher }}"
                            data-classroom="{{ $classroom }}" data-period="{{ $period }}"
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
                selectedClassroom.textContent = selectedOption.dataset.classroom || 'N/A';
                selectedPeriod.textContent = selectedOption.dataset.period || 'N/A';
                selectedDay.textContent = selectedOption.dataset.day || 'N/A';
                groupHeader.style.display='';
            } else{
                groupHeader.style.display='none';
            }
        });

        // Initialize with the first option's data if available
        if (select.options.length > 1 && select.options[0].dataset) {
            const initialData = select.options[0].dataset;
            selectedLessonSubject.textContent = initialData.subject || 'N/A';
            selectedLessonTeacher.textContent = initialData.teacher || 'N/A';
            selectedClassroom.textContent = initialData.classroom || 'N/A';
            selectedPeriod.textContent = initialData.period || 'N/A';
            selectedDay.textContent = initialData.day || 'N/A';
        }
    </script>
</x-app-layout>
