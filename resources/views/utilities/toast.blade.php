@once
<style>
    .toast-header.success {
        color: var(--kt-primary);
    }

    .toast-header.error {
        color: var(--kt-danger);
    }

    .toast-header.success .fa-warning {
        display: none;
    }

    .toast-header.error .fa-check {
        display: none;
    }
</style>
@endonce
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
@once
<script type="text/javascript">
    function _showToast(messageType, message, messageHeader = '') {
        const container = $('#kt_docs_toast_stack_container');
        const targetElement = $('[data-kt-docs-toast="stack"]');
        targetElement.parent('#kt_docs_toast_stack_container').empty();
        const newToast = targetElement.clone();

        const _toast_header = newToast.find('.toast-header');
        const _toast_body = newToast.find('.toast-body');
        _toast_header.addClass(messageType);
        _toast_header.addClass(messageType === 'success' ? 'bg-success text-white' : 'bg-danger text-white');
        _toast_header.find('.me-auto').empty().html(messageHeader);
        _toast_body.empty().html(message);

        container.append(newToast);

        const toast = bootstrap.Toast.getOrCreateInstance(newToast);
        toast.show();
    }

    function showSuccess($message, messageHeader = '') {
        _showToast('success', $message, messageHeader)
    }

    function showError($message, messageHeader = '') {
        _showToast('error', $message, messageHeader)
    }

    $(document).ready(function () {
        @if (session()->has('_success_msg'))
        showSuccess('{{ session('_success_msg') }}', 'Success!');
        @endif
        @if (session()->has('status'))
        showSuccess('{{ session('status') }}', 'Success!');
        @endif
        @if (session()->has('resent'))
        showSuccess('{{ trans('bws/core::core.auth.resent_verify_email') }}', 'Success!');
        @endif
        @if (session()->has('_error_msg'))
        showError('{{ session('_error_msg') }}', 'Error!');
        @endif
        @if (isset($error_msg))
        showError('{{ $error_msg }}', 'Error!');
        @endif
        @if (isset($errors))
        @foreach ($errors->all() as $error)
        showError('{{ $error }}', 'Validate error!');
        @endforeach
        @endif
    });
</script>
@endonce
