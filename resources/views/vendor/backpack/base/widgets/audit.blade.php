@php
    // preserve backwards compatibility with Widgets in Backpack 4.0
    $widget['wrapper']['class'] = $widget['wrapper']['class'] ?? ($widget['wrapperClass'] ?? 'col-sm-6 col-md-4');
    
    $badge_class = function (bool $rounded = false): string {
        $class = '';
    
        $badges = ['bg-primary', 'bg-secondary', 'bg-success', 'bg-danger', 'bg-warning text-dark', 'bg-info text-white', 'bg-light text-dark', 'bg-dark'];
    
        if ($rounded) {
            $class .= 'rounded-pill ';
        }
    
        $class .= $badges[array_rand($badges)];
    
        return $class;
    };
    
    $audit_icons = function (string $event): string {
        $eventIcons = [
            'created' => '<i class="fas fa-plus bg-success" type="button" data-toggle="tooltip" data-placement="top" title="Created"></i>',
            'updated' => '<i class="fas fa-edit bg-primary" type="button" data-toggle="tooltip" data-placement="top" title="Updated"></i>',
            'deleted' => '<i class="fas fa-trash bg-danger" type="button" data-toggle="tooltip" data-placement="top" title="Deleted"></i>',
            'restored' => '<i class="fas fa-trash-restore bg-warning" type="button" data-toggle="tooltip" data-placement="top" title="Restored"></i>',
        ];
    
        return $eventIcons[$event] ?? '<i class="fas fa-user bg-secondary" data-toggle="tooltip" data-placement="top" title="Undefined"></i>';
    };
    
    $audit_changes = function ($new_values, $old_values) {
        return array_keys(array_merge($new_values, $old_values));
    };
    
@endphp

@includeWhen(!empty($widget['wrapper']), 'backpack::widgets.inc.wrapper_start')
<div class="{{ $widget['class'] ?? 'card' }}">
    <div class="card-header">
        @if (isset($widget['header']))
            {!! $widget['header'] !!}
        @elseif(isset($widget['model']))
            {{ class_basename($widget['model']) }} Audits
        @elseif(isset($widget['crud']))
            {{ class_basename($widget['crud']->getCurrentEntry()) }} Audits
        @else
            {{ 'Model Audits' }}
        @endif
    </div>
    <div class="card-body">
        @php
            $model = $widget['model'] ?? $widget['crud']->getCurrentEntry();
            $audits = [];
        @endphp
        @if ($model instanceof \OwenIt\Auditing\Contracts\Auditable)
            @php
                $model
                    ->audits()
                    ->with('user')
                    ->latest()
                    ->get()
                    ->each(function ($audit) use (&$audits) {
                        $audits[\Carbon\CarbonImmutable::parse($audit->created_at)->format('Y-m-d')][] = $audit;
                    });
            @endphp

            @if (!empty($audits))
                <div class="timeline timeline-inverse">
                    @foreach ($audits as $date => $actions)
                        <!-- timeline time label -->
                        <div class="time-label">
                            <span class="{{ $badge_class() }}">
                                {{ date('d M. Y', strtotime($date)) }}
                            </span>
                        </div>
                        <!-- /.timeline-label -->
                        @foreach ($actions as $action)
                            <!-- timeline item -->
                            <div>
                                {!! $audit_icons($action->event) !!}
                                <div class="timeline-item">
                                    <span class="time">
                                        <i class="far fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($action->created_at)->format('h:i a') }}
                                    </span>
                                    <h3 class="timeline-header">
                                        <a href="{{ route('user.showDetailsRow', $action->user->id ?? 1) }}">
                                            {{ $action->user->name ?? 'System' }}</a> {{ $action->event }} this
                                        {{ strtolower(class_basename($action->auditable_type)) }}
                                    </h3>

                                    <div class="timeline-body">
                                        <p>
                                            This operation is requested from <a
                                                href="https://google.com/search?q={{ $action->ip_address }}"
                                                target="_blank">{{ $action->ip_address }}</a>, browser <span
                                                class="text-info">{{ $action->user_agent }}</span>.
                                        </p>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <tbody>
                                                    <tr class="text-center font-weight-bold">
                                                        <th>Field</th>
                                                        <td>New</td>
                                                        <td>Old</td>
                                                    </tr>
                                                    @foreach ($audit_changes($action->new_values, $action->old_values) ?? [] as $change_field)
                                                        <tr>
                                                            <th>
                                                                {{ ucwords(str_replace(['_'], [' '], $change_field)) }}
                                                            </th>
                                                            <td>
                                                                {{ $action->new_values[$change_field] ?? '-' }}
                                                            </td>
                                                            <td>
                                                                {{ $action->new_values[$change_field] ?? '-' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END timeline item -->
                        @endforeach
                    @endforeach
                    <div>
                        <i class="far fa-clock bg-gray"></i>
                    </div>
                </div>
            @else
                <div class="alert alert-warning text-center mb-0">
                    No Event Recorded
                </div>
            @endif
        @else
            <div class="alert alert-warning text-center mb-0">
                Undefined Model index or Object is not instance of <code>\OwenIt\Auditing\Contracts\Auditable</code>
            </div>
        @endif
    </div>
</div>
@includeWhen(!empty($widget['wrapper']), 'backpack::widgets.inc.wrapper_end')
