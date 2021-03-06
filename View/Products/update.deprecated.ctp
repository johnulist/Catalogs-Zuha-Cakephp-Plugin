<div class="products form update">
  <h2>
  Existing Attributes
  </h3>
  <table>
    <tr>
      <th>Option</th>
      <th>Quantity</th>
      <th>Action</th>
    <tr>
      <?php
	foreach($product['Children'] as $child) : ?>
      <?php #debug($child); ?>
    <tr>
      <?php
		$optionName = '';
		foreach($child['CategoryOption'] as $option) :
			$optionName .= $option['name'] . ', ';
		endforeach;?>
      <td><?php echo $optionName; ?></td>
      <td><?php echo $child['stock']; ?></td>
      <td><?php echo $this->Html->link('Edit', array('action' => 'edit', $child['id'])); ?> <?php echo $this->Html->link('Delete', array('action' => 'delete', $child['id'])); ?></td>
    </tr>
    <?php
    endforeach; ?>
  </table>
  <fieldset>
    <legend class="toggleClick"> <?php echo __('Set inventory and options for %s attributes', $product['Product']['name']); ?></legend>
    <?php
	echo $this->Form->create('Product', array('action' => 'update', 'type' => 'file'));
	echo __('Its important that you select one attribute from each group to make a full description of the product.  (for example :  Large, Green T-shirt [SAVE]; Large, Blue T-shirt [SAVE];  Small, Green T-shirt [SAVE]; etc.), and do not duplicate an already set attribute combination before deleting any matching existing combination(s).'); ?>
    <fieldset id="attributeResults"></fieldset>
    <?php
	echo $this->Form->hidden('Product.parent_id', array('value' => $product['Product']['id']));
	echo $this->Form->input('GalleryImage.filename', array('type' => 'file', 'label' => 'Will the selected attribute(s) use different pictures than the ' . $product['Product']['name'], 'after' => ' You can add additional images after save.'));
    echo $this->Form->input('price', array('label' => 'Will the selected attribute(s) change the price?', 'after' => ' (Leave blank to use ' . $product['Product']['name'] . '\'s price)'));
    echo $this->Form->input('sku', array('label' => 'Will this use a new SKU?', 'after' => ' (Leave blank to use current sku: ' . $product['Product']['sku'] ));
    ?>
    <fieldset>
      <legend class="toggleClick"><?php echo __('Add ARB settings for option?');?></legend>
      <?php echo $this->Form->input('Product.arb_settings', array('rows'=>1, 'cols' => 30,'label' => 'Arb Settings')); ?>
    </fieldset>
  </fieldset>
  <?php echo $this->Form->end('Save');?> </div>
<script type="text/javascript">
$(document).ready(function() {
	var id = $('#ProductParentId').val();
	getProduct(id);

	$('#ProductParentId').change(function(e){
		var id = $(this).val();
		getProduct(id);
	});

	function getProduct(id) {
		$.ajax({
	        type: "POST",
			url: "/products/products/get_product/" + id ,
	        dataType: "html",
	        success:function(data){
	        	$('#attributeResults').html(data);
	        }
	    });
	}
});
</script>
