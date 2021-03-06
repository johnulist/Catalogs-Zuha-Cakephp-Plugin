<?php
/**
 * Products Admin Add View
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2012, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.products.views
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
 ?>
<div class="row products">
	<div class="span3 col-md-4" id="productNav">
	    <ul class="list-group nav-list">
	        <li class="list-group-item"><a class="tab-trigger" data-target="#productDetails"><i class="icon-chevron-right"></i> Product Information</a></li>
	        <li class="list-group-item"><a class="tab-trigger" data-target="#optionalDetails"><i class="icon-chevron-right"></i> Optional Details</a></li>
	        <li class="list-group-item"><a class="tab-trigger" data-target="#productImages"><i class="icon-chevron-right"></i> Product Images</a></li>
	        <li class="list-group-item"><a class="tab-trigger" data-target="#productVariants"><i class="icon-chevron-right"></i> Product Variants</a></li>
	        <li class="list-group-item"><a class="tab-trigger" data-target="#shippingDetails"><i class="icon-chevron-right"></i> Shipping Details</a></li>
	        <li class="list-group-item"><a class="tab-trigger" data-target="#productCategorization"><i class="icon-chevron-right"></i> Categorization</a></li>
	        <li class="list-group-item"><a data-target="#optionForm">Add Variant Group</a>
	        <?php
	        $addVariantForm = $this->Form->create('Product') . $this->Form->input('Product.id') . $this->Form->input('Override.redirect', array('type' => 'hidden', 'value' => $this->request->here)) . $this->Form->input('Option.0.name', array('label' => false, 'value' => '', 'placeholder' => 'Group Name (eg. Sizes)', 'class' => 'span2')) . $this->Form->end('Submit');
	
	        if (count($existingOptions) < 3 && empty($this->request->data['Product']['parent_id'])) {
	            echo '<div id="optionForms">';
	            echo !empty($options) ? __('<small class="pull-right">%s</small> %s', $this->Html->link('new', '#', array('class' => 'newOptionType', 'data-target' => '#Option0Name')), $this->Form->create('Product') . $this->Form->input('Override.redirect', array('type' => 'hidden', 'value' => $this->request->here)) . $this->Form->input('Product.id') . $this->Form->input('Option.Option.0', array('class' => 'span2', 'label' => false, 'type' => 'select', 'options' => $options)) . $this->Form->end('Add Attribute to Product')) . __('<small class="pull-right">%s</small> %s', $this->Html->link('cancel', '', array('class' => 'cancelOptionType', 'data-target' => '#OptionOption0')), $addVariantForm) : __('<h5>Add Variant Type</h5> %s', $addVariantForm); 
	            echo '</div>';
	        }?>
	        </li>
	    </ul>
	</div>
	<div class="products productAdd form pull-right span8 col-md-8" data-spy="scroll" data-target="#productNav">
		<?php echo $this->Form->create('Product', array('type' => 'file')); ?>
	    <fieldset id="productDetails">
	        <legend class="sectionTitle"><?php echo __d('products', 'Product Information'); ?></legend>
	    	<?php
			echo $this->Form->input('Product.id');
			echo $this->Form->input('Product.model', array('type' => 'hidden')); // added for beef to edit a credit product, seems like we can have this field here, because it should have a value 3/9/2014 RK
			echo $this->Form->input('Product.name', array('label' => 'Display Name'));
	        echo $this->Form->input('Product.price', array('label' => 'Retail Price <small><em>(ex. 0000.00)</em></small>', 'step' => '0.01', 'min' => '0', 'max' => '99999999999'));
			echo $this->Form->input('Product.description', array('type' => 'richtext', 'label' => 'What is the sales copy for this item?')); ?>
	    </fieldset>
	    <fieldset id="optionalDetails">
	        <legend class="toggleClick"><?php echo __d('products', 'Optional product details'); ?></legend>
	        <?php
	    	echo $this->Form->input('Product.sku', array('label' => 'SKU'));
	        echo $this->Form->input('Product.summary', array('type' => 'text', 'label' => 'Promo Text'));
			echo $this->Form->input('Product.product_brand_id', array('empty' => '-- Select --', 'label' => 'What is the brand name for this product? ('.$this->Html->link('add', array('controller' => 'product_brands', 'action' => 'add')).' / '.$this->Html->link('edit', array('controller' => 'product_brands', 'action' => 'index')).' brands)'));
			echo $this->Form->input('Product.stock', array('label' => 'Would you like to track inventory?'));
	        echo $this->Form->input('Product.cost', array('label' => 'What does the product cost you? <br /><small><em>Used if you get profit reports</em></small>', 'between'=>'<span class="add-on">$</span>', 'div'=>array('class'=>'input-prepend')));
			echo $this->Form->input('Product.cart_min', array('label' => 'Minimun Cart Quantity? <br /><small><em>Enter the minimum cart quantity or leave blank for 1</em></small>'));
			echo $this->Form->input('Product.cart_max', array('label' => 'Maximum Cart Quantity? <br /><small><em>Enter the max cart quantity or leave blank for unlimited</em></small>'));
	        echo $this->Form->input('Product.is_public', array('default' => 1, 'label' => 'Published'));
	        echo $this->Form->input('Product.is_buyable', array('default' => 1, 'label' => 'Buyable')); ?>
	    </fieldset>
	    <fieldset id="productImages">
	        <legend class="toggleClick"><?php echo __d('products', 'Product images'); ?></legend>
	        <?php echo CakePlugin::loaded('Media') ? $this->element('Media.selector', array('media' => $this->request->data['Media'], 'multiple' => true)) : null; ?>
	    </fieldset>    
	    <fieldset id="productVariants">
	        <legend class="toggleClick"><?php echo __d('products', 'Production Variations'); ?></legend>
	        <div class="modal hide fade" id="variantModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                <h3 id="myModalLabel">Add Variant of <?php echo $this->request->data['Product']['name']; ?></h3>
	            </div>
	            <div class="modal-body"></div>
	        </div>
	        <?php
	        // list of variants (think about moving to the controller, or an element for reuse)
	        echo !empty($existingOptions) ? __('<hr class="clear" /><h5>Variants %s</h5>', $this->Html->link(__('Add Variant'), array('controller' => 'products', 'action' => 'add', 'default', $this->request->data['Product']['id']), array('class' => 'btn btn-mini', 'data-toggle' => 'modal', 'data-target' => '#variantModal'))) : null;
	        if (!empty($this->request->data['Children'])) {
	            foreach ($this->request->data['Children'] as $child) {
	                if (!empty($child['Option'])) {
	                    foreach ($child['Option'] as $variant) {
	                        $variants[$child['id']][] = $variant['name'];  
	                        unset($variant);
	                    } 
	                    echo __('<p>%s %s %s</p>', $this->Html->link(__('edit'), array('action' => 'edit', key($variants), '1'), array('class' => 'btn btn-primary btn-mini')), $this->Html->link(__('delete'), array('action' => 'delete', key($variants)), array('class' => 'btn btn-danger btn-mini'),  'Are you sure?'), $this->Html->link(implode(', ', $variants[key($variants)]), array('action' => 'edit', key($variants), '1')));
	                    unset($variants);
	                }
	            }
	        }
	        if (!empty($existingOptions)) {
	            echo __('<hr /><h5>Available Variant Types</h5>');
	            foreach ($existingOptions as $key => $value) {
	                echo __('<p>%s %s</p>', $this->Html->link('delete', array('action' => 'delete', $this->request->data['Product']['id'], $key), array('class' => 'btn btn-mini btn-primary'), 'Are you sure? This will delete related variant products!'), $value);
	            }
	        } else {
	            echo __('<p>%s</p>', $this->Html->link(__('Add a variant group to add variants.'), '', array('data-target' => '#optionForms',  'class' => 'toggleClick')));
	        } ?>
	    </fieldset>
		<fieldset id="shippingDetails">
	 		<legend class="toggleClick"><?php echo __d('products', 'Do you offer shipping for this product?');?></legend>
	    	<?php
			$fedexSettings = defined('__ORDERS_FEDEX') ? unserialize(__ORDERS_FEDEX) : null;
			$radioOptions = array();
			if (!empty($fedexSettings)) {
	            foreach($fedexSettings as $k => $val) {
	    			$radioOptions[$k] = $val ;
	    			echo $this->Form->input('Product.weight', array('label' => 'Weight (lbs)'));
	    			echo $this->Form->input('Product.height', array('label' => 'Height (8-70 inches)'));
	    			echo $this->Form->input('Product.width', array('label' => 'Width (50-119 inches)'));
	    			echo $this->Form->input('Product.length', array('label' => 'Length (50-119 inches)'));
			    }
	        }
			$radioOptions += array('FIXEDSHIPPING' => 'FIX SHIPPING', 'FREESHIPPING' => 'FREE SHIPPING') ;
			echo $this->Form->input('Product.shipping_type', array('legend' => false, 'options' => $radioOptions, 'class' => 'shipping_type' , 'default' => ''));
		 	echo $this->Form->input('Product.shipping_charge'); ?>
	    </fieldset>
	    
	    <?php if (empty($this->request->data['Product']['parent_id']) && in_array('Categories', CakePlugin::loaded())) { ?>
		<fieldset id="productCategorization">
	 		<legend class="toggleClick"><?php echo __d('products', 'Does this product belong to a category?');?></legend>
			<?php echo $this->Form->input('Category', array('multiple' => 'checkbox', 'selected' => $selectedCategories, 'label' => __('Choose categories (%s)', $this->Html->link('edit', array('action' => 'categories'))))); ?>
		</fieldset>
	    <?php } ?>
		
		<?php if(!empty($paymentOptions)) { ?>
	    <fieldset>
	        <legend class="toggleClick"><?php echo __d('products', 'Select Payment Types For The Item.');?></legend>
	        <?php
	            echo $this->Form->input('Product.payment_type', array('options' => $paymentOptions, 'multiple' => 'checkbox'));
	        ?>
	    </fieldset>
		<?php } 
	    echo $this->Form->submit('Save & Continue', array('name' => 'SaveAndContinue', 'class' => 'btn pull-right'));
		
	    echo $this->Form->end('Save'); ?>
	</div>
</div>

<script type="text/javascript">
$(function() {
    $(document).ready( function(){
        // animation 
        var offset = $('#productNav').offset().top;
        $('#productNav a.tab-trigger').click(function(e) {
            e.preventDefault();
            var wait = $('legend.toggleClick').siblings().length;
            var i = 1;
            var me = $(this);
            $('legend.toggleClick').siblings().hide('fast', function() {
                if(i == wait) {
                    var navTo = $(me.attr('data-target')).offset().top;
                    $('#productNav a').parent().removeClass('active');
                    me.parent().addClass('active');
                    $('html, body').animate({ scrollTop: navTo - offset }, 800, function() {
                        $('legend.toggleClick', me.attr('data-target')).siblings().show('slow');
                    });
                }
                ++i;
            });
        });
        // side nav clean up
        $('#productNav a[data-target="#productDetails"]').parent().addClass('active');
        $('body').css('padding-bottom', '800px');
        
        
        if($('input.shipping_type:checked').val() == 'FIXEDSHIPPING') {
            $('#ShippingPrice').show();
        } else {
            $('#ShippingPrice').hide();
        }

        var shipTypeValue = null;
        $('input.shipping_type').click(function(e){
            shipTypeValue = ($('input.shipping_type:checked').val());
            if(shipTypeValue == 'FIXEDSHIPPING') {
                $('#ProductShippingCharge').parent().show();
            } else {
                $('#ProductShippingCharge').parent().hide();
            }

        });

        $('.cancelOptionType').parent().hide();
        $('.cancelOptionType').parent().next().hide();
        $('.newOptionType, .cancelOptionType').click(function(e){
            e.preventDefault();
            $(this).parent().hide();
            $(this).parent().next().hide();
            $($(this).attr('data-target')).parent().parent().show();
            $($(this).attr('data-target')).parent().parent().prev().show();
        });
    });
});

</script>



<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
    array(
		'heading' => 'Products',
		'items' => array(
			$this->Html->link(__('Dashboard'), array('admin' => true, 'controller' => 'products', 'action' => 'dashboard')),
			)
		),
    array(
    	'heading' => 'Products',
		'items' => array(
			$this->Html->link(__('List'), array('controller' => 'products', 'action' => 'index')),
            $this->Html->link(__('View'), array('controller' => 'products', 'action' => 'view', $this->request->data['Product']['id'])),
			$this->Html->link(__('Delete'), array('controller' => 'products', 'action' => 'delete', $this->request->data['Product']['id']), array(), 'Are you sure? (cannot be undone)'),
    		)
		),
	))); ?>




<?php /*
 * 

<div class="hero-unit pull-left first span3">
    <div class="modal hide fade" id="variantModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Add Variant of <?php echo $this->request->data['Product']['name']; ?></h3>
        </div>
        <div class="modal-body"></div>
    </div>
    <?php
    echo $this->Element('gallery', array('model' => 'Product', 'foreignKey' => $this->request->data['Product']['id']), array('plugin' => 'galleries'));
    echo $this->Html->link('Edit Gallery', array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'edit', 'Product', $this->request->data['Product']['id'])); 
    // list of variants (think about moving to the controller, or an element for reuse)
    echo !empty($existingOptions) ? __('<hr class="clear" /><h5>Variants %s</h5>', $this->Html->link(__('Add Variant'), array('controller' => 'products', 'action' => 'add', 'default', $this->request->data['Product']['id']), array('class' => 'btn btn-mini', 'data-toggle' => 'modal', 'data-target' => '#variantModal'))) : null;
    if (!empty($this->request->data['Children'])) {
        foreach ($this->request->data['Children'] as $child) {
            if (!empty($child['Option'])) {
                foreach ($child['Option'] as $variant) {
                    $variants[$child['id']][] = $variant['name'];  
                    unset($variant);
                } 
                echo __('<p>%s %s %s</p>', $this->Html->link(__('edit'), array('action' => 'edit', key($variants), '1'), array('class' => 'btn btn-primary btn-mini')), $this->Html->link(__('delete'), array('action' => 'delete', key($variants)), array('class' => 'btn btn-danger btn-mini'),  'Are you sure?'), $this->Html->link(implode(', ', $variants[key($variants)]), array('action' => 'edit', key($variants), '1')));
                unset($variants);
            }
        }
    }
    if (!empty($existingOptions)) {
        echo __('<hr /><h5>Available Variant Types</h5>');
        foreach ($existingOptions as $key => $value) {
            echo __('<p>%s %s</p>', $this->Html->link('delete', array('action' => 'delete', $this->request->data['Product']['id'], $key), array('class' => 'btn btn-mini btn-primary'), 'Are you sure? This will delete related variant products!'), $value);
        }
    }
    $addVariantForm = $this->Form->create('Product') . $this->Form->input('Product.id') . $this->Form->input('Override.redirect', array('type' => 'hidden', 'value' => $this->request->here)) . $this->Form->input('Option.0.name', array('label' => false, 'value' => '')) . $this->Form->end('Submit');
    
    if (count($existingOptions) < 3 && empty($this->request->data['Product']['parent_id'])) {
        echo !empty($options) ? __('<hr /><h5>Add Variant Type <small>%s</small></h5>%s', $this->Html->link('add new', '#', array('class' => 'newOptionType', 'data-target' => '#Option0Name')), $this->Form->create('Product') . $this->Form->input('Override.redirect', array('type' => 'hidden', 'value' => $this->request->here)) . $this->Form->input('Product.id') . $this->Form->input('Option.Option.0', array('label' => false, 'type' => 'select', 'options' => $options)) . $this->Form->end('Add Available Variant Type')) . __('<h5>Add Variant Type <small>%s</small></h5> %s', $this->Html->link('cancel', '#', array('class' => 'cancelOptionType', 'data-target' => '#OptionOption0')), $addVariantForm) : __('<h5>Add Variant Type</h5> %s', $addVariantForm); 
    } ?>
</div>
 */