<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

define('PAGE_FIRST_LINK', 25);
define('PAGE_LAST_LINK', 26);
define('PAGE_NEXT_LINK', 27);
define('PAGE_PREV_LINK', 28);
define('PAGE_FULL_TAG_OPEN', 29);
define('PAGE_FULL_TAG_CLOSE', 30);
define('PAGE_NUM_TAG_OPEN', 31);
define('PAGE_NUM_TAG_CLOSE', 32);
define('PAGE_CUR_TAG_OPEN', 33);
define('PAGE_CUR_TAG_CLOSE', 34);
define('PAGE_NEXT_TAG_OPEN', 35);
define('PAGE_NEXT_TAG_CLOSE', 36);
define('PAGE_PREV_TAG_OPEN', 37);
define('PAGE_PREV_TAG_CLOSE', 38);
define('PAGE_FIRST_TAG_OPEN', 39);
define('PAGE_FIRST_TAG_CLOSE', 40);
define('PAGE_LAST_TAG_OPEN', 41);
define('PAGE_LAST_TAG_CLOSE', 42);
define('PAGE_NUM_LINKS', 43);
define('PAGE_USE_PAGES_NUM', 57);
define('PAGE_QRY_STRING', 58);
define('PAGE_ENABLE_QRY_STRING', 59);
define('PAGE_REUSE_QRY_STRING', 60);
define('PAGE_DISPLAY_PAGES', 61);

class MY_Pagination extends CI_Pagination
{
  public function __construct()
  {
    parent::__construct();
  }

  // @url api urls
  public function page($url)
  {
    //default using twitter bootstrap
    return array(
      //show n digit before and after on current page
      'base_url'  =>  $url,
      'num_links' =>  $this->config->default_cfg(PAGE_NUM_LINKS, 2),
      //show actual number page
      'use_page_numbers'  =>  $this->config->default_cfg(PAGE_USE_PAGES_NUM, 'false'),
      'page_query_string' =>  $this->config->default_cfg(PAGE_QRY_STRING, 'false'),
      'enable_query_strings'  =>  $this->config->default_cfg(PAGE_ENABLE_QRY_STRING, 'false')
      'reuse_query_string'  =>  $this->config->default_cfg(PAGE_REUSE_QRY_STRING, 'false'),
      'first_link' =>  $this->config->default_cfg(PAGE_FIRST_LINK,'First'),
      'first_tag_open'  =>  $this->config->default_cfg(PAGE_FULL_TAG_OPEN, '<li class="page-item"><span class="page-link">'),
      'first_tag_close' =>  $this->config->default_cfg(PAGE_FIRST_TAG_CLOSE, '</span></li>'),
      //alternate url for first link
      // 'first_url' =>  $this->config->default_cfg(PAGE_FIR),
      'last_link' =>  $this->config->default_cfg(PAGE_LAST_LINK, 'Last'),
      'last_tag_open' =>  $this->config->default_cfg(PAGE_LAST_TAG_OPEN, '<li class="page-item"><span class="page-link">'),
      'last_tag_close' =>  $this->config->default_cfg(PAGE_LAST_TAG_CLOSE, '</span></li>'),
      //custom next link
      'next_link' =>  $this->config->default_cfg(PAGE_NEXT_LINK, 'Next'),
      'next_tag_open' =>  $this->config->default_cfg(PAGE_NEXT_TAG_OPEN, '<li class="page-item"><span class="page-link">'),
      'next_tag_close' =>  $this->config->default_cfg(PAGE_NEXT_TAG_CLOSE, '<span aria-hidden="true">&raquo;</span></span></li>'),
      'prev_link' =>  $this->config->default_cfg(PAGE_PREV_LINK,'Prev'),
      'prev_tag_open' =>  $this->config->default_cfg(PAGE_PREV_TAG_OPEN, '<li class="page-item"><span class="page-link">'),
      'prev_tag_close' =>  $this->config->default_cfg(PAGE_PREV_TAG_CLOSE, '</span>Next</li>'),
      //custom current page
      'cur_tag_open' =>  $this->config->default_cfg(PAGE_CUR_TAG_OPEN, '<li class="page-item active"><span class="page-link">'),
      'cur_tag_close' =>  $this->config->default_cfg(PAGE_CUR_TAG_CLOSE, '<span class="sr-only">(current)</span></span></li>'),
      //custom digit link
      'num_tag_open' =>  $this->config->default_cfg(PAGE_NUM_TAG_OPEN, '<li class="page-item"><span class="page-link">'),
      'num_tag_close' =>  $this->config->default_cfg(PAGE_NUM_TAG_CLOSE, '</span></li>'),
      //hide current id_page
      'display_pages' =>  $this->config->default_cfg(PAGE_DISPLAY_PAGES, 'false'),
      'full_tag_open' =>  $this->config->default_cfg(PAGE_FULL_TAG_OPEN, '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">'),
      'full_tag_close' =>  $this->config->default_cfg(PAGE_FULL_TAG_CLOSE, '</ul></nav></div>'),
    )
  }
}
