<?php
class ControllerCheckoutSuccess extends Controller { 
	public function index() {
    $order_id = '';
		if (isset($this->session->data['order_id'])) {
      //$order_id = $this->session->data['order_id'];
			$this->cart->clear();

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['guest']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);	
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);
			unset($this->session->data['totals']);
		}	
    if(isset($this->request->get['order_id'])) {
      $order_id = $this->request->get['order_id'];
    }

		$this->language->load('checkout/success');

		$this->document->setTitle($this->language->get('heading_title'));
    $this->data['email_confirmation'] = $this->language->get('email_confirmation');

		$this->data['breadcrumbs'] = array(); 

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('common/home'),
			'text'      => $this->language->get('text_home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('checkout/cart'),
			'text'      => $this->language->get('text_basket'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('checkout/checkout', '', 'SSL'),
			'text'      => $this->language->get('text_checkout'),
			'separator' => $this->language->get('text_separator')
		);	

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('checkout/success'),
			'text'      => $this->language->get('text_success'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		if ($this->customer->isLogged()) {
			$this->data['text_message'] = sprintf($this->language->get('text_customer'), $this->url->link('account/account', '', 'SSL'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/download', '', 'SSL'), $this->url->link('information/contact'));
		} else {
			$this->data['text_message'] = sprintf($this->language->get('text_guest'), $this->url->link('information/contact'));
		}

		$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['continue'] = $this->url->link('common/home');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/success.tpl';
		} else {
			$this->template = 'default/template/common/success.tpl';
		}
    if (!empty($order_id)) {
      $this->load->model('checkout/order');
      $this->data['order_info'] = $this->model_checkout_order->getOrder($order_id);
      
      $this->load->model('account/order');

      $products = $this->model_account_order->getOrderProducts($order_id);

      foreach ($products as $product) {
        $option_data = array();

        $options = $this->model_account_order->getOrderOptions($order_id, $product['order_product_id']);

        foreach ($options as $option) {
          if ($option['type'] != 'file') {
            $value = $option['value'];
          }
          else {
            $value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
          }

          $option_data[] = array(
              'name' => $option['name'],
              'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
          );
        }

        $this->data['products'][] = array(
            'name' => $product['name'],
            'model' => $product['model'],
            'option' => $option_data,
            'quantity' => $product['quantity'],
            'price' => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
            'total' => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
            'return' => $this->url->link('account/return/insert', 'order_id=' . $order_info['order_id'] . '&product_id=' . $product['product_id'], 'SSL')
        );
      }
    }
    $this->data['totals'] = $this->model_account_order->getOrderTotals($order_id);
    
    $this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'			
		);

		$this->response->setOutput($this->render());
	}
}
?>