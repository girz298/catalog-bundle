(function ($) {

    $.fn.gridPlugin = function () {
        var that = this;

        var options = {
            sortableColumn: 'id',
            itemsPerPage: 10,
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
            this.table.append('</thead>');
        }

        function setBody(data) {
            this.table.append('<tbody>');
            var tbody = $('table tbody');
            data.forEach(function (item, i) {
                tbody.append('<tr id="titem'+i+'">');
                var tr = $('#titem'+i+'');
                for (var pole in item){
                    tr.append('<td>'+item[pole]+'</td>');
                }
                tbody.append('</tr>');
            });
            this.table.append('</tbody>');
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
                },
            });
        }

        function setSortable() {
            var that = this;
            $('th').click(function () {
                if ($(this).hasClass('active-filter')) {

                    $('th').removeClass('active-filter');
                    $('th').removeClass('active-filter-desc');
                    $(this).addClass('active-filter-desc');
                    console.log($(this)[0].outerText);
                    options.sortableColumn = $(this)[0].outerText + "";
                    options.direction = 0;
                    ajaxRequest(options);
                } else {
                    $('th').removeClass('active-filter');
                    $('th').removeClass('active-filter-desc');
                    $(this).addClass('active-filter');
                    console.log($(this)[0].outerText);
                    options.sortableColumn = $(this)[0].outerText + "";
                    options.direction = 1;
                    ajaxRequest(options);
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

        ajaxRequest(options);

    }

})(jQuery);


$('#grid-table').gridPlugin();