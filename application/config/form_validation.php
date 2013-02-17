<?php

$config = array(
    'page' => array(
        array(
            'field' => 'parent_id',
            'label' => 'Hoofd pagina of losse pagina',
            'rules' => 'trim|xxsclean',
        ),
        array(
            'field' => 'menu_title',
            'label' => 'Menu titel',
            'rules' => 'required|trim|xxsclean'
        ),
        array(
            'field' => 'browser_title',
            'label' => 'Browser titel',
            'rules' => 'required|trim|xxsclean'
        ),
        array(
            'field' => 'content_title',
            'label' => 'Content titel',
            'rules' => 'required|trim|xxsclean'
        ),
        array(
            'field' => 'content',
            'label' => 'Content',
            'rules' => 'trim|xxsclean'
        ),
        array(
            'field' => 'meta_keywords',
            'label' => 'Meta keywords',
            'rules' => 'trim|xxsclean'
        ),
        array(
            'field' => 'meta_description',
            'label' => 'Meta description',
            'rules' => 'trim|xxsclean'
        ),
        array(
            'field' => 'page_status',
            'label' => 'Pagina status',
            'rules' => 'required|xssclean'
        ),
        array(
            'field' => 'in_menu',
            'label' => 'Pagina in menu',
            'rules' => 'trim|xssclean',
        ),
    ),
    'page_update' => array(
        array(
            'field' => 'parent_id',
            'label' => 'Hoofd pagina of losse pagina',
            'rules' => 'trim|xxsclean',
        ),
        array(
            'field' => 'menu_title',
            'label' => 'Menu titel',
            'rules' => 'required|trim|xxsclean'
        ),
        array(
            'field' => 'browser_title',
            'label' => 'Browser titel',
            'rules' => 'required|trim|xxsclean'
        ),
        array(
            'field' => 'content_title',
            'label' => 'Content titel',
            'rules' => 'required|trim|xxsclean'
        ),
        array(
            'field' => 'content',
            'label' => 'Content',
            'rules' => 'trim|xxsclean'
        ),
        array(
            'field' => 'meta_keywords',
            'label' => 'Meta keywords',
            'rules' => 'trim|xxsclean'
        ),
        array(
            'field' => 'meta_description',
            'label' => 'Meta description',
            'rules' => 'trim|xxsclean'
        ),
        array(
            'field' => 'page_status',
            'label' => 'Pagina status',
            'rules' => 'required'
        ),
        array(
            'field' => 'in_menu',
            'label' => 'Pagina in menu',
            'rules' => 'trim|xssclean',
        ),
    ),
    'film' => array(
        array(
            'field' => 'name',
            'label' => 'Film naam',
            'rules' => 'required|trim|xxsclean'
        ),
        array(
            'field' => 'link',
            'label' => 'link',
            'rules' => 'trim|xxsclean'
        ),
        array(
            'field' => 'filmtext',
            'label' => 'filmtext',
            'rules' => 'trim|xxsclean'
        ),
        array(
            'field' => 'page_id',
            'label' => 'page_id',
            'rules' => 'trim|xxsclean|'
        ),
        
    ),
    'film_update' => array(
       array(
          'field' => 'name',
          'label' => 'Film naam',
          'rules' => 'required|trim|xxsclean'
      ),
       array(
            'field' => 'link',
            'label' => 'Film link',
            'rules' => 'trim|xxsclean'
        ),
        array(
            'field' => 'filmtext',
            'label' => 'filmtext',
            'rules' => 'trim|xxsclean'
        ),
        array(
            'field' => 'page_id',
            'label' => 'page_id',
            'rules' => 'trim|xxsclean'
        ),
    )
);