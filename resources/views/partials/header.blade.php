<header class="main_menu {{ isset($breadcrumb) ? 'single_page_menu' : 'home_menu' }}">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand logo_1" href="{{ route('home') }}">
                        <img src="{{ asset('img/single_page_logo.png') }}" alt="logo">
                    </a>
                    <a class="navbar-brand logo_2" href="{{ route('home') }}">
                        <img src="{{ asset('img/logo.png') }}" alt="logo">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse main-menu-item justify-content-end"
                        id="navbarSupportedContent">
                        <ul class="navbar-nav align-items-center">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">{{ __('main.home') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('courses.index') }}">{{ __('main.courses') }}</a>
                            </li>
                            @if ($menuDisciplines->count())
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                                        role="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        {{ __('main.disciplines') }}
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        @foreach ($menuDisciplines as $id => $discipline)
                                            <a class="dropdown-item"
                                                href="{{ route('courses.index') }}?discipline={{ $id }}">{{ $discipline }}</a>
                                        @endforeach
                                    </div>
                                </li>
                            @endif
                            @if ($menuInstitutions->count())
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                                        role="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        {{ __('main.institutions') }}
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        @foreach ($menuInstitutions as $id => $institution)
                                            <a class="dropdown-item"
                                                href="{{ route('courses.index') }}?institution={{ $id }}">{{ $institution }}</a>
                                        @endforeach
                                    </div>
                                </li>
                            @endif
                            @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('enroll.myCourses') }}">{{ __('main.my_courses') }}</a>
                            </li>
                            <li class="d-none d-lg-block">
                                <a class="btn_1" href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">{{ trans('global.logout') }}</a>
                                <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @else
                            <li class="d-none d-lg-block">
                                <a class="btn_1" href="{{ route('login') }}">{{ trans('global.login') }}</a>
                            </li>
                        @endauth


                        <!-- Language Switcher -->
                        <li class="nav-item">
                            <a href="{{ url('lang/en') }}" class="nav-link">English</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('lang/fa') }}" class="nav-link">فارسی</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
</header>
