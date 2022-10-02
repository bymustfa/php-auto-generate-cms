CREATE VIEW no_login_orders_view AS
SELECT orders.id                                                 AS id,
       orders.order_guid,
       orders.order_products_total_price                         AS products_total_price,
       orders.order_cargo_price                                  AS cargo_price,
       orders.order_total_price                                  AS total_price,

       order_statuses.id                                         AS status_id,
       order_statuses.order_status_name                          AS status_name,
       order_statuses.order_status_description                   AS status_description,
       order_statuses.order_status_content                       AS status_content,

       no_login_orders.no_login_order_firstname                  AS firstname,
       no_login_orders.no_login_order_lastname                   AS lastname,
       no_login_orders.no_login_order_company_name               AS company_name,
       no_login_orders.no_login_order_city_id                    AS city_id,
       no_login_orders.no_login_order_district_id                AS district_id,
       no_login_orders.no_login_order_neighbourhood              AS neighbourhood,
       no_login_orders.no_login_order_post_code                  AS post_code,
       no_login_orders.no_login_order_addres                     AS addres,
       no_login_orders.no_login_order_phone                      AS phone,
       no_login_orders.no_login_order_email                      AS email,
       no_login_orders.no_login_order_order_note                 AS order_note,
       no_login_orders.no_login_order_payment_method             AS payment_method,
       no_login_orders.no_login_order_payment_status             AS payment_status,
       no_login_orders.no_login_order_payment_status_description AS payment_status_description,

       cities.city_name,
       districts.district_name,

       orders.created_at,
       orders.updated_at

FROM orders
         INNER JOIN order_statuses ON order_statuses.id = orders.order_status
         INNER JOIN no_login_orders ON no_login_orders.order_id = orders.id
         INNER JOIN cities ON cities.id = no_login_orders.no_login_order_city_id
         INNER JOIN districts ON districts.id = no_login_orders.no_login_order_district_id
WHERE orders.order_type = 1
-- just no login orders

