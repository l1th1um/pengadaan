@include('login.header_login')

<body style="background:#F7F7F7;">
<h1 style="font-size: 48px;text-align:center;font-family: 'Lato', sans-serif;">
    {{ Config::get('qilara.site_name') }}
</h1>
<div class="">
    <a class="hiddenanchor" id="tologin"></a>

    <div id="wrapper">
        <div id="login" class="animate form">
            @if (count($errors) > 0)
                <div class="alert alert-danger" style="margin-bottom : 50px">
                    <ul style="list-style : none">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <section class="login_content">
                {!! Form::open(array('action' => 'DashboardController@login', 'class' => 'form-horizontal', 'method' => 'post')) !!}
                    <h1>Login Form</h1>
                    <div>
                        <input type="text" class="form-control" placeholder="Username or E-mail" required="" name="username" value="{{ old('username') }}" />
                    </div>
                    <div>
                        <input type="password" class="form-control" placeholder="Password" required="" name="password" />
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success">
                            Sign In
                        </button>
                    </div>
                    <div class="clearfix"></div>
                    <div class="separator">
                        <div class="clearfix"></div>
                        <br />
                        <div>
                            <p>©2015 Qilara CMS</p>
                        </div>
                    </div>
                {!! Form::close() !!}
                <!-- form -->
            </section>
            <!-- content -->
        </div>
    </div>
</div>

</body>

</html>

