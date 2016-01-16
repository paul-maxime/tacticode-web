{{--*/ $nav = 'scripts' /*--}}
@extends('layouts.dashboard')

@section('page-scripts')
    <script src="/js/codemirror.js"></script>
    <script src="/js/modes/javascript.js"></script>
@endsection

@section('page-styles')
    <link rel="stylesheet" href="/css/codemirror.css">
@endsection

@section('content')
    <h1 class="page-header">{{ $script->name }}</h1>

    {!! Form::open() !!}

    	<textarea id="codemirror" style="display:none" name="content">{{ $script->content }}</textarea>

    	<div class="spacer"></div>

    	<div class="form-group">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>

    {!! Form::close() !!}

    <script>
    	$(document).ready(function() {

    		var editor = CodeMirror.fromTextArea(document.getElementById('codemirror'), {
    			lineNumbers: true,
    			mode: "javascript",
    			matchBrackets: true
			});
    	});
    </script>
@endsection