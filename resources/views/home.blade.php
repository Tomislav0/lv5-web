@extends('layouts.app')

@section('content')
    @if (session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-4">

                    <div class="card-body >
                        <h1 class="ps-4 pb-2">Tasks</h1>

                        <ul>
                            @checkRole('student')
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Name (English)</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($objects as $object)
                                            <tr>
                                                <td>{{ $object['name'] }}</td>
                                                <td>{{ $object['name_en'] }}</td>
                                                <td>
                                                    @unless ($object['isAssigned'])
                                                        <form
                                                            action="{{ route('apply-to-task', ['taskId' => $object['id'], 'userId' => auth()->id()]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary">Assign</button>
                                                        </form>
                                                    @else
                                                        <span class="assigned">Assigned</span>
                                                    @endunless
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endcheckRole

                            @checkRole('teacher')
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('Object Name') }}</th>
                                            <th scope="col">{{ __('Object Name (English)') }}</th>
                                            <th scope="col">{{ __('Student') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($objects as $object)
                                            <tr>
                                                <td>{{ $object['name'] }}</td>
                                                <td>{{ $object['name_en'] }}</td>
                                                <td>
                                                    @if (isset($object['users']) && !isset($object['isAssigned']))
                                                        <form method="POST" style="gap:20px" class="d-flex align-items-center"
                                                            action="{{ route('assign-student', ['task' => $object['id']]) }}">
                                                            @csrf

                                                            <div class="form-group">
                                                                <select name="student" id="student" class="form-control">
                                                                    @foreach ($object['users'] as $user)
                                                                        <option value="{{ $user['id'] }}">
                                                                            {{ $user['name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <button type="submit"
                                                                class="btn btn-primary">{{ __('Accept') }}</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endcheckRole

                            @checkRole('admin')
                                @foreach ($objects as $object)
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
