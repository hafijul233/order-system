{{-- This file is used to store topbar (right) items --}}

<style>
    #notification-bell::after {
        border: 0;
    }

    .translate-middle {
        transform: translate(-50%, -50%) !important;
    }

    @keyframes tilt-shaking {
        0% {
            transform: rotate(0deg);
        }
        25% {
            transform: rotate(15deg);
        }
        50% {
            transform: rotate(0deg);
        }
        75% {
            transform: rotate(-15deg);
        }
        100% {
            transform: rotate(0deg);
        }
    }

    .u-avatar--sm {
        width: 2.75rem;
        height: 2.75rem;
    }

    #notification-dropdown .list-group-item {
        padding: 0.5rem 1rem;
    }
</style>
<li class="nav-item dropdown d-md-down-none">
    <a id="notification-bell" class="nav-link dropdown-toggle" title="Alerts" href="#" role="button"
       data-toggle="dropdown" aria-expanded="false">
        <i class="la la-bell la-2x" style="animation: tilt-shaking 0.25s linear infinite; margin-top: 3px;"></i>
        <span class="position-absolute translate-middle p-1 bg-danger rounded-circle" style="top:5px; left: 60%"></span>
    </a>
    <div class="dropdown-menu dropdown-menu-right border-0 py-0 mt-4" aria-labelledby="dropdownMenuLink"
         style="width: 360px;">
        <div class="card">
            <div class="card-header d-flex align-items-center bg-light">
                <span class="font-weight-bold">Notifications(5)</span>
                <a class="ml-auto" href="#">Clear all</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush" id="notification-dropdown">
                    <!-- Activity -->
                    <a class="list-group-item list-group-item-action" href="#">
                        <div class="media align-items-center">
                            <img class="u-avatar--sm rounded-circle mr-3" src="./assets/img/avatars/img1.jpg"
                                 alt="Image description">
                            <div class="media-body">
                                <div class="d-flex align-items-center">
                                    <p class="mb-1">Chad Cannon</p>
                                    <small class="text-muted ml-auto">23 Jan 2018</small>
                                </div>
                                <p class="text-truncate mb-0" style="max-width: 250px;">
                                    We've just done the project.
                                </p>
                            </div>
                        </div>
                    </a>
                    <!-- End Activity -->
                    <!-- Activity -->
                    <a class="list-group-item list-group-item-action" href="#">
                        <div class="media align-items-center">
                            <img class="u-avatar--sm rounded-circle mr-3" src="./assets/img/avatars/img2.jpg"
                                 alt="Image description">
                            <div class="media-body">
                                <div class="d-flex align-items-center">
                                    <p class="mb-1">Jane Ortega</p>
                                    <small class="text-muted ml-auto">18 Jan 2018</small>
                                </div>
                                <p class="text-truncate mb-0" style="max-width: 250px;">
                                    <span class="text-primary">@Bruce</span> advertising your project is not good idea.
                                </p>
                            </div>
                        </div>
                    </a>
                    <!-- End Activity -->
                    <!-- Activity -->
                    <a class="list-group-item list-group-item-action" href="#">
                        <div class="media align-items-center">
                            <img class="u-avatar--sm rounded-circle mr-3" src="./assets/img/avatars/user-unknown.jpg"
                                 alt="Image description">
                            <div class="media-body">
                                <div class="d-flex align-items-center">
                                    <p class="mb-1">Stella Hoffman</p>
                                    <small class="text-muted ml-auto">15 Jan 2018</small>
                                </div>
                                <p class="text-truncate mb-0" style="max-width: 250px;">
                                    When the release date is expexted for the advacned settings?
                                </p>
                            </div>
                        </div>
                    </a>
                    <!-- End Activity -->
                    <!-- Activity -->
                    <a class="list-group-item list-group-item-action" href="#">
                        <div class="media align-items-center">
                            <img class="u-avatar--sm rounded-circle mr-3" src="./assets/img/avatars/img4.jpg"
                                 alt="Image description">
                            <div class="media-body">
                                <div class="d-flex align-items-center">
                                    <p class="mb-1">Htmlstream</p>
                                    <small class="text-muted ml-auto">05 Jan 2018</small>
                                </div>
                                <p class="text-truncate mb-0" style="max-width: 250px;">
                                    Adwords Keyword research for beginners
                                </p>
                            </div>
                        </div>
                    </a>
                    <!-- End Activity -->
                </div>
            </div>
            <div class="card-footer bg-light">
                <a class="btn btn-block btn-outline-primary" href="{{ route('notification.index') }}">View all notifications</a>
            </div>
        </div>
    </div>
</li>
