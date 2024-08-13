@extends('layouts.app')
@section('content')
<div id="user_info" style="display: none;">{{ Auth::user()}}</div>
<maincomponent></maincomponent>
@endsection('content')