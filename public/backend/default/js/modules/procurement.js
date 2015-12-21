var oTable;
var memoTable;
var url = $('input[name="proc_url"]').val();
var proc_id = $('input[name="proc_id"]').val()

$(document).ready(function () {
    //+ "/addItem/" + $('input[name="proc_id"]').val();
    oTable = $('#item_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: url + "/datatables/" + proc_id,
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
            { data: 'amount', name: 'amount' , sClass : 'right' },
            { data: 'unit', name: 'unit' },
            { data: 'unit_price', name: 'unit_price', sClass : 'right'}
        ]
    } );

    memoTable = $('#item_memo_table').DataTable({
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
            { data: 'amount', name: 'amount' , sClass : 'right' },
            { data: 'unit', name: 'unit' },
            { data: 'unit_price', name: 'unit_price', sClass : 'right'}
        ]
    } );

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

    $('input[name="offering_letter_date"], input[name="po_letter_date"]').datepicker({ format: "dd/mm/yyyy",
        autoclose: true,
        todayHighlight: true
    });

    $(document).on('keyup', '.numeric', function(event) {
        var v = this.value;
        if($.isNumeric(v) === false) {
            //chop off the last char entered
            this.value = this.value.slice(0,-1);
        }
    });


    $('#item_table tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('active') ) {
            $(this).removeClass('active');
        }
        else {
            oTable.$('tr.selected').removeClass('selected');
            $(this).addClass('active');
        }
    } );

    $('#myModal').on('shown.bs.modal', function () {
        $('#addItemModal input').val('');
        $('input[name="item_name"]').focus();
    });



    $('#addItemModal').on('submit', function(){
        var  unit_price = $('input[name="unit_price"]').val();

        if($('input[name="proc_id"]').val())
        {
            ajaxUrl = url + "/addItem/" + proc_id;

            $.post( ajaxUrl, {
                item_name : $('input[name="item_name"]').val(),
                amount : $('input[name="amount"]').val(),
                unit : $('input[name="unit"]').val(),
                unit_price : number_format(unit_price)
            }, function(data){
                oTable.row.add({
                    "id" : data,
                    "item_name" : $('input[name="item_name"]').val(),
                    "amount" : $('input[name="amount"]').val(),
                    "unit" : $('input[name="unit"]').val(),
                    "unit_price" : number_format(unit_price)
                }).draw();
            });
        }
        else
        {
            oTable.row.add({
                "id" : 1000,
                "item_name" : $('input[name="item_name"]').val(),
                "amount" : $('input[name="amount"]').val(),
                "unit" : $('input[name="unit"]').val(),
                "unit_price" : number_format(unit_price)
            }).draw();
        }



        $('#myModal').modal('hide');

        return false;
    });


    $('#addItemMemoModal').on('submit', function(){
        var  unit_price = $('input[name="unit_price"]').val();

        if($('input[name="proc_id"]').val())
        {
            ajaxUrl = url + "/addItem/" + proc_id;

            $.post( ajaxUrl, {
                item_name : $('input[name="item_name"]').val(),
                amount : $('input[name="amount"]').val(),
                unit : $('input[name="unit"]').val(),
                unit_price : number_format(unit_price)
            }, function(data){
                memoTable.row.add({
                    "id" : data,
                    "item_name" : $('input[name="item_name"]').val(),
                    "amount" : $('input[name="amount"]').val(),
                    "unit" : $('input[name="unit"]').val(),
                    "unit_price" : number_format(unit_price)
                }).draw();
            });
        }
        else
        {
            memoTable.row.add({
                "id" : 1000,
                "item_name" : $('input[name="item_name"]').val(),
                "amount" : $('input[name="amount"]').val(),
                "unit" : $('input[name="unit"]').val(),
                "unit_price" : number_format(unit_price)
            }).draw();
        }



        $('#myModal').modal('hide');

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
        if($('input[name="proc_id"]').val()) {
            ajaxUrl = url + "/removeItem/" + proc_id;

            data = oTable.rows('.active').data();

            var items = {};

            data.each(function (value, index ){
                items[index] = value["id"];
            });

            $.post( ajaxUrl, { items : JSON.stringify(items) }, function(data) {
                oTable.rows('.active').remove().draw( false );
            });
        }
        else
        {
            oTable.rows('.active').remove().draw( false );
        }
    });

});
