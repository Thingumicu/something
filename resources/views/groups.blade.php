@extends('layout')

@section('content')
    <h1>Groups</h1>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Class ID</th>
            <th>Entire class</th>
            <th>Division tag</th>
        </tr>
        </thead>
        <tbody>
        @foreach($groups as $group)
            <tr>
                <td>{{ $group['id'] }}</td>
                <td>{{ $group['name'] }}</td>
                <td>{{ $group['classid'] }}</td>
                <td>{{ $group['entireclass'] }}</td>
                <td>{{ $group['divisiontag'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
