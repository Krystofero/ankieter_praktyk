{{-- Navigation Bar on the up site - included in files --}}
<nav class="navbar navbar-expand-md bg-dark navbar-dark sticky-top">
    <!-- Logo -->
    {{-- <img src="{{URL::asset('/image/Logo.png')}}" width="45" height="40"> --}}
    <a class="navbar-brand logo" href="{{url('')}}">QuestionIS?</a>
    {{-- Responsive button --}}
    <button class="navbar-toggler" data-toggle="collapse" data-target="#collapse_target">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="nav-item collapse navbar-collapse menu" id="collapse_target">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{url('/ankiety')}}">Moje ankiety</a>
        </li>
        {{-- @if($user->user_level == "1") --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Panel administratora
            </a>
            <div class="dropdown-menu bg-dark">
                <a class="dropdown-item nav-link navbar-collapse" href="{{url('/admin/zarzadzajankiety')}}">Zarządzaj ankietami</a>
                <a class="dropdown-item nav-link navbar-collapse" href="{{url('/admin/users')}}">Zarządzaj użytkownikami</a>
            </div>
        </li>
        {{-- @if($user->user_level == "2") --}}
        <li class="nav-item">
            <a class="nav-link" href="{{url('/moderator/zarzadzajankiety')}}">Zarządzaj ankietami</a>
        </li>
    </ul>
    </div>
    {{-- @if($user->logged == true)
        <a class="navbar-brand loger d-flex" href="/" style="margin-left: auto;" title="Wyloguj się">Wyloguj się</a>
    @else --}}
        <a class="navbar-brand loger d-flex" href="{{url('/logowanie')}}" style="margin-left: auto;" title="Przejdź do logowania">Zaloguj się</a>
    {{-- @endif --}}
</nav>
<script>
    $(document).ready(function() {
	// dropdown animation
	$('.dropdown').on('show.bs.dropdown', function(e) {
		$(this).find('.dropdown-menu').first().stop(true, true).slideDown(400);
	});
	$('.dropdown').on('hide.bs.dropdown', function(e) {
		$(this).find('.dropdown-menu').first().stop(true, true).slideUp(200);
	});
});
</script>
