<?php include $_SERVER['DOCUMENT_ROOT'] . "/application/views/templates/head.php";?>
<body>
<div>共<?php echo count($stock_list) ?>条数据</div>
<table class="table table-bordered">
    <thead>
    <tr>
        <th class="text-center">

        </th>
        <th class="text-center">
            代码
        </th>
        <th class="text-center">
            名称
        </th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($stock_list as $key => $stock): ?>
        <tr>
            <td>
                <?php echo $key; ?>
            </td>
            <td>
                <?php echo substr($stock['code'], 2); ?>
            </td>
            <td>
                <?php echo $stock['name']; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
