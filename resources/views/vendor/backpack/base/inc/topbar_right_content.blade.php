{{-- This file is used to store topbar (right) items --}}

<style>
    #notification-bell::after {
        border: 0;
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
        padding: 0.5rem;
    }
</style>

@if(setting('notifications') == 1)
    <li class="nav-item dropdown d-md-down-none">
        <a id="notification-bell" class="nav-link dropdown-toggle" title="Alerts" href="#" role="button"
           data-toggle="dropdown" aria-expanded="false">
            <i class="la la-bell la-2x" id="notification-bell-icon"></i>
            <span class="position-absolute bg-danger rounded-circle"
                  style="top:5px; left: 60%; transform: translate(-50%, -50%) !important;"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right border-0 py-0 mt-4 bg-secondary" style="width: 360px;">
            <div class="card mb-0">
                <div class="card-header d-flex align-items-center bg-light">
                    <span class="font-weight-bold" id="notification-count"></span>
                    <a class="ml-auto" href="{{ route('notifications.clear-all') }}">Clear all</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush" id="notification-dropdown">
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <a class="btn btn-block btn-outline-primary" href="{{ route('notification.index') }}">
                        View all notifications
                    </a>
                </div>
            </div>
        </div>
        <script type="text/javascript">

            function renderNotification(id, created_at, data) {

                let notification_dt = Date.parse(created_at);
                notification_dt = new Date(notification_dt);

                let notification_url = '{{ route('notification.show', '##') }}';
                notification_url = notification_url.toString().replace('##', id);

                return `<a class="list-group-item list-group-item-action" href="${notification_url}">
                        <div class="media align-items-center">
                            <img class="u-avatar--sm rounded-circle mr-3"
                                 src="./assets/img/avatars/img1.jpg"
                                 alt="Image">
                            <div class="media-body">
                                <div class="d-flex align-items-center">
                                    <p class="mb-1 font-weight-bold">${data.name}</p>
                                    <small class="text-muted ml-auto">${notification_dt.toDateString()}</small>
                                </div>
                                <p class="text-truncate mb-0" style="max-width: 250px;">
                                    ${data.message}
                                </p>
                            </div>
                        </div>
                    </a>`;
            }

            function notificationApiCall() {
                $.ajax({
                    method: 'GET',
                    url: '{{ route('notifications.index') }}?guard=web', success: function (notifications) {
                        if (notifications.length > 0) {
                            $("#notification-count").text(`Notifications(${notifications.length})`);
                            $("#notification-bell-icon").css({
                                "animation": "tilt-shaking 0.25s linear infinite",
                                "margin-top": "3px"
                            });

                            notifications.forEach(function (notification) {
                                $("#notification-dropdown").append(
                                    renderNotification(notification.id, notification.created_at, notification.data)
                                );
                            });
                        } else {
                            $("#notification-count").text(`Notifications`);
                            $("#notification-bell-icon").css({"margin-top": "3px"});
                            $("#notification-dropdown")
                                .html(`<a class="list-group-item list-group-item-action" href="#" style="min-height: 200px; padding: 100px 0;">
                                    <p class="text-center" style="margin: auto;">No notifications available</p>
                                   </a>`);
                        }
                    }
                });
            }

            document.addEventListener('DOMContentLoaded', function () {
                setTimeout(() => {
                    if (window.jQuery) {
                        @if(setting('refresh_interval') <= 0)
                        notificationApiCall();
                        @else
                        setInterval(function () {
                            notificationApiCall();
                        }, {{ setting('refresh_interval')}});
                        @endif
                    }
                }, 500);
            });
        </script>
    </li>
@endif

