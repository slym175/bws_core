import {Helpers} from './App/Helpers/Helpers';
import {MediaConfig} from './App/Config/MediaConfig';
import {ContextMenuService} from './App/Services/ContextMenuService';

export class EditorService {
    static editorSelectFile(selectedFiles) {

        let is_ckeditor = Helpers.getUrlParam('CKEditor') || Helpers.getUrlParam('CKEditorFuncNum');

        if (window.opener && is_ckeditor) {
            let firstItem = _.first(selectedFiles);

            window.opener.CKEDITOR.tools.callFunction(Helpers.getUrlParam('CKEditorFuncNum'), firstItem.full_url);

            if (window.opener) {
                window.close();
            }
        } else {
            // No WYSIWYG editor found, use custom method.
        }
    }
}

class rvMedia {
    constructor(selector, options) {
        window.rvMedia = window.rvMedia || {};

        let $body = $('body');

        let defaultOptions = {
            multiple: true,
            type: '*',
            onSelectFiles: (files, $el) => {

            }
        };

        options = $.extend(true, defaultOptions, options);

        let clickCallback = event => {
            event.preventDefault();
            let $current = $(event.currentTarget);
            $('#rv_media_modal').modal();

            window.rvMedia.options = options;
            window.rvMedia.options.open_in = 'modal';

            window.rvMedia.$el = $current;

            MediaConfig.request_params.filter = 'everything';
            Helpers.storeConfig();

            let elementOptions = window.rvMedia.$el.data('rv-media');
            if (typeof elementOptions !== 'undefined' && elementOptions.length > 0) {
                elementOptions = elementOptions[0];
                window.rvMedia.options = $.extend(true, window.rvMedia.options, elementOptions || {});
                if (typeof elementOptions.selected_file_id !== 'undefined') {
                    window.rvMedia.options.is_popup = true;
                } else if (typeof window.rvMedia.options.is_popup !== 'undefined') {
                    window.rvMedia.options.is_popup = undefined;
                }
            }

            if ($('#rv_media_body .rv-media-container').length === 0) {
                $('#rv_media_body').load(RV_MEDIA_URL.popup, data => {
                    if (data.error) {
                        alert(data.message);
                    }
                    $('#rv_media_body')
                        .removeClass('media-modal-loading')
                        .closest('.modal-content').removeClass('bb-loading');
                    $(document).find('.rv-media-container .js-change-action[data-type=refresh]').trigger('click');

                    if (Helpers.getRequestParams().filter !== 'everything') {
                        $('.rv-media-actions .btn.js-rv-media-change-filter-group.js-filter-by-type').hide();
                    }

                    ContextMenuService.destroyContext();
                    ContextMenuService.initContext();
                });
            } else {
                $(document).find('.rv-media-container .js-change-action[data-type=refresh]').trigger('click');
            }
        };

        if (typeof selector === 'string') {
            $body.off('click', selector).on('click', selector, clickCallback);
        } else {
            selector.off('click').on('click', clickCallback);
        }
    }
}

window.RvMediaStandAlone = rvMedia;

$('.js-insert-to-editor').off('click').on('click', function (event) {
    event.preventDefault();
    let selectedFiles = Helpers.getSelectedFiles();
    if (_.size(selectedFiles) > 0) {
        EditorService.editorSelectFile(selectedFiles);
    }
});

$.fn.rvMedia = function (options) {
    let $selector = $(this);

    MediaConfig.request_params.filter = 'everything';
    $(document).find('.js-insert-to-editor').prop('disabled', MediaConfig.request_params.view_in === 'trash');
    Helpers.storeConfig();

    new rvMedia($selector, options);
};

class rvMediaIntegrate {
    initMediaIntegrate() {

        if (jQuery().rvMedia) {

            $('[data-type="rv-media-standard-alone-button"]').rvMedia({
                multiple: false,
                onSelectFiles: (files, $el) => {
                    $($el.data('target')).val(files[0].url);
                }
            });

            $.each($(document).find('.btn_gallery'), function (index, item) {
                var _editorName = $(item).data('editor');
                $(item).rvMedia({
                    multiple: false,
                    filter: $(item).data('action') === 'select-image' ? 'image' : 'everything',
                    view_in: 'all_media',
                    onSelectFiles: (files, $el) => {
                        switch ($el.data('action')) {
                            case 'media-insert-ckeditor':
                                let content = '';
                                $.each(files, (index, file) => {
                                    let link = file.full_url;
                                    if (file.type === 'youtube') {
                                        link = link.replace('watch?v=', 'embed/');
                                        content += '<iframe width="420" height="315" src="' + link + '" frameborder="0" allowfullscreen></iframe><br />';
                                    } else if (file.type === 'image') {
                                        content += '<img src="' + link + '" alt="' + file.name + '" /><br />';
                                    } else {
                                        content += '<a href="' + link + '">' + file.name + '</a><br />';
                                    }
                                });
                                var __editor = [];
                                if (typeof _use_editor === "undefined") {
                                    let _editor_obj = $(item).data('editor')
                                    __editor[_editorName] = window.hasOwnProperty(_editor_obj) ? window[_editor_obj] : null;
                                }
                                if (typeof _use_editor !== "undefined") {
                                    __editor = _use_editor;
                                }
                                if (__editor !== []) {
                                    __editor[_editorName].model.change(writer => {
                                        const _insertPosition = __editor[_editorName].model.document.selection.getFirstPosition();
                                        const _viewFragment = __editor[_editorName].data.processor.toView(content);
                                        const _modelFragment = __editor[_editorName].data.toModel(_viewFragment);
                                        writer.insert(_modelFragment, _insertPosition);
                                    });
                                }
                                break;
                            case 'media-insert-tinymce':
                                let html = '';
                                $.each(files, (index, file) => {
                                    let link = file.full_url;
                                    if (file.type === 'youtube') {
                                        link = link.replace('watch?v=', 'embed/');
                                        html += '<iframe width="420" height="315" src="' + link + '" frameborder="0" allowfullscreen></iframe><br />';
                                    } else if (file.type === 'image') {
                                        html += '<img src="' + link + '" alt="' + file.name + '" /><br />';
                                    } else {
                                        html += '<a href="' + link + '">' + file.name + '</a><br />';
                                    }
                                });
                                tinymce.activeEditor.execCommand('mceInsertContent', false, html);
                                break;
                            case 'select-image':
                                let firstImage = _.first(files);
                                $el.closest('.image-box').find('.image-data').val(firstImage.url);
                                $el.closest('.image-box').find('.preview_image').attr('src', firstImage.thumb);
                                $el.closest('.image-box').find('.preview-image-wrapper').show();
                                break;
                            case 'attachment':
                                let firstAttachment = _.first(files);
                                $el.closest('.attachment-wrapper').find('.attachment-url').val(firstAttachment.url);
                                $el.closest('.attachment-wrapper').find('.attachment-details').html('<a href="' + firstAttachment.full_url + '" target="_blank">' + firstAttachment.url + '</a>');
                                break;
                        }
                    }
                });
            });

            $(document).on('click', '.btn_remove_image', event => {
                event.preventDefault();
                $(event.currentTarget).closest('.image-box').find('.preview-image-wrapper').hide();
                $(event.currentTarget).closest('.image-box').find('.image-data').val('');
            });

            $(document).on('click', '.btn_remove_attachment', event => {
                event.preventDefault();
                $(event.currentTarget).closest('.attachment-wrapper').find('.attachment-details a').remove();
                $(event.currentTarget).closest('.attachment-wrapper').find('.attachment-url').val('');
            });

            new RvMediaStandAlone('.js-btn-trigger-add-image', {
                filter: 'image',
                view_in: 'all_media',
                onSelectFiles: (files, $el) => {
                    let $currentBoxList = $el.closest('.gallery-images-wrapper').find('.images-wrapper .list-gallery-media-images');

                    $currentBoxList.removeClass('hidden');

                    $('.default-placeholder-gallery-image').addClass('hidden');

                    _.forEach(files, file => {
                        let template = $(document).find('#gallery_select_image_template').html();

                        let imageBox = template
                            .replace(/__name__/gi, $el.attr('data-name'));

                        let $template = $('<li class="gallery-image-item-handler">' + imageBox + '</li>');

                        $template.find('.image-data').val(file.url);
                        $template.find('.preview_image').attr('src', file.thumb).show();

                        $currentBoxList.append($template);
                    });
                }
            });

            new RvMediaStandAlone('.images-wrapper .btn-trigger-edit-gallery-image', {
                filter: 'image',
                view_in: 'all_media',
                onSelectFiles: (files, $el) => {
                    let firstItem = _.first(files);

                    let $currentBox = $el.closest('.gallery-image-item-handler').find('.image-box');
                    let $currentBoxList = $el.closest('.list-gallery-media-images');

                    $currentBox.find('.image-data').val(firstItem.url);
                    $currentBox.find('.preview_image').attr('src', firstItem.thumb).show();

                    _.forEach(files, (file, index) => {
                        if (!index) {
                            return;
                        }
                        let template = $(document).find('#gallery_select_image_template').html();

                        let imageBox = template
                            .replace(/__name__/gi, $currentBox.find('.image-data').attr('name'));

                        let $template = $('<li class="gallery-image-item-handler">' + imageBox + '</li>');

                        $template.find('.image-data').val(file.url);
                        $template.find('.preview_image').attr('src', file.thumb).show();

                        $currentBoxList.append($template);
                    });
                }
            });

            $(document).on('click', '.btn-trigger-remove-gallery-image', event => {
                event.preventDefault();
                $(event.currentTarget).closest('.gallery-image-item-handler').remove();
                if ($('.list-gallery-media-images').find('.gallery-image-item-handler').length === 0) {
                    $('.default-placeholder-gallery-image').removeClass('hidden');
                }
            });

            $('.list-gallery-media-images').each((index, item) => {
                if (jQuery().sortable) {
                    let $current = $(item);
                    if ($current.data('ui-sortable')) {
                        $current.sortable('destroy');
                    }
                    $current.sortable();
                }
            });
        }
    }
}

let _rvMediaIntegrate = new rvMediaIntegrate();
_rvMediaIntegrate.initMediaIntegrate();
