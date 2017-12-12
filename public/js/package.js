$(document).ready(function() {
    $("#pack-new").ajaxForm(function(response) {
        $("#create-form").css('opacity', 1);
        $("#create-loader").hide();
        if (response == "1") {
            $("#err-alert").hide();
            $("#succ-alert").show();
            return false;
            
        }
        $("#succ-alert").hide();
        $("#err-alert").show();
        $('#err-msg').html(response.replace(/\\/g, '').replace(/"/g, ''));
    });

    $("#create-btn").click(function() {
        $("#create-form").css('opacity', 0);
        $("#create-loader").show();
    });

});

function changeStatus(id)
{
    $('#status-' + id).fadeOut('slow');
    $('.loader-' + id).fadeIn('slow');

    $.ajax({
        type: 'POST',
        url: '/package/status',
        data: { id: id, status: $('#status-' + id).val()},
        success: function(data, status)
        {
            $('#status-' + id).fadeIn('slow');
            $('.loader-' + id).fadeOut('slow');
        },
        error: function(data, status)
        {
            $('#status-' + id).fadeIn('slow');
            $('.loader-' + id).fadeOut('slow');
           console.log('Some problems');
        }
    });
}

function showEditPack(id)
{
    $('#title-edit').val($("#pack-"+id+">.pack-title").text());
    $('#from-edit').val($("#pack-"+id+">.pack-from").text());
    $('#to-edit').val($("#pack-"+id+">.pack-to").text());
    $('#description-edit').val($("#pack-"+id+">.pack-description").text());
    $('#deps-edit').val($("#pack-"+id+">.pack-dep").attr('data-dep-id'));
    $('#id-edit').val(id);
    $("#editModal").modal('show');
}

function showDeletePack(id)
{
    $(".rm-pack-title").text($("#pack-"+id+">.pack-title").text());
    $("#rm-pack-id").val(id);
    $("#deleteModal").modal('show');
}