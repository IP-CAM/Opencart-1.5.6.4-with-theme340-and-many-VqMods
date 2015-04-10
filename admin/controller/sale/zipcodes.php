<?php

class ControllerSaleZipcodes extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('sale/zipcodes');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sale/zipcode');

        $this->getList();
    }

    public function getList() {

        if (isset($this->request->get['filter_zipcode'])) {
            $filter_zipcode = $this->request->get['filter_zipcode'];
        } else {
            $filter_zipcode = null;
        }

        if (isset($this->request->get['filter_status'])) {
            $filter_status = $this->request->get['filter_status'];
        } else {
            $filter_status = null;
        }
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['token'] = $this->session->data['token'];

        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('sale/zipcodes', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        $this->data['button_filter'] = $this->language->get('button_filter');
        $this->data['button_insert'] = $this->language->get('button_insert');
        $this->data['entry_zipcode'] = $this->language->get('entry_zipcode');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['filter_zipcode'] = $filter_zipcode;
        $this->data['filter_status'] = $filter_status;
        $this->data['text_confirm_zipcode'] = $this->language->get('text_confirm_zipcode');
        $filter_data['filter_zipcode'] = $filter_zipcode;
        $filter_data['filter_status'] = $filter_status;
        $this->data['column_action'] = $this->language->get('column_action');
        $this->data['column_date_created'] = $this->language->get('column_date_created');
        $this->data['column_date_modified'] = $this->language->get('column_date_modified');

        if (isset($this->request->post['selected'])) {
            $this->data['selected'] = (array) $this->request->post['selected'];
        } else {
            $this->data['selected'] = array();
        }

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }
        $url = '';

        if (isset($this->request->get['filter_zipcode'])) {
            $url .= '&filter_zipcode=' . $this->request->get['filter_zipcode'];
        }
        $filter_data['start'] = ($page - 1) * $this->config->get('config_admin_limit');
        $filter_data['limit'] = $this->config->get('config_admin_limit');

        $result = $this->model_sale_zipcode->getZipcodes($filter_data);
        if ($result) {
            foreach ($result as $row) {
                $action = array();
                $action[] = array(
                    'text' => $this->language->get('text_edit'),
                    'href' => $this->url->link('sale/zipcodes/add', 'token=' . $this->session->data['token'] . '&id=' . $row['id'] . $url, 'SSL'),
                );
                $this->data['zipcodes'][] = array('id' => $row['id'],
                    'zipcode' => $row['zipcode'],
                    'status' => $row['status'],
                    'date_created' => $row['timecreated'],
                    'date_modified' => $row['timemodified'],
                    'action' => $action
                );
            }
        } else {
            $this->data['zipcodes'] = array();
        }
        $this->data['insert'] = $this->url->link('sale/zipcodes/add', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['button_view'] = $this->language->get('button_view');
        $this->data['button_edit'] = $this->language->get('button_edit');
        $this->data['button_delete'] = $this->language->get('button_delete');

        $this->data['delete'] = $this->url->link('sale/zipcodes/delete', 'token=' . $this->session->data['token'].$url, 'SSL');

        $totalzipcodes = $this->model_sale_zipcode->getTotalZipcodes($filter_data);

        $pagination = new Pagination();
        $pagination->total = $totalzipcodes;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->url = $this->url->link('sale/zipcodes', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->data['text_no_results'] = $this->language->get('text_no_results');

        $this->template = 'sale/zipcodes.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function add() {
        $this->load->language('sale/zipcodes');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sale/zipcode');
        $this->data['error_warning'] = $this->data['success'] = '';

        if ($this->validate() && $this->request->server['REQUEST_METHOD'] == 'POST') {
            if (trim($_POST['zipcode']) == '') {
                $this->data['zipcode_required'] = $this->language->get('zipcode_required');
            } else {
                if (isset($_POST['id'])) {
                    $this->model_sale_zipcode->updateZipcode($_POST);
                    $this->data['success'] = $this->language->get('success_update');
                    $this->redirect($this->url->link('sale/zipcodes', 'token=' . $this->session->data['token'], 'SSL'));
                } else {
                    if (!$this->model_sale_zipcode->InsertZipcode($_POST)) {
                        $this->data['error_warning'] = $this->language->get('warning_zipcode');
                    } else {
                        $this->data['success'] = $this->language->get('success_add');
                    }
                }
            }
        }
        $this->getForm();
    }

    public function getForm() {

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');

        $url = '';

        if (isset($this->request->get['filter_zipcode'])) {
            $url .= '&filter_zipcode=' . $this->request->get['filter_zipcode'];
        }

        if (isset($this->request->get['id'])) {
            $url .= '&id=' . $this->request->get['id'];
            $this->data['id'] = $this->request->get['id'];
        }
        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->data['heading_title'],
            'href' => $this->url->link('sale/zipcodes', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );
        if (isset($this->request->get['id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $zipcode_info = $this->model_sale_zipcode->getZipcode($this->request->get['id']);
            $this->data['zipcode'] = $zipcode_info['zipcode'];
            $this->data['status'] = $zipcode_info['status'];
        } else {
            $this->data['zipcode'] = '';
            $this->data['status'] = 0;
        }
        $this->data['entry_zipcode'] = $this->language->get('entry_zipcode');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['add_zipcode'] = $this->language->get('add_zipcode');
        $this->data['update_zipcode'] = $this->language->get('update_zipcode');

        if (!isset($this->request->get['order_id'])) {
            $this->data['action'] = $this->url->link('sale/zipcodes/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $this->data['action'] = $this->url->link('sale/zipcodes/update', 'token=' . $this->session->data['token'] . '&id=' . $this->request->get['id'] . $url, 'SSL');
        }
        $this->data['cancel'] = $this->url->link('sale/zipcodes', 'token=' . $this->session->data['token'], 'SSL');

        $this->template = 'sale/zipcode_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function delete() {
        $this->language->load('sale/zipcodes');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sale/zipcode');

        if (isset($this->request->post['selected']) && ($this->validateDelete())) {
            foreach ($this->request->post['selected'] as $id) {
                $this->model_sale_zipcode->deleteZipcode($id);                
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_zipcode'])) {
                $url .= '&filter_zipcode=' . $this->request->get['filter_zipcode'];
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }            

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->redirect($this->url->link('sale/zipcodes', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getList();
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'sale/zipcode')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return true;
    }

    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'sale/zipcodes')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}
