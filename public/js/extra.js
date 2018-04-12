const triggerDeleteForm = function (url) {
    if (confirm('确定要删除本条内容？')) {
        $('#delete_form').attr('action', url).submit();
    }
}