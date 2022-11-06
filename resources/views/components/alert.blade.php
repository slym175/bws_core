@if(isset($message) && $message)
    <div
        class="alert {{ $dismissible ? 'alert-dismissible' : '' }} bg-light-{{ $type }} d-flex justify-content-start align-items-center flex-column flex-sm-row p-5 mb-10">
        <span class="svg-icon svg-icon-2hx svg-icon-{{ $type }} me-4 mb-5 mb-sm-0">

        </span>
        <div class="d-flex flex-column pe-0 pe-sm-10">
            <h4 class="fw-semibold m-0">{{ $message }}</h4>
        </div>
        @if($dismissible)
            <button type="button"
                    class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                    data-bs-dismiss="alert">
                <span class="svg-icon svg-icon-1 svg-icon-{{ $type }}">
                    <i class="bi bi-x"></i>
                </span>
            </button>
        @endif
    </div>
@endif
