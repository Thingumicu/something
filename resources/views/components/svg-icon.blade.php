{{-- This is svg-icon.blade.php --}}
@if(!empty($path))
    @php
        echo file_get_contents(public_path($path));
    @endphp
@else
    {{-- Handle the case where $path is not provided --}}
    <p>SVG path not provided.</p>
@endif
