@extends('layouts.app')

@section('title')
<a href="#!" class="breadcrumb">@lang('role.student-council')</a>
<a href="#!" class="breadcrumb">@lang('community-service.community-service')</a>
@endsection

@section('student_council_module') active @endsection

@section('content')

@can('create', \App\Models\CommunityService::class)
<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('community-service.add-new-service')</span>
        <blockquote>@lang('community-service.add-new-service-descr')</blockquote>
        <form method="POST" action="{{ route('community_service.create') }}">
            @csrf
            <div class="row">
                <x-input.text m=6 l=6 id="description" required :text="__('community-service.description')" />
                <x-input.select m=6 l=6 id="approver" :elements="$possible_approvers" :text="__('community-service.approver')"/>
            </div>
            <x-input.button floating class="btn=large right" icon="send" />
        </form>
    </div>
</div>
@endcan


@can('approveAny', \App\Models\CommunityService::class)
<div class="card">
    <div class="card-content">
        <span class="card-title">@lang('community-service.search-user')</span>
        <blockquote>@lang('community-service.search-user-descr')</blockquote>
        <div class="row center">
        <x-input.button text="general.search" :href="route('community_service.search')"></x-input.button>
        </div>
    </div>
</div>
@endcan


@include('student-council.community-service.table', ['showApprove' => true])

@endsection