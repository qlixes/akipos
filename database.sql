create table `roles`(
  `id` int unsigned not null auto_increment,
  `role_name` varchar(64) not null unique,
  `is_enable` int(1) not null default 1,
  primary key(`id`)
)collate='utf8_bin'; -- admin etc

create table `access`(
  `id` int unsigned not null auto_increment,
  `access_code` varchar(128) not null unique,
  primary key(`id`)
)collate='utf8_bin'; -- permissions

create table `role_access`(
    `id` int unsigned not null auto_increment,
    `role_id` int unsigned not null,
    `access_id` int unsigned not null,
    primary key(`id`)
  )collate='utf8_bin';

create table `province` (
  `id` int unsigned not null auto_increment,
  `province_code` varchar(16) not null,
  `province_name` varchar(64) not null,
  primary key(`id`)
)collate='utf8_bin';

create table `city` (
  `id` int unsigned not null auto_increment,
  `province_id` int unsigned not null,
  `city_code` varchar(16) not null,
  `city_name` varchar(64) not null,
  primary key(`id`)
)collate='utf8_bin'; -- tunggu database pusat

create table `store` (
  `id` int unsigned not null auto_increment,
  `store_code` varchar(16) not null unique,
  `store_name` varchar(128) not null,
  `store_address` text not null,
  `store_phone` varchar(64) not null,
  `store_email` varchar(128) not null,
  `city_id` int unsigned not null,
  `province_id` int unsigned not null,
  `is_enable` int(1) not null default 1,
  primary key(`id`)
)collate='utf8_bin';

create table `group` (
  `id` int unsigned not null auto_increment,
  `group_code` varchar(16) not null unique,
  `group_name` varchar(64) not null,
  primary key(`id`)
)collate='utf8_bin'; -- member, customer, mitra

create table `users` (
  `id` int unsigned not null auto_increment,
  `role_id` int unsigned not null,
  `uname` varchar(128) not null unique,
  `upass` varchar(255) not null,
  `secure_code` varchar(255) not null,
  `api_code` varchar(255) not null,
  `is_enable` int(1) not null default 1,
  primary key(`id`)
)collate='utf8_bin';

create table `users_info` (
  `id` int unsigned not null,
  `fullname` varchar(128) not null,
  `address` text not null,
  `phone` varchar(32) not null,
  `email` varchar(128) not null,
  `image_profile` varchar(128) not null default 'noimage.jpg',
  `facebook_id` varchar(128) not null default '-',
  `twitter_id` varchar(128) not null default '-',
  `gplus_id` varchar(128) not null default '-',
  `blog_id` varchar(128) not null default '-',
  primary key(`id`)
)collate='utf8_bin';

create table `users_store`(
  `id` int unsigned not null auto_increment,
  `users_id` int unsigned not null,
  `store_id` int unsigned not null,
  `is_default` int(1) not null default 0,
  `is_enable` int(1) not null default 1,
  primary key(`id`)
)collate='utf8_bin';

alter table `users_store` add constraint `fk_users_store1` foreign key (`users_id`) references `users`(`id`), add constraint `fk_users_store2` foreign key (`store_id`) references `store`(`id`), add constraint `idx_users_store` unique index `users_store`(`users_id`, `store_id`);

create table `configs` (
  `id` int unsigned not null auto_increment,
  `cfg_code` varchar(128) not null unique,
  `cfg_value` varchar(128) not null,
  `is_enable` int(1) not null default 1,
  primary key(`id`)
)collate='utf8_bin';

create table `member`(
  `id` int unsigned not null auto_increment,
  `member_code` varchar(32) not null unique,
  `member_name` varchar(64) not null, -- gold,silver dll
  primary key(`id`)
)collate='utf8_bin';

create table `payment` (
  `id` int unsigned not null auto_increment,
  `payment_code` varchar(32) not null unique,
  `payment_name` varchar(64) not null,
  primary key(`id`)
)collate='utf8_bin';

create table `terms` (
  `id` int unsigned not null auto_increment,
  `terms_code` varchar(128) not null unique,
  `terms_info` text not null,
  `terms_value` varchar(128) not null,
  primary key(`id`)
)collate='utf8_bin';

create table `payment_terms` (
  `id` int unsigned not null auto_increment,
  `payment_id` int unsigned not null,
  `terms_id` int unsigned not null,
  `final_value` varchar(128) not null,
  primary key(`id`)
)collate='utf8_bin';

create table `company` (
  `id` int unsigned not null auto_increment,
  `group_id` int unsigned not null, -- umum, mitra
  `member_id` int unsigned not null,
  `city_id` int unsigned not null,
  `company_code` varchar(64) not null unique,
  `company_fullname` varchar(128) not null,
  `company_id` varchar(32) not null,
  `company_license` varchar(32) not null,
  `company_birthday` date not null,
  `company_address` text not null,
  `company_phone` varchar(32) not null,
  `company_mobile` varchar(32) not null,
  `company_email` varchar(128) not null,
  `company_register` datetime not null,
  `is_enable` int(1) not null default 1,
  primary key(`id`)
) collate='utf8_bin';

create table `vehicles` (
  `id` int unsigned not null auto_increment,
  `vehicles_code` varchar(64) not null unique,
  `vehicles_brand` varchar(64) not null,
  `vehicles_type` varchar(64) not null,
  `vehicles_class` varchar(64) not null,
  primary key(`id`)
)collate='utf8_bin'; -- create unique index thdp brand,type,class

create table `company_vehicles` (
  `id` int unsigned not null auto_increment,
  `company_id` int unsigned not null,
  `vehicles_id` int unsigned not null,
  `vehicles_year` int(4) not null,
  `vehicles_number` varchar(16) not null,
  primary key(`id`)
)collate='utf8_bin'; -- cust_id,vehicles_id, nopol unique

create table `categories` (
  `id` int unsigned not null auto_increment,
  `category_code` varchar(32) not null unique,
  `category_name` varchar(128) not null,
  primary key(`id`)
)collate='utf8_bin'; -- kategori product

create table `brands` (
  `id` int unsigned not null auto_increment,
  `brand_code` varchar(32) not null unique,
  `brand_name` varchar(128) not null,
  primary key(`id`)
)collate='utf8_bin';

create table `types` (
  `id` int unsigned not null auto_increment,
  `types_code` varchar(32) not null unique,
  `types_name` varchar(128) not null,
  primary key(`id`)
)collate='utf8_bin';

create table `qty` (
  `id` int unsigned not null auto_increment,
  `qty_code` varchar(16) not null unique,
  primary key(`id`)
)collate='utf8_bin';

create table `pqty` ( -- product_qty
  `id` int unsigned not null auto_increment,
  `qty_mst` int unsigned not null, -- qty_id
  `qty_det` int unsigned not null,
  `qty_value` double not null default 1,
  primary key(`id`)
)collate='utf8_bin';

alter table `pqty` add constraint `idx_qty` unique index `qty`(`qty_mst`, `qty_det`, `qty_value`);

create table `products` (
  `id` int unsigned not null auto_increment,
  `products_code` varchar(64) not null unique,
  `products_name` varchar(128) not null,
  `categories_id` int unsigned not null,
  `brands_id` int unsigned not null,
  `types_id` int unsigned not null,
  `pqty_id` int unsigned not null,
  `products_register` datetime not null,
  `products_active` int(1) not null default 1,
  primary key(`id`)
)collate='utf8_bin';
-- each products should has 2 balance each qty_id
create table `products_store`( -- utk posting
  `id` int unsigned not null auto_increment,
  `products_id` int unsigned not null,
  `store_id` int unsigned not null,
  `qty_id` int unsigned not null,
  `products_year` smallint(4) not null,
  `products_month` smallint(2) not null,
  `products_balance` double not null default 0,
  `products_in` double not null default 0,
  `products_out` double not null default 0,
  primary key (`id`)
)collate='utf8_bin';

alter table `products_store` add constraint `idx_products_store` unique index `products_store`(`products_id`, `store_id`, `qty_id`, `products_year`, `products_month`);

-- qty_id = km->m, shg ada 2 id utk hrg km dan hrg m
create table `products_price` (
  `id` int unsigned not null auto_increment,
  `products_id` int unsigned not null,
  `group_id` int unsigned not null,
  `member_id` int unsigned not null,
  `qty_id` int unsigned not null, -- km / m
  `qty_sell` double not null default 0,
  `qty_buy` double not null default 0,
  primary key(`id`)
)collate='utf8_bin'; -- unique product_id, group_id, member_id

create table `products_discount` (
  `id` int unsigned not null auto_increment,
  `products_id` int unsigned not null,
  `group_id` int unsigned not null,
  `member_id` int unsigned not null,
  `products_discount` double not null default 0,
  primary key(`id`)
)collate='utf8_bin'; -- unique product_id, group_id, member_id

create table `sessions`(
  `id` int unsigned not null auto_increment,
  `sessions_id` int unsigned not null, -- id users_sessions
  `sessions_uri` varchar(255) not null,
  `sessions_ip` varchar(64) not null,
  `sessions_browser` varchar(128) not null,
  primary key(`id`)
)collate='utf8_bin';

create table `users_auth`(
  `id` int unsigned not null auto_increment,
  `users_store` int unsigned not null, -- users_store id
  `sessions_id` varchar(128) not null,
  `sessions_create` datetime not null,
  `sessions_expire` datetime not null,
  primary key(`id`)
)collate='utf8_bin';

alter table `sessions` add constraint `fk_sessions_users` foreign key (`sessions_id`) references `users_auth`(`id`);

alter table `users_auth` add constraint `fk_users_auth` foreign key (`users_store`) references `users_store`(`id`);

-- 1 guarantee - 1 vehicles
create table `company_guarantee` (
  `id` int unsigned not null auto_increment,
  `guarantee_code` varchar(128) not null unique,
  `company_vehicles` int unsigned not null,
  `products_id` int unsigned not null,
  `guarantee_start` date not null,
  `guarantee_expire`  date not null,
  `is_enable` int(1) not null default 1,
  primary key(`id`)
)collate='utf8_bin';

create table `pmst_drop` (
  `id` int unsigned not null auto_increment,
  `drop_fullname` varchar(128) not null,
  `drop_address` text not null,
  `drop_phone`  varchar(32) not null,
  primary key(`id`)
)collate='utf8_bin';

create table `pmst` (
  `id` int unsigned not null auto_increment,
  `pmst_date` date not null,
  `pmst_expire` date not null,
  `pmst_mode` int unsigned not null, -- jual,beli dll
  `users_id` int unsigned not null,
  `vehicles_id` int unsigned not null,
  `guarantee_id` int unsigned not null,
  `invoice_no` varchar(64) not null,
  `delivery_no` varchar(64) not null,
  `company_id` int unsigned not null,
  `pmst_info` text not null,
  primary key(`id`)
)collate='utf8_bin';

create table `pmst_total`(
  `id` int unsigned not null,
  `pmst_hpp` double not null default 0,
  `pmst_dpp` double not null default 0,
  `pmst_diskon` double not null default 0,
  `pmst_ppn` double not null default 0,
  `pmst_total` double not null default 0,
  primary key(`id`)
)collate='utf8_bin';

create table `payments` (
  `id` int unsigned not null auto_increment,
  `users_id` int unsigned not null,
  `pmst_id` int unsigned not null,
  `payments_date` date not null,
  `payments_no` varchar(64) not null unique,
  `payments_info` text not null,
  `payments_value` double not null default 0,
  primary key(`id`)
)collate='utf8_bin';

create table `pdet_drop` (
  `id` int unsigned not null,
  `product_name` varchar(128) not null,
  primary key(`id`)
)collate='utf8_bin';

create table `pdet` (
  `id` int unsigned not null auto_increment,
  `pmst_id` int unsigned not null,
  `products_id` int unsigned not null,
  `qty_id` int unsigned not null, -- km/m
  `qty_times` double not null default 1,
  `qty_price` double not null default 0,
  `qty_total` double not null default 0,
  primary key(`id`)
)collate='utf8_bin';

create table `pdet_total` (
  `id` int unsigned not null,
  `pdet_hpp` double not null default 0,
  `pdet_dpp` double not null default 0,
  -- total dari pdet_disc.val + pdet_disc.price
  `pdet_discount` double not null default 0,
  `pdet_ppn` double not null default 0,
  `pdet_total` double not null default 0,
  primary key(`id`)
)collate='utf8_bin';

-- create trigger after count in this table will
-- update into pdet_price.qty_diskon
create table `pdet_discount` (
  `id` int unsigned not null auto_increment,
  `pdet_id` int unsigned not null,
  `pdet_price` double not null default 0,
  `discount_id` int unsigned not null,
  `discount_value` double not null default 0,
  `discount_price` double not null default 0,
  primary key(`id`)
) collate='utf8_bin';

create table `menu`(
  `id` int unsigned not null auto_increment,
  `menu_name` varchar(32) not null unique,
  `menu_icon` varchar(32) not null,
  `is_enable` int(1) not null default 1,
  primary key(`id`)
)collate='utf8_bin';

create table `menu_item`(
  `id` int unsigned not null auto_increment,
  `menu_id` int unsigned not null,
  `item_code` varchar(32) not null unique,
  `item_name` varchar(64) not null,
  `item_icon` varchar(32) not null,
  `item_link` varchar(32) not null,
  `is_enable` int(1) not null default 1,
  primary key(`id`)
)collate='utf8_bin';

-- create table `pmst_log`(
--   `id` int unsigned not null auto_increment,
--   `log_date` timestamp not null default now(),
--   `users_id` int unsigned not null,
--   ``
-- )
-- create table `pdet_log`
-- ada auth_session (1800) : has expire time ,
-- adn if auth_session not expired and access_session not expire
-- update new expire time & new update_session
-- if access_session expired, need login again
-- add access_session (300):
-- create table `auth_log`(
--   `id` int unsigned not null auto_increment,
--   `users_id` int unsigned not null,
--   `auth_date` timestamp not null default now(),
--   `auth_session` varchar(128) not null,
--   `auth_expired` datetime not null,
--   `update_session` varchar(128) not null,
--   `update_expired` datetime not null,
--   -- harus ada new session ketika sudah expire tnp diketahui
--   primary key(`id`)
-- )collate='utf8_bin';

-- create table `access_log` (
--   `id` int unsigned not null auto_increment,
--   `access_date` timestamp not null default now(),
--   `users_id` int unsigned not null,
--   `access_uri` varchar(128) not null,
--   `access_ip` varchar(64) not null,
--   `access_info` text not null,
--   primary key(`id`)
-- )collate='utf8_bin';

create table `articles_categories`(
  `id` int unsigned not null auto_increment,
  `articles_id` int unsigned not null,
  `categories_id` int unsigned not null,
  `is_enable` int(1) not null default 1,
  primary key(`id`)
)collate='utf8_bin';

create table `articles`(
  `id` int unsigned not null auto_increment,
  `users_id` int unsigned not null,
  `article_titles` varchar(128) not null unique,
  `articles_contents` text not null,
   primary key (`id`)
)collate='utf8_bin';

create table `articles_image` (
  `id` int unsigned not null auto_increment,
  `articles_id` int unsigned not null,
  `articles_img` varchar(128) not null,
  `articles_caption` varchar(128) not null,
  primary key(`id`)
)collate='utf8_bin';

create table `articles_video` (
  `id` int unsigned not null auto_increment,
  `articles_id` int unsigned not null,
  `articles_video` varchar(128) not null,
  `articles_caption` varchar(128) not null,
  primary key(`id`)
)collate='utf8_bin';

create table `meta`(
  `id` int unsigned not null auto_increment,
  `meta_name` varchar(32) not null unique,
  primary key(`id`)
)collate='utf8_bin';

create table `articles_meta` (
  `id` int unsigned not null auto_increment,
  `articles_id` int unsigned not null,
  `meta_id` int unsigned not null,
  primary key(`id`)
)collate='utf8_bin';

alter table `articles_meta` add constraint `fk_articles_meta1` foreign key (`articles_id`) references `articles`(`id`), add constraint `fk_articles_meta2` foreign key (`meta_id`) references `meta`(`id`);

insert into roles(role_name) values ('Owner'),('Manager'),('Supervisor'),('BackOffice'),('FrontOffice'),('Marketing'),('Member');

  -- create table `salary` (
  --   `id` int unsigned not null,
  --   `salary_code` int unsigned not null unique,
  --   `salary_name` varchar(64) not null,
  -- )
  --
  -- create table `users_rank`(
  --   `id` int unsigned not null auto_increment,
  --   `users_id` int unsigned not null,
  --   `rank_date` datetime not null,
  --   `rank_id` int unsigned not null, -- get from role_id
  --   `rank_salary` double not null,
  --   ``
  -- )
  --
  -- -- -- for hris rank
  -- create table `users_records`(
  --   `id` int unsigned not null auto_increment,
  --   `users_id` int unsigned not null,
  --   `records_date` date not null,
  --   `records_desc` text not null,
  --   `records_point` int not null default 0, -- could has minus point
  --   primary key(`id`)
  -- )collate='utf8_bin';
  -- -- absensi
  -- create table `users_log` (
  --   `id` int unsigned not null auto_increment,
  --   `users_id` int unsigned not null,
  --   `log_date` date not null,
  --   `log_time` time not null,
  -- )collate='utf8_bin';
