@extends('layouts.app')


@section('content')
    <script type="text/javascript">
        function isEnglishFileName() {
            var fileName = document.getElementById('ja').value.split('.')[0];
            return !fileName.match(/[^\x00-\xff]+/g);
        }
    </script>
    <input id="ja" name="NewFile" type="file">
    <button name="test" onclick="if(isEnglishFileName()) alert('test');" value="test">test</button>
@endsection('content')