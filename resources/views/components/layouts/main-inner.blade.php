<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $lng === 'ar' ? 'rtl' : 'ltr' }}">

	@include('layouts.head')


    <body class="{{ $lng === 'ar' ? 'arabic-version' : '' }}">

		@include('layouts.header')

			@yield('content')

		@include('layouts.footer')


	</body>
</html>
