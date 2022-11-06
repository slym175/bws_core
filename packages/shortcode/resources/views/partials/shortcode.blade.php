<div class="modal fade" tabindex="-1" id="kt_shortcode_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-none">
            <div class="modal-header py-3">
                <h5 class="modal-title">Shortcode <span class="shortcode"></span></h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x">
                        <i class="bi bi-x"></i>
                    </span>
                </div>
            </div>
            <div class="modal-body p-0">
                <div id="kt_shortcode_modal_form"></div>
            </div>
        </div>
    </div>
</div>
<script>
    let _shortcode_getform_url = '{{ router_url('ajax.shortcode.get-form') }}'
</script>
<script src="{{ asset('/vendor/bws/shortcode/js/shortcode.js') }}"></script>
