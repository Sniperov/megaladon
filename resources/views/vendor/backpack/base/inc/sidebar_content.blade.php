{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-question"></i> Пользователи</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('ad-category') }}"><i class="nav-icon la la-question"></i> Категории объявлений</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('city') }}"><i class="nav-icon la la-question"></i> Города</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('company-type') }}"><i class="nav-icon la la-question"></i> Виды компаний</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('service-type') }}"><i class="nav-icon la la-question"></i> Виды услуг</a></li>