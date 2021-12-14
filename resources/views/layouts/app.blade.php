@include('layouts.header')
<body>
    <div class="site-header">
        <div class="container">
            <a>
                <div class="logo-type" style="padding-top:2%">
                    <div class="topBanCnt body" style="width:351px">
                        <p><img src="https://www.bizmates.ph/common/images/logo_big.png" alt=""></p>
                        <p class="cpn_name">Philippines, Inc.</p>
                        <p class="bigtxt">No.1 ONLINE BUSINESS<br>ENGLISH SCHOOL in Japan</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    
    <div class="container">
        @yield('content')
    </div>
</body>
@include('layouts.footer')
@yield('footer-scripts')
