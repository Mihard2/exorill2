<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Vi_Wad_Ali_Orders_Info_Table' ) ) {
	class Vi_Wad_Ali_Orders_Info_Table {
		/**
		 * Create table
		 */
		public static function create_table() {
			global $wpdb;
			$table = $wpdb->prefix . 'vi_wad_ali_orders_info';

			$query = "CREATE TABLE IF NOT EXISTS {$table} (
                             `id` bigint(20) NOT NULL AUTO_INCREMENT,
                             `order_id` varchar(50) NOT NULL unique,
                             `currency` varchar(20),
                             `order_total` float,
                             PRIMARY KEY  (`id`)
                             )";

			$wpdb->query( $query );
		}

		/**Insert data to table
		 *
		 * @param $order_id
		 * @param $currency
		 * @param $order_total
		 *
		 * @return int
		 */

		public static function insert( $order_id, $currency, $order_total ) {
			global $wpdb;
			$table       = $wpdb->prefix . 'vi_wad_ali_orders_info';
			$order_id    = strval( $order_id );
			$currency    = trim( $currency );
			$order_total = floatval( $order_total );
			$result      = self::get_row_by_order_id( $order_id );
			if ( count( $result ) ) {
				if ( $order_total ) {
					$update_fields = array( 'order_total' => $order_total );
					if ( $currency ) {
						$update_fields['currency'] = $currency;
					}
					$wpdb->update( $table,
						$update_fields,
						array(
							'id' => $result[0]['id'],
						)
					);
				}

				$return = $result[0]['id'];
			} else {
				$wpdb->insert( $table,
					array(
						'order_id'    => $order_id,
						'currency'    => $currency,
						'order_total' => $order_total,
					),
					array(
						'%s',
						'%s',
						'%f',
					)
				);
				$return = $wpdb->insert_id;
			}

			return $return;
		}

		/**Delete row
		 *
		 * @param $id
		 *
		 * @return false|int
		 */
		public static function delete( $id ) {
			global $wpdb;
			$table  = $wpdb->prefix . 'vi_wad_ali_orders_info';
			$delete = $wpdb->delete( $table,
				array(
					'id' => $id,
				),
				array(
					'%d',
				)
			);

			return $delete;
		}

		/**Get row
		 *
		 * @param $id
		 *
		 * @return array|null|object
		 */
		public static function get_row( $id ) {
			global $wpdb;
			$table = $wpdb->prefix . 'vi_wad_ali_orders_info';
			$query = "SELECT * FROM {$table} WHERE id=%d";

			return $wpdb->get_results( $wpdb->prepare( $query, $id ), ARRAY_A );
		}

		/**Get row by id
		 *
		 * @param $order_id
		 *
		 * @return array|null|object
		 */
		public static function get_row_by_order_id( $order_id ) {
			global $wpdb;
			$table = $wpdb->prefix . 'vi_wad_ali_orders_info';
			$query = "SELECT * FROM {$table} WHERE order_id=%f";

			return $wpdb->get_results( $wpdb->prepare( $query, $order_id ), ARRAY_A );
		}

		/**Get rows
		 *
		 * @param int $limit
		 * @param int $offset
		 * @param bool $count
		 *
		 * @return array|null|object|string
		 */
		public static function get_rows( $limit = 0, $offset = 0, $count = false ) {
			global $wpdb;
			$table  = $wpdb->prefix . 'vi_wad_ali_orders_info';
			$select = '*';
			if ( $count ) {
				$select = 'count(*)';
				$query  = "SELECT {$select} FROM {$table}";

				return $wpdb->get_var( $query );
			} else {
				$query = "SELECT {$select} FROM {$table}";
				if ( $limit ) {
					$query .= " LIMIT {$offset},{$limit}";
				}

				return $wpdb->get_results( $query, ARRAY_A );
			}
		}
	}
}
