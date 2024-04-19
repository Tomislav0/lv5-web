
@extends('layouts.app')

@section('content') 
    @if(session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
<div class="container">
    <div>
    <form id="taskForm" method="GET" action="{{ route('task', ['lang' => 'en']) }}">
    @csrf
    <select id="localeSelect" name="locale" onchange="updateFormAction()">
        <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
        <option value="hr" {{ app()->getLocale() == 'hr' ? 'selected' : '' }}>Croatian</option>
    </select>
</form>

    </div>
    <h1>{{__('task.add_task')}}</h1>
    <form method="POST" action="{{ route('create-task') }}">
        @csrf

        <div class="form-group">
            <label for="name">{{__('task.name')}}:</label>
            <input type="text" name="name" id="name" class="form-control">
        </div>

        <div class="form-group">
            <label for="name_en">{{__('task.name_en')}}:</label>
            <input type="text" name="name_en" id="name_en" class="form-control">
        </div>

        <div class="form-group">
            <label for="task_aim">{{__('task.task_aim')}}:</label>
            <textarea type="text" name="task_aim" id="task_aim" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="study_type">{{__('task.study_type')}}:</label>
            <select name="study_type" id="study_type" class="form-control">
                <option value="stručni">{{__('task.professional')}}</option>
                <option value="preddiplomski">{{__('task.undergraduate')}}</option>
                <option value="diplomski">{{__('task.graduate')}}</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Submit</button>
    </form>
</div>

<script>
    function updateFormAction() {
        var selectedLocale = document.getElementById('localeSelect').value;
        var form = document.getElementById('taskForm');
        console.log(selectedLocale)
        form.action = "{{ route('task', ['lang' => ':locale']) }}".replace(':locale', selectedLocale);
        form.submit();
    }
</script>
@endsection
