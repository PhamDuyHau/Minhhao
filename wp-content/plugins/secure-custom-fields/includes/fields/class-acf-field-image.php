<?php

if ( ! class_exists( 'acf_field_image' ) ) :

	class acf_field_image extends acf_field {


		/**
		 * This function will setup the field type data
		 *
		 * @type    function
		 * @date    5/03/2014
		 * @since   ACF 5.0.0
		 *
		 * @param   n/a
		 * @return  n/a
		 */
		function initialize() {

			// vars
			$this->name          = 'image';
			$this->label         = __( 'Image', 'secure-custom-fields' );
			$this->category      = 'content';
			$this->description   = __( 'Uses the native WordPress media picker to upload, or choose images.', 'secure-custom-fields' );
			$this->preview_image = acf_get_url() . '/assets/images/field-type-previews/field-preview-image.png';
			$this->doc_url       = 'https://developer.wordpress.org/secure-custom-fields/features/fields/image/';
			$this->tutorial_url  = 'https://developer.wordpress.org/secure-custom-fields/features/fields/image/image-tutorial/';
			$this->defaults      = array(
				'return_format' => 'array',
				'preview_size'  => 'medium',
				'library'       => 'all',
				'min_width'     => 0,
				'min_height'    => 0,
				'min_size'      => 0,
				'max_width'     => 0,
				'max_height'    => 0,
				'max_size'      => 0,
				'mime_types'    => '',
			);

			// filters
			add_filter( 'get_media_item_args', array( $this, 'get_media_item_args' ) );
		}


		/**
		 * description
		 *
		 * @type    function
		 * @date    16/12/2015
		 * @since   ACF 5.3.2
		 *
		 * @param   $post_id (int)
		 * @return  $post_id (int)
		 */
		function input_admin_enqueue_scripts() {

			// localize
			acf_localize_text(
				array(
					'Select Image' => __( 'Select Image', 'secure-custom-fields' ),
					'Edit Image'   => __( 'Edit Image', 'secure-custom-fields' ),
					'Update Image' => __( 'Update Image', 'secure-custom-fields' ),
					'All images'   => __( 'All images', 'secure-custom-fields' ),
				)
			);
		}

		/**
		 * Renders the field HTML.
		 *
		 * @date    23/01/13
		 * @since   ACF 3.6.0
		 *
		 * @param   array $field The field settings.
		 * @return  void
		 */
		function render_field( $field ) {
			$uploader = acf_get_setting( 'uploader' );

			// Enqueue uploader scripts
			if ( $uploader === 'wp' ) {
				acf_enqueue_uploader();
			}

			// Elements and attributes.
			$value     = '';
			$div_attrs = array(
				'class'             => 'acf-image-uploader',
				'data-preview_size' => $field['preview_size'],
				'data-library'      => $field['library'],
				'data-mime_types'   => $field['mime_types'],
				'data-uploader'     => $uploader,
			);
			$img_attrs = array(
				'src'       => '',
				'alt'       => '',
				'data-name' => 'image',
			);

			// Detect value.
			if ( $field['value'] && is_numeric( $field['value'] ) ) {
				$image = wp_get_attachment_image_src( $field['value'], $field['preview_size'] );
				if ( $image ) {
					$value               = $field['value'];
					$img_attrs['src']    = $image[0];
					$img_attrs['alt']    = get_post_meta( $field['value'], '_wp_attachment_image_alt', true );
					$div_attrs['class'] .= ' has-value';
				}
			}

			// Add "preview size" max width and height style.
			// Apply max-width to wrap, and max-height to img for max compatibility with field widths.
			$size               = acf_get_image_size( $field['preview_size'] );
			$size_w             = $size['width'] ? $size['width'] . 'px' : '100%';
			$size_h             = $size['height'] ? $size['height'] . 'px' : '100%';
			$img_attrs['style'] = sprintf( 'max-height: %s;', $size_h );

			// Render HTML.
			?>
<div <?php echo acf_esc_attrs( $div_attrs ); ?>>
			<?php
			acf_hidden_input(
				array(
					'name'  => $field['name'],
					'value' => $value,
				)
			);
			?>
	<div class="show-if-value image-wrap" style="max-width: <?php echo esc_attr( $size_w ); ?>">
		<img <?php echo acf_esc_attrs( $img_attrs ); ?> />
		<div class="acf-actions -hover">
			<?php if ( $uploader !== 'basic' ) : ?>
			<a class="acf-icon -pencil dark" data-name="edit" href="#" title="<?php esc_attr_e( 'Edit', 'secure-custom-fields' ); ?>"></a>
			<?php endif; ?>
			<a class="acf-icon -cancel dark" data-name="remove" href="#" title="<?php esc_attr_e( 'Remove', 'secure-custom-fields' ); ?>"></a>
		</div>
	</div>
	<div class="hide-if-value">
			<?php if ( $uploader === 'basic' ) : ?>
				<?php if ( $field['value'] && ! is_numeric( $field['value'] ) ) : ?>
				<div class="acf-error-message"><p><?php echo acf_esc_html( $field['value'] ); ?></p></div>
			<?php endif; ?>
			<label class="acf-basic-uploader">
				<?php
				acf_file_input(
					array(
						'name' => $field['name'],
						'id'   => $field['id'],
						'key'  => $field['key'],
					)
				);
				?>
			</label>
		<?php else : ?>
			<p><?php esc_html_e( 'No image selected', 'secure-custom-fields' ); ?> <a data-name="add" class="acf-button button" href="#"><?php esc_html_e( 'Add Image', 'secure-custom-fields' ); ?></a></p>
		<?php endif; ?>
	</div>
</div>
			<?php
		}


		/**
		 * Create extra options for your field. This is rendered when editing a field.
		 * The value of $field['name'] can be used (like bellow) to save extra data to the $field
		 *
		 * @type    action
		 * @since   ACF 3.6
		 * @date    23/01/13
		 *
		 * @param   $field  - an array holding all the field's data
		 */
		function render_field_settings( $field ) {
			acf_render_field_setting(
				$field,
				array(
					'label'        => __( 'Return Format', 'secure-custom-fields' ),
					'instructions' => '',
					'type'         => 'radio',
					'name'         => 'return_format',
					'layout'       => 'horizontal',
					'choices'      => array(
						'array' => __( 'Image Array', 'secure-custom-fields' ),
						'url'   => __( 'Image URL', 'secure-custom-fields' ),
						'id'    => __( 'Image ID', 'secure-custom-fields' ),
					),
				)
			);

			acf_render_field_setting(
				$field,
				array(
					'label'        => __( 'Library', 'secure-custom-fields' ),
					'instructions' => __( 'Limit the media library choice', 'secure-custom-fields' ),
					'type'         => 'radio',
					'name'         => 'library',
					'layout'       => 'horizontal',
					'choices'      => array(
						'all'        => __( 'All', 'secure-custom-fields' ),
						'uploadedTo' => __( 'Uploaded to post', 'secure-custom-fields' ),
					),
				)
			);
		}

		/**
		 * Renders the field settings used in the "Validation" tab.
		 *
		 * @since ACF 6.0
		 *
		 * @param array $field The field settings array.
		 * @return void
		 */
		function render_field_validation_settings( $field ) {
			// Clear numeric settings.
			$clear = array(
				'min_width',
				'min_height',
				'min_size',
				'max_width',
				'max_height',
				'max_size',
			);

			foreach ( $clear as $k ) {
				if ( empty( $field[ $k ] ) ) {
					$field[ $k ] = '';
				}
			}

			acf_render_field_setting(
				$field,
				array(
					'label'   => __( 'Minimum', 'secure-custom-fields' ),
					'hint'    => __( 'Restrict which images can be uploaded', 'secure-custom-fields' ),
					'type'    => 'text',
					'name'    => 'min_width',
					'prepend' => __( 'Width', 'secure-custom-fields' ),
					'append'  => 'px',
				)
			);

			acf_render_field_setting(
				$field,
				array(
					'label'   => '',
					'type'    => 'text',
					'name'    => 'min_height',
					'prepend' => __( 'Height', 'secure-custom-fields' ),
					'append'  => 'px',
					'_append' => 'min_width',
				)
			);

			acf_render_field_setting(
				$field,
				array(
					'label'   => '',
					'type'    => 'text',
					'name'    => 'min_size',
					'prepend' => __( 'File size', 'secure-custom-fields' ),
					'append'  => 'MB',
					'_append' => 'min_width',
				)
			);

			acf_render_field_setting(
				$field,
				array(
					'label'   => __( 'Maximum', 'secure-custom-fields' ),
					'hint'    => __( 'Restrict which images can be uploaded', 'secure-custom-fields' ),
					'type'    => 'text',
					'name'    => 'max_width',
					'prepend' => __( 'Width', 'secure-custom-fields' ),
					'append'  => 'px',
				)
			);

			acf_render_field_setting(
				$field,
				array(
					'label'   => '',
					'type'    => 'text',
					'name'    => 'max_height',
					'prepend' => __( 'Height', 'secure-custom-fields' ),
					'append'  => 'px',
					'_append' => 'max_width',
				)
			);

			acf_render_field_setting(
				$field,
				array(
					'label'   => '',
					'type'    => 'text',
					'name'    => 'max_size',
					'prepend' => __( 'File size', 'secure-custom-fields' ),
					'append'  => 'MB',
					'_append' => 'max_width',
				)
			);

			acf_render_field_setting(
				$field,
				array(
					'label'        => __( 'Allowed File Types', 'secure-custom-fields' ),
					'instructions' => __( 'Comma separated list. Leave blank for all types', 'secure-custom-fields' ),
					'type'         => 'text',
					'name'         => 'mime_types',
				)
			);
		}

		/**
		 * Renders the field settings used in the "Presentation" tab.
		 *
		 * @since ACF 6.0
		 *
		 * @param array $field The field settings array.
		 * @return void
		 */
		function render_field_presentation_settings( $field ) {
			acf_render_field_setting(
				$field,
				array(
					'label'        => __( 'Preview Size', 'secure-custom-fields' ),
					'instructions' => '',
					'type'         => 'select',
					'name'         => 'preview_size',
					'choices'      => acf_get_image_sizes(),
				)
			);
		}

		/**
		 * This filter is applied to the $value after it is loaded from the db and before it is returned to the template
		 *
		 * @type    filter
		 * @since   ACF 3.6
		 * @date    23/01/13
		 *
		 * @param   $value (mixed) the value which was loaded from the database
		 * @param   $post_id (mixed) the post_id from which the value was loaded
		 * @param   $field (array) the field array holding all the field options
		 *
		 * @return  $value (mixed) the modified value
		 */
		function format_value( $value, $post_id, $field ) {

			// bail early if no value
			if ( empty( $value ) ) {
				return false;
			}

			// bail early if not numeric (error message)
			if ( ! is_numeric( $value ) ) {
				return false;
			}

			// convert to int
			$value = intval( $value );

			// format
			if ( $field['return_format'] == 'url' ) {
				return wp_get_attachment_url( $value );
			} elseif ( $field['return_format'] == 'array' ) {
				return acf_get_attachment( $value );
			}

			// return
			return $value;
		}


		/**
		 * description
		 *
		 * @type    function
		 * @date    27/01/13
		 * @since   ACF 3.6.0
		 *
		 * @param   $vars (array)
		 * @return  $vars
		 */
		function get_media_item_args( $vars ) {

			$vars['send'] = true;
			return( $vars );
		}


		/**
		 * This filter is applied to the $value before it is updated in the db
		 *
		 * @type    filter
		 * @since   ACF 3.6
		 * @date    23/01/13
		 *
		 * @param   $value - the value which will be saved in the database
		 * @param   $post_id - the post_id of which the value will be saved
		 * @param   $field - the field array holding all the field options
		 *
		 * @return  $value - the modified value
		 */
		function update_value( $value, $post_id, $field ) {

			return acf_get_field_type( 'file' )->update_value( $value, $post_id, $field );
		}


		/**
		 * This function will validate a basic file input
		 *
		 * @type    function
		 * @since   ACF 5.0.0
		 *
		 * @param  boolean $valid The current validity status.
		 * @param  mixed   $value The field value.
		 * @param  array   $field The field array.
		 * @param  string  $input The name of the input in the POST object.
		 * @return boolean The validity status.
		 */
		public function validate_value( $valid, $value, $field, $input ) {
			return acf_get_field_type( 'file' )->validate_value( $valid, $value, $field, $input );
		}

		/**
		 * Additional validation for the image field when submitted via REST.
		 *
		 * @param  boolean $valid The current validity boolean.
		 * @param  integer $value The value of the field.
		 * @param  array   $field The field array.
		 * @return boolean|WP_Error
		 */
		public function validate_rest_value( $valid, $value, $field ) {
			return acf_get_field_type( 'file' )->validate_rest_value( $valid, $value, $field );
		}

		/**
		 * Return the schema array for the REST API.
		 *
		 * @param  array $field The field array
		 * @return array
		 */
		public function get_rest_schema( array $field ) {
			return acf_get_field_type( 'file' )->get_rest_schema( $field );
		}

		/**
		 * Apply basic formatting to prepare the value for default REST output.
		 *
		 * @param  mixed          $value   The field value
		 * @param  string|integer $post_id The post ID
		 * @param  array          $field   The field array
		 * @return mixed
		 */
		public function format_value_for_rest( $value, $post_id, array $field ) {
			return acf_format_numerics( $value );
		}
	}


	// initialize
	acf_register_field_type( 'acf_field_image' );
endif; // class_exists check

?>
