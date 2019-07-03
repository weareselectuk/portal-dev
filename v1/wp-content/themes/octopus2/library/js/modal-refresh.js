;(function($){
('#my-modal').on('hidden.bs.modal', function () {
  window.alert('hidden event fired!');
  function escapeRegExp(str) {
  return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
}
})(jQuery);