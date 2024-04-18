@extends('layouts.app')

@section('content') 
@if(session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                <h1>Tasks</h1>

                <ul>
                    @foreach($objects as $object)
                        <li>
                            {{ $object['name'] }} ({{ $object['name_en'] }})
                            
                            @if(!$object['isAssigned'])
                            <form action="{{ route('assign', ['taskId' => $object['id'], 'userId'=>auth()->id()]) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit">Assign</button>
                            </form>
                            @endif
                        </li>
                    @endforeach
                </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
