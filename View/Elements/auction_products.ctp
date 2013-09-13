<div class="products" id="elementAuctionProducts">

	<div class="row-fluid">
	<?php
    if (!empty($products)) {
        $i = 0;
        foreach ($products as $product) : ?>
        
        <div class="span11">
        	<div class="row">
        		<div class="span3">
					<?php echo $this->Element('thumb', array('model' => 'Product', 'foreignKey' => $product['Product']['id'], 'thumbSize' => 'medium', 'thumbLink' => '/products/products/view/'.$product['Product']['id']), array('plugin' => 'galleries')); ?>
				</div>
				<div class="span9">
					<?php echo $this->Html->link($product['Product']['name'] , array('controller' => 'products' , 'action'=>'view' , $product["Product"]["id"])); ?>
				</div>
			</div>
        </div>
        <div class="span1">
        	<div>$<?php echo (!empty($product['ProductPrice'][0]['price']) ? $product['ProductPrice'][0]['price'] : $product['Product']['price']); ?></div>
        </div>
        
        <?php
        endforeach;
    } else {
        echo __('<p>No products found. %s</p>', $this->Html->link('Add the first', array('plugin' => 'products', 'controller' => 'products', 'action' => 'add')));
    }
    ?>
	</div>

    <div class="indexContainer">
    <?php
    if (!empty($products)) {
        $i = 0;
        foreach ($products as $product) : ?>
            <div class="indexRow">
                <div class="indexCell galleryThumb imageCell" id="galleryThumb<?php echo $product['Product']['id']; ?>"> 
                    <?php echo $this->Element('thumb', array('model' => 'Product', 'foreignKey' => $product['Product']['id'], 'thumbSize' => 'medium', 'thumbLink' => '/products/products/view/'.$product['Product']['id']), array('plugin' => 'galleries')); ?>
                </div>
                <div class="indexCell itemDescription productDescription metaCell" id="productDescription<?php echo $product["Product"]["id"]; ?>"> 
                    <ul class="metaData">
                        <li><?php echo strip_tags($product['Product']['summary']); ?></li>
                        <?php if (!empty($product['ProductBrand'])) { ?>
                        <li class="itemBrand productBrand" id="productBrand<?php echo $product["Product"]["id"]; ?>"> <?php echo $this->Html->link($product['ProductBrand']['name'] , array('controller' => 'product_brands' , 'action'=>'view' , $product["ProductBrand"]["id"])); ?> </li>
                    <?php } ?>
                    </ul>
                </div>
                <div class="indexCell indexData">
                    <div class="indexCell itemName productName titleCell" id="productName<?php echo $product["Product"]["id"]; ?>">
                        <div class="recorddat">
                            <b><?php echo $this->Html->link($product['Product']['name'] , array('controller' => 'products' , 'action'=>'view' , $product["Product"]["id"])); ?></b>
                        </div>
                    </div>
                    <div class="indexCell itemPrice productPrice descriptionCell" id="productPrice<?php echo $product['Product']['id']; ?>"> 
                        <div class="recorddat">
                            <div class="truncate"><?php echo __('$'); ?><?php echo (!empty($product['ProductPrice'][0]['price']) ? $product['ProductPrice'][0]['price'] : $product['Product']['price']); ?></div>
                        </div>
                        <?php if (empty($product['Option']) && $product['Product']['is_buyable'] !== false) { ?>
                        <div class="indexCell itemAction productAction" id="productAction<?php echo $product['Product']['id']; ?>">
                            <?php echo $this->Element('cart_add', array('product' => $product), array('plugin' => 'products')); ?> 
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php
        endforeach;
    } else {
        echo __('<p>No products found. %s</p>', $this->Html->link('Add the first', array('plugin' => 'products', 'controller' => 'products', 'action' => 'add')));
    }
    ?>
    </div>
    <?php echo $this->Element('paging');?>
</div>