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
    <a href='./chengjiaoliang/lowest_30'>30日成交新低</a>
</div>
<div class="form-group">
    <a href='./chengjiaoliang/pulse_7'>7日成交量变</a>
</div>
<div class="form-group">
    <a href='./chengjiaoliang/pulse_15'>15日成交量变</a>
</div>
<div class="form-group">
    <a href='./chengjiaoliang/pulse_30'>30日成交量变</a>
</div>
<div class="row form-group">
    <button id="backup" class="btn btn-default">备份数据</button>
    <button id="update" class="btn btn-default">更新今日数据</button>
</div>
<script>
    $.ajax({
        url: '/stock/check_server_status',
        cache: false,
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
        timeout: 60 * 1000,
        success: function (data) {
            if (data == 'ok') {
                $('#update_stock_status').html('已完成！');
            } else {
                $('#update_stock_status').html('正在执行中！');
            }
        },
        error: function () {
            $('#server_status').html('请求数据失败！');
        }
    });

    $.ajax({
        url: '/stock/check_update_data_status',
        cache: false,
        timeout: 60 * 1000,
        success: function (data) {
            if (data == 'ok') {
                $('#update_data_status').html('已完成！');
            } else {
                $('#update_data_status').html('正在执行中！');
            }
        },
        error: function () {
            $('#server_status').html('请求数据失败！');
        }
    });

    $.ajax({
        url: '/stock/check_backup_status',
        cache: false,
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

    function updateStockData() {
        $.ajax({
            url: '/stock/update_stock_data',
            cache: false,
            timeout: 10 * 60 * 1000,
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
    setTimeout(function () {
        window.location.reload();
    }, 10 * 60000);
</script>
</body>
</html>