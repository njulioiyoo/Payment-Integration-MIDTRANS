@extends('layouts.app')

@section('content')

<main>
  <div class="table">
    @foreach ($product as $key => $p)
      @php
        $index = $key + 1;
      @endphp
      <div class="tiles tile{{ $index }}">
        <h1 style="color: black;">{{ $p->name }}</h1><img class="center" src="{{ $p->image }}" alt=""/>
        {!! $p->description !!}
        <br>
        <a href="{{ url('/select').'/'.$p->type }}" class="btn btn-info" role="button">Rp.{{ number_format($p->price) }}/month</a>
      </div>
    @endforeach
  </div>
</main>

@endsection
