<style type="text/css">td, th, table{border:1px solid #aaa;}</style>
<table style="width:100%">
    <tr>
        <th>Script name</th>

        <th>Price1</th> 
        <th>Price2</th>
        <th>Price3</th>

        <th>Delivery per1</th> 
        <th>Delivery per2</th>
        <th>Delivery per3</th>

        <th>Volume1</th> 
        <th>Volume2</th>
        <th>Volume3</th>
    </tr>

    <?php if (isset($stocks)) {
        foreach ($stocks as $val) {
            ?>
            <tr>
                <td><?php echo $val['name']; ?></td>

                <td><?php echo $val['p1']; ?></td>
                <td><?php echo $val['p2']; ?></td>
                <td><?php echo $val['p3']; ?></td>

                <td><?php echo $val['d1']; ?></td>
                <td><?php echo $val['d2']; ?></td>
                <td><?php echo $val['d3']; ?></td>

                <td><?php echo $val['v1']; ?></td>
                <td><?php echo $val['v2']; ?></td>
                <td><?php echo $val['v3']; ?></td>
            </tr>
    <?php }
} ?>
</table>            