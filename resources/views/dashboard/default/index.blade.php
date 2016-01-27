<!DOCTYPE html>
<html lang="en">
<head>
    <title> {{$title}} | {{ Config::get('qilara.site_name') }}</title>
    @include('partial.header')
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">
                        <a href="{{route('dashboard')}}" class="site_title"><i class="icomoon-lipi"></i> <span>Puslit Kimia</span></a>
                    </div>
                    <div class="clearfix"></div>


                    <!-- menu prile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            <img src="{{Theme::url('images/user.png')}}" class="img-circle profile_img" id="image_upload">
                            <input type="file" id="avatar_upload" style="display: none;" />
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>{{ Auth::user()->name }}</h2>
                        </div>
                    </div>
                    <!-- /menu prile quick info -->

                    <br />
                    @include('partial.menu')
                </div>
            </div>

            <!-- top navigation -->
            @include('partial.top_nav')
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                @yield('content')
            </div>
</div>
@include('partial.footer')
@yield('footer_js')
</body>

</html>
