<?php include $_SERVER['DOCUMENT_ROOT'] . "/application/views/templates/head.php";?>
<body>
<div class="form-group">
    <span>服务器通信状态：</span>
    <span id="server_status"></span>
</div>
<div class="form-group">
    <span>更新股票列表数据状态：</span>
    <span id="update_stock_status"></span>
</div>
<div class="form-group">
    <span>更新今日数据状态：</span>
    <span id="update_data_status"></span>
</div>
<div class="form-group">
    <span>备份数据状态：</span>
    <span id="backup_status"></span>
</div>
<div class="form-group">
    <a href='./lists'>股票列表</a>
</div>
<div class="form-group">
    &nbsp;
</div>
<div class="form-group">
    &nbsp;
</div>
<div class="row form-group">
    <button id="backup" class="btn btn-default">备份数据</button>
    <button id="update" class="btn btn-default">更新今日数据</button>
</div>
<script>
    $.ajax({
        url: '/stock/check_server_status',
        cache: false,
        async: false,
        timeout: 60 * 1000,
        success: function (data) {
            $('#server_status').html('与服务器通信正常！');
        },
        error: function () {
            $('#server_status').html('请求数据失败！');
        }
    });

    $.ajax({
        url: '/stock/check_update_stock_status',
        cache: false,
        async: false,
        timeout: 60 * 1000,
        success: function (data) {
            if (data == 'ok') {
                $('#update_stock_status').html('已完成！');
            } else {
                $('#update_stock_status').html(Number(data * 100).toFixed(4) + '%');
            }
        },
        error: function () {
            $('#server_status').html('请求数据失败！');
        }
    });

    $.ajax({
        url: '/stock/check_update_data_status',
        cache: false,
        async: false,
        timeout: 60 * 1000,
        success: function (data) {
            if (data == 'ok') {
                $('#update_data_status').html('已完成！');
                window.name = '';
            } else {
                if (window.name && window.name == data) {
                    updateStockData();
                } else {
                    window.name = data;
                    $('#update_data_status').html(Number(data * 100).toFixed(4) + '%');
                }
            }
        },
        error: function () {
            $('#server_status').html('请求数据失败！');
        }
    });

    $.ajax({
        url: '/stock/check_backup_status',
        cache: false,
        async: false,
        timeout: 60 * 1000,
        success: function (data) {
            if (data == 'ok') {
                $('#backup_status').html('已完成！');
            } else {
                $('#backup_status').html('正在执行中！');
            }
        },
        error: function () {
            $('#server_status').html('请求数据失败！');
        }
    });

    $('#backup').on('click', function () {
        if (confirm('确定要备份数据？')) {
            $.ajax({
                url: '/stock/back_up',
                cache: false,
                timeout: 10 * 60 * 1000,
                success: function (data) {
                    window.location.reload();
                },
                error: function () {
                    $('#server_status').html('请求数据失败！');
                }
            });
        }
    });

    $('#update').on('click', function () {
        if (confirm('确定要更新今日数据？')) {
            updateStockData();
        }
    });

    function getParameterByName(name, href) {
        name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        var regexS = "[\\?&]" + name + "=([^&#]*)";
        var regex = new RegExp(regexS);
        var results = regex.exec(href || window.location.href);
        if (results == null)
            return "";
        else
            return decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    function updateStockData() {
        $.ajax({
            url: '/stock/update_stock_data',
            cache: false,
            timeout: 10 * 60 * 1000,
            data: {
                start: getParameterByName('start') || getDateToday(),
                end: getParameterByName('end') || getDateToday()
            },
            success: function (data) {
                console.log(data);
                if (data == 0) {
                    alert('更新股票代码数据成功！');
                }
            },
            error: function () {
                $('#server_status').html('请求数据失败！');
            }
        });
    }
    function getDateToday () {
        var today = new Date();
        var todayStr = '';
        var year,month,date;

        year = today.getFullYear();
        month = +today.getMonth() + 1;
        date = today.getDate();

        todayStr += year;
        todayStr += month > 9 ? month : ('0' + month);
        todayStr += date > 9 ? date : ('0' + date);

        return todayStr;
    }
    setTimeout(function () {
        if (window.name) {
            window.location.reload();
        }
    }, 2 * 60000);
</script>
</body>
</html>
