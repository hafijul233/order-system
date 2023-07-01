@extends(backpack_view('blank'))

@section('after_styles')
    <style media="screen">
        .backpack-profile-form .required::after {
            content: ' *';
            color: red;
        }
    </style>
@endsection

@php
    $breadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        trans('backpack::base.my_account') => false,
    ];
@endphp

@section('header')
    <section class="content-header">
        <div class="container-fluid mb-3">
            <h1>{{ trans('backpack::base.my_account') }}</h1>
        </div>
    </section>
@endsection

@section('content')
    <div class="row">

        @if (session('success'))
            <div class="col-lg-8">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if ($errors->count())
            <div class="col-lg-8">
                <div class="alert alert-danger">
                    <ul class="mb-1">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <div class="col-12 bold-labels">
            <div class="tab-container  mb-2">
                <div class="nav-tabs-custom" id="form_tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="nav-item">
                            <a href="#tab_profile" aria-controls="tab_profile" role="tab" tab_name="profile"
                               data-toggle="tab" class="nav-link active">Profile</a>
                        </li>

                        <li role="presentation" class="nav-item">
                            <a href="#tab_authentication" aria-controls="tab_authentication" role="tab"
                               tab_name="authentication" data-toggle="tab" class="nav-link ">Authentication</a>
                        </li>

{{--                        <li role="presentation" class="nav-item">
                            <a href="#tab_promotion" aria-controls="tab_promotion" role="tab" tab_name="promotion"
                               data-toggle="tab" class="nav-link ">Timeline</a>
                        </li>--}}
                    </ul>

                    <div class="tab-content p-0 ">

                        <div role="tabpanel" class="tab-pane active" id="tab_profile">
                            <form class="form" action="{{ route('backpack.account.info.store') }}" method="post">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    @php
                                        $label = trans('backpack::base.name');
                                        $field = 'name';
                                    @endphp
                                    <label class="required">{{ $label }}</label>
                                    <input required class="form-control" type="text" name="{{ $field }}"
                                           value="{{ old($field) ? old($field) : $user->$field }}">
                                </div>

                                <div class="form-group">
                                    @php
                                        $label = config('backpack.base.authentication_column_name');
                                        $field = backpack_authentication_column();
                                    @endphp
                                    <label class="required">{{ $label }}</label>
                                    <input required class="form-control"
                                           type="{{ backpack_authentication_column()==backpack_email_column()?'email':'text' }}"
                                           name="{{ $field }}"
                                           value="{{ old($field) ? old($field) : $user->$field }}">
                                </div>
                                <hr>
                                <button type="submit" class="btn btn-success"><i
                                        class="la la-save"></i> {{ trans('backpack::base.save') }}</button>
                                <a href="{{ backpack_url() }}"
                                   class="btn">{{ trans('backpack::base.cancel') }}</a>
                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="tab_authentication">
                            <form class="form" action="{{ route('backpack.account.password') }}" method="post">

                                {!! csrf_field() !!}

                                <div class="form-group">
                                    @php
                                        $label = trans('backpack::base.old_password');
                                        $field = 'old_password';
                                    @endphp
                                    <label class="required">{{ $label }}</label>
                                    <input autocomplete="new-password" required class="form-control"
                                           type="password" name="{{ $field }}" id="{{ $field }}" value="">
                                </div>

                                <div class="form-group">
                                    @php
                                        $label = trans('backpack::base.new_password');
                                        $field = 'new_password';
                                    @endphp
                                    <label class="required">{{ $label }}</label>
                                    <input autocomplete="new-password" required class="form-control"
                                           type="password" name="{{ $field }}" id="{{ $field }}" value="">
                                </div>

                                <div class="form-group">
                                    @php
                                        $label = trans('backpack::base.confirm_password');
                                        $field = 'confirm_password';
                                    @endphp
                                    <label class="required">{{ $label }}</label>
                                    <input autocomplete="new-password" required class="form-control"
                                           type="password" name="{{ $field }}" id="{{ $field }}" value="">
                                </div>
                                <hr>
                                <button type="submit" class="btn btn-success"><i
                                        class="la la-save"></i> {{ trans('backpack::base.change_password') }}
                                </button>
                                <a href="{{ backpack_url() }}"
                                   class="btn">{{ trans('backpack::base.cancel') }}</a>
                            </form>
                        </div>

{{--                        <div role="tabpanel" class="tab-pane" id="tab_promotion">
                            <div class="timeline">

                                <div class="time-label">
                                    <span class="bg-red">10 Feb. 2014</span>
                                </div>


                                <div>
                                    <i class="fas fa-envelope bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> 12:05</span>
                                        <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
                                        <div class="timeline-body">
                                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                            quora plaxo ideeli hulu weebly balihoo...
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-sm">Read more</a>
                                            <a class="btn btn-danger btn-sm">Delete</a>
                                        </div>
                                    </div>
                                </div>


                                <div>
                                    <i class="fas fa-user bg-green"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> 5 mins ago</span>
                                        <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request</h3>
                                    </div>
                                </div>


                                <div>
                                    <i class="fas fa-comments bg-yellow"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> 27 mins ago</span>
                                        <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
                                        <div class="timeline-body">
                                            Take me to your leader!
                                            Switzerland is small and neutral!
                                            We are more like Germany, ambitious and misunderstood!
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-warning btn-sm">View comment</a>
                                        </div>
                                    </div>
                                </div>


                                <div class="time-label">
                                    <span class="bg-green">3 Jan. 2014</span>
                                </div>


                                <div>
                                    <i class="fa fa-camera bg-purple"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> 2 days ago</span>
                                        <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
                                        <div class="timeline-body">
                                            <img src="https://placehold.it/150x100" alt="...">
                                            <img src="https://placehold.it/150x100" alt="...">
                                            <img src="https://placehold.it/150x100" alt="...">
                                            <img src="https://placehold.it/150x100" alt="...">
                                            <img src="https://placehold.it/150x100" alt="...">
                                        </div>
                                    </div>
                                </div>


                                <div>
                                    <i class="fas fa-video bg-maroon"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> 5 days ago</span>
                                        <h3 class="timeline-header"><a href="#">Mr. Doe</a> shared a video</h3>
                                        <div class="timeline-body">
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tMWkeBIohBs" allowfullscreen=""></iframe>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a href="#" class="btn btn-sm bg-maroon">See comments</a>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-clock bg-gray"></i>
                                </div>
                            </div>
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
