<?php include $_SERVER['DOCUMENT_ROOT'] . "/application/views/templates/head.php";?>
<body>
<div>共<?php echo count($stock_list) ?>条数据</div>
<table class="table table-bordered">
    <thead>
    <tr>
        <th class="text-center">
            代码
        </th>
        <th class="text-center">
            名称
        </th>
        <th class="text-center">
            操作
        </th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($stock_list as $stock): ?>
        <tr>
            <td class="code">
                <?php echo $stock['code']; ?>
            </td>
            <td>
                <?php echo $stock['name']; ?>
            </td>
            <td>
                <?php if($stock['selected']){echo "<button class='add'>添加自选</button>";}else{echo "<button class='remove'>删除自选</button>";} ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<script>
    $('.add').on('click', function () {
        var code = $(this).parents('tr').find('.code').text().trim();

        $.ajax({
            url: '/stock/add_stock_selected',
            cache: false,
            async: false,
            timeout: 60 * 1000,
            data: {
                code: code
            },
            success: function (data) {
                window.location.reload();
            },
            error: function () {
                alert('请求数据失败！');
            }
        });
    });

    $('.remove').on('click', function () {
        var code = $(this).parents('tr').find('.code').text().trim();

        $.ajax({
            url: '/stock/remove_stock_selected',
            cache: false,
            async: false,
            timeout: 60 * 1000,
            data: {
                code: code
            },
            success: function (data) {
                window.location.reload();
            },
            error: function () {
                alert('请求数据失败！');
            }
        });
    });
</script>
</body>
</html>