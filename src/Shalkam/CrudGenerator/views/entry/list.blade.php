@extends('app')
@section('title')
@endsection
@section('content')
Examples List

<table class="table table-striped table-hover table-responsive">
    <tr>
        @foreach ($entries->first()->sortable as $attr)
        <th>@sortablelink($attr)</th>
        @endforeach
        <td></td>
    </tr>
    @foreach ($entries as $entry)
    <tr>
        @foreach ($entry->sortable as $attr)
        <td>{{ $entry->$attr }}</td>
        @endforeach
        <td><a href="{{ Request::url() }}/{{ $entry->id }}">Read more</a></td>
    </tr>
    @endforeach
</table>
{!! $entries->appends(\Input::except('page'))->render() !!}
<!--@foreach ($entries as $entry)
<ul>
    @foreach ($entry->getAttributes() as $id=> $val)
    <li>{{ $id }} : {{$val}}</li>
    @endforeach
</ul>
@endforeach-->
@endsection