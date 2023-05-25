@extends('layout')

@section('content')
    <h1>Lessons</h1>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Class ID</th>
            <th>Subject ID</th>
            <th>Periods per card</th>
            <th>Periods per week</th>
            <th>Teacher ID</th>
            <th>Group ID</th>
            <th>Term ID</th>
            <th>Week ID</th>
            <th>Day ID</th>
        </tr>
        </thead>
        <tbody>
        @foreach($lessons as $lesson)
            <tr>
                <td>{{ $lesson['id'] }}</td>
                <td>{{ $lesson['classids'] }}</td>
                <td>{{ $lesson['subjectid'] }}</td>
                <td>{{ $lesson['periodspercard'] }}</td>
                <td>{{ $lesson['periodsperweek'] }}</td>
                <td>{{ $lesson['teacherids'] }}</td>
                <td>{{ $lesson['groupids'] }}</td>
                <td>{{ $lesson['termsdefid'] }}</td>
                <td>{{ $lesson['weeksdefid'] }}</td>
                <td>{{ $lesson['daysdefid'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
