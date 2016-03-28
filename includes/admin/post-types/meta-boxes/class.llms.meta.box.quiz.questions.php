<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
* Quiz Questions
*
* Allows users to assign questions to a quiz.
*/
class LLMS_Meta_Box_Quiz_Questions {

	/**
	 * Static output class.
	 *
	 * Displays MetaBox
	 * Calls static class metabox_options
	 * Loops through meta-options array and displays appropriate fields based on type.
	 *
	 * @param  object $post [WP post object]
	 *
	 * @return void
	 */
	public static function output( $post ) {
		global $post;

		wp_nonce_field( 'lifterlms_save_data', 'lifterlms_meta_nonce' );

		$questions_selected = get_post_meta( $post->ID, '_llms_questions', true );
		?>

		<div id="llms-question-container">

			<div id="llms-single-options">
				<table class="wp-list-table widefat fixed posts question-list ui-sortable">
					<thead>
						<tr>
							<th class="llms-table-select">Name</th>
							<th class="llms-table-points">Points</th>
							<th class="llms-table-options">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if ( $questions_selected ) {

							foreach ( $questions_selected as $q ) {

								echo self::get_question_html_template( $q['id'], $q['points'] );

							}

						}
						?>
					</tbody>
					<tfoot>
						<tr>
							<td><?php _e( 'Total Points: ', 'lifterlms' ) ?> <span id="llms_points_total"></span></td>
							<td colspan="2"><a href="#" class="button" id="add_new_question"/><?php _e( 'Add a new question', 'lifterlms' ); ?></a></td>
						</tr>
					</tfoot>
				</table>
			</div>

			<!-- This is a template for a single question used by Javascript to create new questions -->
			<table id="llms-single-question-template" style="display: none !important;">
				<?php echo self::get_question_html_template(); ?>
			</table>

		</div>
	<?php
	}

	/**
	 * Static save method
	 *
	 * cleans variables and saves using update_post_meta
	 *
	 * @param  int 		$post_id [id of post object]
	 * @param  object 	$post [WP post object]
	 *
	 * @return void
	 */
	public static function save( $post_id, $post ) {
		global $wpdb;

		$questions = array();

		if ( isset( $_POST['_llms_question'] ) ) {
			foreach ($_POST['_llms_question'] as $key => $value) {
				$question_id = llms_clean( $value );
				$question_data = array();

				if ( ! empty( $question_id ) ) {
					$question_data['id'] = $question_id;
					$question_data['points'] = ($_POST['_llms_points'][ $key ] == '' ? 1 : $_POST['_llms_points'][ $key ]);

					$questions[ $key ] = $question_data;
				}

				if ($questions) {
					update_post_meta( $post_id, '_llms_questions', $questions );
				}
			}
		}

	}


	/**
	 * Retrieve the HTML for a single question row
	 * @param  integer $id     WP Post ID of the question
	 * @param  integer $points Number of points awarded for the question
	 * @return string
	 *
	 * @since  2.4.0
	 */
	private static function get_question_html_template( $id = 0, $points = 1 ) {

		// lookup the title and output an option if we have an ID
		$option = ( $id ) ? '<option selected="selected" value="'. $id .'">' . get_the_title( $id ) . ' (' . $id . ')</option>' : '';

		return '
			<tr class="list_item llms-question" data-question-id="' . $id . '">
				<td class="llms-table-select">
					<select class="llms-question-select" name="_llms_question[]" data-placeholder="' . __( 'Choose a Question', 'lifterlms' ) . '">' . $option . '</select>
				</td>
				<td class="llms-table-points">
					<input type="number" class="llms-points" min="1" name="_llms_points[]" step="1" value="' . $points . '" />
				</td>
				<td class="llms-table-options">
					<i class="fa fa-pencil-square-o llms-fa-edit"></i>
					<i class="fa fa-bars llms-fa-move"></i>
					<i data-code="f153" class="dashicons dashicons-dismiss llms-remove-question deleteBtn single-option-delete"></i>
				</td>
			</tr>
		';

	}

}
