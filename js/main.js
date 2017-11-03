$(document).ready(function () {

    $('select[name=drop_down]').change(function () {
        $.ajax({
            url: '../library/openFile.php?file=' + $(this).val(),
            success: function (data) {
                tinymce.get('message').setContent(data);
            },
            error: function () {
                alert('error');
            }
        });

    });
    tinymce.init({
        selector: 'textarea#message',
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste imagetools"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        height: 300
    });

    tinymce.init({
        selector: 'textarea#h-message',
        menubar: false,
        toolbar: false,
        statusbar: false,
        height: 176,
        readonly : 1,
        max_height: 176
    });

});

var result = $('#result').data('result').split(',');
if(result!=",") {
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Результат', 'Количество'],
            ['Успешно', parseFloat(result[0])],
            ['Ошибка', parseFloat(result[1])],
        ]);

        var options = {
            title: 'Результат отправки'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
}