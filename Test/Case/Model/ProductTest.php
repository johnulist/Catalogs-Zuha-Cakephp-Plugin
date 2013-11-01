<?php
App::uses('Product', 'Products.Model');

/**
 * Product Test Case
 *
 */
class ProductTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
        'app.Alias',
        'app.Meta',
        'plugin.Contacts.Contact',
        'plugin.Categories.Category',
        'plugin.Categories.Categorized',
        'plugin.Categories.CategorizedOption',
        'plugin.Galleries.Gallery',
        'plugin.Galleries.GalleryImage',
        'plugin.Products.Product',
        'plugin.Products.ProductBid',
        'plugin.Products.ProductBrand',
        'plugin.Products.ProductOption',
        'plugin.Products.ProductPrice',
        'plugin.Products.ProductStore',
        'plugin.Products.ProductsProductOption',
        'plugin.Webpages.Webpage',
        'plugin.Users.User'
        );
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Product = ClassRegistry::init('Products.Product');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Product);
		parent::tearDown();
	}

/**
 * Test expire
 * 
 */
 	public function testExpire() {
 		$this->Product->notifications = false; // supress notifications so that we don't need a fixture for them
 		$data = array(
			'Product' => array(
				'id' => '5249c848-f100-4cc4-a0b0-04df0ad25527',
				'name' => 'Brown Cow',
				'description' => '<p>How now, brown cow?</p>',
				'price' => '45',
				'is_expired' => 0,
				'started' => '2013-09-30 11:50:00',
				'ended' => '2013-10-20 11:50:00',
				'type' => 'auction'
			)
		);
		$this->Product->create();
		$this->Product->save($data);
		$results = $this->Product->expire($data, array('email' => false));
		$results = $this->Product->find('first', array('conditions' => array('Product.id' => $data['Product']['id'])));
		$this->assertTrue($results['Product']['is_expired']); ///this should be expired
		
		$results = array(
			(int) 0 => array(
				'Product' => array(
					'id' => '4249c848-f100-4cc4-a0b0-04df0ad25528',
					'name' => 'Brown Cow',
					'description' => '<p>How now, brown cow?</p>',
					'price' => '16',
					'is_expired' => 0,
					'started' => '2013-09-30 11:50:00',
					'ended' => date('Y-m-d h:i:s', strtotime('+3 days')),
					'type' => 'auction'
				),
			)
		);
		$results = $this->Product->expire($results, array('email' => false));
		$this->assertTrue($results[0]['Product']['is_expired'] === 0); //this should not expire
 	}

/**
 * testExpireEmpty method
 */
 	public function testExpireEmpty() {
 		$this->Product->notifications = false; // supress notifications so that we don't need a fixture for them
 		// if the first parameter in expire is empty then 
 		$data[] = array(
			'Product' => array(
				'name' => 'Brown Cow',
				'stock' => null,
				'price' => '45.00',
				'is_expired' => 0,
				'started' => '2013-09-30 11:50:00',
				'ended' => '2013-10-20 11:50:00',
				'type' => 'auction'
			)
		);
		$data[] = array(
			'Product' => array(
				'name' => 'Brown Cow',
				'stock' => null,
				'price' => '18.00',
				'is_expired' => 0,
				'started' => '2013-09-30 11:50:00',
				'ended' => '2013-10-24 11:50:00',
				'type' => 'auction'
			)
		);
		$this->Product->create();
		$this->Product->saveAll($data);
 		$this->Product->expire(array(), array('email' => false));
		$results = Set::extract('/Product/is_expired', $this->Product->find('all'));
		$this->assertTrue(array(true, true) == $results);  // both products should have been expired
 	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testSave() {
        $testData = array(
            'Product' => array(
                'is_public' => '1',
                'name' => 'Lorem ipsum',
                'sku' => '',
                'price' => '93.00',
                'summary' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut pretium est sed risus malesuada mollis.',
                )
            );
      
        $this->Product->save($testData);
        $result = $this->Product->findById($this->Product->id);
        $this->assertEqual($result['Product']['id'], $this->Product->id);  // make sure the item was added
        $this->assertTrue(!empty($result['Product']['sku']));  // the sku should be filled automatically when it's empty
	}
/**
 * testSaveWithMeta method
 *
 * @return void
 */
    public function testSaveWithMeta() {
		$product = array(
			'Product' => array(
				'id' => '50b00085-a8bc-498d-93fa-17f345a3a949',
				'parent_id' => null,
				'lft' => '3',
				'rght' => '4',
				'sku' => '76628',
				'name' => 'Townhouse',
				'summary' => 'If you don\'t see this today, it will be gone tomorrow.',
				'description' => '<p>Lorem ipsum dolor at tincidunt id, dapibus vitae sem. Pellentesque eget odio ut quam bibendum placerat eget consectetur sem.</p>',
				'price' => '1400',
				'Meta' => array(
					'location' => 'Geneva',
					'bedrooms' => '3'
					)
				)
			);
        $this->Product->save($product);
        $result = $this->Product->findById($this->Product->id);
        $this->assertEqual($result['Product']['Meta']['location'], $product['Product']['Meta']['location']);
	}
    
/**
 * testDelete method
 * 
 */
    public function testDelete() {
        $testData = array(
            'Product' => array(
                'is_public' => '1',
                'name' => 'Lorem ipsum',
                'sku' => '',
                'price' => '93.00',
                'summary' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut pretium est sed risus malesuada mollis.',
                ),
            );
		$this->Product->create();
        $this->Product->save($testData);
		$id = $this->Product->id;
        $result = $this->Product->find('first', array('conditions' => array('Product.id' => $id)));
        $this->assertTrue(!empty($result)); // product was created
        try {
           $this->Product->delete($id);            
        } catch (PdoException $e) {
            debug($e->getMessage());
            break;
        }
        $result = $this->Product->find('first', array('conditions' => array('Product.id' => $this->Product->id)));
        $this->assertTrue(empty($result)); // product should be gone
    }
    
/**
 * testCleanItemPrice method
 *
 * @return void
 */
	public function testCleanItemPrice() {
		$price = array(
			'Product' => array(
				'id' => '50b00085-a8bc-498d-93fa-17f345a3a949',
				'parent_id' => null,
				'lft' => '3',
				'rght' => '4',
				'sku' => '76628',
				'name' => 'Townhouse',
				'summary' => 'If you don\'t see this today, it will be gone tomorrow.',
				'description' => '<p>Lorem ipsum dolor at tincidunt id, dapibus vitae sem. Pellentesque eget odio ut quam bibendum placerat eget consectetur sem.</p>',
				'price' => '1400',
				'Meta' => array(
					'location' => 'Geneva',
					'bedrooms' => '3'
					)
				)
			);
		$result = $this->Product->cleanItemPrice($price);
		$this->assertEqual(strpos($result['Product']['price'], ','), false); // there should not be commas in the price return from the model (it doesn't work in forms)
	}
}
