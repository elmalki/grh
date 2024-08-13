@extends('layouts.app')
@section('content')
        @if ($errors->has('cin'))
        $errors->has('cin')         
        @endif
<login></login>
@endsection('content')