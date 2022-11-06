/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************************************************!*\
  !*** ./bws/core/packages/shortcode/resources/assets/js/shortcode.js ***!
  \**********************************************************************/
$(document).ready(function () {
  $.each($(document).find('.btn_shortcode'), function (index, item) {
    $(item).on('click', function (e) {
      e.preventDefault();
      var _this = $(this),
        _shortcode = _this.data('shortcode'),
        _editor = _this.data('editor');
      _result = _this.data('result');
      $('.shortcode').empty().html('[' + _shortcode + ']');
      $('#kt_shortcode_modal_form [name="shortcode"]').val(_shortcode);
      if (_shortcode_getform_url) {
        $.ajax({
          url: _shortcode_getform_url,
          method: 'POST',
          data: {
            'shortcode': _shortcode,
            'result': _result,
            'editor': _editor
          },
          beforeSend: function beforeSend() {
            _this.find('.fas').removeClass('fa-code').addClass(['fa-spin', 'fa-spinner']);
          },
          success: function success(response) {
            if (response.html) {
              $('#kt_shortcode_modal #kt_shortcode_modal_form').empty().html(response.html);
            }
          },
          error: function error(_error) {},
          complete: function complete() {
            _this.find('.fas').removeClass(['fa-spin', 'fa-spinner']).addClass('fa-code');
            $('#kt_shortcode_modal').modal('show');
          }
        });
      }
    });
  });
  $('.form_insert_shortcode_button').click(function () {
    var _this = $(this),
      _form = _this.parents('#form_insert_shortcode');
    if (_form.attr('action')) {
      $.ajax({
        url: _form.attr('action'),
        method: 'POST',
        data: _form.serialize(),
        beforeSend: function beforeSend() {},
        success: function success(response) {
          var content = response.shortcode;
          var result = response.result;
          if (content) {
            var __editor = [];
            if (typeof _use_editor === 'undefined') {
              var _editor_obj = _this.data('editor');
              __editor[result] = window.hasOwnProperty(_editor_obj) ? window[_editor_obj] : null;
            }
            if (typeof _use_editor !== 'undefined') {
              __editor = _use_editor;
            }
            if (__editor !== []) {
              __editor[result].model.change(function (writer) {
                var _insertPosition = __editor[result].model.document.selection.getFirstPosition();
                var _viewFragment = __editor[result].data.processor.toView(content);
                var _modelFragment = __editor[result].data.toModel(_viewFragment);
                writer.insert(_modelFragment, _insertPosition);
              });
            }
          }
        },
        error: function error(_error2) {},
        complete: function complete() {
          $('#kt_shortcode_modal').modal('hide');
        }
      });
    }
  });
});
/******/ })()
;