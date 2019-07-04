@extends('layouts.app')

@section('title', $user->name)

@section('content')
  <div class="container">
    <div class="col-md-8 offset-md-2">
      <div class="card">
        <div class="card-header">
          <h4>
            <i class="glyphicon glyphicon-edit"></i>
            编辑个人资料
          </h4>
        </div>
        <div class="card-body">
          <form action="{{ route('user.update', Auth::user()) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            @include('shared._error')
            <div class="form-group">
              <label for="name-field">用户名</label>
              <input type="text" name="name" value="{{ old('name', $user->name) }}" id="name-field" class="form-control" placeholder="" aria-describedby="helpId">
            </div>
            <div class="form-group">
              <label for="email-field">邮 箱</label>
              <input type="text" name="email" value="{{ old('email', $user->email) }}" id="email-field" class="form-control" placeholder="" aria-describedby="helpId">
            </div>
            <div class="form-group">
              <label for="introduction-field">个人简介</label>
              <textarea type="text" name="introduction" id="introduction-field" class="form-control" rows="3" placeholder="" aria-describedby="helpId">
{{ old('introduction', $user->introduction) }}
            </textarea>
            </div>
            <div class="form-group mb-4">
              <label for="" class="avatar-label">用户头像</label>
              <input type="file" name="avatar" id="" class="form-control-file">
              @if ($user->avatar)
                <br>
                <img src="{{ $user->avatar }}" alt="" class="img-thumbnail img-responsive" width="200px">
              @endif
            </div>
            <div class="well well-sm">
              <button type="submit" class="btn btn-primary">保存</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@stop