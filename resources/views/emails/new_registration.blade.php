@component('mail::message')
<h1>@lang('mail.dear') {{ $recipient }}!</h1>
<p>
    @lang('mail.new_registration', ['registered_user' => $user->name])
</p>
@php
    $personal=$user->personalInformation
@endphp
@component('mail::panel')
@lang('user.name'): {{$user->name}}<br>
@lang('user.place_and_date_of_birth'): {{$personal->getPlaceAndDateOfBirth()}}<br>
@lang('user.mothers_name'): {{$personal->mothers_name}}<br>
@lang('user.country'): {{$personal->country}}<br>
@lang('user.tenant_until'): {{$personal->tenant_until}}
@endcomponent
<div class="row">
@component('mail::button', ['url'=> route('secretariat.registrations.accept', ['id' => $user->id])])
@lang('user.accept')    
@endcomponent
</div>
<p>@lang('mail.administrators')</p>
@endcomponent
