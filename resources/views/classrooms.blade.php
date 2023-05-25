@extends('layout')

@section('content')
    <h1>Sali</h1>
    <select name="classroom" id="classroom-select">
        <option value="" disabled selected>Selecteaza o sala</option>
        @foreach($classrooms as $index => $classroom)
            <option value="{{ $classroom['id'] }}" {{ $index == -1 ? 'selected' : '' }}>{{ ltrim($classroom['name'], '_') }}</option>
        @endforeach
    </select>

    @include('_back-button')

    <h3 id="selected-classroom"></h3>

    <script>
        const select = document.getElementById('classroom-select');
        const selectedTeacher = document.getElementById('selected-classroom');

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
