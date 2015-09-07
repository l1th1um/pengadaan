$(document).ready(function () {
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
        oTable.row.add([
            0,
            $('input[name="item_name"]').val(),
            $('input[name="amount"]').val(),
            $('input[name="unit"]').val(),
            number_format(unit_price)
        ]).draw();

        $('#myModal').modal('hide');

        return false;
    });

    $('#del_row').click( function () {
        oTable.rows('.active').remove().draw( false );
    } );

    var items = {};

    $('#add_procurement').submit(function(e){
        var i = 1;
        oTable
            .data()
            .each( function ( value, index ) {
                items[i] = value;
                i = i + 1;
            });

        var json_data = JSON.stringify(items);

        $('input[name="items"]').val(json_data);
    });

    /*Procurement List*/
    $('#proc_list').DataTable({
        "columns": [
            null,
            { "orderable": false },
            null,
            null,
            { "orderable": false }
        ],
        "aaSorting": []
    });

    $('.editor').summernote({
        height: 200,
        tabsize: 2,
        styleWithSpan: false,
        toolbar: [
            ['style', ['bold', 'italic', 'underline']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['para', ['ul', 'ol', 'paragraph']],
        ]
    });

});
