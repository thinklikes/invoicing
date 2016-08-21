@extends('layouts.app')

@section('content')
    <form action="" method="POST" role="form">
        <div class="custom-table">
            <div class="thead">
                <div class="tr">
                    <div class="th string">使用者姓名</div>
    @foreach($auths as $auth)
                    <div class="th string">
                        <label>{{ $auth->comment }}</label>
                    </div>
    @endforeach
                </div>
            </div>
    @foreach($users as $user)
            <div class="tr">
                <div class="th string">
                    <label>{{ $user->emp_name }}</label>
                    <input type="hidden" name="auth[employee_id][{{ $user->employee_id }}]"
                        value="{{ $user->employee_id }}">
                </div>
        @foreach($auths as $auth)
                <div class="td string" data-title="{{ $user->emp_name }}">
                    <label>
                        <input type="radio" name="auth[auth_level][{{ $user->employee_id }}]"
                            value="{{ $auth->level }}"
                            {{ ($user->leavl == $auth->level) ? "checked" : ""}}>
                    </label>
                </div>
        @endforeach
            </div>
    @endforeach
        </div>
        <button class="btn btn-default">確認送出</button>
    </form>
@endsection