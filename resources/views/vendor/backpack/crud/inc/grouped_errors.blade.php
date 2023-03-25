{{-- Show the errors, if any --}}
@if ($crud->groupedErrorsEnabled() && session()->get('errors'))
    <div class="alert alert-danger pb-0">
        <ul class="list-unstyled">
            @foreach(session()->get('errors')->getBags() as $bag => $errorMessages)
                @foreach($errorMessages->getMessages() as $errorMessageForInput)
                    @foreach($errorMessageForInput as $message)
                        <li><i class="la la-info-circle"></i> {{ $message }}</li>
                    @endforeach
                @endforeach
            @endforeach
        </ul>
    </div>
@endif