function getAllOperators(operatorPlaceHolders)
{
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/get-operators',
        data: {},
        success: function (operators) {
            var htmlString = getHTMLOperators(operators);
            $('#operator-table-body').html(htmlString);

            init(operatorPlaceHolders);
            // console.log(htmlString);
        },
        error: function (data, status) {
            console.log("Error!");
        }
    });
}


function getHTMLOperators(operators)
{
    var str = '';
    var count = operators.length;
    for (var i = 0; i < count; i++) {
        var operator = operators[i];

        str += '<tr>';
        str += '<td>' + operator['id'] + '</td>';
        str += '<td>' + operator['operator_name'] + '</td>';
        str += '<td id="phone-number-' + operator['id'] + '">' + operator['phone_number'] + '</td>';
        str += '<td>' + operator['calls_count_6h'] + '</td>';
        str += '<td>' + operator['calls_count_24h'] + '</td>';
        str += '<td>' + operator['calls_count_48h'] + '</td>';
        str += '<td>' + operator['last_call_date'] + '</td>';
        str += '<td class="actions">';
        str += '<a title="Edit Record" href="#" class="edit-operator-info" id="edit-' + operator["id"] + '" data-toggle="modal" data-target="#operator-info-modal">';
        str += '<i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;</a>';
        str += '<a title="Refresh Logs" href="/refresh?phoneNumber=' + operator['phone_number'] + '">';
        str += '<i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;</a>';
        str += '<a title="View Logs" href="#" class="open-logs-modal" id="log-' + operator['id'] + '" data-toggle="modal" data-target="#logs-modal">';
        str += '<i class="fa fa-rss" aria-hidden="true"></i>&nbsp;</a>';
        str += '<a title="New Message" href="#" class="open-message-modal" id="message-' + operator['id'] + '" data-toggle="modal" data-target="#new-message-modal">';
        str += '<i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;</a></td>';
        str += '</tr>';
    }

    return str;
}

function prepareOperatorEditForm(operatorId, operatorPlaceHolders)
{
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/get-operator-info',
        data: {operatorId : operatorId},
        success: function (operatorInfo) {

            for(var key in operatorInfo) {
                $('#' + key).val(operatorInfo[key]);
            }

            init(operatorPlaceHolders);
        },
        error: function (data, status) {
            console.log("Error!");
        }
    });
}


function setModalHeader(id, elementId, headerText)
{
    var phoneNumber = getPhoneNumber(id);
    headerText += phoneNumber;
    $('#' + elementId).html(headerText);
}

function getPhoneNumber(id)
{
    return $('#phone-number-' + id).html();
}

function appendLogsByOperatorId(operatorId)
{
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/get-logs',
        data: {operatorId: operatorId},
        success: function (logs) {
            var htmlString = getHTMLLogs(logs);
            $('#logs-body').html(htmlString);
            // console.log(htmlString);
        },
        error: function (data, status) {
            console.log("Error!");
        }
    });
}

function getHTMLLogs(logs)
{
    var str = '';

    var count = logs.length;
    for (var i = 0; i < count; i++) {
        var log = logs[i];

        str += '<div class="log-item">';
        str += '<p><span class="logs-header">Inbount Number:</span> ' + log['inbount_number'] + '</p>';
        str += '<p><span class="logs-header">Outbount Number:</span> ' + log['outbount_number'] + '</p>';
        str += '<p><span class="logs-header">Duration(mm:ss):</span> ' + log['duration'] + '</p>';
        str += '<p><span class="logs-header">Date:</span> ' + log['call_date'] + '</p>';
        str += '</div>';
    }
    return str;
}

function getHTMLOperator(operatorInfo)
{
    var str = '';
    str += '<div class="log-item">';
    str += '<p><span class="logs-header">Operator Name:</span> ' + operatorInfo['operator_name'] + '</p>';
    str += '<p><span class="logs-header">Calls count last 6 hours:</span> ' + operatorInfo['calls_count_6h'] + '</p>';
    str += '<p><span class="logs-header">Calls count last 24 hours:</span> ' + operatorInfo['calls_count_24h'] + '</p>';
    str += '<p><span class="logs-header">Calls count last 48 hours:</span> ' + operatorInfo['calls_count_48h'] + '</p>';
    str += '<p><span class="logs-header">Phone Number:</span> ' + operatorInfo['phone_number'] + '</p>';
    str += '<p><span class="logs-header">Last Call Date:</span> ' + operatorInfo['last_call_date'] + '</p>';
    str += '</div>';

    return str;
}

function appendOperatorInfoById(operatorId, operatorPlaceHolders)
{
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/get-operator-info',
        data: {operatorId: operatorId},
        success: function (operatorInfo) {
            var htmlOperatorInfo = getHTMLOperator(operatorInfo);
            var htmlHoldersString = getHTMLHolders(operatorPlaceHolders);

            $('#operator-info').html(htmlOperatorInfo);
            $('#available-holders').html(htmlHoldersString);

            $('#new-message-area').keyup(function () {
                insertFormatedMessage(this, operatorInfo, operatorPlaceHolders);
            });

        },
        error: function (data, status) {
            console.log("Error!");
        }
    });
}


function getHTMLHolders(operatorPlaceHolders)
{
    var str = '<p>';
    str += 'Available placeholders(without coma): ';
    var count = operatorPlaceHolders.length;

    for(var i = 0; i < count; i++) {
         str += '<strong>{{' + getCleanOperatorInfoKey(operatorPlaceHolders[i]) + '}}</strong>, ';
    }

    var str = str.substring(0, str.length - 2);
    var final = str + '</p>';
    return final;
}


function insertFormatedMessage(element, operatorInfo, operatorPlaceHolders)
{
    var areaEl = $(element);
    var message = areaEl.val();
    message = message.trim();
    var formatedMessage = replacePlaceHolders(message, operatorPlaceHolders, operatorInfo);
    $('#append-formated-message').html(formatedMessage);

}

function replacePlaceHolders(message, operatorPlaceHolders, operatorInfo)
{
    var count = operatorPlaceHolders.length;
    for(var i = 0; i < count; i++) {
        var info = getCleanOperatorInfoKey(operatorPlaceHolders[i]);
        message = message.replace(operatorPlaceHolders[i], operatorInfo[info]);
    }

    return message;
}

function getCleanOperatorInfoKey(key)
{
    var str = key.substring(2);
    var final = str.substring(0, str.length - 2);
    return final;
}

function editOperatorInfo(operatorPlaceHolders)
{
    event.preventDefault();
    var form = $('#edit-operator-info-form');
    var data = form.serializeArray();
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/edit-operator-info',
        data: {data: data},
        success: function (result) {

            console.log(result);
            if(result == '1') {
                $('#edit-result-span').html('<h4>Success editing!</h4>');
                console.log('Success');
                getAllOperators(operatorPlaceHolders);
                setTimeout(function() {
                    $('#operator-info-modal').modal('hide');
                }, 2000);
            } else {
                $('#edit-result-span').html('<h4>Failed editing! Or changes have not been made!</h4>');
                setTimeout(function() {
                    $('#operator-info-modal').modal('hide');
                }, 2000);
            }
        },
        error: function (data, status) {
            console.log("Error!");
        }
    });

}


function init(operatorPlaceHolders)
{
    $('#operators').DataTable();

    $('.open-logs-modal').click(function () {
        var id = $(this).attr('id');
        id = id.substring(4);
        setModalHeader(id, 'operator-phone-header', 'Logs for ');
        appendLogsByOperatorId(id);
    });


    $('.open-message-modal').click(function () {
        var id = $(this).attr('id');
        id = id.substring(8);
        setModalHeader(id, 'new-message-header', 'New message for ');
        $('#append-formated-message').html('');
        appendOperatorInfoById(id, operatorPlaceHolders);

    });


    $('.edit-operator-info').click(function () {
        $('#edit-result-span').html('');
        var id = $(this).attr('id');
        id = id.substring(5);
        setModalHeader(id, 'operator-info-header', 'Edit operator ');
        prepareOperatorEditForm(id, operatorPlaceHolders);

    });

}


jQuery(document).ready(function () {

    var operatorPlaceHolders = [
        '{{operator_name}}',
        '{{calls_count_6h}}',
        '{{calls_count_24h}}',
        '{{calls_count_48h}}',
        '{{phone_number}}',
        '{{last_call_date}}'
    ];

    getAllOperators(operatorPlaceHolders);

    $('#edit-operator-submit').click(function () {
        editOperatorInfo(operatorPlaceHolders);
    });

    setTimeout(function() {
        $('#api-info').hide();
    }, 5000)
});
