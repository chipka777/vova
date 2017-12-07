function showEdit(id) {
    $('#editModal').modal('show');

    $('#name-edit').val($('#dep-' + id + '>.dep-name').text());
    $('#address-edit').val($('#dep-' + id + '>.dep-addr').text());
    $('#phone-edit').val($('#dep-' + id + '>.dep-phone').text());
    $('#id-edit').val(id);
}

function showDelete(id) {
    $('#deleteModal').modal('show');
    $('.rm-dep-name').text($('#dep-' + id + '>.dep-name').text());

    $('#rm-dep-id').val(id);
}
