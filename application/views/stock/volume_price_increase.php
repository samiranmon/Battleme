<!--<style type="text/css">td, th, table{border:1px solid #32CD32;}</style>-->
<h3>buy stocks</h3>
<table style="width:100%; border:1px solid #32CD32;">
    <tr>
        <th style="border:1px solid #32CD32;">Script name</th>

        <th style="border:1px solid #32CD32;">Price1</th> 
        <th style="border:1px solid #32CD32;">Price2</th>
        <th style="border:1px solid #32CD32;">Price3</th>

        <th style="border:1px solid #32CD32;">Delivery per1</th> 
        <th style="border:1px solid #32CD32;">Delivery per2</th>
        <th style="border:1px solid #32CD32;">Delivery per3</th>

        <th style="border:1px solid #32CD32;">Volume1</th> 
        <th style="border:1px solid #32CD32;">Volume2</th>
        <th style="border:1px solid #32CD32;">Volume3</th>
    </tr>

    <?php if (isset($buy_stocks)) {
        foreach ($buy_stocks as $val) {
            ?>
            <tr>
                <td style="border:1px solid #32CD32;"><a href="https://www.google.com/search?q=NSE:<?php echo $val['name'] ?>" target="_blank"><?php echo $val['name']; ?></a></td>

                <td style="border:1px solid #32CD32;"><?php echo $val['p1']; ?></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['p2']; ?></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['p3']; ?></td>

                <td style="border:1px solid #32CD32;"><?php echo $val['d1']; ?></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['d2']; ?></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['d3']; ?></td>

                <td style="border:1px solid #32CD32;"><?php echo $val['v1']; ?></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['v2']; ?></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['v3']; ?></td>
            </tr>
    <?php }
} ?>
</table>

<h3>sell seript</h3>
<table style="width:100%">
    <tr>
        <th style="border:1px solid #32CD32;">Script name</th>

        <th style="border:1px solid #32CD32;">Price1</th> 
        <th style="border:1px solid #32CD32;">Price2</th>
        <th style="border:1px solid #32CD32;">Price3</th>

        <th style="border:1px solid #32CD32;">Delivery per1</th> 
        <th style="border:1px solid #32CD32;">Delivery per2</th>
        <th style="border:1px solid #32CD32;">Delivery per3</th>

        <th style="border:1px solid #32CD32;">Volume1</th> 
        <th style="border:1px solid #32CD32;">Volume2</th>
        <th style="border:1px solid #32CD32;">Volume3</th>
    </tr>

    <?php if (isset($sell_stocks)) {
        foreach ($sell_stocks as $val) {
            ?>
            <tr>
                <td style="border:1px solid #32CD32;"><a href="https://www.google.com/search?q=NSE:<?php echo $val['name'] ?>" target="_blank"><?php echo $val['name']; ?></a></td>

                <td style="border:1px solid #32CD32;"><?php echo $val['p1']; ?></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['p2']; ?></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['p3']; ?></td>

                <td style="border:1px solid #32CD32;"><?php echo $val['d1']; ?></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['d2']; ?></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['d3']; ?></td>

                <td style="border:1px solid #32CD32;"><?php echo $val['v1']; ?></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['v2']; ?></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['v3']; ?></td>
            </tr>
    <?php }
} ?>
</table>





<h3>last 3 days continuously price and volume increase</h3>
<table style="width:100%">
    <tr>
        <th style="border:1px solid #32CD32;">Script name</th>

        <th style="border:1px solid #32CD32;">Price1</th> 
        <th style="border:1px solid #32CD32;">Price2</th>
        <th style="border:1px solid #32CD32;">Price3</th>

        <th style="border:1px solid #32CD32;">Delivery per1</th> 
        <th style="border:1px solid #32CD32;">Delivery per2</th>
        <th style="border:1px solid #32CD32;">Delivery per3</th>

        <th style="border:1px solid #32CD32;">Volume1</th> 
        <th style="border:1px solid #32CD32;">Volume2</th>
        <th style="border:1px solid #32CD32;">Volume3</th>
    </tr>

    <?php if (isset($stocks)) {
        foreach ($stocks as $val) {
            ?>
            <tr>
                <td style="border:1px solid #32CD32;"><a href="https://www.google.com/search?q=NSE:<?php echo $val['name'] ?>" target="_blank"><?php echo $val['name']; ?></a></td>

                <td style="border:1px solid #32CD32;"><?php echo $val['p1']; ?></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['p2']; ?></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['p3']; ?></td>

                <td style="border:1px solid #32CD32;"><?php echo $val['d1']; ?></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['d2']; ?></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['d3']; ?></td>

                <td style="border:1px solid #32CD32;"><?php echo $val['v1']; ?></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['v2']; ?></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['v3']; ?></td>
            </tr>
    <?php }
} ?>
</table>            