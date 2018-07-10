alter table `city` add constraint `fk_city_province` foreign key (`province_id`) references `province`(`id`);
alter table `company` add constraint `fk_company_group` foreign key (`group_id` ) references `group`(`id`), add constraint `fk_company_city` foreign key (`city_id`) references `city`(`id`);
alter table `company` add constraint `fk_company_member` foreign key (`member_id`) references `member`(`id`);
alter table   `company_guarantee` add constraint `fk_guarantee_vehicles` foreign key (`company_vehicles`) references `company_vehicles` (`id`), add constraint `fk_guarantee_product` foreign key (`products_id`) references `products`(`id`);
alter table `company` add constraint `idx_company` unique index `company`(`group_id`, `member_id`, `city_id`, `company_code`);
alter table `company_vehicles` add constraint `fk_company_vehicles1` foreign key (`company_id`) references `company`(`id`), add constraint `fk_company_vehicles2` foreign key (`vehicles_id`) references `vehicles`(`id`);
alter table `payment_terms` add constraint `fk_payment_terms1` foreign key (`payment_id`) references `payment`(`id`), add constraint `fk_payment_terms2` foreign key (`terms_id`) references `terms`(`id`);
alter table `payments` add constraint `fk_payments_users` foreign key (`users_id`) references `users`(`id`), add constraint `fk_payments_pmst` foreign key (`pmst_id`) references `pmst`(`id`);
alter table `products` add constraint `fk_products_category` foreign key (`categories_id`) references `categories`(`id`), add constraint `fk_products_brands` foreign key (`brands_id`) references `brands`(`id`), add constraint `fk_products_types` foreign key (`types_id`) references `types`(`id`), add constraint `fk_products_pqty` foreign key (`pqty_id`) references `pqty`(`id`);
alter table `pqty` add constraint `fk_pqty_qty1` foreign key (`qty_mst`) references `qty`(`id`), add constraint `fk_pqty_qty2` foreign key (`qty_det`) references `qty`(`id`);
alter table `products_discount` add constraint `fk_discount_products` foreign key (`products_id`) references `products` (`id`), add constraint `fk_discount_group` foreign key (`group_id`) references `group`(`id`), add constraint `fk_discount_member` foreign key (`member_id`) references `member`(`id`);
alter table `products_price` add constraint `fk_price_products` foreign key(`products_id`) references `products`(`id`), add constraint `fk_price_group` foreign key (`group_id`) references `group`(`id`), add constraint `fk_price_member` foreign key (`member_id`) references `member`(`id`), add constraint `fk_price_qty` foreign key (`qty_id`) references `qty`(`id`);
alter table `users` add constraint `fk_users_roles` foreign key (`role_id`) references `roles`(`id`);
alter table `role_access` add constraint `fk_role_access1` foreign key (`role_id`) references `roles`(`id`), add constraint `fk_role_access2` foreign key (`access_id`) references `access`(`id`);

alter table `pdet` add constraint `fk_pdet_pmst` foreign key (`pmst_id`) references `pmst`(`id`), add constraint `fk_pdet_products` foreign key (`products_id`) references `products`(`id`), add constraint `fk_pdet_qty` foreign key (`qty_id`) references `qty`(`id`);
alter table `pdet_discount` add constraint `fk_pdet_discount1` foreign key (`pdet_id`) references `pdet`(`id`), add constraint `fk_pdet_discount2` foreign key (`discount_id`) references `products_discount`(`id`);
alter table `pmst` add constraint `fk_pmst_users` foreign key (`users_id`) references `users`(`id`), add constraint `fk_pmst_vehicles` foreign key (`vehicles_id`) references `vehicles`(`id`), add constraint `fk_pmst_guarantee` foreign key (`guarantee_id`) references `company_guarantee`(`id`), add constraint `fk_pmst_company` foreign key(`company_id`) references `company`(`id`);

alter table `products_store` add constraint `fk_pstore_products` foreign key (`products_id`) references `products`(`id`), add constraint `fk_pstore_store` foreign key (`store_id`) references `store`(`id`), add constraint `fk_pstore_qty` foreign key (`qty_id`) references `qty`(`id`);



alter table `articles` add constraint `fk_articles_users` foreign key (`users_id`) references `users`(`id`);
alter table `articles_image` add constraint `fk_articles_image` foreign key (`articles_id`) references `articles`(`id`);
alter table `articles_categories` add constraint `fk_articles_categories1` foreign key (`articles_id`) references `articles`(`id`), add constraint `fk_articles_categories2` foreign key (`categories_id`) references `categories`(`id`);
alter table `articles_video` add constraint `fk_articles_video` foreign key (`articles_id`) references `articles`(`id`);
