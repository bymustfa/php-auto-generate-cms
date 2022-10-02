CREATE VIEW user_orders_view AS
SELECT orders.id                               AS id,
       orders.order_guid,
       orders.order_products_total_price       AS products_total_price,
       orders.order_cargo_price                AS cargo_price,
       orders.order_total_price                AS total_price,

       order_statuses.id                       AS status_id,
       order_statuses.order_status_name        AS status_name,
       order_statuses.order_status_description AS status_description,
       order_statuses.order_status_content     AS status_content,

       user_orders.user_id,
       user_orders.order_note,
       user_orders.payment_method,
       user_orders.payment_status,
       user_orders.payment_status_description,

       users.user_firstname AS firstname,
       users.user_lastname AS lastname,
       users.user_email AS email,
       users.user_phone AS phone,
       users.user_addres AS addres,


       orders.created_at,
       orders.updated_at

FROM orders
         INNER JOIN order_statuses ON order_statuses.id = orders.order_status
         INNER JOIN user_orders ON user_orders.order_id = orders.id
         INNER JOIN users ON users.id = user_orders.user_id
WHERE orders.order_type = 0
-- just user orders
