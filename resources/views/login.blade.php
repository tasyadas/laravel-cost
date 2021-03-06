@extends('layout.layout')

@section('title','login')

@section('style')
<link rel="stylesheet" href="{{url('/')}}/css/login.css">
@endsection

@section('content')

<div class="container">
  <div class="putar"></div>
  <div class="putar2"><img src="/img/logo2.png"></div>
</div>

<div class="form">
    <div class="form-panel one">
            <h1>Account Login</h1>
    </div>
      
    <div class="form-content">
        <form method="post" action="/api/login">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" name="email" required="required"/>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" required="required"/>
            </div>
          
            <div class="form-group">
              <button type="submit" name="login">Log In</button>
            </div>
            <div class="form-group">
              <p>
                  Not yet a member? <a href="sign_up.php" style="text-decoration: none">Sign up</a>
              </p>
            </div>
        </form>
    </div>
  </div>


@endsection