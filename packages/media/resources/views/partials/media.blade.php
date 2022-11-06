<div class="modal fade media-modal"
     data-keyboard="false"
     tabindex="-1"
     role="dialog"
     id="rv_media_modal"
     aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bb-loading">
            <div class="modal-header py-3">
                <h4 class="modal-title">
                    <i class="fas fa-th fa-lg me-2 text-dark"></i>
                    <strong>{{ trans('bws/media::media.gallery') }}</strong>
                </h4>
                <button type="button" class="close border-0 bg-transparent" data-dismiss="modal" aria-label="{{ trans('bws/media::media.close') }}">
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                </button>
            </div>
            <div class="modal-body media-modal-body media-modal-loading" id="rv_media_body"></div>
            <div class="loading-wrapper">
                <div class="loader">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
                                stroke-miterlimit="10"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

@include('bws@media::config')
<link href="{{ asset('vendor/bws/media/css/media.css?v=' . time()) }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('vendor/bws/media/js/integrate.js?v=' . time()) }}"></script>
