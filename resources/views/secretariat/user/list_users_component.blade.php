<div>
    <div class="card">
        <div class="card-content">
            <span class="card-title">@lang('general.filter')</span>
            <input type="text" class="input-field" id="filter_name" placeholder="@lang('user.name')"
                   wire:model="filter_name"/>
            <input type="number" class="input-field" id="year_of_acceptance" placeholder="@lang('user.year_of_acceptance')"
                   wire:model="year_of_acceptance"/>
            <h6>@lang('role.roles')</h6>
            @foreach (\App\Models\Role::all() as $r)
                @if(in_array($r->id, $this->roles))
                    <span class="new badge {{ $r->color() }}" data-badge-caption=""
                          style="float:none;padding:2px 2px 2px 5px;margin:2px;cursor:pointer;"
                          wire:click="deleteRole({{$r->id}})">
                    <nobr><i>{{ $r->translatedName }}</i> &cross;</nobr>
                </span>
                @else
                    <span class="new badge {{ $r->color() }}" data-badge-caption=""
                          style="float:none;padding:2px 2px 2px 5px;margin:2px;cursor:pointer"
                          wire:click="addRole({{$r->id}})">
                    <nobr>{{ $r->translatedName }}</nobr>
                </span>
                @endif
            @endforeach
            <hr>
            <h6>@lang('user.workshops')</h6>
            @foreach (\App\Models\Workshop::all() as $w)
                @if(in_array($w->id, $this->workshops))
                    <span class="new badge {{ $w->color() }}" data-badge-caption=""
                          style="float:none;padding:2px 2px 2px 5px;margin:2px;cursor:pointer;"
                          wire:click="deleteWorkshop({{$w->id}})">
                    <nobr><i>{{ $w->name }}</i> &cross;</nobr>
                </span>
                @else
                    <span class="new badge {{ $w->color() }}" data-badge-caption=""
                          style="float:none;padding:2px 2px 2px 5px;margin:2px;cursor:pointer"
                          wire:click="addWorkshop({{$w->id}})">
                    <nobr>{{ $w->name }}</nobr>
                </span>
                @endif
            @endforeach
            <hr>
            <h6>@lang('admin.statuses') ({{\App\Models\Semester::current()->tag}})</h6>
            @foreach (\App\Models\SemesterStatus::STATUSES as $s)
                @if(in_array($s, $this->statuses))
                    <span class="new badge {{ \App\Models\SemesterStatus::color($s) }}" data-badge-caption=""
                          style="float:none;padding:2px 2px 2px 5px;margin:2px;cursor:pointer;"
                          wire:click="deleteStatus('{{$s}}')">
                    <nobr><i>@lang('user.'.$s)</i> &cross;</nobr>
                </span>
                @else
                    <span class="new badge {{ \App\Models\SemesterStatus::color($s) }}" data-badge-caption=""
                          style="float:none;padding:2px 2px 2px 5px;margin:2px;cursor:pointer"
                          wire:click="addStatus('{{$s}}')">
                    <nobr>@lang('user.'.$s)</nobr>
                </span>
                @endif
            @endforeach
        </div>
    </div>

    {{-- Export --}}
    <div class="fixed-action-btn">
        <a wire:click="exportUsers" class="btn-floating btn-large">
            <i class="large material-icons">file_download</i>
        </a>
    </div>

    <div class="card">
        <div class="card-content">

            {{-- List --}}
            <div class="row">
                <div class="col s12 xl7">
                    <span class="card-title">@lang('general.users')</span>
                </div>
            </div>

            @forelse($this->users as $user)
                @can('view', $user)
                    <div class="row">
                        <div class="col s12 xl3">
                            <a href="{{ route('users.show', ['user' => $user->id]) }}"><b>{{ $user->name }}</b></a><br>
                            {{ $user->email }}
                            @if($user->hasEducationalInformation())
                                <br>{{ $user->educationalInformation->neptun ?? '' }}
                            @endif
                        </div>
                        <!-- Workshops -->
                        <div class="col s12 xl4">
                            @if($user->hasEducationalInformation())
                                @include('user.workshop_tags', ['user' => $user, 'newline' => true])
                            @endif
                        </div>
                        <!-- Roles -->
                        <div class="col s12 xl4">
                            @include('user.role_tags', [
                                'roles' => $user->roles->whereNotIn('name', ['internet-user', 'printer']),
                                'newline' => true
                            ])
                        </div>
                        <!-- Status -->
                        <div class="col s12 xl1">
                            @if($user->hasEducationalInformation())
                                @can('view', $user)
                                    <span
                                        class="new badge tag {{ \App\Models\SemesterStatus::color($user->getStatus()) }}"
                                        data-badge-caption="">
                                            @lang("user." . $user->getStatus())
                                    </span>
                                @endcan
                            @endif
                        </div>
                    </div>
                @endcan
            @empty
            Nincs a megadott feltételeknek megfelelő felhasználó, vagy nincs jogosultsága megtekinteni.
            @endforelse
            <div class="row">
                <div class="col s12">
                    <div class="divider"></div>
                    <div class="right"><i><b>{{$this->users->count()}} felhasználó</i></b></div>
                </div>
            </div>
        </div>
    </div>
</div>
