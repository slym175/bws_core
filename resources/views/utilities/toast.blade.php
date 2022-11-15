@push('js')
@if (session()->has('_success_msg')
    || session()->has('_error_msg')
    || (isset($errors) && $errors->count() > 0)
    || isset($error_msg)
    || session()->has('status')
    || session()->has('resent'))
    <div id="kt_docs_toast_stack_container" class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast overflow-hidden" role="alert" aria-live="assertive" aria-atomic="true"
             data-kt-docs-toast="stack">
            <div class="toast-header">
                <span class="svg-icon svg-icon-2 svg-icon-primary me-3">
                    <i class="fas fa-check text-white"></i>
                    <i class="fas fa-warning text-white"></i>
                </span>
                <strong class="me-auto"></strong>
                <button type="button" class="btn-close text-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body bg-white"></div>
        </div>
    </div>
@endif
@endpush
@once
<script type="text/javascript">
    function _toastrOptions() {
        return {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toastr-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    }

    function showSuccess($message) {
        toastr.options = _toastrOptions();
        toastr.success($message);
    }

    function showError($message) {
        toastr.options = _toastrOptions();
        toastr.error($message);
    }

    $(document).ready(function () {
        @if (session()->has('_success_msg'))
            showSuccess('{{ session('_success_msg') }}');
        @endif
        @if (session()->has('status'))
            showSuccess('{{ session('status') }}');
        @endif
        @if (session()->has('resent'))
            showSuccess('{{ trans('bws/core::core.auth.resent_verify_email') }}');
        @endif
        @if (session()->has('_error_msg'))
            showError('{{ session('_error_msg') }}');
        @endif
        @if (isset($error_msg))
            showError('{{ $error_msg }}');
        @endif
        @if (isset($errors))
        @foreach ($errors->all() as $error)
            showError('{{ $error }}');
        @endforeach
        @endif
    });
</script>
@endonce
