<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class AdminController extends AppController
{
    public $uses = array('Admin');

    public function beforeFilter()
    {
        parent::beforeFilter();
    }

    public function popupUser()
    {
        $this->layout = false;
    }

    public function add()
    {
        //   $this->layout = false;
    }

    public function changePassword()
    {
        $session_data = $this->Session->read('admin');
        if (empty($session_data)) {
            $this->redirect('/Admin');
        }
        //$title_for_layout
        $this->set(array(
            'title_for_layout' => 'Thay Đổi mật khẩu',
        ));

        if ($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;
            if (strlen($data['Admin']['password_new_2']) < 6) {
                $this->Session->setFlash(__('Mật khẩu ít nhất 6 kí tự'), 'messages/flash_error');
                $this->request->data['password'] = '';
                return $this->redirect($this->referer());
            }
            if ($data['Admin']['password_new_1'] != $data['Admin']['password_new_2']) {
                $this->Session->setFlash(__('Mật khẩu không trùng'), 'messages/flash_error');
                return $this->redirect($this->referer());
            }
            $exists = $this->Admin->find('first', array(
                'conditions' => array(
                    //"Admin.password" => $data["Admin"]["password"],
                    'Admin.id' => $session_data['Admin']['id'],
                ),
            ));
            if (!empty($exists)) {
                $exists['Admin']['password'] = $data['Admin']['password_new_1'];
                $this->Admin->create();
//                pr($exists["Admin"]);exit;
                $this->Admin->save($exists['Admin']);
                $this->Session->setFlash(__('Thay đổi thành công'), 'messages/flash_success');
                return $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(__('Thay đổi thất bại'), 'messages/flash_error');
            }
        }
    }

    public function index()
    {
        $this->layout = false;
        $this->set(array(
            'title_for_layout' => 'Login',
        ));
        $session_data = $this->Session->read('admin');
        if (!empty($session_data)) {
            $this->redirect('/');
        }
        //  $this->layout = false;
        if ($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;
            $exists = $this->Admin->find('first', array(
                'conditions' => array(
                    'Admin.username' => $data['Admin']['username'],
                    'Admin.password' => $data['Admin']['password'],
                ),
            ));
            if (!empty($exists)) {
                $this->Session->write('admin', $exists);
                $this->redirect('/');
            } else {
                $this->request->data['Admin']['password'] = '';
                $this->Session->setFlash(__('Đăng nhập thất bại'), 'messages/flash_error');
            }
        }
    }

    public function logout()
    {
        $this->Session->delete('admin');
        $this->redirect(
                array(
                    'controller' => 'Admin',
                    'action' => 'index',
        ));
    }
}
