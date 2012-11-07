<div>
<?php
echo $this->Html->link($transactionItem['name'],
	'/prdocuts/products/view/'.$transactionItem['foreign_key'],
	array('style' => 'text-decoration: underline;'),
	'Are you sure you want to leave this page?'
	);
?>
</div>
<?php
echo $this->element('thumb', array(
	    'model' => 'Product',
	    'foreignKey' => $transactionItem['foreign_key'],
	    'thumbSize' => 'small',
	    'thumbWidth' => 75,
	    'thumbHeight' => 75,
	    'thumbLink' => '/products/products/view/'.$transactionItem['foreign_key']
	    ),
	array('plugin' => 'galleries')
	);

$minQty = !empty($product['Product']['cart_min']) ? $product['Product']['cart_min'] : 1;
$maxQty = !empty($product['Product']['cart_max']) ? $product['Product']['cart_max'] : null;

echo $this->Form->input("TransactionItem.{$i}.quantity", array(
    'label' => 'Qty.',
    'div' => array('style' => 'display:inline-block'),
    'value' => $transactionItem['quantity'],
    'min' => $minQty, 'max' => $maxQty,
    'size' => 1
    ));
?>

<div style="display: inline-block; float: right; font-weight: bold; padding: 22px 0;" id="">
    $<?php echo number_format($transactionItem['price'], 2); ?>
</div>