<?php include $_SERVER['DOCUMENT_ROOT'] . "/application/views/templates/head.php";?>
<body>
<div class="row margin-top-10">
    <button id="init_stock" class="btn btn-default">更新票代码数据库</button>
</div>
<br/>
<table class="table table-bordered">
    <thead>
    <tr>
        <th class="text-center">
            代码
        </th>
        <th class="text-center">
            最新价
        </th>
        <th class="text-center">
            涨幅
        </th>
        <th class="text-center">
            换手率
        </th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($stock_list as $stock): ?>
        <tr>
            <td>
                <?php echo substr($stock['code'], 3); ?>
            </td>
            <td>
                <?php echo $stock['zuixin']; ?>
            </td>
            <td>
                <?php echo $stock['zhangfu']; ?>
            </td>
            <td>
                <?php echo $stock['huanshou']; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="row">
    <button id="prev" class="btn btn-default">上一页</button>
    &nbsp;
    <button id="next" class="btn btn-default">下一页</button>
</div>
<script>

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

    $('#init_stock').on('click', function () {
        if (confirm('确定要更新数据库数据？')) {
            $.ajax({
                url: './lists/init_stock',
                cache: false,
                timeout: 5 * 60 * 1000,
                data: {
                    start: getParameterByName('start'),
                    end: getParameterByName('end')
                },
                success: function (data) {
                    console.log('更新数据库成功！');
                    console.log(data);
                },
                error: function () {
                    console.log('更新数据库失败！');
                }
            });
        }
    });
</script>
<script src="/assets/js/pagination.js"></script>
</body>
</html>