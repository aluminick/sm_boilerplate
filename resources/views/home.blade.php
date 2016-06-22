@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    Your Application's Landing Page.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('feed')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-primary">
        <div class="panel-heading">News Feed</div>

        <div class="panel-body">

            <!-- Add Post (posts/add.blade.php) -->
            @include('posts.components.add')
            <!-- End of Add Post -->

            <!-- Post List (posts/list.blade.php)-->
            @include('posts.list')
            <!-- End of Post List -->
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
