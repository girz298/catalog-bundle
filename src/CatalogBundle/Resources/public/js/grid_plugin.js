(function ($) {

    $.fn.gridPlugin = function () {
        var that = this;

        var options = {
            sortableColumn: 'id',
            itemsPerPage: 6,
            page: 1,
            direction: 1
        };

        function setTable() {
            that.append('<table></table>');
            this.table = $('table');
            this.table.addClass('table table-striped');
        }

        function setHeaders(header) {
            this.table.append('<thead>');
            var thead = $('table thead');
            for(var pole in header){
                if (pole == options.sortableColumn && options.direction == 1) {
                    thead.append('<th class="active-filter">'+pole+'</th>');
                } else if(pole == options.sortableColumn && options.direction == 0) {
                    thead.append('<th class="active-filter-desc">'+pole+'</th>');
                } else {
                    thead.append('<th>'+pole+'</th>');
                }
            }
            thead.append('<th class="disabled-header">Edit</th>');
            this.table.append('</thead>');
        }

        function setBody(data, from) {
            if (!from) {
                this.table.append('<tbody>');
            }
            var tbody = $('table tbody');
            data.forEach(function (item, i) {
                tbody.append('<tr id="titem'+item['id']+'">');
                var tr = $('#titem'+item['id']+'');
                for (var pole in item){
                    if (pole != 'category') {
                        tr.append('<td>' + (item[pole]+"").slice(0,20) + '</td>');
                    } else {
                        tr.append('<td>' + item['category']['title'] + '</td>');
                    }
                }

                tr.append('<td>' +
                    '<div class="btn-group" role="group" >' +
                    '<button id="view' + item['id'] +
                    '" class="btn btn-info view-btn" >' +
                    '<span class="glyphicon glyphicon-book" ></span></button>' +
                    '<button id="edit' + item['id'] +
                    '" class="btn btn-primary edit-btn">' +
                    '<span class="glyphicon glyphicon-pencil"></span></button>' +
                    '<button id="remove' + item['id'] +
                    '" class="btn btn-danger remove-btn">' +
                    '<span class="glyphicon glyphicon-remove"></span></button>' +
                    '</div>' +
                    '</td>');

                tbody.append('</tr>');
            });

            if (!from) {
                this.table.append('</tbody>');
            }
        }

        function ajaxRequest(options) {
            $('table').remove();
            $('#prev-btn').remove();
            $('#next-btn').remove();
            $.ajax({
                url: 'http://localhost:8000/api/products/'+options.page+'/'+
                options.itemsPerPage+'/'+options.sortableColumn+'/'+
                options.direction,
                success: function(data){
                    setTable();
                    setHeaders(data[0]);
                    setBody(data);
                    setSortable();
                    setButtons();
                    setButtonsWorkable();
                },
            });
        }

        function setSortable() {
            $('th').click(function () {
                if (!$(this).hasClass('disabled-header')) {
                    if ($(this).hasClass('active-filter')) {
                        $('th').removeClass('active-filter');
                        $('th').removeClass('active-filter-desc');
                        $(this).addClass('active-filter-desc');
                        // console.log($(this)[0].outerText);
                        options.sortableColumn = $(this)[0].outerText + "";
                        options.direction = 0;
                        ajaxRequest(options);
                    } else {
                        $('th').removeClass('active-filter');
                        $('th').removeClass('active-filter-desc');
                        $(this).addClass('active-filter');
                        // console.log($(this)[0].outerText);
                        options.sortableColumn = $(this)[0].outerText + "";
                        options.direction = 1;
                        ajaxRequest(options);
                }
            }
            });
        }

        function setButtons() {
            that.append('<button id="prev-btn" class="btn btn-default">Prev</button>');
            that.append('<button id="next-btn" class="btn btn-default">Next</button>');
            $('#prev-btn').click(function () {
                if (options.page > 1) {
                    options.page--;
                    ajaxRequest(options);
                }
            });

            $('#next-btn').click(function () {
                options.page++;
                ajaxRequest(options);
            });
        }

        function setButtonsWorkable() {
            $('.remove-btn').click(function () {
                var id = $(this).attr('id').slice(6);
                // console.log($(this).attr('id').slice(6));
                // $('#titem'+id).hide("fast", function () {
                    removeAjax(id);
                // });
                // prettyRemoveHelper();
            });
        }
        
        function removeAjax(id) {
            $.ajax({
                url: 'http://localhost:8000/product/' + id + '/remove',
                success: function (data) {
                    if (data == 1) {
                        $('#titem'+id).remove();
                    } else {
                        this.error();
                    }
                },
                error: function () {
                    alert("Something going wrong!");
                }
            });
        }

        function prettyRemoveHelper() {
            $.ajax({
                url: 'http://localhost:8000/api/products/'+((options.page*options.itemsPerPage))+'/'+
                1+'/'+options.sortableColumn+'/'+
                options.direction,
                success: function(data){
                    setBody(data, 1);

                },
            });
        }

        ajaxRequest(options);
    }

})(jQuery);


$('#grid-table').gridPlugin();