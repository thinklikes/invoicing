@extends('layouts.app')

@inject('public', 'App\Presenters\PublicPresenter')

@section('content')

        <form action="{{ url("/".$app_name) }}" method="POST" role="form">
            {{ csrf_field() }}
    @foreach ($head['fields'] as $key => $item)
            <div class="form-group">
                <label {{ in_array($key, $required[$headName]) ? 'class=required' : '' }}>
                    {{ $item['title'] }}
                    {{ method_field('PUT') }}
                </label>
                {!!
                    $public->renderHtmlElement(
                        $item['type'],
                        $headName."[".$key."]",
                        $head['data'][$key],
                        (
                            isset($item['source'])
                            ? $item['source']
                            : []
                        )
                    )
                !!}
            </div>
    @endforeach
            <button class="btn btn-default">確認送出</button>
        </form>

@endsection