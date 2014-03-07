<?php
namespace Module\Product_technology
{

    use Module\Product_technology as Product_technology;
    use Framework\Registry as Registry;

    /**
     *
     * @author Marcin Pyrka
     *        
     */
    class Product extends Product_technology
    {

        /**
         *
         * @param unknown $options            
         */
        public function __construct($options = array())
        {
            /**
             */
            parent::__construct($options);
        }

        /**
         *
         * @param unknown $_id            
         */
        public function _isExists($_id)
        {
            $database = Registry::get("database");
        }

        /**
         *
         * @return unknown
         */
        public function _createList()
        {
            $database = Registry::get("database");
            $data = NULL;
            
            $data = $database->_mysql->fetch_array('SELECT * FROM products
                    left join units on products.units_id_units = units.id_units
                	left join category_product on category_product.product_id_product = products.id_products
                	left join category on category.id_category = category_product.category_id_category
                    LIMIT 100;');
            return $data;
        }

        /**
         *
         * @return unknown
         */
        public function _createListSearch($_keywords)
        {
            $database = Registry::get("database");
            $data = NULL;
            
            $data = $database->_mysql->fetch_array('SELECT * FROM products
                    left join units on products.units_id_units = units.id_units
                	left join category_product on category_product.product_id_product = products.id_products
                	left join category on category.id_category = category_product.category_id_category
                    WHERE `products_name` LIKE \'%' . $_keywords . '%\' LIMIT 100;');
            return $data;
        }

        /**
         *
         * @return unknown
         */
        public function _createListCount()
        {
            $database = Registry::get("database");
            /**
             * Wyzerowanie zmienynch
             */
            $count = NULL;
            
            $count = $database->_mysql->fetch_array('SELECT COUNT(`id_products`) FROM products;');
            return $count['0']['COUNT(`id_products`)'];
        }

        /**
         * Zwraca tabelę assoc z pojedyńczą stroną z listy produktów
         *
         * SELECT COUNT(`id_products`) FROM table_name;
         * SELECT * FROM test.products LIMIT 100;
         */
        /**
         *
         * @param number $_pageNumber            
         * @param number $_limitAtPage            
         * @return unknown
         */
        public function _createSoftList($_pageNumber = 1, $_limitAtPage = 20)
        {
            $database = Registry::get("database");
            
            /**
             * Wyzerowanie zmienynch
             */
            $data = NULL;
            $limit_down = NULL;
            $limit_up = NULL;
            
            /**
             * Obliczenia
             */
            $limit_down = $_limitAtPage * ($_pageNumber - 1);
            $limit_up = $_limitAtPage;
            
            /**
             * PAMIĘTAJ!!!
             * limit działa przyrostowo!
             */
            $data = $database->_mysql->fetch_array('SELECT * FROM products
                    left join units on products.units_id_units = units.id_units
                	left join category_product on category_product.product_id_product = products.id_products
                	left join category on category.id_category = category_product.category_id_category
                    ORDER BY `products_name` ASC LIMIT ' . $limit_down . ' , ' . $limit_up . ';');
            return $data;
        }

        /**
         *
         * @return unknown
         */
        public function _createView($_id)
        {
            $database = Registry::get("database");
            $data = NULL;
            
            $data = $database->_mysql->fetch_array('SELECT * FROM products
                    left join units on products.units_id_units = units.id_units
                	left join category_product on category_product.product_id_product = products.id_products
                	left join category on category.id_category = category_product.category_id_category
                    WHERE `id_products` = ' . $_id . ' LIMIT 100;');
            return $data;
        }
    }
}