@layout('layouts.master')

<?php
    $edit = isset($policy);
?>

@section('content')
    @if ($edit)
        <h1>Edit Policy Document</h1>
    @else
        <h1>Add Policy Document</h1>
    @endif
@endsection