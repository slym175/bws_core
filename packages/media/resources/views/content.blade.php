<div class="rv-media-container">
    <div class="rv-media-wrapper">
        <input type="checkbox" id="media_aside_collapse" class="fake-click-event hidden">
        <input type="checkbox" id="media_details_collapse" class="fake-click-event hidden">
        <aside class="rv-media-aside vertical rv-media-aside-hide-desktop">
            <label for="media_aside_collapse" class="collapse-sidebar">
                <i class="fa fa-sign-out"></i>
            </label>
            <div class="rv-media-block rv-media-filters">
                <div class="rv-media-block-title">
                    {{ trans('bws/media::media.filter') }}
                </div>
                <div class="rv-media-block-content">
                    <ul class="rv-media-aside-list">
                        <li>
                            <a href="#" class="js-rv-media-change-filter" data-type="filter" data-value="everything">
                                <i class="fa fa-recycle"></i> {{ trans('bws/media::media.everything') }}
                            </a>
                        </li>
                        @if (array_key_exists('image', bws_media()->getConfig('mime_types', [])))
                            <li>
                                <a href="#" class="js-rv-media-change-filter" data-type="filter" data-value="image">
                                    <i class="fa fa-file-image"></i> {{ trans('bws/media::media.image') }}
                                </a>
                            </li>
                        @endif
                        @if (array_key_exists('video', bws_media()->getConfig('mime_types', [])))
                            <li>
                                <a href="#" class="js-rv-media-change-filter" data-type="filter" data-value="video">
                                    <i class="fa fa-file-video"></i> {{ trans('bws/media::media.video') }}
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="#" class="js-rv-media-change-filter" data-type="filter" data-value="document">
                                <i class="fa fa-file"></i> {{ trans('bws/media::media.document') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="rv-media-block rv-media-view-in">
                <div class="rv-media-block-title">
                    {{ trans('bws/media::media.view_in') }}
                </div>
                <div class="rv-media-block-content">
                    <ul class="rv-media-aside-list">
                        <li>
                            <a href="#" class="js-rv-media-change-filter" data-type="view_in" data-value="all_media">
                                <i class="fa fa-globe"></i> {{ trans('bws/media::media.all_media') }}
                            </a>
                        </li>
                        <li>
                            <a href="#" class="js-rv-media-change-filter" data-type="view_in" data-value="trash">
                                <i class="fa fa-trash"></i> {{ trans('bws/media::media.trash') }}
                            </a>
                        </li>
                        <li>
                            <a href="#" class="js-rv-media-change-filter" data-type="view_in" data-value="recent">
                                <i class="fa fa-clock"></i> {{ trans('bws/media::media.recent') }}
                            </a>
                        </li>
                        <li>
                            <a href="#" class="js-rv-media-change-filter" data-type="view_in" data-value="favorites">
                                <i class="fa fa-star"></i> {{ trans('bws/media::media.favorites') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        <div class="rv-media-main-wrapper">
            <header class="rv-media-header">
                <div class="rv-media-top-header">
                    <div class="rv-media-actions">
                        <label for="media_aside_collapse" class="btn btn-danger collapse-sidebar">
                            <i class="fa fa-bars"></i>
                        </label>
                        <button class="btn btn-success js-dropzone-upload">
                            <i class="fas fa-cloud-upload-alt"></i> {{ trans('bws/media::media.upload') }}
                        </button>
                        <button class="btn btn-success js-download-action" data-toggle="modal"
                                data-target="#modal_download_url">
                            <i class="fas fa-cloud-download-alt"></i> {{ trans('bws/media::media.download_link') }}
                        </button>
                        <button class="btn btn-success" data-toggle="modal" data-target="#modal_add_folder">
                            <i class="fa fa-folder"></i> {{ trans('bws/media::media.create_folder') }}
                        </button>
                        <button class="btn btn-success js-change-action" data-type="refresh">
                            <i class="fas fa-sync"></i> {{ trans('bws/media::media.refresh') }}
                        </button>
                        @if (bws_media()->getConfig('sidebar_display') != 'vertical')
                            <div class="btn-group" role="group">
                                <div class="dropdown">
                                    <button
                                        class="btn btn-success dropdown-toggle js-rv-media-change-filter-group js-filter-by-type"
                                        type="button" data-toggle="dropdown">
                                        <i class="fa fa-filter"></i> {{ trans('bws/media::media.filter') }} <span
                                            class="js-rv-media-filter-current"></span>
                                    </button>
                                    <ul class="dropdown-menu p-0 w-100">
                                        <li>
                                            <a href="#" class="js-rv-media-change-filter" data-type="filter"
                                               data-value="everything">
                                                <i class="fa fa-recycle"></i> {{ trans('bws/media::media.everything') }}
                                            </a>
                                        </li>
                                        @if (array_key_exists('image', bws_media()->getConfig('mime_types', [])))
                                            <li>
                                                <a href="#" class="js-rv-media-change-filter" data-type="filter"
                                                   data-value="image">
                                                    <i class="fa fa-file-image"></i> {{ trans('bws/media::media.image') }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (array_key_exists('video', bws_media()->getConfig('mime_types', [])))
                                            <li>
                                                <a href="#" class="js-rv-media-change-filter" data-type="filter"
                                                   data-value="video">
                                                    <i class="fa fa-file-video"></i> {{ trans('bws/media::media.video') }}
                                                </a>
                                            </li>
                                        @endif
                                        <li>
                                            <a href="#" class="js-rv-media-change-filter" data-type="filter"
                                               data-value="document">
                                                <i class="fa fa-file"></i> {{ trans('bws/media::media.document') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="btn-group" role="group">
                                <div class="dropdown">
                                    <button
                                        class="btn btn-success dropdown-toggle js-rv-media-change-filter-group js-filter-by-view-in"
                                        type="button" data-toggle="dropdown">
                                        <i class="fa fa-eye"></i> {{ trans('bws/media::media.view_in') }} <span
                                            class="js-rv-media-filter-current"></span>
                                    </button>
                                    <ul class="dropdown-menu w-100">
                                        <li>
                                            <a href="#" class="js-rv-media-change-filter" data-type="view_in"
                                               data-value="all_media">
                                                <i class="fa fa-globe"></i> {{ trans('bws/media::media.all_media') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="js-rv-media-change-filter" data-type="view_in"
                                               data-value="trash">
                                                <i class="fa fa-trash"></i> {{ trans('bws/media::media.trash') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="js-rv-media-change-filter" data-type="view_in"
                                               data-value="recent">
                                                <i class="fa fa-clock"></i> {{ trans('bws/media::media.recent') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="js-rv-media-change-filter" data-type="view_in"
                                               data-value="favorites">
                                                <i class="fa fa-star"></i> {{ trans('bws/media::media.favorites') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <button class="btn btn-danger js-files-action hidden" data-action="empty_trash">
                            <i class="fa fa-trash"></i> {{ trans('bws/media::media.empty_trash') }}
                        </button>

                    </div>
                    <div class="rv-media-search">
                        <form class="input-search-wrapper" action="" method="GET">
                            <input type="text" class="form-control"
                                   placeholder="{{ trans('bws/media::media.search_file_and_folder') }}">
                            <button class="btn btn-link text-decoration-none" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="rv-media-bottom-header">
                    <div class="rv-media-breadcrumb">
                        <ul class="breadcrumb"></ul>
                    </div>
                    <div class="rv-media-tools">
                        <div class="btn-group" role="group">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle"
                                        type="button"
                                        data-toggle="dropdown">
                                    {{ trans('bws/media::media.sort') }} <i class="fa fa-sort-alpha-down"></i>
                                </button>
                                <ul class="dropdown-menu p-0 w-100 min-w-200px dropdown-menu-right">
                                    <li>
                                        <a href="#"
                                           class="js-rv-media-change-filter"
                                           data-type="sort_by"
                                           data-value="name-asc">
                                            <i class="fas fa-sort-alpha-up"></i> {{ trans('bws/media::media.file_name_asc') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="js-rv-media-change-filter"
                                           data-type="sort_by"
                                           data-value="name-desc">
                                            <i class="fas fa-sort-alpha-down"></i> {{ trans('bws/media::media.file_name_desc') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="js-rv-media-change-filter"
                                           data-type="sort_by"
                                           data-value="created_at-asc">
                                            <i class="fas fa-sort-numeric-up"></i> {{ trans('bws/media::media.uploaded_date_asc') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="js-rv-media-change-filter"
                                           data-type="sort_by"
                                           data-value="created_at-desc">
                                            <i class="fas fa-sort-numeric-down"></i> {{ trans('bws/media::media.uploaded_date_desc') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="js-rv-media-change-filter"
                                           data-type="sort_by"
                                           data-value="size-asc">
                                            <i class="fas fa-sort-numeric-up"></i> {{ trans('bws/media::media.size_asc') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="js-rv-media-change-filter"
                                           data-type="sort_by"
                                           data-value="size-desc">
                                            <i class="fas fa-sort-numeric-down"></i> {{ trans('bws/media::media.size_desc') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown rv-dropdown-actions disabled">
                                <button class="btn btn-secondary dropdown-toggle"
                                        type="button" data-toggle="dropdown">
                                    {{ trans('bws/media::media.actions') }} &nbsp;<i class="fa fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu p-0 w-100 min-w-200px"></ul>
                            </div>
                        </div>
                        <div class="btn-group js-rv-media-change-view-type" role="group">
                            <button class="btn btn-secondary" type="button" data-type="tiles">
                                <i class="fa fa-th-large"></i>
                            </button>
                            <button class="btn btn-secondary" type="button" data-type="list">
                                <i class="fa fa-th-list"></i>
                            </button>
                        </div>
                        <label for="media_details_collapse" class="btn btn-link text-decoration-none ms-3 collapse-panel">
                            <i class="fa fa-sign-out"></i>
                        </label>
                    </div>
                </div>
            </header>

            <main class="rv-media-main">
                <div class="rv-media-items"></div>
                <div class="rv-media-details hidden">
                    <div class="rv-media-thumbnail">
                        <i class="far fa-image"></i>
                    </div>
                    <div class="rv-media-description">
                        <div class="rv-media-name">
                            <p>{{ trans('bws/media::media.nothing_is_selected') }}</p>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="rv-media-footer hidden">
                <button type="button"
                        class="btn btn-danger btn-lg js-insert-to-editor">{{ trans('bws/media::media.insert') }}</button>
            </footer>
        </div>
        <div class="rv-upload-progress hide-the-pane">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('bws/media::media.upload_progress') }}</h3>
                    <a href="javascript:void(0);" class="close-pane">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="panel-body">
                    <ul class="rv-upload-progress-table"></ul>
                </div>
            </div>
        </div>
    </div>

    <div class="rv-modals">
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_coming_soon">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <i class="fab fa-windows"></i>
                            <span>{{ trans('bws/media::media.coming_soon') }}</span>
                        </h4>
                        <button type="button" class="close" data-dismiss-modal="#modal_coming_soon"
                                aria-label="{{ trans('bws/media::media.close') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>These features are on development</p>
                        <div class="modal-notice"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_add_folder">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <i class="fa fa-folder"></i> {{ trans('bws/media::media.create_folder') }}
                        </h4>
                        <button type="button" class="close" data-dismiss-modal="#modal_add_folder"
                                aria-label="{{ trans('bws/media::media.close') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="rv-form form-add-folder">
                            <div class="input-group">
                                <input type="text" class="form-control"
                                       placeholder="{{ trans('bws/media::media.folder_name') }}">
                                <div class="input-group-prepend">
                                    <button class="btn btn-success rv-btn-add-folder w-100px d-flex justify-content-center align-items-center"
                                            type="submit">{{ trans('bws/media::media.create') }}</button>
                                </div>
                            </div>
                        </form>
                        <div class="modal-notice"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_rename_items">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="rv-form form-rename">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <i class="fab fa-windows"></i> {{ trans('bws/media::media.rename') }}
                            </h4>
                            <button type="button" class="close" data-dismiss-modal="#modal_rename_items"
                                    aria-label="{{ trans('bws/media::media.close') }}">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="rename-items"></div>
                            <div class="modal-notice"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss-modal="#modal_rename_items">{{ trans('bws/media::media.close') }}</button>
                            <button type="submit"
                                    class="btn btn-primary">{{ trans('bws/media::media.save_changes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_trash_items">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <form class="rv-form form-delete-items">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <i class="fab fa-windows"></i> {{ trans('bws/media::media.move_to_trash') }}
                            </h4>
                            <button type="button" class="close" data-dismiss-modal="#modal_trash_items"
                                    aria-label="{{ trans('bws/media::media.close') }}">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>{{ trans('bws/media::media.confirm_trash') }}</p>
                            <div class="modal-notice"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit"
                                    class="btn btn-danger">{{ trans('bws/media::media.confirm') }}</button>
                            <button type="button" class="btn btn-primary"
                                    data-dismiss-modal="#modal_trash_items">{{ trans('bws/media::media.close') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_delete_items">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <form class="rv-form form-delete-items">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <i class="fab fa-windows"></i> {{ trans('bws/media::media.confirm_delete') }}
                            </h4>
                            <button type="button" class="close" data-dismiss-modal="#modal_delete_items"
                                    aria-label="{{ trans('bws/media::media.close') }}">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>{{ trans('bws/media::media.confirm_delete_description') }}</p>
                            <div class="modal-notice"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit"
                                    class="btn btn-danger">{{ trans('bws/media::media.confirm') }}</button>
                            <button type="button" class="btn btn-primary"
                                    data-dismiss-modal="#modal_delete_items">{{ trans('bws/media::media.close') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_empty_trash">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <form class="rv-form form-empty-trash">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <i class="fab fa-windows"></i> {{ trans('bws/media::media.empty_trash_title') }}
                            </h4>
                            <button type="button" class="close" data-dismiss-modal="#modal_empty_trash"
                                    aria-label="{{ trans('bws/media::media.close') }}">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>{{ trans('bws/media::media.empty_trash_description') }}</p>
                            <div class="modal-notice"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit"
                                    class="btn btn-danger">{{ trans('bws/media::media.confirm') }}</button>
                            <button type="button" class="btn btn-primary"
                                    data-dismiss-modal="#modal_empty_trash">{{ trans('bws/media::media.close') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_download_url">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" data-downloading="{{trans('bws/media::media.downloading')}}"
                            data-text="{{ trans('bws/media::media.download_link') }}">
                            <i class="fas fa-cloud-download-alt"></i> {{ trans('bws/media::media.download_link') }}
                        </h4>
                        <button type="button" class="close" data-dismiss-modal="#modal_download_url"
                                aria-label="{{ trans('bws/media::media.close') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="rv-form form-download-url">
                            <div id="download-form-wrapper">
                                <div class="form-group">
                                <textarea rows="4"
                                          name="urls"
                                          class="form-control"
                                          placeholder="http://example.com/image1.jpg&#10;http://example.com/image2.jpg&#10;http://example.com/image3.jpg&#10;..."></textarea>
                                </div>
                                <small>{{ trans('bws/media::media.download_explain') }}</small>
                            </div>
                            <button class="btn btn-success w-100"
                                    type="submit">{{ trans('bws/media::media.download_link') }}</button>
                        </form>
                        <div class="modal-notice mt-2" id="modal-notice" style="max-height: 350px;overflow: auto"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button class="hidden js-rv-clipboard-temp"></button>
</div>
<script type="text/x-custom-template" id="rv_media_loading">
    <div class="loading-wrapper">
        <div class="showbox">
            <div class="loader">
                <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
                            stroke-miterlimit="10"/>
                </svg>
            </div>
        </div>
    </div>
</script>

<script type="text/x-custom-template" id="rv_action_item">
    <li>
        <a href="javascript:;" class="js-files-action" data-action="__action__">
            <i class="__icon__"></i> __name__
        </a>
    </li>
</script>

<script type="text/x-custom-template" id="rv_media_items_list">
    <div class="rv-media-list">
        <ul>
            <li class="no-items">
                <i class="fas fa-cloud-upload-alt"></i>
                <h3>Drop files and folders here</h3>
                <p>Or use the upload button above.</p>
            </li>
            <li class="rv-media-list-title up-one-level js-up-one-level"
                title="{{ trans('bws/media::media.up_level') }}">
                <div class="custom-checkbox"></div>
                <div class="rv-media-file-name">
                    <i class="fas fa-level-up"></i>
                    <span>...</span>
                </div>
                <div class="rv-media-file-size"></div>
                <div class="rv-media-created-at"></div>
            </li>
        </ul>
    </div>
</script>

<script type="text/x-custom-template" id="rv_media_items_tiles" class="hidden">
    <div class="rv-media-grid">
        <ul>
            <li class="no-items">
                <i class="__noItemIcon__"></i>
                <h3>__noItemTitle__</h3>
                <p>__noItemMessage__</p>
            </li>
            <li class="rv-media-list-title up-one-level js-up-one-level">
                <div class="rv-media-item" data-context="__type__" title="{{ trans('bws/media::media.up_level') }}">
                    <div class="rv-media-thumbnail">
                        <i class="fas fa-level-up-alt"></i>
                    </div>
                    <div class="rv-media-description">
                        <div class="title">...</div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</script>

<script type="text/x-custom-template" id="rv_media_items_list_element">
    <li class="rv-media-list-title js-media-list-title js-context-menu" data-context="__type__" title="__name__"
        data-id="__id__">
        <div class="custom-checkbox">
            <label>
                <input type="checkbox">
                <span></span>
            </label>
        </div>
        <div class="rv-media-file-name">
            __thumb__
            <span>__name__</span>
        </div>
        <div class="rv-media-file-size">__size__</div>
        <div class="rv-media-created-at">__date__</div>
    </li>
</script>

<script type="text/x-custom-template" id="rv_media_items_tiles_element">
    <li class="rv-media-list-title js-media-list-title js-context-menu" data-context="__type__" data-id="__id__">
        <input type="checkbox" class="hidden">
        <div class="rv-media-item" title="__name__">
            <span class="media-item-selected">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path d="M186.301 339.893L96 249.461l-32 30.507L186.301 402 448 140.506 416 110z"></path>
                </svg>
            </span>
            <div class="rv-media-thumbnail">
                __thumb__
            </div>
            <div class="rv-media-description">
                <div class="title title{{Request::get('file_id')}}">__name__</div>
            </div>
        </div>
    </li>
</script>

<script type="text/x-custom-template" id="rv_media_upload_progress_item">
    <li>
        <div class="rv-table-col">
            <span class="file-name">__fileName__</span>
            <div class="file-error"></div>
        </div>
        <div class="rv-table-col">
            <span class="file-size">__fileSize__</span>
        </div>
        <div class="rv-table-col">
            <span class="label label-__status__">__message__</span>
        </div>
    </li>
</script>

<script type="text/x-custom-template" id="rv_media_breadcrumb_item">
    <li>
        <a href="#" data-folder="__folderId__" class="js-change-folder">__icon__ __name__</a>
    </li>
</script>

<script type="text/x-custom-template" id="rv_media_rename_item">
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend" style="background: none;">
                <div class="input-group-text">
                    <i class="__icon__"></i>
                </div>
            </div>
            <input class="form-control" placeholder="__placeholder__" value="__value__">
        </div>
    </div>
</script>
