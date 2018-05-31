<h3>Top volatility stocks</h3>
<table style="width:100%; border:1px solid #32CD32;">
    <tr>
        <th style="border:1px solid #32CD32;">Script name</th>
        <th style="border:1px solid #32CD32;">Current volatility</th> 
        <th style="border:1px solid #32CD32;">Annualised volatility</th>
        <th style="border:1px solid #32CD32;">Volume</th>
    </tr>

    <?php if (isset($stocks)) {
        foreach ($stocks as $val) {
            ?>
            <tr>
                <td style="border:1px solid #32CD32;"><a href="https://www.google.com/search?q=NSE:<?php echo $val['name'] ?>" target="_blank"><?php echo $val['name']; ?></a></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['current_volatility']; ?></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['annualised_volatility']; ?></td>
                <td style="border:1px solid #32CD32;"><?php echo $val['volume']; ?></td>
            </tr>
    <?php }
} ?>
</table>            