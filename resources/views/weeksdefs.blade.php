@extends('layout')

@section('content')
    <h1>Weeks</h1>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Short</th>
            <th>Week</th>
        </tr>
        </thead>
        <tbody>
        @foreach($weeksdefs as $week)
            <tr>
                <td>{{ $week['id'] }}</td>
                <td>{{ $week['name'] }}</td>
                <td>{{ $week['short'] }}</td>
                <td>{{ $week['weeks'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
