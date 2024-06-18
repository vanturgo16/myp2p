@extends('layouts.master')

@section('content')
<div class="page-body">
<div class="container-xl">
    <div class="row">
        <div class="col-7">

        </div>
        <div class="col-md-6 col-lg-5">
            <div class="card">
              <div class="card-status-start bg-danger"></div>
              <div class="card-body">
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">Login</h2>
                    <form action="{{ url('postLogin') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                      @csrf
                      <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="user_email" class="form-control" placeholder="your@email.com" autocomplete="off">
                      </div>
                      <div class="mb-2">
                        <label class="form-label">
                            Password
                            <span class="form-label-description">
                                <a href="./forgot-password.html">I forgot password</a>
                            </span>
                        </label>
                        <div class="input-group input-group-flat">
                            <input type="password" name="user_password" class="form-control"  placeholder="Your password"  autocomplete="off">
                        </div>
                      </div>
                      <div class="mb-2">
                        <label class="form-check">
                          <input type="checkbox" class="form-check-input"/>
                          <span class="form-check-label">Remember me on this device</span>
                        </label>
                      </div>
                      <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                      </div>
                    </form>
                  </div>
                  <div class="hr-text">or</div>
                  <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <a href="#" class="btn w-100">
                                <!-- Download SVG icon from http://tabler-icons.io/i/brand-github -->
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-brand-google"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.945 11a9 9 0 1 1 -3.284 -5.997l-2.655 2.392a5.5 5.5 0 1 0 2.119 6.605h-4.125v-3h7.945z" /></svg>
                                Login with Google
                            </a>
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection