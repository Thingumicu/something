@extends('layout')

@section('content')
    <h1>Materii</h1>
    <select name="subject" id="subject-select">
        <option value="" disabled selected>Selecteaza o materie</option>
        @foreach($subjects as $index => $subject)
            <option value="{{ $subject['id'] }}" {{ $index == -1 ? 'selected' : '' }}>{{ $subject['name'] }} --> {{ $subject['short'] }}</option>
        @endforeach
    </select>

    @include('_back-button')

    <h3 id="selected-subject"></h3>

    <script>
        const select = document.getElementById('subject-select');
        const selectedTeacher = document.getElementById('selected-subject');

        select.addEventListener('change', function() {
            const selectedIndex = select.selectedIndex;
            const selectedOption = select.options[selectedIndex];
            selectedTeacher.textContent = selectedOption.text;
        });

        // Display the first option by default
        const firstOption = select.options[0];
        selectedTeacher.textContent = firstOption.text;
    </script>
@endsection
