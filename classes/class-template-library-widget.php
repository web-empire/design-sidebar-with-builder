<?php
/**
 * Address Widget
 *
 * @package Design Sidebar With Page Builder
 * @since 1.0.0
 */

if ( ! class_exists( 'Sidebar_Template_Library' ) ) :

	/**
	 * Sidebar_Template_Library
	 *
	 * @since 1.0.0
	 */
	class Sidebar_Template_Library extends WP_Widget {

		/**
		 * Instance
		 *
		 * @since 1.0.0
		 *
		 * @access private
		 * @var object Class object.
		 */
		private static $instance;

		/**
		 * Widget Base
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @var object Class object.
		 */
		public $id_base = 'sidebar-template-library';

		/**
		 * Initiator
		 *
		 * @since 1.0.0
		 *
		 * @return object initialized object of class.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			parent::__construct(
				$this->id_base,
				__( 'Reusable Template Library', 'we-sidebar-builder', 'sidebar-using-page-builder' ),
				array(
					'classname' => $this->id_base,
				),
				array(
					'id_base' => $this->id_base,
				)
			);
		}

		/**
		 * Widget
		 *
		 * @param  array $args Widget arguments.
		 * @param  array $instance Widget instance.
		 * @return void
		 */
		function widget( $args, $instance ) {

			$title = apply_filters( 'widget_title', $instance['title'] );

			// Before Widget.
			echo $args['before_widget'];
			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			$sidebar_builder_helper = new Sidebar_Builder_Helper();

			if ( array_key_exists( 'template_id', $instance ) ) {
				echo $sidebar_builder_helper->render_template( $instance['template_id'] );
			}

			// After Widget.
			echo $args['after_widget'];
		}

		/**
		 * Widget Form
		 *
		 * @param  array $instance Widget instance.
		 * @return void
		 */
		public function form( $instance ) {
			$default = array(
				'title'       => '',
				'template_id' => '',
			);

			$instance = array_merge( $default, $instance );

			$templates = get_posts(
				array(
					'post_type'        => 'we-sidebar-builder',
					'post_status'      => 'publish',
					'suppress_filters' => false,
					'posts_per_page'   => -1,
				)
			);

			if ( ! $templates ) {
				_e( 'No templates to show.', 'we-sidebar-builder', 'sidebar-using-page-builder' );

				return;
			}
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title', 'we-sidebar-builder', 'sidebar-using-page-builder' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'template_id' ) ); ?>"><?php esc_attr_e( 'Choose Template', 'we-sidebar-builder', 'sidebar-using-page-builder' ); ?>:</label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'template_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'template_id' ) ); ?>">
					<option value="">— <?php _e( 'Select', 'we-sidebar-builder', 'sidebar-using-page-builder' ); ?> —</option>
					<?php
					foreach ( $templates as $template ) :
						$selected = selected( $template->ID, $instance['template_id'] );
						?>

						<option value="<?php echo $template->ID; ?>" <?php echo $selected; ?> data-type="<?php echo esc_attr( $template->post_type ); ?>">
							<?php
								echo $template->post_title;
							?>
						</option>

						<?php
					endforeach;
					?>
				</select>
			</p>
			<?php
		}

		/**
		 * Update
		 *
		 * @param  array $new_instance Widget new instance.
		 * @param  array $old_instance Widget old instance.
		 * @return array                Merged updated instance.
		 */
		function update( $new_instance, $old_instance ) {
			$instance                = array();
			$instance                = wp_parse_args( $new_instance, $old_instance );
			$instance['template_id'] = ( isset( $new_instance['template_id'] ) ) ? $new_instance['template_id'] : '';

			return $instance;
		}
	}

endif;
