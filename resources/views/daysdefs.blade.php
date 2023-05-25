@extends('layout')

@section('content')
    <h1>Days</h1>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Short</th>
            <th>Days</th>
        </tr>
        </thead>
        <tbody>
        @foreach($daysdefs as $day)
            <tr>
                <td>{{ $day['id'] }}</td>
                <td>{{ $day['name'] }}</td>
                <td>{{ $day['short'] }}</td>
                <td>{{ $day['days'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
