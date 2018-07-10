<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['forms']['signup_rule'] = array(
    array(
        'field' =>  'username',
        'label' =>  'Username',
        'rules' =>  'required',
    ),
    array(
        'field' =>  'password',
        'label' =>  'Password',
        'rules' =>  'required|min_length[8]',
    ),
    array(
        'field' =>  'email',
        'label' =>  'Email',
        'rules' =>  'required|valid_email',
    ),
    array(
        'field' => 'realname',
        'label' => 'Realname',
        'rules' => 'required|alpha'
    ),
    //default roles will guest->writer->superuser->admin
    array(
        'field' =>  'roles',
        'label' =>  'Roles',
        'rules' =>  'required',
    ),
);

$config['forms']['signin_rule'] = array(
    array(
        'field' =>  'email',
        'label' =>  'Email',
        'rules' =>  'required|valid_email',
    ),
    array(
        'field' =>  'password',
        'label' =>  'Password',
        'rules' =>  'required',
    ),
);

$config['forms']['form_input'] = array(
    'f_username'    => array(
        'name'  => 'username',
        'id'    => 'username',
        'class' => 'input', 
        'type'  => 'text',
        'placeholder'   => 'Username',
    ),
    'f_email'       => array(
        'name'  => 'email',
        'id'    => 'email',
        'class' => 'input', 
        'type'  => 'email',
        'placeholder'   => 'Email',
    ),
    'f_password'    => array(
        'name'  => 'password',
        'id'    => 'password',
        'class' => 'input', 
        'type'  => 'password',
        'placeholder'   => 'Password',
    ),
    'f_phone'    => array(
        'name'  => 'phone',
        'id'    => 'phone',
        'class' => 'input', 
        'type'  => 'tel',
        'placeholder'   => 'Phone number',
    ),
    'f_article_title'   => array(
        'name'  => 'article_title',
        'id'    => 'article_title',
        'class' => 'input', 
        'type'  => 'text',
        'placeholder'   => 'Article Title',
    ),
    'f_article_meta'    => array(
        'name'  => 'article_meta',
        'id'    => 'article_meta',
        'class' => 'input', 
        'type'  => 'tags',
        'placeholder'   => 'Add tag',
    ),
    'f_upload'    => array(
        'name'  => 'upload',
        'id'    => 'upload',
        'class' => 'input', 
        'type'  => 'file',
        'placeholder'   => 'Upload',
    )
);

$config['forms']['form_hidden'] = array(
    'f_token'    => array(
        'name'  => 'article_meta',
        'id'    => 'article_meta',
        'class' => 'input', 
        'type'  => 'tags',
        'placeholder'   => 'Add tag',
    )
);

$config['forms']['form_button'] = array(
    'f_add'  => array(
        'name'  => 'btn_add',
        'id'    => 'btn_add',
        'value' => 'Add',
        'class' => 'button',
    ),
    'f_signin'   => array(
        'name'  => 'btn_signin',
        'id'    => 'btn_signin',
        'value' => 'Signin',
        'type'  => 'submit',
        'class' => 'button'
    ),
    'f_reset'   => array(
        'name'  => 'btn_reset',
        'id'    => 'btn_reset',
        'value' => 'Reset',
        'type'  => 'reset',
        'class' => 'button'
    ),
    'f_signout'   => array(
        'name'  => 'btn_signout',
        'id'    => 'btn_signout',
        'value' => 'Signout',
        'type'  => 'submit',
        'class' => 'button'
    ),
    'f_edit'    => array(
        'name'  => 'btn_edit',
        'id'    => 'btn_edit',
        'value' => 'Edit',
        'class' => 'button',
    ),
    'f_erase'   => array(
        'name'  => 'btn_delete',
        'id'    => 'btn_delete',
        'value' => 'Delete',
        'class' => 'button',
    ),
);

$config['forms']['contents_rule'] = array(
    array(
        'field' =>  'title',
        'label' =>  'Title',
        'rules' =>  'required',
    ),
    array(
        'field' =>  'kategori',
        'label' =>  'Kategori',
        'rules' =>  'required',
    ),
);