<?php
/**
 * Additional Filters used by various reporting screens
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! is_admin() ) { exit; }

?>

<nav class="llms-nav-tab-wrapper llms-nav-secondary" id="llms-date-quick-filters">

	<ul class="llms-nav-items">

		<li class="llms-nav-item<?php echo ( $current_range == 'this-year' ) ? ' llms-active' : ''; ?>">
			<a class="llms-nav-link" data-range="this-year" href="<?php echo admin_url( 'admin.php?page=llms-reporting&tab=' . $current_tab . '&range=this-year' ); ?>"><?php _e( 'This Year', 'lifterlms' ); ?></a>
		</li>

		<li class="llms-nav-item<?php echo ( $current_range == 'last-month' ) ? ' llms-active' : ''; ?>">
			<a class="llms-nav-link" data-range="last-month" href="<?php echo admin_url( 'admin.php?page=llms-reporting&tab=' . $current_tab . '&range=last-month' ); ?>"><?php _e( 'Last Month', 'lifterlms' ); ?></a>
		</li>

		<li class="llms-nav-item<?php echo ( $current_range == 'this-month' ) ? ' llms-active' : ''; ?>">
			<a class="llms-nav-link" data-range="this-month" href="<?php echo admin_url( 'admin.php?page=llms-reporting&tab=' . $current_tab . '&range=this-month' ); ?>"><?php _e( 'This Month', 'lifterlms' ); ?></a>
		</li>

		<li class="llms-nav-item<?php echo ( $current_range == 'last-7-days' ) ? ' llms-active' : ''; ?>">
			<a class="llms-nav-link" data-range="last-7-days" href="<?php echo admin_url( 'admin.php?page=llms-reporting&tab=' . $current_tab . '&range=last-7-days' ); ?>"><?php _e( 'Last 7 Days', 'lifterlms' ); ?></a>
		</li>


		<li class="llms-nav-item llms-analytics-form<?php echo ( $current_range == 'custom' ) ? ' llms-active' : ''; ?>">

			<label><?php _e( 'Custom', 'lifterlms' ); ?></label>
			<input type="text" name="date_start" class="llms-datepicker" placeholder="yyyy-mm-dd" value="<?php echo $date_start; ?>"> -
			<input type="text" name="date_end" class="llms-datepicker" placeholder="yyyy-mm-dd" value="<?php echo $date_end; ?>">

			<button class="button small" id="llms-custom-date-submit" type="submit"><?php _e( 'Go', 'lifterlms' ); ?></a>
		</li>

		<li class="llms-nav-item llms-nav-item-right">
			<a class="llms-nav-link" href="#llms-toggle-filters"><span class="dashicons dashicons-filter"></span><?php _e( 'Toggle Filters', 'lifterlms' ); ?></a>
		</li>

	</ul>

</nav>

<nav class="llms-nav-tab-wrapper llms-nav-secondary llms-analytics-filters"<?php echo ( $current_students || $current_courses || $current_memberships ) ? ' style="display:block;"' : '' ; ?>>

	<ul class="llms-nav-items">
		<li class="llms-nav-item llms-analytics-form">

			<label><?php _e( 'Students', 'lifterlms' ); ?></label>

			<select id="llms-students-ids-filter" name="student_ids[]" multiple="multiple">
				<?php
				/**
				 * todo: do a better job on this loop for scalability...
				 */
				?>
				<?php foreach ( $current_students as $id ) : ?>
					<?php $s = get_user_by( 'id', $id ); ?>
					<option value="<?php echo $id; ?>" selected="selected"><?php echo $s->display_name; ?> &lt;<?php echo $s->user_email; ?>&gt;</option>
				<?php endforeach; ?>

			</select>

		</li>

		<li class="llms-nav-item llms-analytics-form">

			<label><?php _e( 'Courses', 'lifterlms' ); ?></label>

			<select class="llms-select2-post" data-placeholder="<?php _e( 'Filter by Course(s)', 'lifterlms' ); ?>" data-post-type="course" id="llms-course-ids-filter" name="course_ids[]" multiple="multiple">
				<?php foreach ( $current_courses as $course_id ) : ?>
					<option value="<?php echo $course_id; ?>" selected><?php echo get_the_title( $course_id ); ?> <?php printf( __( '(ID# %d)', 'lifterlms' ), $course_id ); ?></option>
				<?php endforeach; ?>
			</select>

		</li>

		<li class="llms-nav-item llms-analytics-form">

			<label><?php _e( 'Memberships', 'lifterlms' ); ?></label>

			<select class="llms-select2-post" data-placeholder="<?php _e( 'Filter by Memberships(s)', 'lifterlms' ); ?>" data-post-type="llms_membership" id="llms-membership-ids-filter" name="membership_ids[]" multiple="multiple">
				<?php foreach ( $current_memberships as $membership_id ) : ?>
					<option value="<?php echo $membership_id; ?>" selected><?php echo get_the_title( $membership_id ); ?> <?php printf( __( '(ID# %d)', 'lifterlms' ), $membership_id ); ?></option>
				<?php endforeach; ?>
			</select>

		</li>

		<li class="llms-nav-item llms-analytics-form">
			<button class="button" type="submit"><?php _e( 'Apply Filters', 'lifterlms' ); ?></a>
		</li>

	</ul>
</nav>

<input type="hidden" name="range" value="<?php echo $current_range; ?>">
<input type="hidden" name="tab" value="<?php echo $current_tab; ?>">
<input type="hidden" name="page" value="llms-reporting">
