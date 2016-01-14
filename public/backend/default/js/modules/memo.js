var memoTable;

var memo_url = $('input[name="memo_url"]').val();
var memo_id = $('input[name="memo_id"]').val();

$(document).ready(function () {
    $('#memo_list').DataTable({
        "sPaginationType": "full_numbers",
        'ordering' : false,
        "columnDefs": [
            { "visible": false, "targets": 0 }
        ]
    });

    if (memo_id == 0)
    {
        memoTable = $('#item_memo_table').DataTable({
            processing: false,
            paging:   false,
            ordering: false,
            info:     false,
            searching : false,
            columnDefs: [
                {
                    "targets": [ 0 ],
                    "visible": false,
                }
            ],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'item_name', name: 'item_name' },
                { data: 'catalog', name: 'catalog'},
                { data: 'amount', name: 'amount' , sClass : 'right' },
                { data: 'unit', name: 'unit' },
                { data: 'notes', name: 'notes' },
            ]
        });
    }
    else
    {
        memoTable = $('#item_memo_table').DataTable({
            processing: false,
            serverSide: true,
            ajax: memo_url + "/datatables/" + memo_id,
            paging:   false,
            ordering: false,
            info:     false,
            searching : false,
            columnDefs: [
                {
                    "targets": [ 0 ],
                    "visible": false,
                }
            ],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'item_name', name: 'item_name' },
                { data: 'catalog', name: 'catalog'},
                { data: 'amount', name: 'amount' , sClass : 'right' },
                { data: 'unit', name: 'unit' },
                { data: 'notes', name: 'notes' },
            ]
        });
    }


    $.fn.editable.defaults.mode = 'popup';
    $.fn.editable.defaults.ajaxOptions = {type: "PUT"};

    $(document).on('click', '.item_name', function(){
        $('.item_name').editable(
            {
                type: 'text',
                success: function(response, newValue) {
                    $(this).val(newValue);
                }
            }
        );
    });


    $('#item_memo_table tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('active') ) {
            $(this).removeClass('active');
        }
        else {
            memoTable.$('tr.selected').removeClass('selected');
            $(this).addClass('active');
        }
    } );

    $('#myModal').on('shown.bs.modal', function () {
        $('#addItemModal input').val('');
        $('input[name="item_name"]').focus();
    });

    $('#addItemMemoModal').on('submit', function(){
        if($('input[name="memo_id"]').val() != 0)
        {
            ajaxUrl = memo_url + "/addItem/" + memo_id;

            $.post( ajaxUrl, {
                item_name : $('input[name="item_name"]').val(),
                catalog :  $('input[name="catalog"]').val(),
                amount : $('input[name="amount"]').val(),
                unit : $('input[name="unit"]').val(),
                notes : $('input[name="notes"]').val()
            }, function(data){
                memoTable.row.add({
                    "id" : data,
                    "item_name" : $('input[name="item_name"]').val(),
                    "catalog" :  $('input[name="catalog"]').val(),
                    "amount" : $('input[name="amount"]').val(),
                    "unit" : $('input[name="unit"]').val(),
                    "notes" : $('input[name="notes"]').val()
                }).draw();
            });
        }
        else {
            memoTable.row.add({
                "id": 1000,
                "item_name": $('input[name="item_name"]').val(),
                "catalog": $('input[name="catalog"]').val(),
                "amount": $('input[name="amount"]').val(),
                "unit": $('input[name="unit"]').val(),
                "notes" : $('input[name="notes"]').val()
            }).draw();
        }
        $('#myModal').modal('hide');

        $(this).find("input[type=text]").val("");

        return false;
    });

    var items = {};


    $('#add_memo').submit(function(e){

        var i = 1;
        memoTable
            .data()
            .each( function ( value, index ) {
                items[i] = value;
                i = i + 1;
            });

        var json_data = JSON.stringify(items);

        $('input[name="items"]').val(json_data);
    });

    $('#del_row').click( function () {
        if($('input[name="memo_id"]').val()) {
            ajaxUrl = memo_url + "/removeItem/" + memo_id;

            data = memoTable.rows('.active').data();

            var items = {};

            data.each(function (value, index ){
                items[index] = value["id"];
            });

            $.post( ajaxUrl, { items : JSON.stringify(items) }, function(data) {
                memoTable.rows('.active').remove().draw( false );
            });
        }
        else
        {
            memoTable.rows('.active').remove().draw( false );
        }
    });

    $('#autocomplete').autocomplete({
        serviceUrl: '/autocomplete',
        onSelect: function (suggestion) {
            alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
        }
    });

});
