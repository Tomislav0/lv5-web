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
                    @checkRole('student')
                        @foreach($objects as $object)
                            <li>
                                {{ $object['name'] }} ({{ $object['name_en'] }})
                                
                                @if(!$object['isAssigned'])
                                <form action="{{ route('apply-to-task', ['taskId' => $object['id'], 'userId' => auth()->id()]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit">Assign</button>
                                </form>
                                @endif
                            </li>
                        @endforeach
                    @endcheckRole
                    
                    @checkRole('teacher')
                    @foreach($objects as $object)
                            <li>
                                {{ $object['name'] }} ({{ $object['name_en'] }})
                                @if(isset($object['users']) && !isset($object['isAssigned']))
                                <form method="POST" action="{{ route('assign-student', ['task'=>$object['id']]) }}">
                                    @csrf

                                    <div class="form-group">
                                        <label for="student">{{__('Student')}}:</label>
                                        <select name="student" id="student" class="form-control">
                                            @foreach($object['users'] as $user)
                                                <option value="{{$user['id']}}">{{$user['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-2">Accept</button>
                                </form>
                                @endif
                            </li>
                        @endforeach
                    @endcheckRole

                    @checkRole('admin')

                    @foreach($objects as $object)
                            <li>
                                {{ $object['name'] }} ({{ $object['name_en'] }})
                            </li>
                        @endforeach
                    @endcheckRole
                </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
